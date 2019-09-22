<?php
namespace test;

if(!defined('SITE'))
{
    exit;
}

class DB {
    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_password = '123456';
    private $db_name = 'test';

    private static $mysql_connect = null;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $db_connect = @mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_name);

        if(mysqli_connect_errno($db_connect)) {
            echo 'MySQL connect error!<br/>';
            echo mysqli_connect_errno($db_connect);
            exit;
        }
        else
        {
            mysqli_query($db_connect, "SET NAMES utf8");
            self::$mysql_connect = $db_connect;
        }
    }

    private function query($query = null)
    {
        if($a = @mysqli_query(self::$mysql_connect, $query))
        {
            return $a;
        }
        else
        {
            $e = '<b>Error number:</b> '.mysqli_errno(self::$mysql_connect).PAGE_BR;
            $e .= '<b>Error:</b> '.PAGE_BR;
            $e .= mysqli_error(self::$mysql_connect).PAGE_BR;
            $e .= '<b>Query:</b>'.PAGE_BR;
            $e .= $query;

            die($e);
        }
    }

    private function fetch($query = null)
    {
        return @mysqli_fetch_all($this->query($query), MYSQLI_ASSOC);
    }

    public function find($query)
    {
        return $this->fetch($query);
    }
}