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


    public function getAdName ($id = [],$status = ''){
        $model = $this;
        if(!empty($id)){
            $model = $model->whereIn("id",$id);
        }
        if(!empty($status)){
            $model = $model->where("status",$status);
        }

        $info = $model->select("name","id","type")->get();

        $info = json_decode(json_encode($info),true);
        $newInfo  = [];
        foreach ($info as $v){
            if($v['type'] == 1){
                $v['type'] = 'ios';
            }else if($v['type'] == 2){
                $v['type'] = 'android';
            }else{
                $v['type'] = '未知';
            }
            $newInfo[$v['id']] = $v['name'].'('.$v['type'].')';
        }

        return $newInfo;
    }

    public function getAdNameNew ($id = [],$status = ''){
        $model = $this;
        if(!empty($id)){
            $model = $model->whereIn("id",$id);
        }
        if(!empty($status)){
            $model = $model->where("status",$status);
        }

        $info = $model->select("name","id","type","company")->get();

        $info = json_decode(json_encode($info),true);
        $newInfo  = [];
        foreach ($info as $v){
            if($v['type'] == 1){
                $v['type'] = 'ios';
            }else if($v['type'] == 2){
                $v['type'] = 'android';
            }else{
                $v['type'] = '未知';
            }
            $newInfo[$v['id']] = $v['name'].'('.$v['type'].'-'.$v['company'].')';
        }

        return $newInfo;
    }

}

