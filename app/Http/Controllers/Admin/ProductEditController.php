<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use App\ProductSubcategory;


class ProductEditController extends Controller
{
    //入力フォーム
    public function index(Request $request)
    {
        $isEdit = true; // 編集モード

        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');

        $categories = ProductCategory::all();
        $sub_categories = ProductSubcategory::all();
        
        if(request()->has('id')){
            $currentId = request()->query('id');
        }else{
            $currentId = $request->session()->get('currentId');
        }
        
        $query = Product::query();
        $query->where('id', $currentId);
        $result = $query->get()->first();

        $request->session()->put('currentId', $currentId);

        return view('admin/product_regist', compact('result', 'inputs', 'isEdit', 'currentId', 'categories', 'sub_categories'));
    }

    public function post(Request $request)
    {
        $request->session()->put('inputs', $request->all());
        $inputs = $request->all();
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

        return redirect()->action("Admin\ProductEditController@check");
    }


    //確認
    public function check(Request $request)
    {
        $isEdit = true; // 会員編集モード

        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $currentId = $request->session()->get('currentId');
        $category = ProductCategory::where('id', $inputs['category'])->value('name');
        $sub_category = ProductSubcategory::where('id', $inputs['sub_category'])->value('name');


        return view('admin/product_regist_check', compact('inputs', 'currentId', 'isEdit', 'category', 'sub_category'));
    }
    

    public function update(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $currentId = $request->session()->get('currentId');

        $product = Product::find($currentId);
        // データベースに値を更新
        $data = [
            'product_category_id' => $inputs['category'],
            'product_subcategory_id' => $inputs['sub_category'],
            'name' => $inputs['product_name'],
            'product_content' => $inputs['product_content'],
        ];

        // image_1~4が存在する場合に値を更新
        if (isset($inputs['path1'])) {
            $data['image_1'] = $inputs['path1'];
        }
        if (isset($inputs['path2'])) {
            $data['image_2'] = $inputs['path2'];
        }
        if (isset($inputs['path3'])) {
            $data['image_3'] = $inputs['path3'];
        }
        if (isset($inputs['path4'])) {
            $data['image_4'] = $inputs['path4'];
        }

        $product->update($data);
    
        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("Admin\ProductListController@index");
    }

}
