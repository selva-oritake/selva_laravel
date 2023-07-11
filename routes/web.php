<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/member_regist', 'MemberRegistController@index');

Route::post('/member_regist', 'MemberRegistController@regist');

Route::get('/member_regist_check', 'MemberRegistController@check');

Route::post('/member_regist_check', 'MemberRegistController@check');

Route::post('/member_regist_complete', 'MemberRegistController@complete');

Route::get('/index', 'IndexController@index');

Route::post('/index', 'ProductRegistController@regist');

Route::get('/login', 'LoginController@index');

Route::get('/password/resetsent', 'ResetSentController@index');

Route::get('/product_regist', 'ProductRegistController@index')->middleware('auth');

Route::post('/get_subcategories', 'ProductRegistController@getSubcategories');

Route::post('/get_subcategories2', 'ProductListController@getSubcategories');

Route::post('/image_upload', 'ProductRegistController@imageUpload');

Route::post('/product_regist_check', 'ProductRegistController@check');

Route::get('/product_list', 'ProductListController@index');

Route::post('/product_list', 'ProductRegistController@regist');

Route::get('/product_detail', 'ProductDetailController@index');

Route::get('/review_regist', 'ReviewRegistController@index')->middleware('auth');

Route::post('/review_regist_check', 'ReviewRegistCheckController@index')->middleware('auth');

Route::post('/review_regist_complete', 'ReviewRegistCompleteController@index')->middleware('auth');

Route::get('/review_list', 'ReviewListController@index');

Route::get('/mypage', 'MypageController@index')->middleware('auth');

Route::get('/withdrawal', 'WithdrawalController@index')->middleware('auth');

Route::delete('/withdrawal', 'WithdrawalController@withdrawal')->name('MemberDelete')->middleware('auth');

Route::get('/member_edit', 'MemberEditController@index')->middleware('auth');

Route::post('/member_edit', 'MemberEditController@edit')->middleware('auth');

Route::get('/member_edit_check', 'MemberEditController@check')->middleware('auth');

Route::post('/member_edit_check', 'MemberEditController@regist')->middleware('auth');

Route::get('/password_edit', 'PasswordEditController@index')->middleware('auth');

Route::post('/password_edit', 'PasswordEditController@update')->middleware('auth');

Route::get('/email_edit', 'EmailEditController@index')->middleware('auth');

Route::post('/email_edit', 'EmailEditController@auth')->middleware('auth');

Route::get('/email_edit_auth', 'EmailEditController@check')->middleware('auth');

Route::post('/email_edit_auth', 'EmailEditController@update')->middleware('auth');

Route::get('/myreview', 'MyreviewController@index')->middleware('auth');

Route::get('/myreview_edit', 'MyreviewEditController@index')->middleware('auth');

Route::post('/myreview_edit', 'MyreviewEditController@edit')->middleware('auth');

Route::get('/myreview_edit_check', 'MyreviewEditController@check')->middleware('auth');

Route::post('/myreview_edit_check', 'MyreviewEditController@update')->middleware('auth');

Route::get('/myreview_delete', 'MyreviewDeleteController@index')->middleware('auth');

Route::delete('/myreview_delete', 'MyreviewDeleteController@delete')->name('MyreviewDelete')->middleware('auth');

use App\Http\Controllers\Admin;

//管理画面



Route::prefix('admin')->namespace('Admin')->group(function() {
    Route::get('/login', 'LoginController@index')->name('admin.login');

    Route::post('/login', 'LoginController@login');

    Route::get('/logout', 'LoginController@logout');

    Route::get('/member_list', [Admin\MemberListController::class, 'index']);

    Route::get('/index',[Admin\IndexController::class, 'index'])->name('admin.index');

    Route::get('/member_regist', 'MemberRegistController@index');

    Route::post('/member_regist', 'MemberRegistController@post');

    Route::get('/member_regist_check', 'MemberRegistController@check');

    Route::post('/member_regist_check', 'MemberRegistController@regist');

    Route::get('/member_edit', 'MemberEditController@index');

    Route::post('/member_edit', 'MemberEditController@post');

    Route::get('/member_edit_check', 'MemberEditController@check');

    Route::post('/member_edit_check', 'MemberEditController@update');

    Route::get('/member_detail', 'MemberDetailController@index');

    Route::post('/member_detail', 'MemberDetailController@delete');

});

Route::prefix('admin')->middleware('auth.admin')->group(function () {
    

    
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
