<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GleaningLocation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'radius' => 'nullable|numeric|min:0',
            'gleanable_id' => 'nullable|exists:gleanables,id',
        ]);

        $lat = $data['latitude'] ?? null;
        $lng = $data['longitude'] ?? null;
        $radius = $data['radius'] ?? 500;

        $locations = GleaningLocation::query()
            ->select(['id', 'description', 'latitude', 'longitude', 'city', 'postal_code', 'gleanable_id', 'created_at'])
            ->when(!is_null($lat) && !is_null($lng), function ($query) use ($lat, $lng, $radius) {
                $query
                    ->selectRaw('ST_Distance_Sphere(point(longitude, latitude), point(?, ?)) as distance', [
                        $lng,
                        $lat,
                    ])
                    ->whereRaw('ST_Distance_Sphere(point(longitude, latitude), point(?, ?)) < ?', [
                        $lng,
                        $lat,
                        $radius,
                    ])
                    ->orderBy('distance');
            })
            ->when(!empty($data['gleanable_id']), function ($query) use ($data) {
                $query->where('gleanable_id', $data['gleanable_id']);
            })
            ->orderByDesc('created_at')
            ->get();

        return response()->json($locations);
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
            'files.*' => 'string',
        ]);

        $location = $request->user()->gleaningLocations()->create($data);

        return response()->json([
            'id' => $location->id,
            'url' => route('locations.show', $location),
        ], 201);
    }
}
