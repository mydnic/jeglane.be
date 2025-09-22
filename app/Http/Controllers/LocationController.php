<?php

namespace App\Http\Controllers;

use App\Models\Gleanable;
use App\Models\GleaningLocation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        // Sanitize and normalize incoming geospatial parameters
        $lat = request()->has('latitude') ? (float) request('latitude') : null;
        $lng = request()->has('longitude') ? (float) request('longitude') : null;
        $distance = request()->has('distance') ? (float) request('distance') : null;

        // Normalize longitude to (-180, 180]
        if (!is_null($lng)) {
            $lng = fmod($lng + 180.0, 360.0);
            if ($lng < 0) {
                $lng += 360.0;
            }
            $lng -= 180.0;
        }

        // Clamp latitude to [-90, 90]
        if (!is_null($lat)) {
            $lat = max(-90.0, min(90.0, $lat));
        }

        // Ensure distance is a non-negative number, default to 70km if not provided
        $distance = !is_null($distance) ? max(0.0, $distance) : 70000.0;

        $locations = GleaningLocation::query()
            ->active()
            ->with('gleanable')
            ->when(!is_null($lat) && !is_null($lng), function ($query) use ($lat, $lng, $distance) {
                $query
                    ->selectRaw('*, ST_Distance_Sphere(point(longitude, latitude), point(?, ?)) as distance', [
                        $lng,
                        $lat,
                    ])
                    ->whereRaw('ST_Distance_Sphere(point(longitude, latitude),point(?, ?)) < ?', [
                        $lng,
                        $lat,
                        $distance,
                    ]);
            })
            ->when(request()->filled('categories'), function ($query) {
                $categories = request('categories');
                if (!is_array($categories)) {
                    $categories = array_filter(explode(',', (string) $categories));
                }
                if (!empty($categories)) {
                    $query->whereIn('gleanable_id', $categories);
                }
            })
            ->when(request()->has('postal_code'), function ($query) {
                $query->where('postal_code', request('postal_code'));
            })
            ->withCount(['votes as vote_count' => function($query) {
                $query->select(\DB::raw('COALESCE(SUM(vote), 0)'));
            }])
            ->orderBy('postal_code')
            ->get();

        $gleanables = Gleanable::orderBy('name')->get();

        return inertia('Location/Index', [
            'locations' => $locations,
            'gleanables' => $gleanables,
            // Return sanitized filters so the UI reflects the used values
            'filters' => array_merge(
                request()->only(['categories', 'postal_code']),
                [
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'distance' => $distance,
                ]
            ),
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
        $data = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'city' => 'required|string',
            'postal_code' => 'required',
            'description' => 'nullable|string',
            'gleanable_id' => 'required|exists:gleanables,id',
            'files' => 'nullable|array',
            'confirmed' => 'accepted',
        ]);

        $data['latitude'] = trim($data['latitude'], ',');
        $data['longitude'] = trim($data['longitude'], ',');

        $location = auth()->user()->gleaningLocations()
            ->create($data);

        return redirect()->route('locations.show', $location);
    }
}
