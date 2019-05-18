<?php
/**
 * Created by PhpStorm.
 * User: 王跃东
 * Date: 2018/10/19
 * Time: 10:57
 */

namespace App\Repostories\Eloquent;
use App\Models\Ad;
use App\Models\Pack;
use Illuminate\Http\Request;

class PackModel extends Base
{
    public function __construct(Request $request) {
        $this->model = new Pack();
    }


    public function datalist($request,$columns = array('*'),$where = array())
    {
        if(!empty($_POST['order'])){
            $order           = $_POST['order'];
            $orderFieldIndex = $order[0]['column'];
            $orderType       = $order[0]['dir'];
            $orderField      = $_POST['columns'][$orderFieldIndex]['data'];
        }else{
            $orderType       = "desc";
            $orderField      = "created_at";
        }

//        if(!empty($request->input('start_time'))){
//            $start =$request->input('start_time');
//            $end = empty($request->input('end_time'))? $request->input('start_time'):$request->input('end_time');
//            $this->model  = $this->model->whereBetween('cdate',[$start,$end]);
//        }

        if(!empty($request->input('pack_name'))){
            $this->model  = $this->model->where('name','like','%'.$request->input('pack_name').'%');
        }

        if(!empty($request->input('status'))){
            $this->model  = $this->model->where('status',$request->input('status'));
        }

        $ad = new Ad();
        if(!empty($request->input('ad_name'))){
            $adId = $ad->where("name","like","%".$request['ad_name']."%")->pluck("id");
            $adId = json_decode(json_encode($adId),true);
            $this->model  = $this->model->whereIn('ad_id',$adId);
        }

        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $rows = isset($_POST['length']) ? intval($_POST['length']) == 0 ? 10 : intval($_POST['length']) : 10;


        $total      =  $this->model->count();
        $list       =  $this->model->select($columns)->orderBy($orderField,$orderType)->offset($start)->limit($rows)->get();

        $adInfo = $ad->getAdName();

        foreach($list as &$v){
           $v['ad_name'] = $adInfo[$v['ad_id']];
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






}