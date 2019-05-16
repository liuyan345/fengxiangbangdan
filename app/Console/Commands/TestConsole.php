<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserLog;
use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Models\DailyTimes;
use App\Tools\ModelMessage;

/**
 * 分配用户的信息
 * Class AllocationConsole
 * @package App\Console\Commands
 */
class TestConsole extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'laravel:test';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Command description';

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
        $this->test();
    }


    public function test(){
//       $p = public_path()."/test.txt";
//       file_put_contents($p,date("Y-m-d H:i:s"));
        $videoModel = new Video();
        $videoInfo = $videoModel->where("url","like","%cdn%")->where("lasted_time","")->select("id","url")->get();
        $videoInfo = json_decode(json_encode($videoInfo),true);

        echo count($videoInfo);

        echo "\r\n";

        foreach ($videoInfo as $val){
//            preg_match("/https:\/\/v.qq.com\/x\/page\/(.*)\.html/",$val['url'],$url);
//            $val['vid'] = empty($url[1]) ? "" : $url[1];
//            $path = "https://h5vv.video.qq.com/getinfo?encver=300&_qv_rmtv2=8fuhzqt9j2tz4bfed76tg2jphoootjpt&defn=auto&platform=4210801&otype=json&sdtfrom=v4169&_rnd=1557900943&appVer=7&vid=".$val["vid"]."&newnettype=1";
//            $content = file_get_contents($path);
//            preg_match("/.*preview\":(\d+),.*/",$content,$preview);

            $commond = "ffmpeg -i ".$val['url']." 2>&1";
            ob_start();
            passthru($commond);
            $info = ob_get_contents();
            ob_end_clean();

            preg_match("/Duration: (.*?), start: (.*?), bitrate: (\d*) kb\/s/", $info, $preview);


            if(!empty($preview[1])){
                $second = $this->getSecond($preview[1]);
                echo $val['id'].":".$preview[1]."->".$second."\r\n";
//                $time = $preview[1];
                $videoModel->where("id",$val['id'])->update(['lasted_time'=>$second]);
            }else{
                echo $val['id']."\r\n";

            }
        }


    }

    public function getSecond($string){
        $second = 0;
        if(!empty($string)){
            $arr1 = explode('.',$string);
            if(!empty($arr1[0])){
                $arr2 = explode(':',$arr1[0]);
                $h = $arr2[0];
                $i = $arr2[1];
                $s = $arr2[2];
                $second = $h*3600 + $i*60 + $s;
            }
        }
        return $second;
    }
}
