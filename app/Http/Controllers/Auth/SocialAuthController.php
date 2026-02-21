<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client as GuzzleClient;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the Google OAuth consent screen.
     */
    public function redirectToGoogle()
    {
        $socialite = \Laravel\Socialite\Socialite::driver('google');
        
        // For development: disable SSL verification to avoid certificate errors
        if (config('app.env') === 'local') {
            $guzzle = new GuzzleClient(['verify' => false]);
            $socialite->setHttpClient($guzzle);
        }
        
        return $socialite->redirect();
    }

    /**
     * Handle the callback from Google OAuth.
     */
    public function handleGoogleCallback()
    {
        try {
            $socialite = \Laravel\Socialite\Socialite::driver('google');
            
            // For development: disable SSL verification to avoid certificate errors
            if (config('app.env') === 'local') {
                $guzzle = new GuzzleClient(['verify' => false]);
                $socialite->setHttpClient($guzzle);
            }
            
            $googleUser = $socialite->user();
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect('/login')->withErrors(['google' => 'Google Auth Error: ' . $e->getMessage()]);
        }

        // Find or create user
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Create new user if doesn't exist
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => null, // OAuth users don't have a password
            ]);
        } else {
            // Update google_id and avatar if they don't have them yet
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }
        }

        // Log the user in
        Auth::login($user);

        return redirect('/dashboard');
    }
}
