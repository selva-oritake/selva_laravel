<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('/admin/login');
    }

    public function login(Request $request)
    {
        //ログインバリデーション
        $request->validate([
            'password' => 'required|between:8,20|regex:/^[a-zA-Z0-9]+$/|',
            'login_id' => 'required|between:7,10|regex:/^[a-zA-Z0-9]+$/|',
        ],
        [
            'password.required' => '＊パスワードは入力必須です',
            'password.between' => '＊パスワードは8~20文字で入力してください',
            'password.regex' => '＊パスワードは半角英数字で入力してください',
        
            'login_id.required' => '＊ログインIDは入力必須です',
            'login_id.between' => '＊ログインIDは7~10文字で入力してください',
            'login_id.regex' => '＊ログインIDは半角英数字で入力してください',
        ]);

        $credentials = $request->only(['login_id', 'password']);

        if (Auth::guard('admin')->attempt($credentials)) {
            // ログインしたら管理画面トップにリダイレクト
            return redirect()->action("Admin\IndexController@index");
        }

        //ログインできなかったときに元のページに戻る
        return back()->withInput()->withErrors([
            'login' => ['＊ログインIDまたはパスワードが一致しません'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('admin/login');
    }
}