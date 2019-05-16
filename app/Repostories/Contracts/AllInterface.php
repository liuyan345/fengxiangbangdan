<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/24
 * Time: 19:10
 */
namespace  App\Repostories\Contracts;
/**
 * auther 刘岩
 * 定义一个总的接口
 * */
interface AllInterface{
    /**
     * 列表
     * $column 获取的字段
     */
    public function datalist($request,$columns = array('*'),$where = array());
    /**
     * 新增
     * $condition 条件
    */
    public function store($request,$condition = array(),$id = null);

    /**
     * 获取单条信息
     * $condition 获取信息的id 等条件
    */
    public function edit($request,$columns = array('*'),$condition = '');

    /**
     * 更新信息
     * $condition 被更新数据的条件
     */
    public function update($request,$condition = '');

    /**
     * 删除
     * $condition 被删除数据的条件
    */
    public function delete($request,$condition = '');
}
