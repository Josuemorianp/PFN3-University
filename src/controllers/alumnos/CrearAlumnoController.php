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

<?php
if($_SERVER["REQUEST_METHOD"]==="POST"){
  
  require_once($_SERVER["DOCUMENT_ROOT"] ."/src/config/database.php");
  
  $contrasena="estudiante";
  $hashp=password_hash($contrasena,PASSWORD_DEFAULT);
  
  extract($_POST);

  try{
        
    $stmt=$pdo->prepare("INSERT INTO usuarios (correo, contrasena, nombre, fecha_nac, direccion, role_id, dni) VALUES (:correo, :hashp, :nombre, :fecha_nacimiento, :direccion, :rol_id, :dni  )");
    $stmt->bindParam(':correo',$correo,PDO::PARAM_STR);
    $stmt->bindParam(':hashp',$hashp,PDO::PARAM_STR);
    $stmt->bindParam(':nombre',$nombre,PDO::PARAM_STR );
    $stmt->bindParam(':fecha_nacimiento',$fecha_nacimiento,PDO::PARAM_STR );
    $stmt->bindParam(':direccion', $direccion,PDO::PARAM_STR);
    $stmt->bindParam(':rol_id',$rol_id,PDO::PARAM_INT);
    $stmt->bindParam(':dni',$dni, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: /src/views/admin/Estudiantes.php");

  }catch(PDOException $e){
    echo" Error: " . $e->getMessage();
  }
}
?>
