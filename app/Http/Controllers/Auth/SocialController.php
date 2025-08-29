<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
 use Laravel\Socialite\Two\InvalidStateException;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (InvalidStateException $e) {
            return redirect()->route('login')->with('error', 'Authentication failed. Please try again.');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('login')->with('error', 'Authentication failed. Please try again.');
        }

        $existingUserWithEmail = User::where('email', $socialUser->getEmail())->first();

        if ($existingUserWithEmail && $existingUserWithEmail->social_provider == null) {
            $existingUserWithEmail->update([
                'social_provider' => $provider,
                'social_provider_id' => $socialUser->getId(),
            ]);

            Auth::login($existingUserWithEmail);

            return redirect()->route('home');
        }

        $user = User::updateOrCreate(
            [
                'social_provider' => $provider,
                'social_provider_id' => $socialUser->getId(),
            ],
            [
                'email' => $socialUser->getEmail(),
                'name' => $socialUser->getName(),
                'profile_photo_url' => $socialUser->getAvatar(),
                'password' => bcrypt(Str::random()),
            ]
        );

        Auth::login($user);

        return redirect()->route('home');
    }
}
