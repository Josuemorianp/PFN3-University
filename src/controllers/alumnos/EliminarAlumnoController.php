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

  extract($_GET);

  require_once($_SERVER["DOCUMENT_ROOT"] ."src/config/database.php");

  try{
    $stmnt=$pdo->query("DELETE FROM almnos_materias WHERE materia_id='$id' ");
    header("Location: /src/views/alumno/dashboard.php");

  }catch (PDOException $e){
    echo" Error: " . $e->getMessage();
  }
}