<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Review;

class ReviewRegistController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');

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

        return view('review_regist', compact('inputs',  'avg_evaluation', 'avg_stars'));
    }
}
