<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Mydnic\ChangelogCommitForLaravel\Models\Changelog;

class ChangelogController extends Controller
{
    public function index(Request $request)
    {
        $changelogs = Changelog::latest('date')
            ->paginate(20)
            ->through(fn ($item) => [
                'date' => $item->date,
                'message' => $item->message,
            ]);

        if ($request->wantsJson()) {
            return response()->json($changelogs);
        }

        return inertia('Changelog/Index', [
            'changelogs' => $changelogs
        ]);
    }
}
