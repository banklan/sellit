<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth')->except('');
    // }

    public function index()
    {
        return view('welcome');
    }

    // public function Ad()
    // {
    // 	return view('single');
    // }
}
