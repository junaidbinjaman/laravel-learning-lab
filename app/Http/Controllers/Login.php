<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Login extends Controller
{
    //

    public function login()
    {
        return view('new-login-form');
    }

    public function logincapture()
    {
        Log::info('Hello World');
        return view('new-login-form');
    }
}
