<?php

abstract class dbconnection //подключение к БД
  {
    protected $host = 'mysql';
    protected $username = 'root';
    protected $password = 'secret';
    protected $database = 'test';

    abstract function getConnect();
    }

class mysqlconnection extends dbconnection
  {
    public function getConnect()
      {
        $connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($connection->connect_error)
          {
            throw new Exception("Cannot connect to database");
            //die("Connection failed: " . $connection->connect_error);
          }
        return $connection;
      }
  }

?>
