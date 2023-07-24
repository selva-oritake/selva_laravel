<?php

namespace App\Http\Controllers\Admin;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class MemberDetailController extends Controller
{
    //入力フォーム
    public function index(Request $request)
    {
        $url = session('url');

        $currentId = request()->query('id');
        $query = Member::query();
        $query->where('id', $currentId);
        $result = $query->get()->first();;

        return view('admin/member_detail', compact('result', 'currentId', 'url'));
    }

    public function delete(Request $request)
    {
        $currentId = request()->query('id');
        $member = Member::find($currentId);

        $member->delete();

        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("Admin\MemberListController@index");
    }

}
