<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Member;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthCodeMail;

class EmailEditController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('email_edit', compact('user'));
    }

    public function auth (Request $request)
    {
        //バリデーション
        $request->validate([
            'email' => 'required|email|max:200|unique:members,email',     
        ],
        [
            'email.required' => '＊メールアドレスを200文字以内で入力して下さい',
            'email.email' => '＊メールアドレスを200文字以内で入力して下さい',
            'email.max' => '＊メールアドレスを200文字以内で入力して下さい',
            'email.unique' => '＊このメールアドレスはすでに登録済みです'
        ]);

        $user = Auth::user();
        // データをセッションに保存
        $request->session()->put('email', $request->all());
        $email = $request['email'];

        // ランダムな6桁の数字を生成
        $auth_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Member::where('id', $user['id'])->update(['auth_code' => $auth_code]);

        // メール送信
        Mail::to($email)->send(new AuthCodeMail($auth_code));

        return redirect()->action("EmailEditController@check");
    }

    public function check()
    {
        
        return view('email_edit_auth');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $auth_code = $user['auth_code'];

        $request->validate([
            'auth_code' => [
                'required',
                function ($attribute, $value, $fail) use ($auth_code) {
                    if ($value != $auth_code) {
                        $fail('＊認証コードが一致しません。');
                    }
                },
            ],
        ], [
            'auth_code.required' => '＊認証コードは必須です。',
        ]);

        $user = Auth::user();
        // セッションからデータを取得
        $email = $request->session()->get('email');

        $member = Member::find($user['id']);
        $member->update(['email' => $email['email']]);

        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        

        return redirect()->action("MypageController@index");
    }


}
