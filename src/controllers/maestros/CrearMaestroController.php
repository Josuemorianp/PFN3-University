<?php
session_start();
if (!isset($_SESSION["user_data"])) {
  $denied = " Acceso invalido";
  echo "<script>alert('" . $denied . "')</script>";
  header("Location: /index.php");
  die();
} elseif ($_SESSION["user_data"]["id_rol"] !== 1) {
  $denied = " Acceso invalido";
  echo "<script>alert('" . $denied . "')</script>";
  header("Location: /index.php");
  die();
}
?>

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  extract($_POST);
  require_once($_SERVER["DOCUMENT_ROOT"] . "/src/config/database.php");
  $contrasena = "maestro";
  $hashp = password_hash($contrasena, PASSWORD_DEFAULT);

  try {
    extract($_POST);
    $pdo->beginTransaction();
    $sqlInsertMaestro = "INSERT INTO usuarios (email, contrasena, nombre, fecha_nac, direccion, id_rol) VALUES('$email','$hashp','$nombre','$fecha','$direccion','$id_rol')";

    $pdo->query($sqlInsertMaestro);
    $maestro_id = $pdo->lastInsertId();
    $sqlInsertarMateria = "INSERT INTO maestros_materias (maestro_id, materia_id)
        VALUES ('$maestro_id','$materia')";

    $pdo->query($sqlInsertarMateria);
    $pdo->commit();

    header("Location: /src/views/admin/maestros.php");
  } catch (PDOException $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
  }
}
?>