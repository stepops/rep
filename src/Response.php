<?php

class APIResponse //ответ сервера
{

public $data = NULL;
public $status = 500;
public $code = '';


public function __construct($indata, $instatus)
{
  $this->data=$indata;
  $this->status=$instatus;
  $this->code = $this->requestStatus($this->status);
  header("HTTP/1.1 " . $this->status . " " . $this->code);
}

  public function response()
    {

      if ($this->data == NULL)
        {
          return $this->code;
        }
      return json_encode($this->data);
    }

  public function requestStatus($code)
    {
      $status = array(
          200 => 'OK',
          201 => 'Created',
          304 => 'Not Modified',
          400 => 'Bad Request',
          401 => 'Unauthorized',
          403 => 'Forbidden',
          404 => 'Not found',
          405 => 'Method Not Allowed',
          410 => 'Gone',
          415 => 'Unsupported Media Type',
          422 => 'Unprocessable Entity',
          429 => 'Too Many Requests',
          500 => 'Internal Server Error',
      );
      return ($status[$code])?$status[$code]:$status[500];
    }

}

?>
