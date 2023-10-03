<?php
  session_start();
  if(!isset($_SESSION["user_data"])){
    echo"debes iniciar sesion<br>";
    echo"<a href='/index.php'>Login</a>";
    die();
} elseif ($_SESSION["user_data"]["role_id"] !== 2) {
    echo "No eres maestro<br>";
    echo "vuelve a iniciar sesion<br>";
    echo"<a href='/index.php'>Login</a>";
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=0, initial-scale=1.0">
    <title>Maestro_dasboard</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>
<body>
  <section class="h-screen w-1/4 bg-[#353a40] flex flex-col  text-white aling-center items-center">
    <div class="flex aling-center items-center text-white p-4 justify-around border-b border-white w-[80%]">
      <div class="bg-[url('/assest/logo.jpg')] bg-cover bg-center rounded-full w-10 h-10">
      </div>

        <h2>Universidad</h2>
    </div>
    <?php
    
    require_once($_SERVER["DOCUMENT_ROOT"] ."/config/database.php");

    try{
      $id = $_SESSION["user_data"]["usuario_id"];
      $stmnt = $pdo -> prepare("SELECT usuarios.*, roles.role_nombre AS nombre_rol FROM usuarios JOIN roles ON  usuarios.role_id = rol_id WHERE usuarios.usuario_id =:id");
      $stmnt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmnt->execute();
      
      $result=$stmnt->fetch(PDO::FETCH_ASSOC);
      
      $rol = $result["nombre_rol"];
      $nonmbre = $result["usuario_nombre"];
            
      }catch (PDOException $e){
        echo" Error: " . $e->getMessage();  
      }
    ?>
    <div>
      <h2><?=$rol?></h2>
      <h3><?=$nonmbre?></h3>
    </div>
    <button><a href="/handledb/logout.php">Logout</a></button>
  </section>
</body>
</html>