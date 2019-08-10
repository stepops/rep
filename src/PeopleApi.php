<?php
require_once 'Api.php';
require_once 'DBQueries.php';
require_once 'Response.php';

class PeopleApi extends Api
{
    public $apiName = 'people';
    /**
     * Метод GET curl -v http://localhost/api/people/
     */
    public function indexAction()
    {
        $q = new DBQueries();
        $people = $q->GetAll($this->apiName);
        if($people)
          {
            $resp = new APIResponse($people, 200);
            return $resp->response();
          }
          $resp = new APIResponse(NULL, 404);
        return $resp->response();
   }
   /**
    * Метод GET curl -v http://localhost/api/people/1
    */
   public function viewAction()
   {
       //id должен быть первым параметром после /people/x
       $id = array_shift($this->requestUri);
       if($id && is_numeric($id))
        {
         $q = new DBQueries();
         $people = $q->GetById($id, $this->apiName);
         if($people)
          {
            $resp = new APIResponse($people, 200);
            return $resp->response();
          }
        }
        $resp = new APIResponse(NULL, 404);
       return json_encode(Array('error' => $resp->response()));
   }
   /**
    * Метод POST curl -v http://localhost/api/people/ -d '{"name":"Ivan Petrov","salary":"55","birthday":"19960201"}'
    */
    public function createAction()
    {
        if($this->requestParams['name']) //имя должно быть
          {
            $q = new DBQueries();
            if($result = $q->AddNew($this->apiName, $this->requestParams))
              {
                $resp = new APIResponse(NULL, 201);
                return json_encode(Array($result => $resp->response()));
              }
              $resp = new APIResponse(NULL, 422);
            return json_encode(Array('error' => $resp->response()));
          }
          $resp = new APIResponse(NULL, 400);
        return json_encode(Array('error' => $resp->response()));
    }

    /**
     * Метод DELETE curl -v -X DELETE http://localhost/api/people/3
     */
    public function deleteAction()
        {

            $userId = array_shift($this->requestUri);
            $q = new DBQueries();
            if (!$userId  || !(is_numeric($userId)))
              {
                $resp = new APIResponse(NULL, 400);
                return json_encode(Array('error' => $resp->response()));
              }

            if($result = $q->DeleteById($userId, $this->apiName))
              {
                $resp = new APIResponse(NULL, 200);
                return json_encode(Array($result => $resp->response()));
              }
              $resp = new APIResponse(NULL, 400);
            return json_encode(Array('error' => $resp->response()));
        }

        /**
         * Метод PUT curl -v -X PUT http://localhost/api/people/3 -d '{"name":"Vasily Petrovich","salary":"10","birthday":"20051231"}'
         */
        public function updateAction()
           {
               $userId = array_shift($this->requestUri);

               if (!($this->requestParams) || !(is_numeric($userId)))
               {
                 $resp = new APIResponse(NULL, 400);
                 return json_encode(Array('error' => $resp->response()));
               }
               $q = new DBQueries();
               if($result = $q->Update($this->apiName, $this->requestParams, $userId))
                {
                  $resp = new APIResponse(NULL, 200);
                  return json_encode(Array($result => $resp->response()));
                }
              else
                {
                  $resp = new APIResponse(NULL, 422);
                  return json_encode(Array('error' => $resp->response()));
                }

           }

}
