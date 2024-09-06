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
            ->get();

        return inertia('Location/Index', [
            'locations' => $locations,
        ]);
    }

    public function show(GleaningLocation $gleaningLocation)
    {
        return inertia('Location/Show', compact('gleaningLocation'));
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
            'description' => 'nullable|string',
            'gleanable_id' => 'required|exists:gleanables,id',
            'files' => 'nullable|array',
        ]);


        $location = auth()->user()->gleaningLocations()
            ->create($request->only('latitude', 'longitude', 'description', 'gleanable_id', 'files'));

        return redirect()->route('locations.show', $location);

    }
}
