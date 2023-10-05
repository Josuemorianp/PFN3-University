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

if($_SERVER["REQUEST_METHOD"]==="POST"){
  extract($_POST);
  
  require_once($_SERVER["DOCUMENT_ROOT"] ."/src/config/database.php");

  try{

    $stmnt=$pdo->query("UPDATE usuarios SET  correo='$correo', nombre='$nombre',fecha_nac='$fecha_nacimiento', direccion='$direccion', role_id='$rol_id', dni='$dni'WHERE usuario_id = '$usuario_id' ");

    header("Location: /src/views/admin/estudiantes.php");

  }catch (PDOException $e){
    echo "Error: " . $e->getMessage();
  }
}