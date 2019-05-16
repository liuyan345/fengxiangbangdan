<?php
Route::get('/', function(){
    return redirect("/admin/login");
});
Route::get('/admin/login', 'admin\PublicController@login');
Route::post('/admin/login', 'admin\PublicController@checklogin');
Route::get('/admin/logout', 'admin\PublicController@logout');
Route::post("/admin/changeWd", 'admin\PublicController@changeWd');
Route::get('/nopower', function(){
    echo "<script>function getTopWinow(){var p = window;while(p != p.parent){p = p.parent;} return p;};alert('你没有此权限,请登录！');var top = getTopWinow();top.location.href = '/admin/login'</script>";
});



Route::group(['prefix' => 'admin','middleware'=>'AdminCommon'], function () {
//Route::group(['prefix' => 'admin'], function () {
    //后台首页
    Route::get("adminPlat", 'admin\AdminPlatController@index');
    //修改密码页面
    Route::get("changePW", 'admin\AdminPlatController@changePW');

    /**
     * auther  刘岩
     * 功能模块
     */
    Route::get("power", 'admin\PowerController@index');
    Route::get("power/tree", 'admin\PowerController@tree');
    Route::get("power/edit/{id}", 'admin\PowerController@edit');
    Route::post("power/table", 'admin\PowerController@table');
    Route::post("power/store",'admin\PowerController@store');
    Route::post("power/update/{id}",'admin\PowerController@update');
    Route::post("power/delete/{id}",'admin\PowerController@delete');


    /**
     * auther  刘岩
     * 角色模块
     */
    Route::get("role", 'admin\RoleController@index');
    Route::post('role', 'admin\RoleController@store');
    Route::get('role/tree', 'admin\RoleController@tree');
    Route::post('role/update/{id}', 'admin\RoleController@update');
    Route::post('role/delete/{id}', 'admin\RoleController@delete');
    Route::get('role/edit/{id}', 'admin\RoleController@edit');
    Route::post('role/datalist','admin\RoleController@datalist');
    Route::get('role/powertree','admin\RoleController@powertree');


    /**
     * auther  刘岩
     * 后台用户模块
     */
    Route::get("admin", 'admin\AdminController@index');
    Route::post('admin', 'admin\AdminController@store');
    Route::post('admin/update/{id}', 'admin\AdminController@update');
    Route::post('admin/delete/{id}', 'admin\AdminController@delete');
    Route::post('admin/datalist','admin\AdminController@datalist');
    Route::get('admin/edit/{id}', 'admin\AdminController@edit');
    Route::post('admin/changeStatus/{id}', 'admin\AdminController@changeStatus');




    /**
     * auther  刘岩
     * 用户列表
     */
    Route::get("user", 'admin\UserController@index');
    Route::post('user/datalist','admin\UserController@datalist');
    Route::get('user/edit/{id}', 'admin\UserController@edit');
    Route::post('user/update/{id}', 'admin\UserController@update');

    /**
     * auther  刘岩
     * 视频列表
     */
    Route::get("videoList", 'admin\VideoListController@index');
    Route::post('videoList/datalist','admin\VideoListController@datalist');
    Route::get('videoList/edit/{id}', 'admin\VideoListController@edit');
    Route::post('videoList/update/{id}', 'admin\VideoListController@update');
    Route::post('videoList/upload', 'admin\VideoListController@upload');
    Route::post('videoList/delete/{id}', 'admin\VideoListController@delete');

    /**
     * auther liuyan
     * 分类管理
    */
    Route::get("category", 'admin\CateController@index');
    Route::post("category", 'admin\CateController@store');
    Route::post('category/datalist','admin\CateController@datalist');
    Route::get('category/edit/{id}', 'admin\CateController@edit');
    Route::post('category/update/{id}', 'admin\CateController@update');
    Route::post('category/delete/{id}', 'admin\CateController@delete');

    /**
     * auther liuyan
     * 转发统计列表
     */
    Route::get("reportZf", 'admin\ReportController@zf');
    Route::post('reportZf/datalist','admin\ReportController@zfdatalist');
    /**
     * auther liuyan
     * 视频统计列表
     */
    Route::get("reportVideo", 'admin\ReportController@video');
    Route::post('reportVideo/datalist','admin\ReportController@videodatalist');


});











