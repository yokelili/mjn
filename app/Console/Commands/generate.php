<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TokenBucket;

class generate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        //令牌桶容器
        $queue = 'traffic';
        //最大令牌数
        $max = 5;
        //创建TrafficShaper对象
        $tokenBucket = new TokenBucket($queue,$max);
        //重设令牌桶，填满令牌
        $tokenBucket->add($max);
    }
}
