<?php
/**
 * Created by PhpStorm.
 * User: 王跃东
 * Date: 2018/10/19
 * Time: 10:57
 */

namespace App\Repostories\Eloquent;
use App\Models\Cate;
use App\Models\Header;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VideoListModel extends Base
{
    public function __construct(Request $request) {
        $this->model = new Video();
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
        if(!empty($request['status'])){
            $this->model = $this->model->where("status",$request['status']);
        }
        if(!empty($request['cate_id'])){
            $this->model = $this->model->where("cate_id",$request['cate_id']);
        }
        if(!empty($request['title'])){
            $this->model = $this->model->where("title","like","%".$request['title']."%");
        }

        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $rows = isset($_POST['length']) ? intval($_POST['length']) == 0 ? 10 : intval($_POST['length']) : 10;


        $list       =  $this->model->select($columns)->orderBy($orderField,$orderType)->offset($start)->limit($rows)->get();
        $total      =  $this->model->count();

        $cateModel = new Cate();
        $cateInfo = $cateModel->getCateName();

        foreach($list as &$v){
           $v['cate_name'] = $cateInfo[$v['cate_id']];
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

        $header = new Header();
        $headerInfo = $header->getHeaderInfo();
        $headerId = array_keys($headerInfo);

//        for($i = 1;$i<count($datas);$i++) {
//            $headerIndex = rand(0,count($headerId)-1);
//            $headerIndex = $headerId[$headerIndex];
//            $autherInfo = $headerInfo[$headerIndex];
//
//            $videoInfo = $datas[$i];
//            $temp = [];
//            $temp['cate_id'] = $videoInfo['0'];
//            $temp['title'] = $videoInfo['3'];
//            $temp['img'] = $videoInfo['4'];
//            $temp['lasted_time'] = $videoInfo['5'];
//            $temp['score'] = $videoInfo['6'];
//            $temp['url'] = "https://v.qq.com/x/page/".$videoInfo['2'].".html";
//            $temp['auther_id'] = $autherInfo["id"];
//            $temp['auther'] = $autherInfo["name"];
//            $temp['auther_img'] = $autherInfo["header"];
//            $this->model->insert($temp);
//        }


        for($i = 1;$i<count($datas);$i++){
            $headerIndex = rand(0,count($headerId)-1);
            $headerIndex = $headerId[$headerIndex];
            $autherInfo = $headerInfo[$headerIndex];

            $videoInfo = $datas[$i];
            $temp = [];
            $temp['cate_id'] = $videoInfo['1'];
            $temp['title'] = $videoInfo['3'];
            $temp['img'] = json_decode($videoInfo['4'],true)[0];
            $temp['url'] = $videoInfo['5'];
            $temp['lasted_time'] = empty($videoInfo['6']) ? "" : $videoInfo['6'];
            if(!empty($temp['lasted_time']) && $temp['lasted_time']>300){
                continue;
            }else{
                $lastTime = 0;
                preg_match("/https:\/\/v.qq.com\/x\/page\/(.*)\.html/",$temp['url'],$url);
                $vid = empty($url[1]) ? "" : $url[1];
                if(!empty($vid)){
                    $path = "https://h5vv.video.qq.com/getinfo?encver=300&_qv_rmtv2=8fuhzqt9j2tz4bfed76tg2jphoootjpt&defn=auto&platform=4210801&otype=json&sdtfrom=v4169&_rnd=1557900943&appVer=7&vid=".$vid."&newnettype=1";
                    $content = file_get_contents($path);
                    preg_match("/.*preview\":(\d+),.*/",$content,$preview);
                    if(!empty($preview[1])){
                        $lastTime = $preview[1];
                    }
                }
                if(empty($lastTime)){
                    continue;
                }else{
                    $temp['lasted_time'] = $lastTime;
                }
            }
            $temp['auther_id'] = $autherInfo["id"];
            $temp['auther'] = $autherInfo["name"];
            $temp['auther_img'] = $autherInfo["header"];
            $this->model->insert($temp);
        }


        return array('success' => true, 'msg' => '上传成功！');

    }





}