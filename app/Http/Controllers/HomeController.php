<?php

namespace App\Http\Controllers;

use App\Models\GleaningLocation;

class HomeController extends Controller
{
    public function home()
    {
        $locations = GleaningLocation::active()->get();

        return inertia('Home', [
            'locations' => $locations,
        ]);
    }
}
