<?php

require_once 'PeopleApi.php';

try
  {
    $api = new PeopleApi();
    echo $api->exec();
  }
catch (Exception $e)
  {
    echo json_encode(Array('error' => $e->getMessage()));
  }

?>
