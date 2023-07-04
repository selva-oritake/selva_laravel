<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //トップ画面
    public function index(Request $request)
    {
        $user = Auth::user();
        //セッション削除
        $request->session()->forget('url');
        $request->session()->forget('url2');
        $request->session()->forget('products');
        $request->session()->forget('inputs2');

        return view('index');
    }

}
