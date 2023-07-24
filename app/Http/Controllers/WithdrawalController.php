<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        return view('withdrawal', compact('user'));
    }

    public function withdrawal(Request $request)
    {
        $user = Auth::user();

        $user->delete();

        Auth::logout('web');

        return view('index');
    }
}
