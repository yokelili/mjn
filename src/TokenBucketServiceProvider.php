<?php

namespace Blog\TokenBucket;

use Blog\TokenBucket\Http\Middleware\TokenBucketMiddleware;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class TokenBucketServiceProvider extends ServiceProvider
{
    /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */
    protected $defer = true; // 延迟加载服务

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(TokenBucketMiddleware::class);
    }
}
