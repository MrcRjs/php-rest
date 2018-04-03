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

  if (isset($_GET['category']))
  {
    $tdb = new TiendaDB();
    $db = $tdb->getConnection();

    // initialize object
    $Products = new Product($db);

    $reqCategory = $_GET['category'];
    $prodResults = $Products->getProductsByCategoria($reqCategory);

    if($prodResults != null)
    {
      responseHandler(
        200,
        null,
        json_encode($prodResults)
      );
    }
    else
    {
      // Bad Request, category not found
      $errormsg = "No products found for category '". $reqCategory."'";
      responseHandler(404, null, $errormsg);
    }
  }
  else
  {
    // Bad Request, category not specified
    $errormsg = "Category not specified";
    responseHandler(400, null, $errormsg);
  }
?>
