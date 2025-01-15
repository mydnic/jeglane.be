<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

        $existingUserWithEmail = User::where('email', $user->getEmail())->first();

        if ($existingUserWithEmail && $existingUserWithEmail->social_provider == null) {
            $existingUserWithEmail->update([
                'social_provider' => $provider,
                'social_provider_id' => $user->getId(),
            ]);

            Auth::login($existingUserWithEmail);

            return redirect()->route('home');
        }

        $user = User::updateOrCreate(
            [
                'social_provider' => $provider,
                'social_provider_id' => $user->getId(),
            ],
            [
                'email' => $user->getEmail(),
                'name' => $user->getName(),
                'profile_photo_url' => $user->getAvatar(),
                'password' => bcrypt(Str::random()),
            ]
        );

        Auth::login($user);

        return redirect()->route('home');
    }
}
