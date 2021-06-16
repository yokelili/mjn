<?php


namespace App\Services;

class Database
{
    protected $conn;

    private function __construct()
    {

    }

    static function getInstance()
    {
        if (!self::$conn) {
            self::$conn = new self();
        }
        return self::$conn;
    }
}
