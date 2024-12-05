<?php

namespace App\Http\Controllers;

use App\Models\GleaningLocation;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote(Request $request, GleaningLocation $gleaningLocation)
    {
        $request->validate([
            'vote' => 'required|in:1,-1',
        ]);

        $vote = Vote::where([
            'user_id' => auth()->id(),
            'gleaning_location_id' => $gleaningLocation->id,
        ])->first();

        // If no vote exists, create it
        if (!$vote) {
            Vote::create([
                'user_id' => auth()->id(),
                'gleaning_location_id' => $gleaningLocation->id,
                'vote' => $request->vote,
            ]);
            return back();
        }

        // If the user clicked the same vote button, remove their vote
        if ($vote->vote == $request->vote) {
            $vote->delete();
            return back();
        }

        // If the user clicked a different vote button, update their vote
        $vote->update(['vote' => $request->vote]);
        return back();
    }
}
