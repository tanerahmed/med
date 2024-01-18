<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index()
    {

        // Получаване на текущия потребител
        $user = Auth::user();

        // Проверка за роля 'admin' или 'editor'
        if (!$user || !($user->role == 'admin' ||$user->role== 'editor')) {
            // Ако не е админ или редактор, върнете 404 грешка
            abort(404);
        }

        $logs = Activity::all();

        return view('logs.index', compact('logs'));
    }
}