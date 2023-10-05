<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  extract($_POST);

  require_once($_SERVER["DOCUMENT_ROOT"] . "/src/config/database.php");

  try {
    $stmnt = $pdo->query("SELECT * FROM usuarios WHERE correo='$correo'");

    if($stmnt->rowCount() === 1) {
      $result = $stmnt->fetch(PDO::FETCH_ASSOC);

      if ($contrasena === $result["contrasena"]){
        session_start();

        $_SESSION["user_data"] = $result;

        switch($result){
          case $result["role_id"] === "1":
            header("Location: /src/views/admin/dashboard.php");
            break;
          case $result["role_id"] === "2":
            header("Location: /src/views/maestro/dashboard.php");
            break;
          case $result["role_id"] === "3":
            header("Location: /src/views/alumno/dashboard.php");
            break;
          default:
            $denied = " Acceso invalido";
            echo "<script>alert('" . $denied . "')</script>";
            break;
        }
      } else{
        $miss_pass = "Contraseña invalida";
        echo "<script>alert('" . $miss_pass . "')</script>";
        echo "<a href='/index.php'>volver</a>";
        // header("Location: /index.php");
      }
    } else{
      $miss_email = "Correo invalido";
      echo "<script>alert('" . $miss_email . "')</script>";
      echo "<a href='/index.php'>volver</a>";
      // header("Location: /index.php");
    }
  } catch(PDOException $e) {
    echo "Error" . $e->getMessage();
    // header("Location: /index.php");
  }
}