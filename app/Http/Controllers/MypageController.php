<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        //セッション削除
        $request->session()->forget('inputs');

        return view('mypage', compact('user'));
    }
}
