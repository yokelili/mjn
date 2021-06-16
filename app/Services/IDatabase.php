<?php


namespace App\Services;

interface IDatabase
{
    function connect($host, $user, $password, $dbname);
    function query($sql);
    function close();
}

