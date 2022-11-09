<?php

namespace App\Infrastructure\Db;

use \PDO;

class DB
{
    private $host = 'slim_db';
    private $user = 'slim';
    private $pass = 'slim';
    private $dbname = 'slim';

    public function connect()
    {
        $conn_str = "mysql:host=$this->host;port=3306;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}