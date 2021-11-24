<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class tt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    #最大重试次数
    public $tries = 1;
    #最大执行时间
    public $timeout = 6000;
    protected  $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->connection = 'rabbitmq';
        $this->queue = 'TT';
        $this->data = $data;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table('tt')->insert($this->data);

    }
}
