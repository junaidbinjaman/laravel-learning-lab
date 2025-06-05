<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Registration extends Controller
{
    public function registration()
    {
        return view('new-registration');
    }
}
