<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\Review;

class ReviewListController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->forget('inputs');

        $query = Review::query();

        //検索機能
        // ID検索
        $id = $request->input('id');
        if ($id) {
            $query->where('reviews.id', $id);
        }
        
        // フリーワード検索
        $keyword = $request->input('keyword');
        if ($keyword) {
            $query->where('reviews.comment', 'LIKE', '%'.$keyword.'%');
        }
        

        // ソート順の取得
        $idOrder = $request->input('id_order');
        $createdAtOrder = $request->input('created_at_order');
    
        // 並び順の設定
        if ($idOrder) {
            $query->orderBy('reviews.id', $idOrder);
        } elseif ($createdAtOrder) {
            $query->orderBy('reviews.created_at', $createdAtOrder);
        } else {
            $query->orderByDesc('reviews.id');
        }
    
        $reviews = $query->paginate(10);

        return view('admin/review_list', compact('reviews'));
    }
}
