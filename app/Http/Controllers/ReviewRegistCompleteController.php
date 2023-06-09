<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Illuminate\Support\Facades\Auth;

class ReviewRegistCompleteController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $inputs2 = $request->session()->get('inputs2');

        $review = new Review;
        // データベースに値をinsert
        $review->create([
            'member_id' => $user['id'],
            'product_id' => $inputs['id'],
            'evaluation' => $inputs2['evaluation'],
            'comment' => $inputs2['comment'],
        ]);

        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return view('review_regist_complete', compact('inputs'));
    }
}
