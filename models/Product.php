<?php
class Product {

  private $conn;
  private $table_name = "cata_productos";

  public $id_prod_sistema;
  public $clave_prod;
  public $description;
  public $nombre_prod;
  public $categoria_prod;
  public $stock;

  public function __construct($db){
    $this->conn = $db;
  }

  public function getProducts()
  {
    $selectProdsQuery = "SELECT * FROM cata_productos";

    $stmt = $this->conn->prepare($selectProdsQuery);

    $stmt->execute();
    $num_prods = $stmt->rowCount();

    $products_arr;
    if ($num_prods > 0) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        extract($row);
        $products_arr[$categoria_prod][$clave_prod] = array(
          'id_prod_sistema' => $id_prod_sistema,
          'nombre_prod' => $nombre_prod,
          'stock' => $stock
        );
      }
      return $products_arr;
    }
    else
    {
      return null;
    }

  }

  public function getProductsByCategoria($categoria) {
    $selectByCategoriaQuery = "SELECT * FROM cata_productos WHERE categoria_prod=? ORDER BY categoria_prod DESC";

    $stmt = $this->conn->prepare($selectByCategoriaQuery);
    $stmt->bindParam(1, $categoria);
    $stmt->execute();

    $num_prods = $stmt->rowCount();
    $products_arr;

    if ($num_prods > 0) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        extract($row);
        $products_arr[$categoria_prod][$clave_prod] = array(
          'id_prod_sistema' => $id_prod_sistema,
          'nombre_prod' => $nombre_prod,
          'stock' => $stock
        );
      }
      return $products_arr;
    }
    else
    {
      return null;
    }
  }

  public function getProductsByClave($clave) {
    $selectByClaveQuery = "SELECT * FROM cata_productos WHERE clave_prod=? ORDER BY categoria_prod DESC";

    $stmt = $this->conn->prepare($selectByClaveQuery);
    $stmt->bindParam(1, $clave);
    $stmt->execute();

    $num_prods = $stmt->rowCount();
    $products_arr;
    if ($num_prods > 0) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $products_arr[$categoria_prod][$clave_prod] = array(
          'id_prod_sistema' => $id_prod_sistema,
          'nombre_prod' => $nombre_prod,
          'stock' => $stock
        );
      }
      return $products_arr;
    }
    else
    {
      return null;
    }
  }

  public function getProductDetails($clave) {
    $prodDetailQuery = "SELECT * FROM cata_detalles INNER JOIN cata_productos ON cata_productos.id_prod_sistema=cata_detalles.id_prod_sistema WHERE clave_prod=?";

    $stmt = $this->conn->prepare($prodDetailQuery);
    $stmt->bindParam(1, $clave);
    $stmt->execute();
    $num_prods = $stmt->rowCount();
    $prodDetails = array();
    if ($num_prods > 0) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $prodDetails = array(
          'clave_prod' => $clave,
          'categoria_prod' => $categoria_prod,
          'nombre_prod' => $nombre_prod,
          'marca_prod' => $marca_prod,
          'precio_prod' => $precio_prod,
          'descripcion_prod' => $descripcion_prod
      );
    }
      return $prodDetails;
    }
    else
    {
      return null;
    }
  }
}
