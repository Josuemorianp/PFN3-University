<?php
session_start();
if (!isset($_SESSION["user_data"])) {
  $denied = " Acceso invalido";
  echo "<script>alert('" . $denied . "')</script>";
  header("Location: /index.php");
  die();
} elseif ($_SESSION["user_data"]["role_id"] !== "1") {
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
<body>
  <section class=" flex flex-col justify-between items-center aling-center h-screen w-1/4 bg-[#353a40]  text-white">
    <div class=" flex flex-col justify-center items-center w-[90%]r">
      <div class="flex aling-center items-center text-white p-4 justify-around border-b border-white w-[80%]">
        <div class="w-10 h-10 bg-cover bg-center ">
          <img src="/src/images/logo.jpg" alt="logo" class="w-10 h-10 rounded-full" >
      </div>
        <h2>Universidad</h2>
      </div>

      <?php
      require_once($_SERVER["DOCUMENT_ROOT"] . "/src/config/database.php");

      try {
        $id = $_SESSION["user_data"]['usuario_id'];

        $stmnt = $pdo->prepare('SELECT usuarios.*, roles.role_nombre AS nombre_rol FROM usuarios JOIN roles ON  usuarios.role_id = id_rol WHERE usuarios.usuario_id =:id ');
        $stmnt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmnt->execute();

        $result = $stmnt->fetch(PDO::FETCH_ASSOC);
        
        $rol = $result["nombre_rol"];
        $nombre = $result["nombre"];

      }catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>

      <div>
        <h2><?= $rol ?></h2>
        <h3><?= $nombre ?></h3>
      </div>
      <div class="flex flex-col border-t-2">
        <h3>MENU ADMINISTRACIÓN</h3>
        <div class="flex flex-col">
          <div>
            <i class="fa-solid fa-user-clock"></i>
            <button><a href="/src/views/admin/permisos.php">Permisos</a></button>
          </div>
          <div>
            <i class="fa-solid fa-graduation-cap"></i>
            <button><a href="/src/views/admin/alumnos.php">Alumnos</a></button>
          </div>
          <div>
            <i class="fa-solid fa-chalkboard-user"></i>
            <button><a href="/src/views/admin/maestros.php">Maestros</a></button>
          </div>
          <div>
            <i class="fa-solid fa-chalkboard"></i>
            <button><a href="/src/views/admin/clases.php"></a>Clases</button>
          </div>
        </div>
      </div>
    </div>
    <div class="pb-10">
      <i class="fa-solid fa-right-from-bracket"></i>
      <button><a href="/src/models/Logout.php">Logout</a></button>
    </div>
  </section>
</body>
</html>