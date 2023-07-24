<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\Product;

class ProductListController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->forget('inputs');
        $url = url()->full();
        session(['url' => $url]);

        $query = Product::query();

        //検索機能
        // ID検索
        $id = $request->input('id');
        if ($id) {
            $query->where('products.id', $id);
        }
        
        // フリーワード検索
        $keyword = $request->input('keyword');
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('products.name', 'LIKE', '%'.$keyword.'%')
                      ->orWhere('products.product_content', 'LIKE', '%'.$keyword.'%');
            });
        }
        

        // ソート順の取得
        $idOrder = $request->input('id_order');
        $createdAtOrder = $request->input('created_at_order');
    
        // 並び順の設定
        if ($idOrder) {
            $query->orderBy('products.id', $idOrder);
        } elseif ($createdAtOrder) {
            $query->orderBy('products.created_at', $createdAtOrder);
        } else {
            $query->orderByDesc('products.id');
        }
    
        $products = $query->paginate(10);

        return view('admin/product_list', compact('products'));
    }
}
