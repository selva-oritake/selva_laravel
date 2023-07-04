<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Review;

class ReviewRegistCheckController extends Controller
{
    public function index(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $inputs2 = $request->all();

        $request->validate([
            'evaluation' => 'required|integer|between:1,5',
            'comment' => 'required|max:500',
        ],
        [
            'comment.required' => '＊商品説明は必須項目です',
            'comment.max' => '＊商品コメントは500文字以内で入力してください',

        ]);

        //総合評価
        $query2 = Review::query();
        $currentId = $inputs['id'];
        $query2->where('product_id', $currentId)
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

        $request->session()->put('inputs2', $inputs2);

        return view('review_regist_check', compact('inputs', 'inputs2', 'avg_evaluation', 'avg_stars'));
    }
}
