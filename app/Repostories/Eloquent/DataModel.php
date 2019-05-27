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
use Illuminate\Support\Facades\DB;
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
            $orderField      = "cdate";
        }

        if(!empty($request->input('start_time'))){
            $startTime =$request->input('start_time');
            $endTime = empty($request->input('end_time'))? $request->input('start_time'):$request->input('end_time');
            $this->model  = $this->model->whereBetween('cdate',[$startTime,$endTime]);
        }

        if(!empty($request['channel_company'])){
            $this->model = $this->model->where("channel_company","like","%".$request['channel_company']."%");
        }
        if(!empty($request['ad_company'])){
            $this->model = $this->model->where("ad_company","like","%".$request['ad_company']."%");
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
        if(!empty($request['status'])){
            $this->model = $this->model->where("status",$request['status']);
        }
        if(!empty($request['ad_type'])){
            $this->model = $this->model->where("type",$request['ad_type']);
        }

        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $rows  = isset($_POST['length']) ? intval($_POST['length']) == 0 ? 10 : intval($_POST['length']) : 10;

        $footer = $this->model->select(DB::raw("sum(data) as data,sum(money) as money"))->first();
        $footer = json_decode(json_encode($footer), true);

        $total = $this->model->count();
        $list  = $this->model->select($columns)->orderBy($orderField, $orderType)->offset($start)->limit($rows)->get();


        foreach($list as &$v){
           $v['cdate'] = substr($v['cdate'],0,10);
        }

        if(empty($list)){
            $list = array();
        }
        $footer['cdate'] = "总计：";
        $footer['id'] = "";
        $footer['channel_name'] = "";
        $footer['ad_name'] = "";
        $footer['pack_name'] = "";
        $footer['ad_type'] = "";
        $footer["status"] = "";
        $footer['price'] = "";
        $footer['ad_company'] = "";
        $footer['channel_company'] = "";
        $list[] = $footer;

        $result = array(
            "sEcho"=>$_POST,
            "iTotalRecords"=>$total,
            "iTotalDisplayRecords"=>$total,
            "data"=>$list,
//            "footer"=>$footer
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

        $packId = [];

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

            $packId[] = $pack_name;
        }


        if($flag){
            $packModel = new Pack();

            $packInfos = $packModel->whereIn("pack_name",$packId)->select("*")->get();

            $newPackInfos = [];
            foreach ($packInfos as $pvalue){
                $newPackInfos[$pvalue['pack_name']] = $pvalue;
            }

            for($i = 1;$i<count($datas);$i++){
                $dataInfo = $datas[$i];
                $pack_name = trim($dataInfo[1]);
                $packSingleInfo = $newPackInfos[$pack_name];
                $temp = [];
                $temp['cdate'] = date("Y-m-d",strtotime($dataInfo[0]));
                $temp['pack_name'] = $pack_name;
                $temp['channel_id'] = $packSingleInfo['channel_id'];
                $temp['channel_name'] = $packSingleInfo["channel_name"];
                $temp['channel_company'] = $packSingleInfo["channel_company"];
                $temp['ad_id'] = $packSingleInfo["ad_id"];
                $temp['ad_name'] = $packSingleInfo["ad_name"];
                $temp['ad_type'] = $packSingleInfo["ad_type"];
                $temp['ad_company'] = $packSingleInfo["ad_company"];
                $temp['price'] = $dataInfo[2];
                $temp['data'] = $dataInfo[3];
                $temp['money'] = $dataInfo[4];
                $temp['created_at'] = date("Y-m-d H:i:s");

                $this->model->insert($temp);
            }
            return array('success' => true, 'msg' => '上传成功！');
        }else{
            return array('success' => false, 'msg' => $msg);
        }

    }

    // 下载模板
    public function download(){
        ob_end_clean(); // 解决中文乱码问题
        $cellData = [
            ['a'=>'日期','b'=>'渠道包名称','c'=>'单价','d'=>"注册数",'e'=>'收益'], // 这里可以不注释 直接写到数据里面去 但是为了单独的设置表头 可以拿出来单独写入
            ['a'=>'2019/5/1','b'=>'fndexiaonx','c'=>'1.2','d'=>'2156','e'=>'2587.2'],
            ['a'=>'2019/5/2','b'=>'fndexiaonx','c'=>'1.2','d'=>'2156','e'=>'2587.2'],
            ['a'=>'2019/5/3','b'=>'fndexiaonx','c'=>'1.2','d'=>'2156','e'=>'2587.2'],
            ['a'=>'2019/5/4','b'=>'fndexiaonx','c'=>'1.2','d'=>'2156','e'=>'2587.2'],
            ['a'=>'2019/5/5','b'=>'fndexiaonx','c'=>'1.2','d'=>'2156','e'=>'2587.2'],
            ['a'=>'2019/5/6','b'=>'fndexiaonx','c'=>'1.2','d'=>'2156','e'=>'2587.2'],
            ['a'=>'2019/5/7','b'=>'fndexiaonx','c'=>'1.2','d'=>'2156','e'=>'2587.2'],
            ['a'=>'2019/5/8','b'=>'fndexiaonx','c'=>'1.2','d'=>'2156','e'=>'2587.2'],
        ];

        Excel::create("模板",function($excel) use ($cellData){
            $excel->sheet('model', function($sheet) use ($cellData){
                foreach ($cellData as $k=>$val){
                    $sheet->cell('A'.($k+1),$val['a']);// 写入单个单元格的数据
                    $sheet->cell('B'.($k+1),$val['b']);
                    $sheet->cell('C'.($k+1),$val['c']);
                    $sheet->cell('D'.($k+1),$val['d']);
                    $sheet->cell('E'.($k+1),$val['e']);
                }
            });
        })->export('xls');
    }

    public function jiesuan($request){
        $ids = $request->input("ids");
        $ids = explode(",", $ids);
        $ids = array_flip(array_flip($ids));

        $res = $this->model->whereIn("id",$ids)->update(['status'=>2]);

        if($res){
            return ['success'=>true,"msg"=>"结算成功"];
        }else{
            return ['success'=>false,"msg"=>"结算失败"];
        }

    }



}