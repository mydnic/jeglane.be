<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
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
            'files.*' => 'string',
        ]);

        $location = $request->user()->gleaningLocations()->create($data);

        return response()->json([
            'id' => $location->id,
            'url' => route('locations.show', $location),
        ], 201);
    }
}
