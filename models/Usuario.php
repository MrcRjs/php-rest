<?php
class Usuario {

  private $conn;

  public function __construct($db){
    $this->conn = $db;
  }

  public function checkUserPass($user, $pass) {
    $userQuery = "SELECT * FROM cata_usuarios WHERE BINARY nombre_user=? AND BINARY password_user=?";

    $stmt = $this->conn->prepare($userQuery);

    $stmt->execute(array($user, hash('sha256', $pass)));

    $userExists = $stmt->rowCount();
    $products_arr;
    if ($userExists > 0) {
      return true;
    }
    return false;
  }
}
?>
