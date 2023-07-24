<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductCategory;
use App\ProductSubcategory;

class ProductCategoryRegistController extends Controller
{
    //入力フォーム
    public function index(Request $request)
    {
        $inputs = $request->session()->get('inputs');

        return view('admin/product_category_regist', compact('inputs'));
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
            'sub_categories.required_without_all' => '＊小カテゴリは一つ以上入力してください'
        ]);

        // データをセッションに保存
        $request->session()->put('inputs', $request->all());
        $inputs = $request;

        return redirect()->action("Admin\ProductCategoryRegistController@check");
    }


    //確認
    public function check(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');

        return view('admin/product_category_regist_check', compact('inputs'));
    }
    

    public function regist(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');

        $category = new ProductCategory;
        // データベースに値をinsert
        $category->name = $inputs['category'];
        $category->save();
        
        // カテゴリが正常に保存された後にIDを取得する
        $categoryID = $category->id;

        // sub_category1〜10をデータベースに登録
        for ($i = 1; $i <= 10; $i++) {
            if (isset($inputs['sub_category' . $i])) {
                $subcategory = new ProductSubcategory;
                $subcategory->create([
                    'product_category_id' => $categoryID,
                    'name' => $inputs['sub_category' . $i],
                ]);
            }
        }
        // 二重送信を防ぐため token を再生成
        $request->session()->regenerateToken();

        return redirect()->action("Admin\ProductCategoryListController@index");
    }

}
