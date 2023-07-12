<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductCategory;
use App\ProductSubcategory;

class ProductCategoryDetailController extends Controller
{
    public function index(Request $request)
    {
        
        $currentId = request()->query('id');
        $query = ProductCategory::query();
        $query->where('id', $currentId);
        $result = $query->get()->first();

        $query2 = ProductSubcategory::query();
        $query2->where('product_category_id', $currentId);
        $result2 = $query2->get();

        $request->session()->put('currentId', $currentId);

        return view('admin/product_category_detail', compact('result', 'result2', 'currentId'));
    }

    public function delete(Request $request)
    {
        $currentId = request()->query('id');
        $category = ProductCategory::find($currentId);
        $category->delete();
        
        // 関連するサブカテゴリ削除
        ProductSubcategory::where('product_category_id', $currentId)->delete();

        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("Admin\ProductCategoryListController@index");
    }

}
