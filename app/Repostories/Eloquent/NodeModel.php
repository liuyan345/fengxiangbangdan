<?php
namespace App\Repostories\Eloquent;
/*
 * auther  刘岩
 * 后台菜单管理
 * */
use App\Repostories\Contracts\AllInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use Illuminate\Http\Response;
use App\Models\Node;


abstract class NodeModel implements AllInterface{
    private $app;
    protected $model;
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    public function store($request,$condition = array(), $id = null)
    {

    }

    public function tree(){
        $parent = $_GET['parent'];

        if($parent == "#"){
            $parent = 0;
        }
        $info = $this->model->where("pid",$parent)->select("id","name","title","pid","sort")->orderBy("sort","desc")->get()->toArray();
        $data = array();
        foreach ($info as $val){
            $temp = array();
            $temp['id']  = $val['id'];
            $temp['text']  = $val['title'];
            $temp['sort']  = $val['sort'];
            $count = $this->model->where("pid",$val['id'])->count();
            if($count>0){
                $temp['children'] = true;
                $temp['icon']  = "fa fa-folder icon-lg icon-state-warning";
            }else{
                $temp['children'] = false;
                $temp['icon']  = "fa fa-file icon-lg icon-state-warning";
            }
            $temp['type'] = "root";
            $data[] = $temp;
        }
       return $data;
    }

    public function table(){

        if(empty($_GET['id'])){
            $id = 0;
        }else{
            $id = $_GET['id'];
        }

        $dataList = $this->model->where("id",$id)->select("id","name","title","sort","created_at")->get();

        if(empty($dataList)){
            $dataList = array();
        }else{
            $dataList = $dataList->toArray();
        }

        $result = array(
            "sEcho"=>$_POST,
            "iTotalRecords"=>1,
            "iTotalDisplayRecords"=>1,
            "data"=>$dataList,
        );
        echo json_encode($result);

    }


    public function stores($request,$key="",$condition = array()){
        $info = "";
        if((!empty($condition['name'])) && ($condition['name'] !='/')){
            $info = $this->model->where(function($query)use($condition){
                if((!empty($condition['name'])) && ($condition['name'] !='/')){
                    $query->where('name',$condition);
                }
            })->select('id')->first();
        }

        if($info){
            $result = array('success'=>false,'msg'=>'添加失败!此功能路由已存在!!!');
        }else{
            if(empty($_POST['pid'])){
                $_POST['pid'] = 0;
            }
            if( $_POST['pid'] != 0 ){
                $path = $this->model->select('path')->where('id',$_POST['pid'])->first();
                $_POST['path'] = $path['path'].'_'.$_POST['pid'];
            }else{
                $_POST['path'] = 0;
            }

            if(!empty($_POST['smallpower'])){
                foreach($_POST['smallpower'] as $val){
                    $val = trim($val);
                    if(!empty($val)){
                        $smallpower[] = $val;
                    }
                }
                $_POST['smallpower'] = json_encode($smallpower);
            }else{
                $_POST['smallpower'] = '';
            }

            $res = $this->model->create($_POST);
            if($res){
                $result = array('success'=>true,'msg'=>'添加成功!!');
            }else{
                $result = array('success'=>false,'msg'=>'添加失败!!');
            }
        }
        return $result;
    }

    public function datalist($request,$columns = array('*'),$where = array()){

    }


    public function edit($request,$columns = array('*'),$condition = ''){
        $info = $this->model->where("id",$condition)->select($columns)->first();
        if(empty($info)){
            $info = array();
        }else{
            $info = $info->toArray();
        }
        return $info;
    }

    public function update($request,$condition =''){
        $info = $this->model->find($condition);
        if($info){
            if(!empty($_POST['smallpower'])){
                foreach($_POST['smallpower'] as $val){
                    $val = trim($val);
                    if(!empty($val)){
                        $smallpower[] = $val;
                    }
                }
                $_POST['smallpower'] = json_encode($smallpower);
            }else{
                $_POST['smallpower'] = null;
            }

            $res = $info->update($_POST);
            if($res){
                $result = array('success'=>true,'msg'=>'修改成功！');
            }else{
                $result = array('success'=>false,'msg'=>'修改失败！');
            }
        }else{
            $result = array('success'=>false,'msg'=>'修改失败！请选择修改条目!!');
        }
        return $result;
    }

    public function delete($request,$condition = ''){
        $count = $this->model->where("pid",$condition)->count();
        if($count>0){
            $result = array('success'=>false,'msg'=>'删除失败，请先删除子条目！');
        }else{
            $res = $this->model->destroy($condition);
            if($res){
                $result = array('success'=>true,'msg'=>'删除成功！');
            }else{
                $result = array('success'=>false,'msg'=>'删除失败！');
            }
        }
        return $result;
    }

    public function makeModel() {
        $model = $this->app->make($this->model());

        //if (!$model instanceof Model)
            //throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        if (!$model instanceof Model){
            echo $this->model().'不存在，错误！';
        }
        return $this->model = $model;
    }

}



