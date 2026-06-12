<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated($request, $user)
    {
        switch ($user->role) {

            case 'admin':
                return redirect('/admin');

            case 'develop':
                return redirect('/develop');

            case 'offset':
                return redirect('/offset');

            case 'plotter':
                return redirect('/plotter');

            case 'uv':
                return redirect('/uv');

            case 'finishing':
                return redirect('/finishing');

            default:
                return redirect('/home');
        }
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}