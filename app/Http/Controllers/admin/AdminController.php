<?php

namespace App\Http\Controllers\admin;
/**
 * auther 刘岩
 * 后台管理员控制器
 * */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repostories\Models\Admin as Actor;

class AdminController extends Controller{
    private $actor;

    public function __construct(Actor $actor){
        $this->actor = $actor;
    }

    public function index(){
        $data = $this->actor->index();
        return view('admin/admin/admin',['role'=>$data['role']]);
    }

    public function datalist(Request $request){
        $columns = array('*');
        $infos = $this->actor->datalist($request,$columns);
        // echo json_encode($infos);
        return response()->json($infos);
    }

    public function store(Request $request){
        $_POST['password'] = getmd5passwd($_POST['passwd']);
//        $condition['mobile'] = $_POST['mobile'];
        $data = $this->actor->store($request,array());
        // echo json_encode($data);
        return response()->json($data);
    }

    public function edit($id,Request $request){
        $array = array('*');
        $data = $this->actor->edit($request,$array,$id);
        // echo json_encode($data);
        return response()->json($data);
    }

    public function update($id,Request $request){
        $adminInfo = $request->session()->get('admin');

        if(($adminInfo['passwd'] == $_POST['passwd']) || empty($_POST['passwd'])){
            unset($_POST['passwd']);
        }else{
            $_POST['password'] = getmd5passwd($_POST['passwd']);
        }
        $res = $this->actor->update($request,$id);
        // echo json_encode($res);
        return response()->json($res);
    }

    public function delete($id,Request $request){
        $res = $this->actor->delete($request,$id);
        // echo json_encode($res);
        return response()->json($res);
    }

    public function changeStatus($id,Request $request){
        $res = $this->actor->changeStatus($request,$id,$_POST['type']);
        // echo json_encode($res);
        return response()->json($res);
    }

}

