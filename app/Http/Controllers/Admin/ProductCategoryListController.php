<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\ProductCategory;
use App\ProductSubcategory;

class ProductCategoryListController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->forget('inputs');

        $url = url()->full();
        session(['url' => $url]);

        $query = ProductCategory::query();

        //検索機能
        // ID検索
        $id = $request->input('id');
        if ($id) {
            $query->where('product_categories.id', $id);
        }
        
        // フリーワード検索
        $keyword = $request->input('keyword');
        if ($keyword) {
            $query->leftJoin('product_subcategories', 'product_categories.id', '=', 'product_subcategories.product_category_id')
                  ->where(function ($q) use ($keyword) {
                $q->where('product_categories.name', 'LIKE', '%'.$keyword.'%')
                  ->orWhere('product_subcategories.name', 'LIKE', '%'.$keyword.'%');
            })
            //検索後サブカテゴリ情報を除いて重複を除外
            ->select('product_categories.id', 'product_categories.name', 'product_categories.created_at')
            ->groupBy('product_categories.id', 'product_categories.name', 'product_categories.created_at');
        }

        // ソート順の取得
        $idOrder = $request->input('id_order');
        $createdAtOrder = $request->input('created_at_order');
    
        // 並び順の設定
        if ($idOrder) {
            $query->orderBy('product_categories.id', $idOrder);
        } elseif ($createdAtOrder) {
            $query->orderBy('product_categories.created_at', $createdAtOrder);
        } else {
            $query->orderByDesc('product_categories.id');
        }
    
        $categories = $query->paginate(10);

        return view('admin/product_category_list', compact('categories'));
    }
}
