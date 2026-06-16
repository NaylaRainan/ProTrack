<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirect berdasarkan role
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = auth()->user()->role;

        switch ($role) {

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
                return redirect('/');
        }
    }
}