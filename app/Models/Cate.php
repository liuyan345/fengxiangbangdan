<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * auther 刘岩
 * 视频分类列表
 * */
class Cate extends Model
{
    public $table = 'cate';
//    protected $dateFormat = 'U'; //   设置日期时间格式为Unix时间戳
    public $timestamps = true; // create_at和update_at
    public $primaryKey = 'id'; //指定主键
    protected $guarded = [];


    public function getCateName ($id = []){
        if(empty($id)){
            $info = $this->pluck("cate_name","id");
        }else{
            $info = $this->whereIn('id',$id)->pluck("cate_name","id");
        }
        return json_decode(json_encode($info),true);
    }

}

