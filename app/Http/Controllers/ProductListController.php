<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\ProductCategory;
use App\ProductSubcategory;
use Illuminate\Pagination\Paginator;
use App\Review;

class ProductListController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $url = url()->current();
        $url2 = url()->full();
        session(['url' => $url]);
        session(['url2' => $url2]);
        
        $categories = ProductCategory::all();
        $subcategories = ProductSubcategory::all();
        $query = Product::query();
        
        //総合評価
        $query2 = Review::query();
        $query2->selectRaw('product_id, CEIL(AVG(reviews.evaluation)) as avg_evaluation')
               ->groupBy('reviews.product_id');

        //検索機能
         // カテゴリ検索
         $categoryId = $request->input('category');
         if ($categoryId) {
             $query->where('products.product_category_id', $categoryId);
         }
     
         // サブカテゴリ検索
         $subcategoryId = $request->input('sub_category');
         if ($subcategoryId) {
             $query->where('products.product_subcategory_id', $subcategoryId);
         }
     
         // フリーワード検索
         $keyword = $request->input('keyword');
         if ($keyword) {
             $query->where(function ($q) use ($keyword) {
                 $q->where('products.name', 'LIKE', '%'.$keyword.'%')
                   ->orWhere('products.product_content', 'LIKE', '%'.$keyword.'%');
             });
         }
        
        $query->leftJoin('product_categories', 'products.product_category_id', '=', 'product_categories.id')
              ->leftJoin('product_subcategories', 'products.product_subcategory_id', '=', 'product_subcategories.id')
              ->leftJoinSub($query2, 'reviews', function ($join) {
                $join->on('products.id', '=', 'reviews.product_id');
              })
              ->select('products.*', 'product_categories.name as category_name', 'product_subcategories.name as subcategory_name', 'reviews.avg_evaluation as avg_evaluation');
              


        $products = $query->orderByDesc('products.id')->paginate(10);
        session(['products' => $products]);

        $request->session()->forget('inputs');
        $request->session()->forget('inputs2');
    
        return view('product_list', compact('categories', 'subcategories', 'products',));
    }

    public function getSubcategories(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $subcategories = ProductSubcategory::where('product_category_id', $categoryId)->get();
        return response()->json($subcategories);
    }



}
