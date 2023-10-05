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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,500;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link href="/dist/output.css" rel="stylesheet">
  <title>UNIVERSIDAD</title>
  <link href="/dist/output.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/4baf7d2e5d.js" crossorigin="anonymous"></script>
</head>
<body class="flex">
  <section class="h-screen w-1/4 bg-[#353a40] flex flex-col  text-white aling-center items-center justify-between">
    <div class=" flex flex-col w-[90%] justify-center items-center">
      <div class="flex aling-center items-center text-white p-4 justify-around border-b border-white w-[80%]">
        <div class="bg-[url('/assest/logo.jpg')] bg-cover bg-center rounded-full w-10 h-10"></div>

        <h2>Universidad</h2>
      </div>

      <?php

      require_once($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");

      try {
        $id = $_SESSION["user_data"]['usuario_id'];
        $stmnt = $pdo->prepare('SELECT usuarios.*, roles.role_nombre AS nombre_rol FROM usuarios JOIN roles ON  usuarios.role_id = rol_id WHERE usuarios.usuario_id =:id ');
        $stmnt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmnt->execute();

        $result = $stmnt->fetch(PDO::FETCH_ASSOC);
        $rol = $result["nombre_rol"];
        $nombre = $result["nombre"];
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>

      <div>
        <h2><?= $rol ?></h2>
        <h3><?= $nombre ?></h3>
      </div>
      <div class="flex flex-col border-t-2">
        <h3>MENU ADMINISTRACION</h3>
        <div class="flex flex-col">
          <div>
            <i class="fa-solid fa-graduation-cap"></i>
            <button><a href="/src/views/admin/alumnos.php">Alumnos</a></button>
          </div>
        </div>
      </div>
      <div class="pb-10">
        <i class="fa-solid fa-right-from-bracket"></i>
        <button><a href="/src/models/Logout.php">Logout</a></button>
      </div>
    </div>

  </section>

  <form action="/src/controllers/alumnos/crearAlumnoController.php" method="POST" class="flex flex-col">
    
    <?php $rol = 3 ?>

    <input type="number" hidden value="<?= $rol ?>" name="rol_id">

    <Label>DNI</Label>
    <input type="number" name="dni" class="border rounded py-2 px-4 focus:outline-none focus:ring focus:border-blue-500">

    <Label>Correo electronico</Label>
    <input type="email" name="correo" class="border rounded py-2 px-4 focus:outline-none focus:ring focus:border-blue-500">

    <Label>Nombre(s)</Label>
    <input type="text" name="nombre" class="border rounded py-2 px-4 focus:outline-none focus:ring focus:border-blue-500">

    <Label>Dirección</Label>
    <input type="text" name="direccion" class="border rounded py-2 px-4 focus:outline-none focus:ring focus:border-blue-500">

    <Label>Fecha de nacimiento</Label>
    <input type="reversedate" name="fecha_nacimiento" class="border rounded py-2 px-4 focus:outline-none focus:ring focus:border-blue-500" placeholder="YYYY-MM-DD">

    <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Añadir</button>
  </form>
  <button><a href="/src/views/admin/dashboard.php">Home</a></button>
  <button><a href="/src/views/admin/alumnos.php">Back</a></button>
</body>
</html>