<?php
require_once 'Response.php';

abstract class Api
{
    public $apiName = ''; //people
    protected $method = ''; //GET|POST|PUT|DELETE
    public $requestUri = []; ///api/people/1
    public $requestParams = []; //данные на входе
    protected $action = ''; //Название метода для выполнения


    public function __construct()
    {   //заголовки
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
        $data = json_decode(file_get_contents("php://input"), true); //данные на входе в формате json
        $this->requestParams = $data;
        $this->method = $_SERVER['REQUEST_METHOD'];

        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER))
        {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE')
              {
                $this->method = 'DELETE';
              }
            else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT')
              {
                $this->method = 'PUT';

              }
            else
              {
                throw new Exception("Unexpected Header");
              }
        }
    }

    public function exec()
      {
        if(array_shift($this->requestUri) !== 'api' || array_shift($this->requestUri) !== $this->apiName)
          {
            $resp = new APIResponse(NULL, 404);
            return json_encode(Array('error' => $resp->response()));
          }
        $this->action = $this->getAction();
        if (method_exists($this, $this->action))
          {
            return $this->{$this->action}(); //вызов нужного метода
          }
            else
              {$resp = new APIResponse('error', 405);
                return json_encode(Array('error' => $resp->response()));
              }
            }

    protected function getAction() //определение нужного метода
    {
        $method = $this->method;
        switch ($method) {
            case 'GET':
                if($this->requestUri)
                  {
                    return 'viewAction';
                  }
                    else
                      {
                        return 'indexAction';
                      }
                break;
            case 'POST':
                return 'createAction';
                break;
            case 'PUT':
                return 'updateAction';
                break;
            case 'DELETE':
                return 'deleteAction';
                break;
            default:
                return null;
        }
    }

    abstract protected function indexAction();
    abstract protected function viewAction();
    abstract protected function createAction();
    abstract protected function updateAction();
    abstract protected function deleteAction();
}
