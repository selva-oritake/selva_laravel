<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App\Member;


class MemberListController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->forget('inputs');

        $user = Auth::user('admin');
        
        $url = url()->full();
        session(['url' => $url]);

        $query = Member::query();

        //検索機能
        // ID検索
        $id = $request->input('id');
        if ($id) {
            $query->where('members.id', $id);
        }
    
        // 性別検索
        $male = $request->input('male');
        $female = $request->input('female');
        if ($male && $female) {
            $query->where(function ($q) {
                $q->where('members.gender', 1)
                  ->orWhere('members.gender', 2);
            });
        } elseif ($male) {
            $query->where('members.gender', 1);
        } elseif ($female) {
            $query->where('members.gender', 2);
        }
        
        // フリーワード検索
        $keyword = $request->input('keyword');
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('members.name_sei', 'LIKE', '%'.$keyword.'%')
                  ->orWhere('members.name_mei', 'LIKE', '%'.$keyword.'%')
                  ->orWhere('members.email', 'LIKE', '%'.$keyword.'%');
            });
        }

        // ソート順の取得
        $idOrder = $request->input('id_order');
        $createdAtOrder = $request->input('created_at_order');
    
        // 並び順の設定
        if ($idOrder) {
            $query->orderBy('members.id', $idOrder);
        } elseif ($createdAtOrder) {
            $query->orderBy('members.created_at', $createdAtOrder);
        } else {
            $query->orderByDesc('members.id');
        }
    
        $members = $query->paginate(10);

        

        return view('admin/member_list', compact('user', 'members'));
    }
}
