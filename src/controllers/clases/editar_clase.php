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

  require_once($_SERVER["DOCUMENT_ROOT"] ."/config/database.php");

  try{
    $stmt=$pdo->query("UPDATE materias SET   materia_nombre='$materia_nombre' WHERE materia_id = '$materia_id' ");
    header("Location: /views/admin/clases.php");
  }catch (PDOException $e){
    $pdo->rollBack();
    echo" Error: " . $e->getMessage();
  }
}