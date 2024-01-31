<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogOffController extends Controller
{
    function logOff()
    {
        Auth::logout(); 
        return redirect('/');
    }
}
