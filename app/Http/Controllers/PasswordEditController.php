<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Member;
use Illuminate\Support\Facades\Hash;

class PasswordEditController extends Controller
{
    public function index()
    {
        return view('password_edit');
    }

    public function update(Request $request)
    {
        //バリデーション
        $request->validate([
            'password' => 'required|between:8,20|regex:/^[a-zA-Z0-9]+$/|confirmed',
            'password_confirmation' => 'required|between:8,20|regex:/^[a-zA-Z0-9]+$/',       
        ],
        [
            'password.required' => '＊パスワードを8~20文字の半角英数字で入力してください',
            'password.between' => '＊パスワードを8~20文字の半角英数字で入力してください',
            'password.regex' => '＊パスワードを8~20文字の半角英数字で入力してください',
            'password.confirmed' => '＊パスワードが一致しません'
        ]);

        $user = Auth::user();
        $member = Member::find($user['id']);
        $hashedPassword = Hash::make($request['password']);
        $member->update(['password' => $hashedPassword]);

        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("MypageController@index");
    }
}
