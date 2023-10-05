<?php

session_start();
if (!isset($_SESSION["user_data"])) {
  echo "debes iniciar sesion<br>";
  echo "<a href='/index.php'>Login</a>";
  die();

} elseif ($_SESSION["user_data"]["role_id"] !== 2) {
  echo "No eres maestro<br>";
  echo "vuelve a iniciar sesion<br>";
  echo "<a href='/index.php'>Login</a>";
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
<body class="flex bg-slate-100">
  <section class="h-screen w-1/4 bg-[#353a40] flex flex-col  text-white aling-center items-center ">
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
      $nombre = $result["usuario_nombre"];
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>

    <div>
      <h2><?= $rol ?></h2>
      <h3><?= $nombre ?></h3>
    </div>
    <div>
      <div class="flex flex-col">
        <div>
          <i class="fa-solid fa-graduation-cap"></i>
          <button><a href="/src/views/maestro/lista.php">Alumnos</a></button>
        </div>
        <div>
          <i class="fa-solid fa-user"></i>
          <button><a href="/src/views/maestro/perfil.php">Perfil</a></button>
        </div>
        <div>
          <i class="fa-solid fa-hand-point-left"></i>
          <button><a href="/views/maestro/dashboard.php">volver</a></button>
        </div>
      </div>
      <div class="pb-10">
        <i class="fa-solid fa-right-from-bracket"></i>
        <button><a href="src/models/Logout.php">Logout</a></button>
      </div>
    </div>
  </section>
  <main class="w-[100%] flex flex-col  ">
    <header class=" bg-white flex   justify-between w-[100%] mb-4 items-center">
      <h1 class="text-2xl">Editar Datos de Perfil</h1>
      <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded m-5"><a href="/src/views/maestro/dashboard.php">Home</a></button>
    </header>
    <section class="w-[100%]">

      <?php
      $maestro_id = $_SESSION["user_data"]["usuario_id"];

      require_once($_SERVER["DOCUMENT_ROOT"] . "/src/config/database.php");

      try {
        $stmnt = $pdo->query("SELECT * FROM usuarios WHERE  usuario_id = '$maestro_id' ");

        if ($stmnt->rowCount() === 1) {
          $result = $stmnt->fetch(PDO::FETCH_ASSOC);
        }
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>

      <form class="flex flex-col  bg-white p-4 border rounded shadow-lg" action="/src/controllers/maestros/editar_perfil.php " method="POST">
        <input type="number" hidden name="user_id" value="<?= $maestro_id ?>">
        <label class="block text-gray-700 font-bold mb-2">Correo Electronico</label>
        <input class="border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500" type="email" name="correo" value="<?= $result["correo"] ?>">
        <label class="block text-gray-700 font-bold mt-2 mb-2">contraseña ingresa para cambiar la contraseña</label>
        <input class="border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500" type="password" required name="contrasena">
        <label class="block text-gray-700 font-bold mb-2 mt-2">Nombres</label>
        <input class="border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500" type="text" name="nombre" value='<?= $result["usuario_nombre"] ?>'>
        <label class="block text-gray-700 font-bold mb-2 mt-2">Direcccion</label>
        <input class="border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500" type="text" name="direccion" value="<?= $result["direccion"] ?>">
        <label class="block text-gray-700 font-bold mb-2 mt-2">Fecha de Nacimiento</label>
        <input class="border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500" type="text" name="fecha" value="<?= $result['fecha_nacimientgo'] ?>">

        <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded m-5">Enviar</button>
      </form>
    </section>
  </main>
</body>
</html>