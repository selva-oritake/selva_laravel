<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ProductCategory;
use App\ProductSubcategory;

class ProductRegistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = ProductCategory::all();
        $subcategories = ProductSubcategory::all();

        return view('product_regist', compact('categories', 'subcategories'));
    }

    public function getSubcategories(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $subcategories = ProductSubcategory::where('product_category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function check(Request $request)
    {
        $user = Auth::user();

        $inputs = $request->all();
        $inputs['image1'] = null;
        $inputs['image2'] = null;
        $inputs['image3'] = null;
        $inputs['image4'] = null;
        $category = ProductCategory::where('id', $inputs['category'])->value('name');
        $sub_category = ProductSubcategory::where('id', $inputs['sub_category'])->value('name');

        // 画像ファイルの保存場所指定
        if(request('image1')){
            $filename=request()->file('image1')->getClientOriginalName();
            $inputs['image1']=request('image1')->storeAs('public', $filename,);
            $inputs['image1'] = str_replace('public/', 'storage/', $inputs['image1']);
        }
        if(request('image2')){
            $filename2=request()->file('image2')->getClientOriginalName();
            $inputs['image2']=request('image2')->storeAs('public', $filename2);
            $inputs['image2'] = str_replace('public/', 'storage/', $inputs['image2']);
        }
        if(request('image3')){
            $filename3=request()->file('image3')->getClientOriginalName();
            $inputs['image3']=request('image3')->storeAs('public', $filename3);
            $inputs['image3'] = str_replace('public/', 'storage/', $inputs['image3']);
        }
        if(request('image4')){
            $filename4=request()->file('image4')->getClientOriginalName();
            $inputs['image4']=request('image4')->storeAs('public', $filename4);
            $inputs['image4'] = str_replace('public/', 'storage/', $inputs['image4']);
        }


        
         //バリデーション
         $request->validate([
            'product_name' => 'required|max:100',
            'category' => 'required|integer|between:1,5',
            'sub_category' => 'required|integer|between:1,25',
            'image1' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'image2' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'image3' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'image4' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'product_content' => 'required|max:500',
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
            'image_1' => $inputs['image1'],
            'image_2' => $inputs['image2'],
            'image_3' => $inputs['image3'],
            'image_4' => $inputs['image4'],
            'product_content' => $inputs['product_content'],
        ]);

        $request->session()->regenerateToken();

        return view('index');
    }
}
