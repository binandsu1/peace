<?php

namespace App\Jobs;

use App\Models\Jiayu;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpPicJob implements ShouldQueue
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
        $this->queue = 'UpPicJob';
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        echo 1;die;
       Jiayu::create($this->data);

//        $add_re = QueLog::create($this->data);
//        if($add_re){
//            $result = Jiayu::create($this->data);
//            if($result){
//                $one = QueLog::where('name',$this->data['name'])->first();
//                $one->is_success = 1;
//                $one->save();
//            }
//        }
    }
}
