<?php

namespace App\Http\Controllers\admin;
/**
 * auther 刘岩
 * 后台角色控制器
 * */

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repostories\Models\Role as Actor;

class RoleController extends Controller
{
    private $actor;

    public function __construct(Actor $actor){
        $this->actor = $actor;
    }

    public function index(){
        return view('admin.role.role');
    }

    public function datalist(Request $request){
        $columns = array('*');
        $infos = $this->actor->datalist($columns);
        // echo json_encode($infos);
        return response()->json($infos);
    }

    public function tree(){
        $dataList = $this->actor->tree();
        return response()->json($dataList);
    }

    public function store(Request $request){
        $condition['name'] = $_POST['name'];
        $data = $this->actor->store($request,$condition);
        // echo json_encode($data);
        return response()->json($data);
    }

    public function edit(Request $request,$id){
        $array = array('id','name','power','description');
        $data = $this->actor->edit($request,$array,$id);
        return response()->json($data);
        // echo json_encode($data);
    }

    public function update(Request $request,$id){
        $res = $this->actor->update($request,$id);
        // echo json_encode($res);
        return response()->json($res);
    }

    public function delete(Request $request,$id){
        $res = $this->actor->delete($request,$id);
        // echo json_encode($res);
        return response()->json($res);
    }

    public function powertree(){
        $res = $this->actor->powertree();
        // echo json_encode($res);
        return response()->json($res);
    }

}
