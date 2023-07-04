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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
