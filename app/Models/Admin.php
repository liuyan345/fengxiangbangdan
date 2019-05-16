<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * auther 刘岩
 * 管理员模型
 * */
class Admin extends Model
{
    public $table = 'admin';
//    protected $dateFormat = 'U'; //   设置日期时间格式为Unix时间戳
    public $timestamps = true; // create_at和update_at
    public $primaryKey = 'id'; //指定主键
    protected $guarded = [];

}
