<?php

namespace App\Http\Controllers\home;
/**
 * auther 刘岩
 * 渠道控制器
 * */
use App\Models\Data;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repostories\Eloquent\ChannelModel as Actor;

class ChannelController extends Controller{
    private $actor;

    public function __construct(Actor $actor){
        $this->actor = $actor;
    }

    public function info(Request $request){
        $channelInfo =  $request->session()->get('home');
        return view('home/info',['channelInfo'=>$channelInfo]);
    }

    public function datalist(Request $request){
        $columns = array('*');
        $infos = $this->Mdatalist($request,$columns);
        return response()->json($infos);
    }

    public function Mdatalist($request,$columns = array('*'),$where = array())
    {
        if(!empty($_POST['order'])){
            $order           = $_POST['order'];
            $orderFieldIndex = $order[0]['column'];
            $orderType       = $order[0]['dir'];
            $orderField      = $_POST['columns'][$orderFieldIndex]['data'];
        }else{
            $orderType       = "desc";
            $orderField      = "cdate";
        }
        $channelInfo =  $request->session()->get('home');
        $channelId = $channelInfo['id'];

        $model = new Data();
        $model = $model->where("channel_id",$channelId);

        if(!empty($request->input('start_time'))){
            $startTime =$request->input('start_time');
            $endTime = empty($request->input('end_time'))? $request->input('start_time'):$request->input('end_time');
            $model = $model->whereBetween('cdate',[$startTime,$endTime]);
        }

        if(!empty($request['ad_name'])){
            $model= $model->where("ad_name","like","%".$request['ad_name']."%");
        }
        if(!empty($request['pack_name'])){
            $model= $model->where("pack_name","like","%".$request['pack_name']."%");
        }

        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $rows = isset($_POST['length']) ? intval($_POST['length']) == 0 ? 10 : intval($_POST['length']) : 10;

        $total      =  $model->count();
        $list       =  $model->select($columns)->orderBy($orderField,$orderType)->offset($start)->limit($rows)->get();


        foreach($list as &$v){
            $v['cdate'] = substr($v['cdate'],0,10);
        }

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

    public function store(Request $request){
        $_POST['asepasswd'] = getmd5passwd($_POST['passwd']);
        $condition['name'] = $request['name'];
        $data = $this->actor->store($request,$condition);
        return response()->json($data);
    }

    public function data(){
        return view('home/data');
    }

    public function changePw(Request $request){
        $channelInfo =  $request->session()->get('home');
        return view('home/changePw',['adminInfo'=>$channelInfo]);
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

