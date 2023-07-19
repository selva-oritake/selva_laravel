<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Review;

class ReviewRegistController extends Controller
{
    //入力フォーム
    public function index(Request $request)
    {
        $inputs = $request->session()->get('inputs');

        $products = Product::all();

        return view('admin/review_regist', compact('inputs', 'products'));
    }

    public function post(Request $request)
    {

        //バリデーション
        $request->validate([
            'product' => 'required|exists:products,id',
            'evaluation' => 'required|integer|between:1,5',
            'comment' => 'required|max:500',
        ],
        [
            'comment.required' => '＊商品コメントは必須項目です',
            'comment.max' => '＊商品コメントは500文字以内で入力してください',

        ]);
        
        // データをセッションに保存
        $request->session()->put('inputs', $request->all());
        $inputs = $request;

        return redirect()->action("Admin\ReviewRegistController@check");
    }


    //確認
    public function check(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');

        $product = Product::find($inputs['product']);

        //総合評価
        $query = Review::query();
        $query->where('product_id', $inputs['product'])
               ->selectRaw('CEIL(AVG(reviews.evaluation)) as avg_evaluation')
               ->groupBy('reviews.product_id');
        $results = $query->get();
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

        return view('admin/review_regist_check', compact('inputs', 'product', 'avg_evaluation', 'avg_stars'));
    }
    

    public function regist(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        
        $review = new Review;

        // データベースに値をinsert
        $review->create([
            'member_id' => 1,
            'product_id' => $inputs['product'],
            'evaluation' => $inputs['evaluation'],
            'comment' => $inputs['comment'],
        ]);
        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("Admin\ReviewListController@index");
    }

}
