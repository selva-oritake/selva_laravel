<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\ProductCategory;
use App\ProductSubcategory;

class ProductListController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = ProductCategory::all();
        $subcategories = ProductSubcategory::all();
    
        return view('product_list', compact('categories', 'subcategories'));
    }

    public function search(Request $request)
    {
        $categories = ProductCategory::all();
        $subcategories = ProductSubcategory::all();
        $query = Product::query();
    
        // カテゴリ検索
        $categoryId = $request->input('category');
        if ($categoryId) {
            $query->where('product_category_id', $categoryId);
        }
    
        // サブカテゴリ検索
        $subcategoryId = $request->input('subcategory');
        if ($subcategoryId) {
            $query->where('product_subcategory_id', $subcategoryId);
        }
    
        // フリーワード検索
        $keyword = $request->input('keyword');
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%'.$keyword.'%')
                  ->orWhere('product_content', 'LIKE', '%'.$keyword.'%');
            });
        }
    
        $products = $query->get();
    
        // カテゴリとサブカテゴリのオプションをビューに渡す
        $categories = Category::all();
        $subcategories = [];
        if ($categoryId) {
            $category = Category::find($categoryId);
            if ($category) {
                $subcategories = $category->subcategories;
            }
        }
    
        return view('products.index', compact('products', 'categories', 'subcategories'));
    }
}
