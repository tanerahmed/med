<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function UserDashboard()
    {
        // Return NOTIFICATION message to view
        $notification = array(
            'message'=> 'Admin test message',
            'alert-type'=>'success'
        );
        // return view('user.dashboard')->with($notification);
        return view('user.dashboard');
    }
}
