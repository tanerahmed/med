<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function assignRole(Request $request, User $user)
    {

        $request->validate([
            'role' => ['required', 'string', 'in:admin,editor,reviewer'],
        ]);

        $user->role = $request->role;
        $user->save();


        $notification = array(
            'message'=> 'User Role was updated successfully.',
            'alert-type'=>'success'
        );

        return redirect()->back()->with($notification);
    }

}
