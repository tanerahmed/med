<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        // Return NOTIFICATION message to view
        $notification = array(
            'message'=> 'Admin test message',
            'alert-type'=>'success'
        );

        return view('admin.index')->with($notification);
    }

}
