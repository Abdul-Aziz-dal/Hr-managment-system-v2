<?php

//***ImportingConfig******//
require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../config/helpers.php';
checkRequestMethod();
class Database
{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $connection;

    public function __construct()
    {


        $this->host = DB_HOST;
        $this->username = DB_USER;
        $this->password = DB_PASS;
        $this->dbname = DB_NAME;

        $this->connect();
    }

    private function connect()
    {
        $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);

        if (mysqli_connect_errno()) {
            die("Database connection failed: " . mysqli_connect_error());
        }
    }

    public function query($sql)
    {
        $result = mysqli_query($this->connection, $sql);

        if (!$result) {
            throw new Exception("Query execution failed: " . mysqli_error($this->connection));
        }

        return $result;
    }

    public function fetch($sql)
    {
        $result = $this->query($sql);
        return mysqli_fetch_assoc($result);
    }

    public function fetchAll($sql)
    {
        $result = $this->query($sql);
        $rows = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function execute($sql)
    {
        $this->query($sql);
        return mysqli_affected_rows($this->connection);
    }

    public function lastInsertId()
    {
        return mysqli_insert_id($this->connection);
    }

    public function close()
    {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }
}
