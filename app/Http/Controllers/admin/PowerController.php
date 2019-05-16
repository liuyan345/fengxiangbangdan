<?php

namespace App\Http\Controllers\admin;
/**
 * auther 刘岩
 * 后台菜单控制器
 * */
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repostories\Models\Node as Actor;

class PowerController extends Controller
{

    private $actor;

    public function __construct(Actor $actor){
        $this->actor = $actor;
    }

    public function index(){
        return view('admin.power.power');
    }

    public function tree(){
        $data = $this->actor->tree();
        return response()->json($data);
    }

    public function table(){
       $this->actor->table();
    }

    public function datalist(Request $request){
        $columns = array('*');
        $infos = $this->actor->datalist($request,$columns);
        // echo json_encode($infos);
        return response()->json($infos);
    }

    public function store(Request $request){
        $condition['name'] = $_POST['name'];
        $data = $this->actor->stores($request,'',$condition);
        // echo json_encode($data);
        return response()->json($data);
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

    public function edit(Request $request,$id){
        $data = $this->actor->edit($request,$columns = array('*'),$id);
        // echo json_encode($data);
        return response()->json($data);
    }


}
