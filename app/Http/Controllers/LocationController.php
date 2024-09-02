<?php

namespace App\Http\Controllers;

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

    public function create()
    {
        return inertia('Location/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'description' => 'required|string',
            'tags' => 'required|string',
        ]);

    }
}
