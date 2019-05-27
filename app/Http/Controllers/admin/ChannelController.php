<?php

namespace App\Http\Controllers\admin;
/**
 * auther 刘岩
 * 渠道控制器
 * */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repostories\Eloquent\ChannelModel as Actor;

class ChannelController extends Controller{
    private $actor;

    public function __construct(Actor $actor){
        $this->actor = $actor;
    }

    public function index(){
        return view('admin/channel/index');
    }

    public function datalist(Request $request){
        $columns = array('*');
        $infos = $this->actor->datalist($request,$columns);
        return response()->json($infos);
    }

    public function store(Request $request){
        $_POST['asepasswd'] = getmd5passwd($_POST['passwd']);
        $condition['name'] = $request['name'];
        $condition['company'] = $request['company'];
        $data = $this->actor->store($request,$condition);
        return response()->json($data);
    }

    public function edit($id,Request $request){
        $array = array('*');
        $data = $this->actor->edit($request,$array,$id);
        return response()->json($data);
    }

    public function update($id,Request $request){
        $_POST['asepasswd'] = getmd5passwd($_POST['passwd']);
        $res = $this->actor->update($request,$id);
        return response()->json($res);
    }

    public function delete($id,Request $request){
        $res = $this->actor->delete($request,$id);
        return response()->json($res);
    }

    public function changeStatus($id,Request $request){
        $res = $this->actor->changeStatus($request,$id,$_POST['type']);
        return response()->json($res);
    }

}

