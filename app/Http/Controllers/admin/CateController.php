<?php

namespace App\Http\Controllers\admin;
/**
 * auther 刘岩
 * 视频分类表控制器
 * */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repostories\Eloquent\CateModel as Actor;
use Illuminate\Support\Facades\Redis;

class CateController extends Controller{
    private $actor;

    public function __construct(Actor $actor){
        $this->actor = $actor;
    }

    public function index(){
        return view('admin/video/cate');
    }

    public function datalist(Request $request){
        $columns = array('*');
        $infos = $this->actor->datalist($request,$columns);
        return response()->json($infos);
    }

    public function store(Request $request){
        $data = $this->actor->store($request);
        return response()->json($data);
    }

    public function edit($id,Request $request){
        $array = array('*');
        $data = $this->actor->edit($request,$array,$id);
        return response()->json($data);
    }

    public function update($id,Request $request){
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

