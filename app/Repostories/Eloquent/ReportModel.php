<?php
/**
 * Created by PhpStorm.
 * User: 王跃东
 * Date: 2018/10/19
 * Time: 10:57
 */

namespace App\Repostories\Eloquent;

use App\Models\Statistics;
use App\Models\VideoStatistics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportModel extends Base
{
    public function __construct(Request $request) {
        $this->model = new Statistics();
    }


    public function zfdatalist($request,$columns = array('*'),$where = array())
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
        $startTime = 0;
        $endTime = 0;
        if(!empty($request->input('start_time'))){
            $startTime =$request->input('start_time');
            $endTime = empty($request->input('end_time'))? $request->input('start_time'):$request->input('end_time');
            $this->model  = $this->model->whereBetween('cdate',[$startTime,$endTime]);
        }


        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $rows = isset($_POST['length']) ? intval($_POST['length']) == 0 ? 10 : intval($_POST['length']) : 10;

        $list       =  $this->model->select($columns)->orderBy($orderField,$orderType)->offset($start)->limit($rows)->get();
        $total      =  $this->model->count();


//        foreach($list as &$v){
//
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

    public function videodatalist($request,$columns = array('*'),$where = array())
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
        $model = new VideoStatistics();
        if(!empty($request->input('start_time'))){
            $startTime =$request->input('start_time');
            $endTime = empty($request->input('end_time'))? $request->input('start_time'):$request->input('end_time');
            $model  = $model->whereBetween('cdate',[$startTime,$endTime]);
        }
        if(!empty($request['title'])){
            $model = $model->where("title","like","%".$request['title']."%");
        }

        if(!empty($request['video_id'])){
            $model = $model->where("video_id",$request['video_id']);
        }


        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $rows = isset($_POST['length']) ? intval($_POST['length']) == 0 ? 10 : intval($_POST['length']) : 10;

        $total      =  $model->count();
        $list       =  $model->select($columns)->orderBy($orderField,$orderType)->offset($start)->limit($rows)->get();


//        foreach($list as &$v){
//
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

    public function report($start){
        // 转发按钮点击次数统计
//         $clickModel              = new Click();
        $insert['click_num']     = DB::table("click".$start)->where("type", 1)->count();
        $insert['one_click_num'] = DB::table("click".$start)->where("type", 2)->where("zh", 0)->count();
        $insert['too_click_num'] = DB::table("click".$start)->where("type", 2)->where("zh", "!=", 0)->count();

        // 转发详情页点击次数
//        $zfReadModel = new ZfRead();
        $zfReadInfo = DB::table("zf_read".$start)->where("zh","!=",0)->select(DB::raw("count(1) as num"),"zh")->groupBy("zh")->get();
        $zfReadInfo = json_decode(json_encode($zfReadInfo),true);


        $all_zf_read_num = 0;
        $insert['one_zf_read_num'] = 0;
        $insert['too_zf_read_num'] = 0;
        foreach ($zfReadInfo as $val){
            if($val['zh'] == 1){
                $insert['one_zf_read_num'] = $val['num'];
            }else if($val['zh'] == 2){
                $insert['too_zf_read_num'] = $val['num'];
            }
            $all_zf_read_num += $val['num'];
        }
        $insert['zf_read_num'] = $all_zf_read_num;

        // 群打开的视频详情页统计
//        $groupModel = new GroupRead();
        $groupInfo = DB::table("group_read".$start)->where("group_id","!=","")->select(DB::raw("count(1) as num"),"zh")->groupBy("zh")->get();
        $groupInfo = json_decode(json_encode($groupInfo),true);

        $all_group_read = 0;
        $insert['one_group_read'] = 0;
        $insert['too_group_read'] = 0;
        foreach ($groupInfo as $val1){
            if($val1['zh'] == 1){
                $insert['one_group_read'] = $val1['num'];
            }else if($val1['zh'] == 2){
                $insert['too_group_read'] = $val1['num'];
            }
            $all_group_read += $val1['num'];
        }
        $insert['group_read'] = $all_group_read;

        // 个人打开视频详情页统计
        $insert['one_personal_read'] = $insert['one_zf_read_num'] - $insert['one_group_read'];
        $insert['too_personal_read'] = $insert['too_zf_read_num'] - $insert['too_group_read'];
        $insert['personal_read'] = $insert['zf_read_num'] - $insert['group_read'];

        // 有效阅读次数统计
        $groupOneValidInfo = DB::table("group_read".$start)->where("group_id","!=","")->where("zh",1)->select(DB::raw("count(1) as num"),"group_id")->groupBy("group_id")->get();
        $groupOneValidInfo = json_decode(json_encode($groupOneValidInfo),true);
        $groupTooValidInfo = DB::table("group_read".$start)->where("group_id","!=","")->where("zh",2)->select(DB::raw("count(1) as num"),"group_id")->groupBy("group_id")->get();
        $groupTooValidInfo = json_decode(json_encode($groupTooValidInfo),true);
        $groupValidInfo = DB::table("group_read".$start)->where("group_id","!=","")->select(DB::raw("count(1) as num"),"group_id")->groupBy("group_id")->get();
        $groupValidInfo = json_decode(json_encode($groupValidInfo),true);

        $insert['valid_read'] = count($groupValidInfo) + $insert['personal_read'];
        $insert['one_valid_read'] = count($groupOneValidInfo) + $insert['one_personal_read'];
        $insert['too_valid_read'] = count($groupTooValidInfo) + $insert['too_personal_read'];
        $insert['cdate'] = $start;

        $statistics = new Statistics();
        $statistics->insert($insert);


    }


}