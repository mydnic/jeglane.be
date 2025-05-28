<?php

namespace App\Http\Controllers;

use App\Models\GleaningLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

class HomeController extends Controller
{
    public function home()
    {
        $locations = GleaningLocation::active()->get();

        return inertia('Home', [
            'locations' => $locations,
        ]);
    }

    public function about()
    {
        return Inertia::render('About');
    }
}
