<?php
namespace App\Repostories\Eloquent;
/**
 * 角色管理
 * auther 刘岩
 * */
use App\Repostories\Contracts\AllInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use App\Models\Node;
use DB;

abstract class RoleModel implements AllInterface{
    private $app;
    protected $model;
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    //添加
    public function store($request,$condition = array(),$id=null){
        if(!empty($_POST['name'])){
            $info = $this->model->where(function($query)use($condition){
                if(!empty($condition)){
                    foreach ($condition as $k=>$v){
                        $query->where($k,$v);
                    }
                }
            })->select('id')->first();
            
            if($info){
                $result = array('success'=>false,'msg'=>'添加失败!此权限分组已存在!!!');
            }else{
                if(!empty($_POST['power'])){
                    $_POST['power'] = explode(',',$_POST['power']);
                    sort($_POST['power']);
                    $_POST['power'] = implode(',',$_POST['power']);

                    $powername = $this->get_powername($_POST['power']);
                    $zhuhechaxun = $this->zhuhechaxun($_POST['power'],$powername);

                    $_POST['powername'] = $zhuhechaxun['names'];
                    $powers = $this->get_array1($_POST['power'],$zhuhechaxun['zhuhe']);

                    $_POST['powers'] = json_encode($powers);
                    $ids = $this->getids($_POST['power']);
                    $ids = explode(',',$ids);
                    $Node = new Node;
                    $rootidlist = $Node->select('id')->where('pid',0)->whereIn('id',$ids)->get()->toArray();

                    $tmproot = array();
                    foreach($rootidlist as $value){
                        $tmproot[] = $value['id'];
                    }
                    $rootids = implode(',',$tmproot);
                    $_POST['rootids'] = $rootids;

                    unset($_POST['id']);
                    foreach($_POST as &$v){
                        if(is_string($v)){
                            $v = trim($v);
                        }
                    }
                    $res = $this->model->create($_POST);

                    if($res){
                        $result = array('success'=>true,'msg'=>'添加成功!!');
                    }else{
                        $result = array('success'=>false,'msg'=>'添加失败!!');
                    }
                }else{
                    $result = array('success'=>false,'msg'=>'添加失败!!权限名称不能为空!');
                }

            }
        }else{
            $result = array('success'=>false,'msg'=>'添加失败!!请勾选分配的页面功能!');
        }
        return $result;
    }

    //获取所选中的菜单的文本名称
    public function get_powername($power){
        $data = $this->tree(0);
        $powername = "";
        $power = explode(',',$power);
        foreach ($power as $val){
            $name = $this->get_name($val,$data);

            if(!empty($name)){
                if(empty($powername)){
                    $powername = $name;
                }else{
                    $powername .= ','.$name;
                }
            }
        }

        return $powername;
    }

    public function get_name($id,$data){
        $name = "";
        foreach ($data as $val){
            if($val['id'] == $id){
                $name = $val['text'];
                break;
            }else{
                if(!empty($val['children'])){
                   $name = $this->get_name($id,$val['children']);
                   if(!empty($name)){
                       break;
                   }
                }
            }
        }
        return $name;
    }


    public function get_array1($ids=null,$zhuhe){
        $Node = new Node;
        if(!empty($ids)){
            $ids = $this->getids($ids);
            $ids = explode(',',$ids);
        }

        $result = $Node->select('name','title',DB::raw('CONCAT_WS("_",path,id) as abspath'),'smallpower','id','sort','icon')->whereIn('id',$ids)->orderBy('abspath')->get()->toArray();
        $i = 1;
        $j = 0;
        foreach($result as $key=>$value){
            $deep = count(explode('_',$value['abspath']));

            if($deep==1){
                $data[$i-1]['power'] = $value;
                $j=0; //第二次开始时让j=0;
                $i++;
            }elseif($deep==2){
                $data[$i-1]['power']['childrens'][] =$value;
                $j++;
            }elseif($deep==3){
                $tmparray = json_decode($value['smallpower'],1);
                if(!empty($tmparray)){
                    $tmpcouldedit = array();
                    foreach($tmparray as $key=>$val){
                        $couldeditkey = 'couldedit'.($key+1);
                        $zhuhekey = $value['id'].'.'.($key+1);
                        if(!empty($zhuhe[$zhuhekey])){
                            $tmpcouldedit[$couldeditkey] = 1;
                            //表示只有查看的权限。
                        }else{
                            $tmpcouldedit[$couldeditkey] = 0;
                        }
                    }
                    $value['couldedit'] = $tmpcouldedit;
                }else{
                    $value['couldedit'] = '查看';
                }
                $data[$i-1]['power']['childrens'][$j-1]['childrens'][] = $value;
            }
        }
        return $data;
    }

    protected function getids($ids=null){
        $idsarray = explode(',',$ids);
        foreach($idsarray as $key=>$val){
            if(strstr($val,'.')){
                $tmp = explode('.',$val);
                $tmpids[] = $tmp[0];
            }else{
                $tmpids[] = $val;
            }
        }
        $idsarr = array_unique($tmpids);
        sort($idsarr);
        $ids = implode(',',$idsarr);

        $Node = new Node;
        $tmp1 = array();
        if(!empty($ids)){
            $arr = explode(',',$ids);
            $result = $Node->whereIn('id',$arr)->select('pid')->get()->toArray();
            foreach($result as $value){
                $tmp1[] = $value['pid'];
                if($value['pid'] != 0){
                    $resq = $Node->select('pid')->where('id',$value['pid'])->first();
                    $tmp1[] = $resq['pid'];
                }
            }

            $base = array_unique($tmp1);
            $diff = array_diff($base,$arr);
            sort($diff);
            if($diff[0]==0){
                array_shift($diff);
            }
            $idsarray = array_merge($diff,$arr);
            return implode(',',$idsarray);
        }
    }

    // 获取角色列表
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

        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $rows = isset($_POST['length']) ? intval($_POST['length']) == 0 ? 10 : intval($_POST['length']) : 10;


        $list       =  $this->model->select($columns)->orderBy($orderField,$orderType)->offset($start)->limit($rows)->get();
        $total      =  $this->model->count();


        if(empty($list)){
            $list = array();
        }
        $result = array(
            "sEcho"=>$_POST,
            "iTotalRecords"=>$total,
            "iTotalDisplayRecords"=>$total,
            "data"=>$list,
        );
        return $result;
    }

    //获取更新的数据
    public function edit($request,$columns = array('*'),$condition = ''){
        $info = $this->model->get($columns)->where('id',$condition)->first()->toArray();
        return  $info;
    }

    //数据更新
    public function update($request,$condition =''){
        $info = $this->model->find($condition);

        if($info){
            $_POST['power'] = trim($_POST['power']);
            $_POST['description'] = trim($_POST['description']);
            $_POST['name'] = trim($_POST['name']);
            $_POST['power'] = explode(',',$_POST['power']);
            sort($_POST['power']);
            $_POST['power'] = implode(',',$_POST['power']);

            $powername = $this->get_powername($_POST['power']);
            $zhuhechaxun = $this->zhuhechaxun($_POST['power'],$powername);

            $_POST['powername'] = $zhuhechaxun['names'];
            $powers = $this->get_array1($_POST['power'],$zhuhechaxun['zhuhe']);
            $_POST['powers'] = json_encode($powers);

            $ids = $this->getids($_POST['power']);
            $ids = explode(',',$ids);
            $Node = new Node;
            $rootidlist = $Node->select('id')->where('pid',0)->whereIn('id',$ids)->get()->toArray();

            $tmproot = array();
            foreach($rootidlist as $value){
                $tmproot[] = $value['id'];
            }
            $rootids = implode(',',$tmproot);
            $_POST['rootids'] = $rootids;

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

    //这会儿是取所有操作的名字并拼接好。
    protected function zhuhechaxun($ids,$names){
        $ids_array = explode(',',$ids);
        sort($ids_array);
        $names_array = explode(',',$names);
        $zhuhe = array();
        $fenlei = array();

        foreach($ids_array as $key=>$value){
            $zhuhe[$value]=$names_array[$key];
            $tmparray  = explode('.',$value);
            $fenlei[$tmparray[0]][] = $value;
        }


        $result = array();
        $tmpids = array();
        foreach($fenlei as $key=>$val){
            $nums = count($val);
            if($nums>1){
                $result[$key] = $val;
            }else{
                if(strstr($val[0],'.')){
                    array_unshift($val,"{$key}");
                    $tmpids[] = $key;
                    $result[$key] = $val;
                }
            }
        }

        if(!empty($tmpids)){
            $Node = new Node;
            $list = $Node->select('id','title')->whereIn('id',$tmpids)->get()->toArray();
            //把不完整的id取出来
            foreach($list as $v){
                $zhuhe[$v['id']] = $v['title'];
            }
        }


        //拼成这样的 修改密码(查看,编辑)
        foreach($result as $key=>$val){
            $nums=count($val);
            $t = $nums-1;
            sort($val);
            foreach($val as $k=>$v){
                if($k==0){
                    $res[$key]=$zhuhe[$v].'(';
                }elseif($k<$t){
                    $res[$key].=$zhuhe[$v].',';
                }else{
                    $res[$key].=$zhuhe[$v].')';
                }
            }
        }
        $result = array(
            'zhuhe'=>$zhuhe,
            'names'=>implode(',',$res),
        );
        return $result;
    }


    public function delete($request,$condition = ''){
        // TODO: Implement delete() method.
        $res = $this->model->destroy($condition);
        if($res){
            $result = array('success'=>true,'msg'=>'删除成功！');
        }else{
            $result = array('success'=>false,'msg'=>'删除失败！');
        }
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

    //获取树状结构
    public function tree(){
        $list = $this->get_array(0);

        if(!empty($_GET['power'])){
            $list = $this->add_selected($list,$_GET['power']);
        }

        return $list;
    }

   //获取树状结构数据
    private function get_array($id=0){
        $Node = new Node;
        $result = $Node->select('id','title','pid','smallpower')->where('pid',$id)->orderBy("sort","desc")->get()->toArray();
        $arr = array();
        if($result){//如果有子类
            foreach($result as $rows){ //循环记录集
                $rows['children'] = $this->get_array($rows['id']);
                $tem = array();
                $tem['state'] = array("selected"=>false);
                $tem['text'] = $rows['title'];
                $tem['id'] = $rows['id'];
                $tem['icon'] = "fa fa-folder icon-lg icon-state-warning";
                if(empty($rows['children'])){
                    $tmparray = array();
                    $powers = json_decode($rows['smallpower'],1);
                    if(!empty($powers)){
                        foreach($powers as $key=>$val){
                            $tmp['state'] = array("selected"=>false);
                            $tmp['text'] = $val;
                            $tmp['icon'] = "fa fa-file icon-lg icon-state-warning";
                            $tmp['id'] = $rows['id'].".".($key+1);
                            $tmparray[] = $tmp;
                        }
                    }else{
                        $tmparray[0]['state'] = array("selected"=>false);
                        $tmparray[0]['id'] = $rows['id'].'.2';
                        $tmparray[0]['icon'] = 'fa fa-file icon-lg icon-state-warning';
                        $tmparray[0]['sign'] = 'showandedit';
                        $tmparray[0]['text'] = '编辑';

                        $tmparray[1]['state'] = array("selected"=>false);
                        $tmparray[1]['id'] = $rows['id'].'.1';
                        $tmparray[1]['icon'] = 'fa fa-file icon-lg icon-state-warning';
                        $tmparray[1]['sign'] = 'show';
                        $tmparray[1]['text'] = '查看';
                    }
                    $tem['children'] = $tmparray;
                }else{
                    $tem['children'] = $this->get_array($rows['id']);//调用函数，传入参数，继续查询下级
                }
                $arr[] = $tem; //组合数组
            }
            return $arr;
        }
    }

    // 增加已选节点勾选操作
    public function add_selected($arr,$power){
        $power = explode(',',$power);
        foreach ($power as $val){
            $temp = $this->add_selected_single($val,$arr);

            if(!empty($temp)){
                $arr = $temp;
            }
        }
        return $arr;
    }

    public function add_selected_single($id,$power){

        $children = "";
        foreach ($power as &$val){
            if($val['id'] == $id){
                $flag = true;
                $val['state'] = array("selected"=>true);
                break;
            }else{
                if(!empty($val['children'])){
                    $children = $this->add_selected_single($id,$val['children']);
                    if(!empty($children)){
                        $val['children'] = $children;
                        break;
                    }
                }
            }
        }



        if($children != "" || !empty($flag)){
            return $power;
        }else{
            return "";
        }

    }

}



