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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin_dashboard</title>
  <link href="/dist/output.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/4baf7d2e5d.js" crossorigin="anonymous"></script>
</head>
<body class="flex ">
  <section class="h-screen w-1/4 bg-[#353a40] flex flex-col  text-white  items-center justify-between m">
    <div class=" flex flex-col w-[90%] justify-center items-center">
      <div class="flex aling-center items-center text-white p-4 justify-around border-b border-white w-[80%]">
        <div class="bg-[url('/assest/logo.jpg')] bg-cover bg-center rounded-full w-10 h-10">
        </div>
        <h2>Universidad</h2>
      </div>
      <?php

      require_once($_SERVER["DOCUMENT_ROOT"] . "/src/config/database.php");

      try {
        $id = $_SESSION["user_data"]['usuario_id'];

        $stmnt = $pdo->prepare('SELECT usuarios.*, roles.role_nombre AS nombre_rol FROM usuarios JOIN roles ON  usuarios.id_rol = rol_id WHERE usuarios.usuario_id =:id ');
        $stmnt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmnt->execute();

        $result = $stmnt->fetch(PDO::FETCH_ASSOC);
        $rol = $result["nombre_rol"];
        $nombre = $result["nombre"];
      } catch (PDOException $e) {
        echo " Error: " . $e->getMessage();
      }
      ?>
      <div>
        <h2><?= $rol ?></h2>
        <h3><?= $nombre ?></h3>
      </div>
      <div class="flex flex-col border-t-2">
        <h3>MENU MAESTROS</h3>
        <div class="flex flex-col">
          <div>
            <i class="fa-solid fa-chalkboard-user"></i>
            <button><a href="/src/views/admin/maestros.php">Lista</a></button>
          </div>
          <div>
            <i class="fa-solid fa-user-plus"></i>
            <button><a href="/src/views/admin/nuevo_maestro.php">Crear</a></button>
          </div>
        </div>
      </div>
    </div>
    <div class="pb-10">
      <i class="fa-solid fa-right-from-bracket"></i>
      <button><a href="/handledb/logout.php">Logout</a></button>
    </div>
  </section>
  <main>
    <header class=" flex   justify-between w-[100%] mb-4 items-center">
      <h1 class="text-2xl">Lista de maestros</h1>
      <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded m-5"><a href="/src/views/admin/dashboard.php">Home</a></button>
    </header>
    <div class="overflow-x-auto ml-4">
      <table class="min-w-full divide-y divide-gray-200 w-[20%] border border-gray-200 border-solid   mx-auto">
        <thead>
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Direccion</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase Asignada</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" scope="col">Fec. de Nacimiento</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
          </tr>
        </thead>
      <tbody>
      <?php

      require_once($_SERVER["DOCUMENT_ROOT"] . "/src/config/database.php");
      
      try {
        $rolId = 2;
        $sql = "SELECT u.usuario_id, u.nombre, u.email, u.direccion, u.fecha_nac, IFNULL(m.materia_nombre, 'sin asignación') AS materia_asignada           FROM usuarios u LEFT JOIN maestros_materias mm ON u.usuario_id = mm.maestro_id      LEFT JOIN materias m ON mm.materia_id = m.materia_id
        WHERE u.id_rol = :rolId";
            $stmnt = $pdo->prepare($sql);
            $stmnt->bindParam(':rolId', $rolId, PDO::PARAM_INT);
            $stmnt->execute();
        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <tr>
        <td class='px-6 py-4 whitespace-nowrap bg-gray-100'><?= $row["usuario_id"] ?></td>
        <td class='px-6 py-4 whitespace-nowrap bg-gray-100 max-w-xs truncate'><?= $row["nombre"] ?></td>
        <td class='px-6 py-4 whitespace-nowrap max-w-xs truncate'><?= $row["email"] ?></td>
        <td class='px-6 py-4 whitespace-nowrap bg-gray-100 max-w-xs truncate'><?= $row["direccion"] ?></td>
        <td headers="clase_asignada" class='px-6 py-4 whitespace-nowrap max-w-xs truncate <?= $row["materia_asignada"] === "sin asignación" ? 'bg-red-100' : '' ?>'><?= $row["materia_asignada"] ?></td>
        <td class='px-6 py-4 whitespace-nowrap max-w-xs truncate'><?= $row["fecha_nac"] ?></td>
        <td class="text-center">
          <a href="/src/views/admin/editar_maestro.php?id=<?= $row['usuario_id'] ?>" class="text-green-400"><i class="fa-regular fa-pen-to-square"></i></a>
          <a href="/src/controllers/maestros/EliminarMaestroController.php?id=<?= $row['usuario_id'] ?>" class="text-red-500"><i class="fa-regular fa-trash-can"></i></a>
        </td>
      </tr>

      <?php
        }
      } catch (PDOException $e) {
          echo " Error: " . $e->getMessage();
      }
      ?>

      </tbody>
        </table>
    </div>
  </main>
</body>
</html>