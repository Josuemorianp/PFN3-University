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

    require_once($_SERVER["DOCUMENT_ROOT"] . "/src/config/database.php");

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
          <button><a href="">Alumnos</a></button>
        </div>
        <div>
          <i class="fa-solid fa-hand-point-left"></i>
          <button><a href="/views/maestro/dashboard.php">volver</a></button>
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
    <section>
      <div class="bg-white">
        
        <?php

        require_once($_SERVER["DOCUMENT_ROOT"] . "/src/config/database.php");
        
        try {
          $maestro_id = $_SESSION["user_data"]["usuario_id"];

          $sql1 = "SELECT m.materia_id, m.materia_nombre FROM materias AS m     JOIN maestros_materias AS mm ON m.materia_id = mm.materia_id           WHERE mm.maestro_id = $maestro_id";

          $result1 = $pdo->query($sql1);
          
          if ($row = $result1->fetch(PDO::FETCH_ASSOC)) {
            echo "<h1 class='text-2xl font-semibold text-gray-800 ml-4'>Alumnos de la clase de " . $row['materia_nombre'] . "</h1>";
          }
        } catch (PDOException $e) {
          echo " Error: " . $e->getMessage();
        }
        ?>

      </div>
      <table class="border ml-4 mt-5">
        <thead>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de Alumno</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Calificacion</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mensajes</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
        </thead>
        <tbody>


          <?php

          require_once($_SERVER["DOCUMENT_ROOT"] . "/src/config/database.php");
          
          try {
            $maestro_id = $_SESSION["user_data"]["usuario_id"];

            $sql1 = "SELECT m.materia_id, m.materia_nombre FROM materias AS m     JOIN maestros_materias AS mm ON m.materia_id = mm.materia_id WHERE mm.maestro_id = $maestro_id";

            $result1 = $pdo->query($sql1);
            $materia = $result1->fetch(PDO::FETCH_ASSOC);
            $materia_id = $materia["materia_id"];

            $stmt2 = $pdo->query("SELECT u.usuario_id, u.usuario_nombre FROM usuarios AS u JOIN almnos_materias AS am ON u.usuario_id = am.alumno_id WHERE am.materia_id = $materia_id");

            while ($alumno = $stmt2->fetch(PDO::FETCH_ASSOC)) {

          ?>
              <tr>
                <td class="px-4 py-2 text-center"><?= $alumno["usuario_id"] ?></td>
                <td class="px-4 py-2 text-center"><?= $alumno["nombre"] ?></td>
                <td class="px-4 py-2 text-center">Sin calificacion</td>
                <td class="px-4 py-2 text-center">Sin mensajes</td>
                <td class="px-4 py-2 text-center"><a class="text-blue-300" href="#"><i class="fa-solid fa-clipboard"></i></a>
                  <a class="text-blue-300" href="#">
                    <i class="fa-solid fa-paper-plane"></i>
                  </a>
                </td>
              </tr>

          <?php

            };
          } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
          ?>

        </tbody>
      </table>
    </section>
  </main>
</body>
</html>