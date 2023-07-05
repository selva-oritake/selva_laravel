<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Review;

class MyreviewEditController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $currentId = request()->query('id');
        // セッションからデータを取得
        $inputs = session('myreviews')->where('id', $currentId)->first();;

        //総合評価
        $query2 = Review::query();
        $productId = $inputs['product_id'];
        $query2->where('product_id', $productId)
               ->selectRaw('CEIL(AVG(reviews.evaluation)) as avg_evaluation')
               ->groupBy('reviews.product_id');
        $results = $query2->get();
        $avg_evaluation = $results->pluck('avg_evaluation')->first();
        if($avg_evaluation == 1){
            $avg_stars = "★";
        } elseif($avg_evaluation == 2) {
            $avg_stars = "★★";
        } elseif($avg_evaluation == 3) {
            $avg_stars = "★★★";
        } elseif($avg_evaluation == 4) {
            $avg_stars = "★★★★";
        } elseif($avg_evaluation == 5) {
            $avg_stars = "★★★★★";
        } else {
            $avg_stars = "";
        }

        $request->session()->put('inputs', $inputs);
        $request->session()->put('avg_evaluation', $avg_evaluation);
        $request->session()->put('avg_stars', $avg_stars);


        return view('myreview_edit', compact('inputs',  'avg_evaluation', 'avg_stars'));
    }

    public function edit(Request $request)
    {

        //バリデーション
        $request->validate([
            'evaluation' => 'required|integer|between:1,5',
            'comment' => 'required|max:500',
        ],
        [
            'comment.required' => '＊商品説明は必須項目です',
            'comment.max' => '＊商品コメントは500文字以内で入力してください',

        ]);

        // データをセッションに保存
        $request->session()->put('inputs2', $request->all());
        $inputs2 = $request;

        return redirect()->action("MyreviewEditController@check");
    }

    public function check(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $inputs2 = $request->session()->get('inputs2');
        $avg_evaluation = $request->session()->get('avg_evaluation');
        $avg_stars = $request->session()->get('avg_stars');

        return view('myreview_edit_check', compact('inputs', 'inputs2',  'avg_evaluation', 'avg_stars'));
    }

    public function update(Request $request)
    {
        // セッションからデータを取得
        $inputs2 = $request->session()->get('inputs2');
        $reviewId = $inputs2['id'];

        $review = Review::find($reviewId);
        $review->update([
            'evaluation' => $inputs2['evaluation'],
            'comment' => $inputs2['comment'],
        ]);

        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("MyreviewController@index");
    }
}
