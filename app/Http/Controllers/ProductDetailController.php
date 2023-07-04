<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Review;

class ProductDetailController extends Controller
{
    public function index(Request $request)
    {
        $inputs = $request->session()->get('inputs');

        if(request()->has('id')){
            $currentId = request()->query('id');
        }else{
            $currentId = $inputs['id'];
        }
        $product = session('products')->where('id', $currentId)->first();;
        $updated_at =  date('Ymd', strtotime($product['updated_at']));
        $url2 = session('url2');

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

        // データをセッションに保存
        $request->session()->put('inputs', $product);
          
        return view('product_detail', compact('product', 'updated_at', 'url2', 'avg_evaluation', 'avg_stars'));
    }
}
