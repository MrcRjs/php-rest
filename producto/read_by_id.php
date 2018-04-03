<?php

  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");

  include_once '../config/core.php';
  include_once '../config/database.php';
  include_once '../models/Product.php';
  include_once '../util/validateCredentials.php';
  include_once '../util/responseHandler.php';

    // Check for valid username/pass
  validateCredentials();

  if (isset($_GET['id']))
  {
    $reqId = $_GET['id'];
    $TDB = new TiendaDB();
    $DB = $TDB->getConnection();
    $Products = new Product($DB);
    $ProdDetails = $Products->getProductDetails($reqId);
    if($ProdDetails != null)
    {
      responseHandler(
        200,
        null,
        json_encode($ProdDetails)
      );
    }
    else
    {
      // Bad Request, id not found
      $errormsg = "No products found for id '". $reqId."'";
      responseHandler(404, null, $errormsg);
    }
  }
  else
  {
    // Bad Request, id not specified
    $errormsg = "Id not specified";
    responseHandler(400, null, $errormsg);
  }
?>
