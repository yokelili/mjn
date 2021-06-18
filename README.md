# laravel+redis token bucket

团队内部使用的令牌桶限流包

## 安装

你可以通过`composer`进行安装

```bash
composer require token_bucket_middleware/token_bucket
```

## 使用

1. 生成中间件

```SHELL
 php artisan make:middleware TokenBucketMiddleware
```
2. 修改`app/Http/Kernel.php`增加中间件

```PHP
protected $routeMiddleware = [
    ...
    'tokenBucket' => \App\Http\Middleware\TokenBucketMiddleware::class,
]
```
3. 中间件编写
```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Blog\TokenBucket\TokenBucket;

class TokenBucketMiddleware
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('***********************************');
        // 获取路由
        $url = $request->getRequestUri();
        $url = 'bucket:'.substr($url, 0);
        $tokenBucket = new TokenBucket;
        $result = $tokenBucket->grant($url);
        if (! $result) {
            Log::info('请求Discard'.date('s'));
            return response()->json(['status' => false, 'message' => 'network busy, please try again', 'code' => 429, 'data' => []]);
        }
        Log::info('请求成功'.date('s'));
        return $next($request);
    }
}

```
