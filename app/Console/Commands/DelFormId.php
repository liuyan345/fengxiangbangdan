<?php

namespace App\Console\Commands;

use App\Models\FormId;
use Illuminate\Console\Command;


class DelFormId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel:DelFormId';

    /*  *
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除过期的formId';

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
        $form  = new FormId();
        $time = time()-7*86400;
        $form->where("cdate","<",$time)->delete();
    }

}
