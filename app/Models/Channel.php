<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * auther 刘岩
 * 渠道列表
 * */
class Channel extends Model
{
    public $table = 'channel';
//    protected $dateFormat = 'U'; //   设置日期时间格式为Unix时间戳
    public $timestamps = true; // create_at和update_at
    public $primaryKey = 'id'; //指定主键
    protected $guarded = [];


    public function getChannelName ($id = []){
        if(empty($id)){
            $info = $this->pluck("name","id");
        }else{
            $info = $this->whereIn('id',$id)->pluck("name","id");
        }
        return json_decode(json_encode($info),true);
    }

}

