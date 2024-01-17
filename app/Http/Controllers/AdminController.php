<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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


    public function userList()
    {
        $users = User::all();

        // Добавете ново поле status_color към всяко заявление в зависимост от активността
        foreach ($users as $user) {
            $user->status_color = $user->isActive ? 'success' : 'danger';
            $user->status_text = $user->isActive ? 'Active' : 'In Active';
        }

        return view('admin.list_users', compact('users'));
    }


}
