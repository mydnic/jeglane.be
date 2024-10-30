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
        $file = Jetstream::localizedMarkdownPath('about.md');

        return Inertia::render('About', [
            'about' => Str::markdown(file_get_contents($file)),
        ]);
    }
}
