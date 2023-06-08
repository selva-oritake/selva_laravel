<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetSentController extends Controller
{
    public function index()
    {
        return view('auth/passwords/resetsent');
    }
}
