<?php
namespace App\Repostories\Eloquent;
/**
 * auther 刘岩
 * 总的模板的 里面的公共通用的方法 所有的模块都继承这个类
 * */

class Base{
    public $model;

    public function store($request,$condition = array(),$id = null){

        if(empty($id)){
            $id = 'id';
        }

        if(!empty($condition)){
            $info = $this->model->where($condition)->select($id)->first();
        }else{
            $info = array();
        }

        if($info){
            $result = array('success'=>false,'msg'=>'添加失败!此条目已存在!!!');
        }else{

            if(!empty($_POST['_token'])){
                unset($_POST['_token']);
            }
            foreach($_POST as &$v){
                if(is_string($v)){
                    $v = trim($v);
                }
            }
            $res = $this->model->insertGetId($_POST);

            if($res){
                $result = array('success'=>true,'msg'=>'添加成功!!','id'=>$res);
            }else{
                $result = array('success'=>false,'msg'=>'添加失败!!');
            }
        }
        return $result;
    }

    public function edit($request,$columns = array('*'),$condition = ''){
        $info = $this->model->where("id",$condition)->select('*')->first();

        if(empty($info)){
            $info = array();
        }
        return  $info;
    }

    public function update($request,$condition =''){
        if(!empty($_POST['_token'])){
            unset($_POST['_token']);
        }
        if($condition){
            $_POST['updated_at'] = date("Y-m-d H:i:s");
            $res = $this->model->where("id",$condition)->update($_POST);
            if($res){
                $result = array('success'=>true,'msg'=>'添加修改成功！');
            }else{
                $result = array('success'=>false,'msg'=>'添加修改失败！');
            }
        }else{
            $result = array('success'=>false,'msg'=>'添加修改失败！请选择修改条目!!');
        }
        return $result;
    }

    public function delete($request,$condition = ''){
        $res = $this->model->where("id",$condition)->delete();
        if($res){
            $result = array('success'=>true,'msg'=>'删除成功！');
        }else{
            $result = array('success'=>false,'msg'=>'删除失败！');
        }
        return $result;
    }

    public function changeStatus($request,$condition="",$type=""){
        $update['status'] = $type;
        $update['updated_at'] = date("Y-m-d H:i:s");
        $object = $this->model->where("id",$condition)->update($update);
        if($object){
            $result = array('success'=>true,'msg'=>'状态更改成功！');
        }else{
            $result = array('success'=>false,'msg'=>'状态更改失败！');
        }
        return $result;
    }



}

