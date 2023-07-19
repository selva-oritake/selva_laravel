<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use App\ProductSubcategory;

class ProductRegistController extends Controller
{
    //入力フォーム
    public function index(Request $request)
    {
        $categories = ProductCategory::all();
        $subcategories = ProductSubcategory::all();

        // セッションから入力データを取得する前に、バリデーションエラーの場合はセッションを削除する
        if ($request->session()->has('errors')) {
            $request->session()->forget('inputs');
        }

        $inputs = $request->session()->get('inputs');

        return view('admin/product_regist', compact('categories', 'subcategories', 'inputs'));
    }

    public function post(Request $request)
    {

        //バリデーション
        $request->validate([
            'product_name' => 'required|max:100',
            'category' => 'required|integer|between:1,5',
            'sub_category' => 'required|integer' . ($request->category == 1 ? '|between:1,5' : ($request->category == 2 ? '|between:6,10' : ($request->category == 3 ? '|between:11,15' : ($request->category == 4 ? '|between:16,20' : '|between:21,25')))),
            'product_content' => 'required|max:500',
        ],
        [
            'product_name.required' => '＊商品名は必須項目です',
            'product_name.max' => '＊商品名は100文字以内で入力してください',
            'product_content.required' => '＊商品説明は必須項目です',
            'product_content.max' => '＊商品説明は500文字以内で入力してください',

        ]);
        
        // データをセッションに保存
        $request->session()->put('inputs', $request->all());
        $inputs = $request;

        return redirect()->action("Admin\ProductRegistController@check");
    }


    //確認
    public function check(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');

        $category = ProductCategory::where('id', $inputs['category'])->value('name');
        $sub_category = ProductSubcategory::where('id', $inputs['sub_category'])->value('name');

        return view('admin/product_regist_check', compact('category', 'sub_category', 'inputs'));
    }
    

    public function regist(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        
        $product = new Product;

        // データベースに値をinsert
        $product->create([
            'member_id' => 1,
            'name' => $inputs['product_name'],
            'product_category_id' => $inputs['category'],
            'product_subcategory_id' => $inputs['sub_category'],
            'image_1' => $inputs['path1'],
            'image_2' => $inputs['path2'],
            'image_3' => $inputs['path3'],
            'image_4' => $inputs['path4'],
            'product_content' => $inputs['product_content'],
        ]);
        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("Admin\ProductListController@index");
    }

}
