<?php


namespace App\Services;


class FemaleUserStrategy implements UserStrategy
{
    function showAd()
    {
        echo "2021新款女装";
    }

    function showCategory()
    {
        echo "女装";
    }
}
