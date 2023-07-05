<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Member;

class MemberEditController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('member_edit');
    }

    public function edit(Request $request)
    {
        //バリデーション
        $request->validate([
            'name_sei' => 'required|max:20',
            'name_mei' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|integer|between:1,2',        
        ]);

        // データをセッションに保存
        $request->session()->put('inputs', $request->all());
        $inputs = $request;

        return redirect()->action("MemberEditController@check");
    }

    public function check(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');

        return view('member_edit_check', compact('inputs'));
    }

    public function regist(Request $request)
    {
        $user = Auth::user();
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');

        $member = Member::find($user['id']);
        $member->update([
            'name_sei' => $inputs['name_sei'],
            'name_mei' => $inputs['name_mei'],
            'nickname' => $inputs['nickname'],
            'gender' => $inputs['gender'],
        ]);

        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("MypageController@index");
    }
}
