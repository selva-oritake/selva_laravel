<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Review;



class ReviewEditController extends Controller
{
    //入力フォーム
    public function index(Request $request)
    {
        $isEdit = true; // 編集モード

        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');

        $products = Product::all();
        
        if(request()->has('id')){
            $currentId = request()->query('id');
        }else{
            $currentId = $request->session()->get('currentId');
        }
        
        $query = Review::query();
        $query->where('id', $currentId);
        $result = $query->get()->first();

        $product = Product::find($result['product_id']);

        $request->session()->put('currentId', $currentId);
        $request->session()->put('product', $product);

        return view('admin/review_regist', compact('products', 'product', 'result', 'inputs', 'isEdit', 'currentId'));
    }

    public function post(Request $request)
    {
        $request->session()->put('inputs', $request->all());
        $inputs = $request->all();
        //バリデーション
        $request->validate([
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

        return redirect()->action("Admin\ReviewEditController@check");
    }


    //確認
    public function check(Request $request)
    {
        $isEdit = true; // 会員編集モード

        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $currentId = $request->session()->get('currentId');
        $product = $request->session()->get('product');

        //総合評価
        $query = Review::query();
        $query->where('product_id', $product['id'])
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

        return view('admin/review_regist_check', compact('inputs', 'currentId', 'isEdit', 'product', 'avg_evaluation', 'avg_stars'));
    }
    

    public function update(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $currentId = $request->session()->get('currentId');

        $review = Review::find($currentId);
        // データベースに値を更新
        $data = [
            'evaluation' => $inputs['evaluation'],
            'comment' => $inputs['comment'],
        ];

        $review->update($data);
    
        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("Admin\ReviewListController@index");
    }

}
