<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberRegistController extends Controller
{
    //入力フォーム
    public function index()
    {
        return view('member_regist');
    }

    public function regist(Request $request)
    {   
        $name_sei = $request->name_sei;
        $name_mei = $request->name_mei;
        $nickname = $request->nickname;
        $gender = $request->gender;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;
        $email = $request->email;

        return view('member_regist')->with([
            'name_sei' => $name_sei,
            'name_mei' => $name_mei,
            'nickname' => $nickname,
            'gender' => $gender,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
            'email' => $email,
        ]);
    }


    //確認
    public function check(Request $request)
    {
        //バリデーション
        $request->validate([
            'name_sei' => 'required|max:20',
            'name_mei' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|integer|between:1,2',
            'password' => 'required|between:8,20|regex:/^[a-zA-Z0-9]+$/|confirmed',
            'password_confirmation' => 'required|between:8,20|regex:/^[a-zA-Z0-9]+$/',
            'email' => 'required|email|max:200|unique:members,email',
        ],
        [
            'password.required' => '＊パスワードを8~20文字の半角英数字で入力してください',
            'password.between' => '＊パスワードを8~20文字の半角英数字で入力してください',
            'password.regex' => '＊パスワードを8~20文字の半角英数字で入力してください',
            'password.confirmed' => '＊パスワードが一致しません',

            'email.required' => '＊メールアドレスを200文字以内で入力して下さい',
            'email.email' => '＊メールアドレスを200文字以内で入力して下さい',
            'email.max' => '＊メールアドレスを200文字以内で入力して下さい',
            'email.unique' => '＊このメールアドレスはすでに登録済みです'
        ]);

        // データをセッションに保存
        $request->session()->put('inputs', $request->all());
        $inputs = $request;

        return view('member_regist_check')->with([
            'inputs' => $inputs->all(),
        ]);
    }
    

    //完了
    public function complete(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');

        $member = new Member;
        // データベースに値をinsert
        $member->create([
            'name_sei' => $inputs['name_sei'],
            'name_mei' => $inputs['name_mei'],
            'nickname' => $inputs['nickname'],
            'gender' => $inputs['gender'],
            'password' => Hash::make($inputs['password']),
            'email' => $inputs['email'],
        ]);

        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return view('member_regist_complete');
    }

}
