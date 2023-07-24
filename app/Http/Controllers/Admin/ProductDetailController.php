<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\Product;
use App\ProductCategory;
use App\ProductSubcategory;
use App\Review;
use App\Member;

class ProductDetailController extends Controller
{
    public function index(Request $request)
    {
        
        $inputs = $request->session()->get('inputs');
        $url = session('url');

        if(request()->has('id')){
            $currentId = request()->query('id');
        }else{
            $currentId = $inputs['id'];
        }

        $query = Product::query();
        $query->where('id', $currentId);
        $result = $query->get()->first();

        $category = ProductCategory::where('id', $result['product_category_id'])->value('name');
        $sub_category = ProductSubcategory::where('id', $result['product_subcategory_id'])->value('name');

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

        $query3 = Review::query();
        $query3->where('product_id', $currentId)
              ->leftJoin('members', 'reviews.member_id', '=', 'members.id')
              ->select('reviews.*', 'members.nickname as nickname');
        $reviews = $query3->orderByDesc('id')->paginate(3);
          
        return view('admin/product_detail', compact('currentId', 'result', 'category', 'sub_category', 'avg_evaluation', 'avg_stars', 'reviews', 'url'));
    }

    public function delete(Request $request)
    {
        $currentId = request()->query('id');
        $product = Product::find($currentId);
        $product->delete();

        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("Admin\ProductListController@index");
    }

}
