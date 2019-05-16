<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * auther 刘岩
 * 转发打开视频
 * */
class ZfRead extends Model
{
    public $table = 'zf_read';
//    protected $dateFormat = 'U'; //   设置日期时间格式为Unix时间戳
    public $timestamps = true; // create_at和update_at
    public $primaryKey = 'id'; //指定主键
    protected $guarded = [];
}
