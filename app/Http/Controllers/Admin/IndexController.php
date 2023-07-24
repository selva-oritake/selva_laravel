<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //トップ画面
    public function index(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $request->session()->forget('url');
        $request->session()->forget('product');
        $request->session()->forget('currentId');

        return view('admin/index', compact('user'));
    }

}
