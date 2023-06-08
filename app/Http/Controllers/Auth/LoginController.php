<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //ログアウト
    protected function loggedOut(Request $request)
    {
        return redirect('/index');
    }

    public function ValidateLogin(Request $request)
    {
        //ログインバリデーション
        $request->validate([
            'password' => 'required|between:8,20|regex:/^[a-zA-Z0-9]+$/|',
            'email' => 'required|email|max:200|',
        ],
        [
            'password.required' => '＊パスワードを8~20文字の半角英数字で入力してください',
            'password.between' => '＊パスワードを8~20文字の半角英数字で入力してください',
            'password.regex' => '＊パスワードを8~20文字の半角英数字で入力してください',
        
            'email.required' => '＊メールアドレスを200文字以内で入力して下さい',
            'email.email' => '＊メールアドレスを200文字以内で入力して下さい',
            'email.max' => '＊メールアドレスを200文字以内で入力して下さい',
        ]);
    }
}