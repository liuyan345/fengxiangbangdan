<?php

namespace App\Console\Commands;

use App\Models\Video;
use App\Models\VideoStatistics;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * 统计是每个视频阅读情况
 * Class AllocationConsole
 * @package App\Console\Commands
 */
class VideoDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'laravel:VideoDailyReport';

    /**
     * The console command description.
     * @var string
     */
    protected $description = '统计是每个视频阅读情况';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $this->report();
    }


    public function report(){
        $start = date("Y-m-d");
        // 转发按钮点击次数统计 zh=1的
        $clickInfo = DB::table("click".$start)->where("zh",1)->select(DB::raw("count(1) as num"),"video_id")->groupBy("video_id")->get();

        $clickInfo = json_decode(json_encode($clickInfo),true);

        $videoStatistics = new VideoStatistics();

        foreach ($clickInfo as $v1){
            $update = [];
            $update['click_num'] = $v1['num'];
            $update['updated_at'] = date("Y-m-d H:i:s");
            $res = $videoStatistics->where("video_id",$v1['video_id'])->where("cdate",$start)->update($update);

            if(empty($res)){
                $insert = [];
                $insert['cdate'] = $start;
                $insert['video_id'] = $v1['video_id'];
                $insert['click_num'] = $v1['num'];
                $videoStatistics->insert($insert);
            }
        }

        // 转发详情页点击次数
        $zfReadInfo = DB::table("zf_read".$start)->select(DB::raw("count(1) as num"),"zh","video_id")->groupBy("video_id","zh")->get();
        $zfReadInfo = json_decode(json_encode($zfReadInfo),true);

        $read = [];//播放量
        $zfRead = []; //转发播放量
        foreach ($zfReadInfo as $v2){
            if($v2['zh'] == 1){
                if(empty($zfRead[$v2['video_id']])){
                    $zfRead[$v2['video_id']] = $v2['num'];
                }else{
                    $zfRead[$v2['video_id']] += $v2['num'];
                }
                $update = [];
                $update['one_zf_read'] = $v2['num'];
                $update['updated_at'] = date("Y-m-d H:i:s");
                $res = $videoStatistics->where("video_id",$v2['video_id'])->where("cdate",$start)->select("id")->first();
                if(empty($res->id)){
                    $insert = [];
                    $insert['cdate'] = $start;
                    $insert['video_id'] = $v2['video_id'];
                    $insert['one_zf_read'] = $v2['num'];
                    $videoStatistics->insert($insert);
                }else{
                    $videoStatistics->where("video_id",$v2['video_id'])->where("cdate",$start)->update($update);
                }
            }else if($v2['zh'] == 2){
                if(empty($zfRead[$v2['video_id']])){
                    $zfRead[$v2['video_id']] = $v2['num'];
                }else{
                    $zfRead[$v2['video_id']] += $v2['num'];
                }
                $update = [];
                $update['too_zf_read'] = $v2['num'];
                $update['updated_at'] = date("Y-m-d H:i:s");
                $res = $videoStatistics->where("video_id",$v2['video_id'])->where("cdate",$start)->select("id")->first();
                if(empty($res->id)){
                    $insert = [];
                    $insert['cdate'] = $start;
                    $insert['video_id'] = $v2['video_id'];
                    $insert['too_zf_read'] = $v2['num'];
                    $videoStatistics->insert($insert);
                }else{
                    $videoStatistics->where("video_id",$v2['video_id'])->where("cdate",$start)->update($update);
                }
            }
            if(empty($read[$v2['video_id']])){
                $read[$v2['video_id']] = $v2['num'];
            }else{
                $read[$v2['video_id']] += $v2['num'];
            }
        }

        foreach ($read as $video_id => $num){
            $update = [];
            $update['play_num'] = $num;
            $update['updated_at'] = date("Y-m-d H:i:s");
            $res = $videoStatistics->where("video_id",$video_id)->where("cdate",$start)->select("id")->first();
            if(empty($res->id)){
                $insert = [];
                $insert['cdate'] = $start;
                $insert['video_id'] = $video_id;
                $insert['play_num'] = $num;
                $videoStatistics->insert($insert);
            }else{
                $videoStatistics->where("video_id",$video_id)->where("cdate",$start)->update($update);
            }
        }

          // 群打开的视频详情页统计
        $groupInfo = DB::table("group_read".$start)->where("group_id","!=","")->select(DB::raw("count(1) as num"),"video_id")->groupBy("video_id")->get();
        $groupInfo = json_decode(json_encode($groupInfo),true);

        $groupNum = [];// 群转发打开
        foreach ($groupInfo as $v3){
            $groupNum[$v3['video_id']] = $v3['num'];
        }
        $personal = [];// 视频的个人转发次数
        foreach ($zfRead as $vid => $n){
            if(empty($groupNum[$vid])){
                $groupNum[$vid] = 0;
            }
            $personal[$vid] = $n - $groupNum[$vid];
        }


        // 有效阅读次数统计
        $groupValidInfo = DB::table("group_read".$start)->where("group_id","!=","")->select("group_id","video_id")->groupBy("group_id","video_id")->get();
        $groupValidInfo = json_decode(json_encode($groupValidInfo),true);

        $groupValid = [];
        foreach ($groupValidInfo as $v4){
            if(empty($groupValid[$v4['video_id']])){
                $groupValid[$v4['video_id']] = 0;
            }
            $groupValid[$v4['video_id']]++;
        }

        $keys1 = array_keys($groupValid);
        $keys2 = array_keys($personal);
        $keys = array_merge($keys1,$keys2);
        $keys = array_flip(array_flip($keys));

        foreach ($keys as $v){
            if(empty($personal[$v])){
                $personal[$v] = 0;
            }
            if(empty($groupValid[$v])){
                $groupValid[$v] = 0;
            }
            $num = $personal[$v] + $groupValid[$v];
            $update = [];
            $update['valid_read'] = $num;
            $update['updated_at'] = date("Y-m-d H:i:s");
            $res = $videoStatistics->where("video_id",$v)->where("cdate",$start)->select("id")->first();
            if(empty($res->id)){
                $insert = [];
                $insert['cdate'] = $start;
                $insert['video_id'] = $v;
                $insert['valid_read'] = $num;
                $videoStatistics->insert($insert);
            }else{
                $videoStatistics->where("video_id",$v)->where("cdate",$start)->update($update);
            }
        }

        $emptyTitleVid = $videoStatistics->where("cdate",$start)->where("title","")->pluck("video_id");
        $emptyTitleVid = json_decode(json_encode($emptyTitleVid),true);
        $videoModel = new Video();

        $videoInfos = $videoModel->whereIn("id",$emptyTitleVid)->pluck("title","id");
        $videoInfos = json_decode(json_encode($videoInfos),true);

        foreach ($emptyTitleVid as $v5){
            $videoStatistics->where("video_id",$v5)->where("cdate",$start)->update(['title'=>$videoInfos[$v5]]);
        }


    }
}
