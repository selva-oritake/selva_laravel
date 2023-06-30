<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ProductCategory;
use App\ProductSubcategory;

class ProductRegistController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $categories = ProductCategory::all();
        $subcategories = ProductSubcategory::all();
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        $url = session('url');

        return view('product_regist', compact('categories', 'subcategories', 'inputs', 'url'));
    }

    public function getSubcategories(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $subcategories = ProductSubcategory::where('product_category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function imageUpload(Request $request)
    {
        
        if ($request->hasFile('image1')) {
            $filename = $request->file('image1')->getClientOriginalName();
            $image = $request->file('image1');
    
            // 画像をstorage/public配下に保存する
            $path = $image->storeAs('public', $filename);
            $path1 = str_replace('public/', 'storage/', $path);
            $paths['path1'] = $path1;
        }
    
        if ($request->hasFile('image2')) {
            $filename = $request->file('image2')->getClientOriginalName();
            $image = $request->file('image2');
    
            // 画像をstorage/public配下に保存する
            $path = $image->storeAs('public', $filename);
            $path2 = str_replace('public/', 'storage/', $path);
            $paths['path2'] = $path2;
        }
    
        if ($request->hasFile('image3')) {
            $filename = $request->file('image3')->getClientOriginalName();
            $image = $request->file('image3');
    
            // 画像をstorage/public配下に保存する
            $path = $image->storeAs('public', $filename);
            $path3 = str_replace('public/', 'storage/', $path);
            $paths['path3'] = $path3;
        }
    
        if ($request->hasFile('image4')) {
            $filename = $request->file('image4')->getClientOriginalName();
            $image = $request->file('image4');
    
            // 画像をstorage/public配下に保存する
            $path = $image->storeAs('public', $filename);
            $path4 = str_replace('public/', 'storage/', $path);
            $paths['path4'] = $path4;
        }

        return response()->json($paths);
    }

    public function check(Request $request)
    {
        $user = Auth::user();

        $inputs = $request->all();
        $category = ProductCategory::where('id', $inputs['category'])->value('name');
        $sub_category = ProductSubcategory::where('id', $inputs['sub_category'])->value('name');
        
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
        $request->session()->put('inputs', $inputs);

        return view('product_regist_check')->with([
            'inputs' => $inputs,
            'category' => $category,
            'sub_category' => $sub_category,
        ]);
    }

    public function regist(Request $request)
    {
        $user = Auth::user();
        $member_id = Auth::id();
        // セッションからデータを取得
        $inputs = $request->session()->get('inputs');
        
        $product = new Product;

        // データベースに値をinsert
        $product->create([
            'member_id' => $member_id,
            'name' => $inputs['product_name'],
            'product_category_id' => $inputs['category'],
            'product_subcategory_id' => $inputs['sub_category'],
            'image_1' => $inputs['path1'],
            'image_2' => $inputs['path2'],
            'image_3' => $inputs['path3'],
            'image_4' => $inputs['path4'],
            'product_content' => $inputs['product_content'],
        ]);

        $request->session()->regenerateToken();

        //セッション削除
        $request->session()->forget('inputs');

        return view('index');
    }
}
