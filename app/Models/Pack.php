<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * auther 刘岩
 * 渠道包列表
 * */
class Pack extends Model
{
    public $table = 'ad_pack';
//    protected $dateFormat = 'U'; //   设置日期时间格式为Unix时间戳
    public $timestamps = true; // create_at和update_at
    public $primaryKey = 'id'; //指定主键
    protected $guarded = [];


    public function getPackName ($id = [],$status = 1){

//        if(empty($id)){
//            $info = $this->where('status',$status)->select("name","id","type")->get();
//        }else{
//            $info = $this->where('status',$status)->whereIn('id',$id)->select("name","id","type")->get();
//        }
//        $info = json_decode(json_encode($info),true);
//        $newInfo  = [];
//        foreach ($info as $v){
//            if($v['type'] == 1){
//                $v['type'] = 'ios';
//            }else if($v['type'] == 2){
//                $v['type'] = 'android';
//            }else{
//                $v['type'] = '未知';
//            }
//            $newInfo[$v['id']] = $v['name'].'('.$v['type'].')';
//        }
//
//        return json_decode(json_encode($info),true);
    }

}

