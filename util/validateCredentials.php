<?php
  include_once '../config/database.php';
  include_once '../models/Usuario.php';
  include_once 'responseHandler.php';

  // Middleware to veriify correct user and pass in DB
  function validateCredentials()
  {
    if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
    {
      $user = $_SERVER['PHP_AUTH_USER'];
      $pass = $_SERVER['PHP_AUTH_PW'];
      $TDB = new TiendaDB();
      $conn = $TDB->getConnection();
      $userBD = new Usuario($conn);
      $valid = $userBD->checkUserPass($user, $pass);
      if (!$valid) {
        responseHandler(401, null, "Wrong user or password");
      }
    }
    else
    {
      responseHandler(401, null, "Unauthorized");
    }
  }
?>
