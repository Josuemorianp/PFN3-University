<?php
session_start();
if (!isset($_SESSION["user_data"])) {
  $denied = " Acceso invalido";
  echo "<script>alert('" . $denied . "')</script>";
  header("Location: /index.php");
  die();
} elseif ($_SESSION["user_data"]["role_id"] !== 1) {
  $denied = " Acceso invalido";
  echo "<script>alert('" . $denied . "')</script>";
  header("Location: /index.php");
  die();
}
?>

<?php

if($_SERVER["REQUEST_METHOD"]==="GET"){

  require_once($_SERVER["DOCUMENT_ROOT"] ."/src/config/database.php");

    try {
      $pdo->beginTransaction();
    
      $usuario_id = $_GET['id']; 
      $sqlDeleteMaestrosMaterias = "DELETE FROM maestros_materias    WHERE maestro_id = :usuario_id";
      $stmntDeleteMaestrosMaterias = $pdo->prepare($sqlDeleteMaestrosMaterias);
      $stmntDeleteMaestrosMaterias->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
      $stmntDeleteMaestrosMaterias->execute();
    
      $sqlDeleteUsuario = "DELETE FROM usuarios WHERE usuario_id = :usuario_id";
      $stmntDeleteUsuario = $pdo->prepare($sqlDeleteUsuario);
      $stmntDeleteUsuario->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
      $stmntDeleteUsuario->execute();
    
      $pdo->commit();
    
      header("Location: /src/views/admin/maestros.php");
    
  } catch (PDOException $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
  }
}
?>