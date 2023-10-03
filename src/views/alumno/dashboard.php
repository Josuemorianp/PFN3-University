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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,500;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link href="/dist/output.css" rel="stylesheet">
  <title>UNIVERSIDAD</title>
</head>
<body class="flex">
  <section class="h-screen w-1/4 bg-[#353a40] flex flex-col  text-white aling-center items-center">
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
      echo "Error: " . $e->getMessage();
    }
    ?>

    <div>
      <h2><?= $rol ?></h2>
      <h3><?= $nombre ?></h3>
    </div>
    <button><a href="/src/controllers/Logout.php">Logout</a></button>
  </section>
  <main>
    <h1>Lista de materias</h1>

    <?php
    
    require_once($_SERVER["DOCUMENT_ROOT"] . "/src/config/database.php");
    
    ?>
    
  </main>
</body>
</html>