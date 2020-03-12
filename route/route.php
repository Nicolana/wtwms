<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

// Route::get('hello/:name', 'index/hello');
Route::get('login', 'login/index');
// Route::get('index/index', 'index');
// Route::get('user', 'user/index');
Route::get('user/edit/id/:id', 'user/edit');
Route::get('Role/edit/id/:id', 'role/edit');
Route::get('Storage/edit/:id', 'storage/edit');
Route::get('Category/edit/:id', 'category/edit');
Route::get('Unit/edit/:id', 'unit/edit');
Route::get('Brand/edit/:id', 'brand/edit');
Route::get('Product/edit/:id', 'product/edit');

return [
    // 'login' => 'index/login',
    // 'login/login' => 'login/login/index'
];
