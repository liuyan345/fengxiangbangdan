<?php
namespace App\Repostories\Eloquent;
/**
 * auther 刘岩
 * 总的模板的 里面的公共通用的方法 所有的模块都继承这个类
 * */
use App\Repostories\Contracts\AllInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;


abstract class Models implements AllInterface{
    private $app;
    protected $model;
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    abstract function model();

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
            foreach($_POST as &$v){
                if(is_string($v)){
                    $v = trim($v);
                }
            }

            $res = $this->model->create($_POST);

            if($res){
                $result = array('success'=>true,'msg'=>'添加成功!!','id'=>$res->id);
            }else{
                $result = array('success'=>false,'msg'=>'添加失败!!');
            }
        }
        return $result;
    }

    public function edit($request,$columns = array('*'),$condition = ''){
        $info = $this->model->where("id",$condition)->select('*')->first()->toArray();

        if(empty($info)){
            $info = array();
        }
        return  $info;
    }

    public function update($request,$condition =''){
        $info = $this->model->find($condition);
        if($info){
            $res = $info->update($_POST);
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

    public function delete1($request,$condition = ''){
        $data['is_del'] = 2;
        $res = $this->model->find($condition)->update($data);
        if($res){
            $result = array('success'=>true,'msg'=>'删除成功！');
        }else{
            $result = array('success'=>false,'msg'=>'删除失败！');
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
        $object = $this->model->find($condition);
        $object->status = $type;
        $res = $object->save();
        if($res){
            $result = array('success'=>true,'msg'=>'状态更改成功！');
        }else{
            $result = array('success'=>false,'msg'=>'状态更改失败！');
        }
        return $result;
    }



}

