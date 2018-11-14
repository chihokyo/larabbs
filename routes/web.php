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

Route::get('/', 'PagesController@root')->name('root');


// Authentication Routes...登录路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...注册路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...重置密码路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
// 以上等于Auth::routes();

//创建资源路由 只允许show个人页面展示 edit编辑页面 update更新处理
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
// 分类列表话题
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);
// 上传图片
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
//URI 参数 topic 是 『隐性路由模型绑定』 的提示，将会自动注入 ID 对应的话题实体。 URI 最后一个参数表达式 {slug?} ，? 意味着参数可选
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');
//只需要 store 和 destroy 的路由
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);
//新建消息通知路由入口
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);
// 后台访问权限
Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');