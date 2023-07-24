<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use App\ProductSubcategory;
use Illuminate\Support\Facades\Validator;


class ProductEditController extends Controller
{
    //入力フォーム
    public function index(Request $request)
    {
        $isEdit = true; // 編集モード

        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $url = session('url');

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

        return view('admin/product_regist', compact('result', 'inputs', 'isEdit', 'currentId', 'categories', 'sub_categories', 'url'));
    }

    public function post(Request $request)
    {
        $request->session()->put('inputs', $request->all());
        $inputs = $request->all();
        
        //バリデーション
        Validator::extend('valid_category', function ($attribute, $value, $parameters, $validator) {
            // $valueには入力値が渡される
            // ここで$categoryがproduct_categoriesテーブルのidカラムに存在するか確認
            $category = (int) $value;
        
            // product_categoriesテーブルに$idが存在するかをチェック
            return \App\ProductCategory::where('id', $category)->exists();
        });
        Validator::extend('valid_sub_category', function ($attribute, $value, $parameters, $validator) {
            // $valueには入力値が渡される
            // ここで$subCategoryがproduct_subcategoriesテーブルのidカラムに存在するか確認
            $category = (int) $validator->getData()['category'];
            $subCategory = (int) $value;
        
            return \App\ProductSubcategory::where('product_category_id', $category)
                                          ->where('id', $subCategory)
                                          ->exists();
        });

        $request->validate([
            'product_name' => 'required|max:100',
            'category' => 'required|valid_category',
            'sub_category' => 'required|valid_sub_category',
            'product_content' => 'required|max:500',
        ],
        [
            'category.required' => '＊カテゴリは必須項目です',
            'category.valid_category' => '＊無効なカテゴリが選択されました',
            'sub_category.required' => '＊サブカテゴリは必須項目です',
            'sub_category.valid_sub_category' => '＊無効なサブカテゴリが選択されました',
            'product_name.required' => '＊商品名は必須項目です',
            'product_name.max' => '＊商品名は100文字以内で入力してください',
            'product_content.required' => '＊商品説明は必須項目です',
            'product_content.max' => '＊商品説明は500文字以内で入力してください',

        ]);
        
        // データをセッションに保存
        $request->session()->put('inputs', $request->all());
        $inputs = $request;

        $id = $request->query('id');
        return redirect()->action('Admin\ProductEditController@check', ['id' => $id]);
    }


    //確認
    public function check(Request $request)
    {
        $isEdit = true; // 会員編集モード

        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $currentId = $request->session()->get('currentId');
        $url = session('url');

        $category = ProductCategory::where('id', $inputs['category'])->value('name');
        $sub_category = ProductSubcategory::where('id', $inputs['sub_category'])->value('name');

        $id = $request->query('id');
        return view('admin/product_regist_check', compact('inputs', 'currentId', 'isEdit', 'category', 'sub_category', 'url', 'id'));
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
