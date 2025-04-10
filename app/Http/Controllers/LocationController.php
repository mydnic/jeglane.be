<?php

namespace App\Http\Controllers;

use App\Models\Gleanable;
use App\Models\GleaningLocation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = GleaningLocation::query()
            ->with('gleanable')
            ->when(request()->has('latitude') && request()->has('longitude'), function ($query) {
                $query
                    ->selectRaw('*, ST_Distance_Sphere(point(longitude, latitude), point(?, ?)) as distance', [
                        request('longitude'),
                        request('latitude'),
                    ])
                    ->whereRaw('ST_Distance_Sphere(point(longitude, latitude),point(?, ?)) < ?', [
                        request('longitude'),
                        request('latitude'),
                        request('distance') ?? 70000, // 70 milles metres
                    ]);
            })
            ->when(request()->has('postal_code'), function ($query) {
                $query->where('postal_code', request('postal_code'));
            })
            ->withCount(['votes as vote_count' => function($query) {
                $query->select(\DB::raw('COALESCE(SUM(vote), 0)'));
            }])
            ->orderBy('postal_code')
            ->get();

        return inertia('Location/Index', [
            'locations' => $locations,
        ]);
    }

    public function show(GleaningLocation $gleaningLocation)
    {
        $gleaningLocation->load(['gleanable', 'user']);
        $gleaningLocation->loadMissing(['comments' => function($query) {
            $query->whereNull('parent_id')->with('user', 'replies.user');
        }]);

        if (auth()->check()) {
            $gleaningLocation->load('userVote');
        }

        return inertia('Location/Show', [
            'gleaningLocation' => $gleaningLocation,
            'voteCount' => $gleaningLocation->vote_count,
        ]);
    }

    public function create()
    {
        $gleanables = Gleanable::orderBy('name')->get();
        return inertia('Location/Create', compact('gleanables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'city' => 'required|string',
            'postal_code' => 'required',
            'description' => 'nullable|string',
            'gleanable_id' => 'required|exists:gleanables,id',
            'files' => 'nullable|array',
        ]);

        $location = auth()->user()->gleaningLocations()
            ->create($request->only('latitude', 'longitude', 'city', 'postal_code', 'description', 'gleanable_id', 'files'));

        return redirect()->route('locations.show', $location);
    }
}
