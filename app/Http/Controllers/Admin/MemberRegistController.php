<?php

namespace App\Http\Controllers\Admin;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class MemberRegistController extends Controller
{
    //入力フォーム
    public function index(Request $request)
    {
        $inputs = $request->session()->get('inputs');

        return view('admin/member_regist', compact('inputs'));
    }

    public function post(Request $request)
    {
        //バリデーション
        $request->validate([
            'name_sei' => 'required|max:20',
            'name_mei' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|integer|between:1,2',
            'password' => 'required|between:8,20|regex:/^[a-zA-Z0-9]+$/|confirmed',
            'password_confirmation' => 'required|between:8,20|regex:/^[a-zA-Z0-9]+$/',
            'email' => 'required|email:filter,dns|max:200|unique:members,email',
        ],
        [
            'name_sei.required' => '＊姓は入力必須です',
            'name_sei.max' => '＊姓を20文字以内で入力してください',
            'name_mei.required' => '＊名は入力必須です',
            'name_mei.max' => '＊名を20文字以内で入力してください',
            'nickname.required' => '＊ニックネームは入力必須です',
            'nickname.max' => '＊ニックネームを10文字以内で入力してください',

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

        return redirect()->action("Admin\MemberRegistController@check");
    }


    //確認
    public function check(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');

        return view('admin/member_regist_check', compact('inputs'));
    }
    

    public function regist(Request $request)
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

        return redirect()->action("Admin\MemberListController@index");
    }

}
