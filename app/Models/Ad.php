<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * auther 刘岩
 * 广告列表
 * */
class Ad extends Model
{
    public $table = 'ad';
//    protected $dateFormat = 'U'; //   设置日期时间格式为Unix时间戳
    public $timestamps = true; // create_at和update_at
    public $primaryKey = 'id'; //指定主键
    protected $guarded = [];


    public function getAdName ($id = []){
        if(empty($id)){
            $info = $this->pluck("name","id");
        }else{
            $info = $this->whereIn('id',$id)->pluck("name","id");
        }
        return json_decode(json_encode($info),true);
    }

}

