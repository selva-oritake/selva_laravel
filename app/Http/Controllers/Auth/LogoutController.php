<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    protected function guard()
    {
        return \Auth::guard('web'); //管理者認証のguardを指定
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->regenerateToken();
    
        return redirect('login');
    }
}