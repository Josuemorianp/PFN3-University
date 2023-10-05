<?php
session_start();
if (!isset($_SESSION["user_data"])) {
  $denied = " Acceso invalido";
  echo "<script>alert('" . $denied . "')</script>";
  header("Location: /index.php");
  die();
} elseif ($_SESSION["user_data"]["role_id"] !== "2") {
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

<body class="flex bg-slate-100">
  <section class="h-screen w-1/4 bg-[#353a40] flex flex-col  text-white aling-center items-center ">

    <div class="flex aling-center items-center text-white p-4 justify-around border-b border-white w-[80%]">
      <div class="bg-[url('/assest/logo.jpg')] bg-cover bg-center rounded-full w-10 h-10">

      </div>

      <h2>Universidad</h2>
    </div>
    <?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");

    try {
      //var_dump($_SESSION["user_data"]);
      $id = $_SESSION["user_data"]['usuario_id'];

      $stmnt = $pdo->prepare('SELECT usuarios.*, roles.role_nombre AS nombre_rol FROM usuarios JOIN roles ON  usuarios.role_id = rol_id WHERE usuarios.usuario_id =:id ');
      $stmnt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmnt->execute();

      $result = $stmnt->fetch(PDO::FETCH_ASSOC);
      //var_dump($result);
      $rol = $result["nombre_rol"];
      $nonmbre = $result["usuario_nombre"];

      //var_dump($rol);

    } catch (PDOException $e) {
      echo " Error: " . $e->getMessage();
    }
    ?>
    <div>
      <h2><?= $rol ?></h2>
      <h3><?= $nonmbre ?></h3>
    </div>
    <div>
      <div class="flex flex-col">
        <div>
          <i class="fa-solid fa-graduation-cap"></i>
          <button><a href="/views/maestro/lista.php">Alumnos</a></button>
        </div>

        <div>
          <i class="fa-solid fa-user"></i>
          <button><a href="/views/maestro/perfil.php">Perfil</a></button>
        </div>


      </div>




      <div class="pb-10">
        <i class="fa-solid fa-right-from-bracket"></i>
        <button><a href="/handledb/logout.php">Logout</a></button>
      </div>
  </section>
  <main class="w-[100%] flex flex-col  ">
    <header class=" bg-white flex   justify-between w-[100%] mb-4 items-center">
      <h1 class="text-2xl">Dashboard</h1>
      <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded m-5"><a href="/views/maestro/dashboard.php">Home</a></button>
    </header>
    <main>
      <section class=" bg-white ">
        <h3>Bienvenido</h3>
        <P>Selecciona la accion que quieras realizar en las pestañas de la izquierda</P>
      </section>
    </main>
  </main>


</body>

</html>

</html>



</main>


</body>

</html>