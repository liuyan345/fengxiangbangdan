<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * auther 刘岩
 * 视频作者表
 * */
class Header extends Model
{
    public $table = 'header';
//    protected $dateFormat = 'U'; //   设置日期时间格式为Unix时间戳
    public $timestamps = true; // create_at和update_at
    public $primaryKey = 'id'; //指定主键
    protected $guarded = [];


    public function getHeaderInfo ($id = []){
        if(empty($id)){
            $info = $this->select("id","name","header")->get();
        }else{
            $info = $this->whereIn('id',$id)->select("id","name","header")->get();
        }

        $info = json_decode(json_encode($info),true);

        $newInfo = [];

        foreach ($info as $val){
            $newInfo[$val['id']] = $val;
        }

        return $newInfo;
    }

}

