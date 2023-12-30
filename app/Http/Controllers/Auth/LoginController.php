<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function redirectToOrcid()
    {
        return Socialite::driver('orcid')->redirect();
    }
    
    public function handleOrcidCallback()
    {
        $user = Socialite::driver('orcid')->user();
    
var_dump($user);
die('LoginCOntrler.php');


        // TODO DOBAVI orcid  V TABLICATA USERS
        // TODO DOBAVI orcid  V TABLICATA USERS
        // TODO DOBAVI orcid  V TABLICATA USERS
        // TODO DOBAVI orcid  V TABLICATA USERS
        // TODO DOBAVI orcid  V TABLICATA USERS
        // TODO DOBAVI orcid  V TABLICATA USERS
        // TODO DOBAVI orcid  V TABLICATA USERS

        // Find the user in your database by their ORCID ID.
        $existingUser = User::where('orcid', $user->id)->first();
    
        // If the user doesn't exist, create them.
        if (!$existingUser) {
            $user = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'orcid' => $user->id,
            ]);
        }
    
        // Log the user in.
        Auth::login($user);
    
        // Redirect the user to the home page.
        return redirect('dashboard');
    }



}
