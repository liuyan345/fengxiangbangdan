<?php

namespace App\Console\Commands;

use App\Models\Click;
use App\Models\GroupRead;
use App\Models\Statistics;
use App\Models\User;
use App\Models\UserLog;
use App\Models\ZfRead;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Models\DailyTimes;
use App\Tools\ModelMessage;

/**
 * 统计是视频转发阅读情况
 * Class AllocationConsole
 * @package App\Console\Commands
 */
class DailyReport extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'laravel:DailyReport';

    /**
     * The console command description.
     * @var string
     */
    protected $description = '统计是视频转发阅读情况';

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
        $start = date("Y-m-d",strtotime("-1 day"));
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
