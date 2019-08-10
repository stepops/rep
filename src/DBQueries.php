<?php
require_once 'DBConnect.php';
class DBQueries
{

private $dbcon;

  public function __construct() //соединение с БД
  {
    $db = new mysqlconnection();
    $this->dbcon = $db->getConnect();
  }

  public function GetAll($table)
    {

      $result = $this->dbcon->query("SELECT * FROM $table");//вернет записи в виде массива ассоциативных массивов
      $dbdata = array();
      while ( $row = $result->fetch_assoc())
        {
      	   $dbdata[]=$row;
        }
      return $dbdata;
    }

  public function GetById($id, $table) //вернет запись в виде ассоциативного массива
    {
      $result = $this->dbcon->query("SELECT * FROM $table WHERE id = $id");
      $row = $result->fetch_assoc();
      return $row;
    }

  public function DeleteById($id, $table) //вернет или affected_rows или NULL
    {
      $sql = "DELETE FROM $table WHERE `id` = $id";
      $result = $this->dbcon->query($sql);
      return $this->dbcon->affected_rows;
    }

    public function AddNew($table, $data) //вернет или insert_id или NULL
      {

        $keys=array_keys($data);
        foreach ($keys as $value)
        {
          $what.="`".$value."`,";
        }
        unset($value);
        $what = substr($what, 0, -1);


        foreach ($data as $record)
        {
          $records.="'".$record."',";
        }
        unset($record);
        $records = substr($records, 0, -1);


      $sql = "INSERT INTO $table ($what) VALUES ($records)";
      if ($this->dbcon->query($sql) === TRUE)
        {
          return $this->dbcon->insert_id;
        }
      else
        {
          return NULL;
        }
      }

      public function Update($table, $data, $id) //вернет или affected_rows или NULL
        {

        $set = implode(', ', array_map(function ($v, $k)
          {
            if(is_array($v))
            {
              return $k.'[]='.implode('&'.$k.'[]=', $v);
            }
          else
            {
              return "`".$k."`".'='."'".$v."'";
            }
          }, $data, array_keys($data)));

        $sql = "UPDATE $table SET $set WHERE `id`=$id";

          if ($this->dbcon->query($sql) == TRUE)
            {

              if (mysqli_affected_rows($this->dbcon)==0)
              {
                return NULL;
              }
              else {
                return mysqli_affected_rows($this->dbcon);
              }

            }

        }

}


 ?>
