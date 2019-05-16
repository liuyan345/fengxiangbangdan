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
     * 渠道列表
     */
    Route::get("channel", 'admin\ChannelController@index');
    Route::post("channel", 'admin\ChannelController@store');
    Route::post('channel/datalist','admin\ChannelController@datalist');
    Route::get('channel/edit/{id}', 'admin\ChannelController@edit');
    Route::post('channel/update/{id}', 'admin\ChannelController@update');

    /**
     * auther  刘岩
     * 广告列表
     */
    Route::get("ad", 'admin\AdController@index');
    Route::post("ad", 'admin\AdController@store');
    Route::post('ad/datalist','admin\AdController@datalist');
    Route::get('ad/edit/{id}', 'admin\AdController@edit');
    Route::post('ad/update/{id}', 'admin\AdController@update');
    Route::post('ad/delete/{id}', 'admin\AdController@delete');
    Route::post('ad/select', 'admin\AdController@select');

    /**
     * auther liuyan
     * 渠道包管理
    */
    Route::get("pack", 'admin\PackController@index');
    Route::post("pack", 'admin\PackController@store');
    Route::post('pack/datalist','admin\PackController@datalist');
    Route::get('pack/edit/{id}', 'admin\PackController@edit');
    Route::post('pack/update/{id}', 'admin\PackController@update');
    Route::post('pack/delete/{id}', 'admin\PackController@delete');

    /**
     * auther liuyan
     * 数据列表
     */
    Route::get("data", 'admin\DataController@zf');
    Route::post('data/datalist','admin\DataController@zfdatalist');
    Route::post('data/upload','admin\DataController@upload');



});











