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
            $user->status_text = $user->isActive ? 'Active' : 'Not Active';
        }

        return view('admin.list_users', compact('users'));
    }

    public function userCreate()
{
    return view('admin.users_create');
}


public function userStore(Request $request)
{
    // Валидация на данните от формата
    $validator = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:3',
        'role' => 'required|in:author,reviewer,editor,admin,user',
    ]);

    try {
        // Създаване на нов потребител
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'isActive' => $request->has('isActive'),
        ]);

        return redirect()->route('admin.users-create')->with('success', 'The user was successfully created.');
    } catch (\Exception $e) {
        // Ако възникне грешка, върнете на формата съобщение за грешка
        return redirect()->route('admin.users-create')->withErrors([$e->getMessage()]);
    }
}

    public function userDestroy(User $user)
    {
        $user->delete();
        // return redirect()->route('admin.users-list')->with('success', 'Потребителят беше успешно изтрит.');
        $notification = array(
            'message'=> 'User was deleted successfully.',
            'alert-type'=>'success'
        );

        return redirect()->back()->with($notification);
    }




}
