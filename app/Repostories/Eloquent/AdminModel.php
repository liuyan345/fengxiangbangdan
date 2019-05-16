<?php
namespace App\Repostories\Eloquent;
/**
 * auther 刘岩
 * 后台的管理员模块
 * */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use App\Repostories\Eloquent\Models;
use App\Models\Role;
use App\Models\Node;


abstract class AdminModel extends Models{
    private $app;
    protected $model;
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    public function index(){
        $role = New Role;
        $roleInfos = $role->pluck('name','id')->toArray();
        return array("role"=>$roleInfos);
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
        if(!empty($_POST['admin_name'])){
            $map[]  = array('admin_name','like',"%".$_POST['admin_name']."%");
        }
        if(!empty($_POST['nick_name'])){
            $map[]  = array('nick_name','like',"%".$_POST['nick_name']."%");
        }

        if(!empty($_POST['role_id'])){
            $map[] = array("role_id",$_POST['role_id']);
        }
        $map[] = array("is_del",1);


        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $rows = isset($_POST['length']) ? intval($_POST['length']) == 0 ? 10 : intval($_POST['length']) : 10;

        $roleInfo = $this->getrole();

        $list       =  $this->model->where($map)->select($columns)->orderBy($orderField,$orderType)->offset($start)->limit($rows)->get()->toArray();
        $total      =  $this->model->where($map)->count();

        if(empty($list)){
            $list = array();
        }else{
            foreach ($list as &$val){
                if($val['status'] == 1){
                    $val['status'] = "<span style='color:green'>正常</span>";
                }else if($val['status'] == 2){
                    $val['status'] = "<span style='color:red'>禁用</span>";
                }
                $val['role'] = $roleInfo[$val['role_id']];
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

    public function getrole(){
        $role = new Role;
        $roleinfo = $role->pluck('name','id')->toArray();
        return $roleinfo;
    }

}



