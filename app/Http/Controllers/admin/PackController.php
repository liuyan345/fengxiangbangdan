<?php

namespace App\Http\Controllers\admin;
/**
 * auther 刘岩
 * 渠道包控制器
 * */

use App\Models\Ad;
use App\Models\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repostories\Eloquent\PackModel as Actor;

class PackController extends Controller{
    private $actor;

    public function __construct(Actor $actor){
        $this->actor = $actor;
    }

    public function index(){
        $ad = new Ad();
        $adInfo = $ad->getAdNameNew([],1);
        $chanel = new Channel();
        $channelInfo = $chanel->getChannelNameNew([],1);
        return view('admin/ad/pack',['adInfo'=>$adInfo,'channelInfo'=>$channelInfo]);
    }

    public function datalist(Request $request){
        $columns = array('*');
        $infos = $this->actor->datalist($request,$columns);
        return response()->json($infos);
    }

    public function store(Request $request){
        $condition['ad_id'] = $request['ad_id'];
        $condition['channel_id'] = $request['channel_id'];
        $condition['pack_name'] = $request['pack_name'];
        $data = $this->actor->myStore($request,$condition);
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

