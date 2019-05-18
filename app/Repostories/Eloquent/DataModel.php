<?php
/**
 * Created by PhpStorm.
 * User: 王跃东
 * Date: 2018/10/19
 * Time: 10:57
 */

namespace App\Repostories\Eloquent;


use App\Models\Ad;
use App\Models\Channel;
use App\Models\Data;
use App\Models\Pack;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataModel extends Base
{
    public function __construct(Request $request) {
        $this->model = new Data();
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

        if(!empty($request->input('start_time'))){
            $startTime =$request->input('start_time');
            $endTime = empty($request->input('end_time'))? $request->input('start_time'):$request->input('end_time');
            $this->model  = $this->model->whereBetween('cdate',[$startTime,$endTime]);
        }


        if(!empty($request['channel_name'])){
            $this->model = $this->model->where("channel_name","like","%".$request['channel_name']."%");
        }
        if(!empty($request['ad_name'])){
            $this->model = $this->model->where("ad_name","like","%".$request['ad_name']."%");
        }
        if(!empty($request['pack_name'])){
            $this->model = $this->model->where("pack_name","like","%".$request['pack_name']."%");
        }

        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $rows = isset($_POST['length']) ? intval($_POST['length']) == 0 ? 10 : intval($_POST['length']) : 10;

        $total      =  $this->model->count();
        $list       =  $this->model->select($columns)->orderBy($orderField,$orderType)->offset($start)->limit($rows)->get();


//        foreach($list as &$v){
//           $v['cate_name'] = $cateInfo[$v['cate_id']];
//        }

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
    /**
     * 存储数据
     */
    public function upload($request)
    {
        if(!$request->hasFile('videoList')){
            return array('success' => false, 'msg' => '参数错误！');
        }

        $file = $_FILES;
        $excel_file_path = $file['videoList']['tmp_name'];
        $datas = [];
        Excel::load($excel_file_path, function($reader) use( &$datas ) {
            $reader = $reader->getSheet(0);
            $datas = $reader->toArray();
        });

        $packModel  = new Pack();
        $packInfo = $packModel->where("status",1)->select("pack_name","channel_id","ad_id")->get();
        $packInfo = json_decode(json_encode($packInfo),true);

        $allowPack = [];
        $packSelect = [];
        foreach ($packInfo as $v){
            $allowPack[] = $v['pack_name'];
            $packSelect[$v['pack_name']] = $v;
        }
        $adModel = new Ad();
        $adInfo = $adModel->getAdName();

        $channelModel = new Channel();
        $channelInfo = $channelModel->getChannelName();

        $flag = true;
        $msg = '';
        for($i = 1;$i<count($datas);$i++){
            $dataInfo = $datas[$i];
            if(!in_array($dataInfo[1],$allowPack)){
                $flag = false;
                $msg = "第".($i+1)."行，渠道包不存在";
                break;
            }
            $pack_name = trim($dataInfo[1]);

            if(strtotime($dataInfo[0]) > strtotime("today")){
                $flag = false;
                $msg = "第".($i+1)."行，数据日期为未来数据，不能录入";
                break;
            }

            $temp = [];
            $temp['cdate'] = date("Y-m-d",strtotime($dataInfo[0]));
            $temp['pack_name'] = $pack_name;

            $checkInfo = $this->model->where("cdate",$temp['cdate'])->where("pack_name",$temp['pack_name'])->select("id")->first();
            $checkInfo = json_decode(json_encode($checkInfo),true);
            if(!empty($checkInfo['id'])){
                $flag = false;
                $msg = "第".($i+1)."行，数据已录入";
                break;
            }
        }

        if($flag){
            for($i = 1;$i<count($datas);$i++){
                $dataInfo = $datas[$i];

                $pack_name = trim($dataInfo[1]);
                $channelId = $packSelect[$pack_name]['channel_id'];
                $adId = $packSelect[$pack_name]['ad_id'];
                $temp = [];
                $temp['cdate'] = date("Y-m-d",strtotime($dataInfo[0]));
                $temp['pack_name'] = $pack_name;
                $temp['channel_id'] = $channelId;
                $temp['channel_name'] = $channelInfo[$channelId];
                $temp['ad_id'] = $adId;
                $temp['ad_name'] = $adInfo[$adId];
                $temp['price'] = $dataInfo[2];
                $temp['data'] = $dataInfo[3];
                $temp['money'] = $dataInfo[4];
                preg_match("/\((.*)\)/", $temp['ad_name'],$type);
                if(empty($type[1])){
                    $temp['type'] = "";
                }else{
                    $temp['type'] = $type[1];
                }

                $this->model->insert($temp);
            }
            return array('success' => true, 'msg' => '上传成功！');
        }else{
            return array('success' => false, 'msg' => $msg);
        }



    }





}