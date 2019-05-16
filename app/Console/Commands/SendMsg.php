<?php

namespace App\Console\Commands;



use App\Tools\ModelMessage;
use Illuminate\Console\Command;


class SendMsg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel:sendMsg';

    /*  *
     * The console command description.
     *
     * @var string
     */
    protected $description = '手动发送消息';

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
     *
     * @return mixed
     */
    public function handle()
    {
        $message = new ModelMessage();
        $messageContent = ["标题1","内容1"];
        $message->sendMessageToPeople(['100005'],"0mbs_r-gudD6BkCS0UTuVsmC3mK_gTvf3iLP-zHKPqI",$messageContent,"pages/index/index",false);

    }

}
