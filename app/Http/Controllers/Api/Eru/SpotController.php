<?php

namespace App\Http\Controllers\Api\Eru;

use App\Http\Controllers\Controller;
use App\Models\GleaningLocation;
use App\Models\User;
use Illuminate\Http\Request;

class SpotController extends Controller
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

        $eruUser = User::where('email', 'eru@jeglane.be')->firstOrFail();

        $location = $eruUser->gleaningLocations()->create($data);

        return response()->json([
            'id' => $location->id,
            'url' => route('locations.show', $location),
        ], 201);
    }
}
