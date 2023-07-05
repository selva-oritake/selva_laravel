<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Review;
use App\Product;
use App\ProductCategory;
use App\ProductSubcategory;

class MyreviewController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Review::query();
        $query->where('reviews.member_id', $user['id'])
              ->leftJoin('products', 'reviews.product_id', '=', 'products.id')
              ->leftJoin('product_categories', 'products.product_category_id', '=', 'product_categories.id')
              ->leftJoin('product_subcategories', 'products.product_subcategory_id', '=', 'product_subcategories.id')
              ->select('reviews.*', 'products.image_1 as image_1', 'products.image_2 as image_2', 'products.image_3 as image_3', 'products.image_4 as image_4', 'products.name as name', 'product_categories.name as category', 'product_subcategories.name as subcategory');
        $myreviews = $query->orderByDesc('id')->paginate(5);

        // データをセッションに保存
        session(['myreviews' => $myreviews]);

        return view('myreview', compact('myreviews'));
    }
}
