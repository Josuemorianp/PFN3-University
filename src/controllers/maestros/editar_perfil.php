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
  $hashp=password_hash($contrasena,PASSWORD_DEFAULT);

  require_once($_SERVER["DOCUMENT_ROOT"] ."/src/config/database.php");

  try{
    $sqlUpdateUser=("UPDATE usuarios SET  correo='$correo', contrasena='$hashp', nombre='$nombre',fecha_nac='$fecha', direccion='$direccion'WHERE usuario_id = '$user_id' ");
    $pdo->query($sqlUpdateUser);
    header("Location: /src/views/maestro/perfil.php");

  }catch (PDOException $e){
    echo" Error: " . $e->getMessage(); 
  }
}
?>