<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductCategory;
use App\ProductSubcategory;


class ProductCategoryEditController extends Controller
{
    //入力フォーム
    public function index(Request $request)
    {
        $isEdit = true; // 編集モード

        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        
        if(request()->has('id')){
            $currentId = request()->query('id');
        }else{
            $currentId = $request->session()->get('currentId');
        }
        $query = ProductCategory::query();
        $query->where('id', $currentId);
        $result = $query->get()->first();

        $query2 = ProductSubcategory::query();
        $query2->where('product_category_id', $currentId);
        $result2 = $query2->get();

        $request->session()->put('currentId', $currentId);

        return view('admin/product_category_regist', compact('result', 'result2', 'inputs', 'isEdit', 'currentId'));
    }

    public function post(Request $request)
    {
         //バリデーション
         $request->validate([
            'category' => 'required|max:20',
            'sub_categories' => 'required_without_all:sub_category1,sub_category2,sub_category3,sub_category4,sub_category5,sub_category6,sub_category7,sub_category8,sub_category9,sub_category10',
            'sub_category1' => 'max:20',
            'sub_category2' => 'max:20',
            'sub_category3' => 'max:20',
            'sub_category4' => 'max:20',
            'sub_category5' => 'max:20',
            'sub_category6' => 'max:20',
            'sub_category7' => 'max:20',
            'sub_category8' => 'max:20',
            'sub_category9' => 'max:20',
            'sub_category10' => 'max:20',
        ],
        [
            'category.required' => '＊大カテゴリは入力必須です',
            'category.max' => '＊大カテゴリは20文字以内で入力してください',
            'sub_category1.max' => '＊小カテゴリは20文字以内で入力してください',
            'sub_category2.max' => '＊小カテゴリは20文字以内で入力してください',
            'sub_category3.max' => '＊小カテゴリは20文字以内で入力してください',
            'sub_category4.max' => '＊小カテゴリは20文字以内で入力してください',
            'sub_category5.max' => '＊小カテゴリは20文字以内で入力してください',
            'sub_category6.max' => '＊小カテゴリは20文字以内で入力してください',
            'sub_category7.max' => '＊小カテゴリは20文字以内で入力してください',
            'sub_category8.max' => '＊小カテゴリは20文字以内で入力してください',
            'sub_category9.max' => '＊小カテゴリは20文字以内で入力してください',
            'sub_category10.max' => '＊小カテゴリは20文字以内で入力してください',
            'sub_categories.required_without_all' => 'sub_categoriesは一つ以上入力してください。'
        ]);

        // データをセッションに保存
        $request->session()->put('inputs', $request->all());
        $inputs = $request;

        return redirect()->action("Admin\ProductCategoryEditController@check");
    }


    //確認
    public function check(Request $request)
    {
        $isEdit = true; // 会員編集モード

        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $currentId = $request->session()->get('currentId');


        return view('admin/product_category_regist_check', compact('inputs', 'currentId', 'isEdit'));
    }
    

    public function update(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $currentId = $request->session()->get('currentId');

        $category = ProductCategory::find($currentId);
        // データベースに値を更新
        $data = [
            'name' => $inputs['category'],
        ];
        $category->update($data);

        //一度サブカテゴリを物理削除
        ProductSubcategory::where('product_category_id', $currentId)->forceDelete();
        // 新しいサブカテゴリデータを登録
        for ($i = 1; $i <= 10; $i++) {
            if (isset($inputs['sub_category' . $i])) {
                $data2 = [
                    'product_category_id' => $currentId,
                    'name' => $inputs['sub_category' . $i],
                ];
                ProductSubcategory::create($data2);
            }
        }
    
        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("Admin\ProductCategoryListController@index");
    }

}
