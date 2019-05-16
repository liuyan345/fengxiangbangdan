<?php
namespace App\Repostories\Eloquent;
/**
 * auther 刘岩
 * 用户列表模块
 * */

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class UserModel extends Models{
    private $app;
    protected $model;
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    public function datalist($request,$columns = array('*'),$where = array()){
        if(!empty($_POST['order'])){
            $order           = $_POST['order'];
            $orderFieldIndex = $order[0]['column'];
            $orderType       = $order[0]['dir'];
            $orderField      = $_POST['columns'][$orderFieldIndex]['data'];
        }else{
            $orderType       = "desc";
            $orderField      = "created_at";
        }
        $map = array();
        if(!empty($request->input("nickName"))){
            $this->model = $this->model->where('nickName','like',"%".$request->input("nickName")."%");
        }

        if(!empty($request->input("status"))){
            $this->model = $this->model->where('status',$request->input("status"));
        }

        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $rows = isset($_POST['length']) ? intval($_POST['length']) == 0 ? 10 : intval($_POST['length']) : 10;

        $total      =  $this->model->count();
        $list       =  $this->model->where($map)->select($columns)->orderBy($orderField,$orderType)->offset($start)->limit($rows)->get()->toArray();

        if(empty($list)){
            $list = array();
        }else{
            foreach ($list as &$val){
                if($val['status'] == 1){
                    $val['status'] = "<span style='color:green'>正常</span>";
                }else if($val['status'] == 2){
                    $val['status'] = "<span style='color:red'>禁用</span>";
                }
            }
        }
        $result = array(
            "sEcho"=>$_POST,
            "iTotalRecords"=>$total,
            "iTotalDisplayRecords"=>$total,
            "data"=>$list,
        );
        return $result;
    }

    public function makeModel() {
        $model = $this->app->make($this->model());

        //if (!$model instanceof Model)
        //throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        if (!$model instanceof Model){
            echo $this->model().'不错在，错误！';
        }
        return $this->model = $model;
    }

}



