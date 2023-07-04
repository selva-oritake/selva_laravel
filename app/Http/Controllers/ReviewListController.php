<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Illuminate\Pagination\Paginator;
use App\Member;

class ReviewListController extends Controller
{
    public function index(Request $request)
    {
        
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $inputs2 = $request->session()->get('inputs2');

        $currentId = request()->query('id');
        
        $query = Review::query();
        $query->where('product_id', $currentId)
              ->leftJoin('members', 'reviews.member_id', '=', 'members.id')
              ->select('reviews.*', 'members.nickname as nickname');
        $reviews = $query->orderByDesc('id')->paginate(5);
        
        //総合評価
        $query2 = Review::query();
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

        return view('review_list', compact('inputs', 'inputs2', 'reviews', 'avg_evaluation', 'avg_stars'));
    }
}
