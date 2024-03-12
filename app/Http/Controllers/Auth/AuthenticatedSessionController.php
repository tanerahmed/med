<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        //session()->put('url.intended', url()->previous());
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // TANER Role base redirect!
        $url = '';
        if($request->user()->role === 'admin'){
            $url = "admin/dashboard";
        }elseif($request->user()->role === 'author'){
            $url = "author/dashboard";
        }elseif($request->user()->role === 'reviewer'){
            $url = "reviewer/dashboard";
        }elseif($request->user()->role === 'user'){
            $url = "/";
        }
        // Return Toster NOTIFICATION message to view. Just for test I did it
        $notification = array(
            'message'=> $request->user()->name ." Loggin Successfully",
            'alert-type'=>'info'
        );

       // return redirect()->intended($url)->with($notification);

        //redirect to url intended
        return redirect()->intended(session()->get('url.intended', '/home'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
