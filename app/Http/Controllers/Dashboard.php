<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{

    public function index()
    {
        // Извличане на текущия логнат потребител
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'author') {
            return redirect()->route('author.dashboard');
        } elseif ($user->role === 'reviewer') {
            return redirect()->route('reviewer.dashboard');
        } elseif ($user->role === 'user') {
            return redirect()->route('canvaHome.index');
        }
         else{
            abort(404);
        }

    }
}