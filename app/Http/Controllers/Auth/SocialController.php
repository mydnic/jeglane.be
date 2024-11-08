<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $user = Socialite::driver($provider)->user();

        User::updateOrCreate(
            [
                'social_provider' => $provider,
                'social_provider_id' => $user->getId(),
            ],
            [
                'email' => $user->getEmail(),
                'name' => $user->getName(),
                'avatar' => $user->getAvatar(),
            ]
        );
    }
}
