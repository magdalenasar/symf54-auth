<?php

namespace App\Services;

class DBManager
{
    private $logger;
    private $conn;
    private $db_url;
    private $db_user;
    private $db_pwd;

    public function __construct(Logger $logger, $db_url, $db_user, $db_pwd)
    {
        $this->logger = $logger;
        $this->db_url = $db_url;
        $this->db_user = $db_user;
        $this->db_pwd = $db_pwd;
    }

    function getConnection()
    {
        //create connection if it doesn't exist already
        if ( $this->conn === null )
        {
            try {
                $this->conn = new \PDO($this->db_url, $this->db_user, $this->db_pwd,
                    array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                ));
                $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
            catch (\PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        return $this->conn;
    }

    function GetData($sql, $fetch_options = null)
    {
        //define, log and execute query
        $this->logger->Log(date("Y-m-d H:i:s: ") . $sql );
        $result = $this->getConnection()->query($sql);

        //return result (if there is any)
        if ($result->rowCount() > 0) {

            if ( $fetch_options == null )
            {
                $rows = $result->fetchAll(\PDO::FETCH_BOTH);
            }
            if ( $fetch_options == 'assoc' )
            {
                $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
            }
            if ( $fetch_options == 'num' )
            {
                $rows = $result->fetchAll(\PDO::FETCH_NUM);
            }

            return $rows;
        }
        else return [];

    }

    function ExecuteSQL($sql)
    {
        //define, log and execute query
        $this->logger->Log(date("Y-m-d H:i:s: ") . $sql );
        $result = $this->getConnection()->exec($sql);

        return $result;
    }

    function getInsertedId()
    {
        return $this->getConnection()->lastInsertId();
    }

}

