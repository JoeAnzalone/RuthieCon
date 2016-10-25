<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $error = \Session::get('error');
        return view('welcome', ['error' => $error]);
    }
}
