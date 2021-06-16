<?php


namespace App\Services\Databases;
use App\Services\IDatabase;


class Mysql implements IDatabase
{
    protected $conn;
    function connect($host, $user, $password, $dbname)
    {
        $conn = mysql_connect($host, $user, $password);
        mysql_select_db($dbname, $conn);
        $this->conn = $conn;
    }

    function query($sql)
    {
        mysql_query($sql, $this->conn);
    }

    function close(){
        mysql_close($this->conn);
    }
}
