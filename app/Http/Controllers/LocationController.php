<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
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
