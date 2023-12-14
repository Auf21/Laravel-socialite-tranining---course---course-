<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SociliteController extends Controller
{
    public function login($prpvider)
    {
        return Socialite::driver($prpvider)->redirect();
    }
    public function redirect($provider)
    {
        $socialiteUser = Socialite::driver($provider)->user();
        $user = User::updateOrCreate([
            'provider' => $provider,
            'providor_id' => $socialiteUser->getId()

        ],
            [
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
            ]);
        //auth user
        Auth::login($user, true);

        //redirect to dashboard
        return to_route('dashboard');
    }

}
