<?php

namespace Blog\TokenBucketExpir\Facades;
use Illuminate\Support\Facades\Facade;

class TokenBucketExpir extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'TokenBucketExpir';
    }
}
