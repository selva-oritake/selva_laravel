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

Route::get('/member_regist_complete', 'MemberRegistController@complete');

Route::post('/member_regist_complete', 'MemberRegistController@complete');