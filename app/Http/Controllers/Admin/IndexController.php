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
        $user = Auth::user('admin');

        return view('admin/index', compact('user'));
    }

}
