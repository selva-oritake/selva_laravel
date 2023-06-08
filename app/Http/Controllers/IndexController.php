<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //トップ画面
    public function index()
    {
        $user = Auth::user();
        return view('index');
    }
}
