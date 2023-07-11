<?php

namespace App\Http\Controllers\Admin;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class MemberEditController extends Controller
{
    //入力フォーム
    public function index(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        
        if(request()->has('id')){
            $currentId = request()->query('id');
        }else{
            $currentId = $request->session()->get('currentId');
        }
        $query = Member::query();
        $query->where('id', $currentId);
        $result = $query->get()->first();;

        $request->session()->put('currentId', $currentId);


        return view('admin/member_edit', compact('result', 'inputs'));
    }

    public function post(Request $request)
    {
        $currentId = $request->session()->get('currentId');
        $query = Member::query();
        $query->where('id', $currentId);
        $member = $query->get()->first();;
        //バリデーション
        $request->validate([
            'name_sei' => 'required|max:20',
            'name_mei' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|integer|between:1,2',
            'password' => 'nullable|between:8,20|regex:/^[a-zA-Z0-9]+$/|confirmed',
            'password_confirmation' => 'nullable|between:8,20|regex:/^[a-zA-Z0-9]+$/',
            'email' => [
                'required',
                'email:filter,dns',
                'max:200',
                Rule::unique('members')->ignore($member->id),
            ],
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

        return redirect()->action("Admin\MemberEditController@check");
    }


    //確認
    public function check(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $currentId = $request->session()->get('currentId');


        return view('admin/member_edit_check', compact('inputs', 'currentId'));
    }
    

    public function update(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $currentId = $request->session()->get('currentId');

        $member = Member::find($currentId);
        // データベースに値を更新
        $data = [
            'name_sei' => $inputs['name_sei'],
            'name_mei' => $inputs['name_mei'],
            'nickname' => $inputs['nickname'],
            'gender' => $inputs['gender'],
            'email' => $inputs['email'],
        ];
    
        if (!is_null($inputs['password'])) {
            $data['password'] = Hash::make($inputs['password']);
        }
    
        $member->update($data);
    
        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("Admin\MemberListController@index");
    }

}
