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
</head>
<body class="flex">
  <section class="h-screen w-1/4 bg-[#353a40] flex flex-col  text-white aling-center items-center justify-between">
      <div class=" flex flex-col w-[90%] justify-center items-center">
          <div class="flex aling-center items-center text-white p-4 justify-around border-b border-white w-[80%]">
              <div class="bg-[url('/assest/logo.jpg')] bg-cover bg-center rounded-full w-10 h-10">
              </div>
              <h2>Universidad</h2>
          </div>
          <?php
          require_once($_SERVER["DOCUMENT_ROOT"] ."/src/config/database.php");
          
          try{
          
          $id=$_SESSION["user_data"]['usuario_id'];
          
          $stmnt=$pdo->prepare('SELECT usuarios.*, roles.role_nombre AS nombre_rol FROM usuarios JOIN roles ON  usuarios.id_rol = rol_id WHERE usuarios.usuario_id =:id ');
          $stmnt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmnt->execute();

          $result=$stmnt->fetch(PDO::FETCH_ASSOC);
          $rol=$result["nombre_rol"];
          $nombre=$result["nombre"];

          }catch (PDOException $e){
          echo" Error: " . $e->getMessage();
      
          }
          ?>

          <div>
              <h2><?=$rol?></h2>
              <h3><?=$nombre?></h3>
          </div>
          <div class="flex flex-col border-t-2">
            <h3>MENU ALUMNOS</h3>
            <div class="flex flex-col">
              <div>
                <i class="fa-solid fa-graduation-cap"></i>
                <button><a href="/src/views/admin/alumnos.php">Alumnos</a></button>
              </div>
              <div>
                <i class="fa-solid fa-user-plus"></i>
                <button><a href="/src/views/admin/nuevo_alumno.php">Añadir alumnos</a></button>
              </div>
            </div>
          </div>
      </div>
      <div class="pb-10">
        <i class="fa-solid fa-right-from-bracket"></i>
        <button><a href="/src/controllers/Logout.php">Logout</a></button>
      </div>
  </section>
  <main>
    <header class=" flex   justify-between w-[100%] mb-4 items-center">
        <h1 class="text-2xl">Lista de Alumnos</h1>
        <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded m-5"><a href="/src/views/admin/dashboard.php">Home</a></button>
    </header>
    <section class="pt-10">
      <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">#</th>
              <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">DNI</th>
              <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Nombre</th>
              <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Correo</th>
              <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Direccion</th>
              <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Fec. de Nacimiento</th>
              <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            require_once($_SERVER["DOCUMENT_ROOT"] ."/config/database.php");
            try{
              $rolId=3;
              $sql="SELECT * FROM usuarios WHERE role_id=:rolId";
              $stmnt=$pdo->prepare($sql);
              $stmnt->bindParam(':rolId', $rolId, PDO::PARAM_INT);
              $stmnt->execute();
            
              while($row=$stmnt->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr>
              <td class='px-6 py-4 whitespace-nowrap bg-gray-100'><?=$row["usuario_id"]?></td>
              <td class='px-6 py-4 whitespace-nowrap max-w-xs truncate'><?=$row["dni"]?></td>
              <td class='px-6 py-4 whitespace-nowrap bg-gray-100'><?=$row["nombre"]?></td>
              <td class='px-6 py-4 whitespace-nowrap'><?=$row["email"]?></td>
              <td class='px-6 py-4 whitespace-nowrap bg-gray-100' max-w-xs truncate><?=$row["direccion"]?></td>
              <td class='px-6 py-4 whitespace-nowrap'><?=$row["fecha_nac"]?></td>
              <td class="text-center">
                <a href="/src/controllers/alumnos/EditarAlumnoController.php?=$row['usuario_id']?>" class="text-green-400"><i class="fa-regular fa-pen-to-square"></i></a>
                <a href="/src/controllers/alumnos/EliminarAlumnoController.php?=$row['usuario_id']?>" class="text-red-500"><i class="fa-regular fa-trash-can"></i></a>
              </td>
            </tr>
            <?php
            }
            }catch (PDOException $e){
              echo" Error: " . $e->getMessage();
            }
            ?>
          </tbody>
      </table>  
    </section>
  </main>
</body>
</html>