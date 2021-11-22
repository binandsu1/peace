<?php

namespace App\Console\Commands;

use App\Models\PrizeNum;
use Illuminate\Console\Command;

class pe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'creat:num';

    /**
     * The console command description.
     *
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
     *
     * @return int
     */
    public function handle()
    {
        for($i=0;$i<15000;$i++){
            $num = rand(10000000,99999999);
            $data['num'] = $num;
            $id = PrizeNum::insertGetId($data);
            $this->info('刚刚插入的'.$id);
        }
    }
}
