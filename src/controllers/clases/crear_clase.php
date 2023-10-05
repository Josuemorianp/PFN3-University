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

<?php

if($_SERVER["REQUEST_METHOD"]==="POST"){ 

require_once($_SERVER["DOCUMENT_ROOT"] ."/src/config/database.php");
extract($_POST);

if(empty($nombre_materia)){
    session_start();
    $_SESSION["Materia_vacia"]=true;
    header("Location: /src/views/admin/crear_clase.php");

}else{
  try{
    $stmt=$pdo->query("INSERT INTO materias (materia_nombre) VALUES ('$nombre_materia')");
    header("Location: /src/views/admin/clases.php");
    
    }catch(PDOException $e){
      if ($e->getCode() === '23000') { 

        session_start();
        
        $_SESSION["Materia_existente"] = true;
        header("Location: /src/views/admin/crear_clase.php");
      }else {
        echo "Error: " . $e->getMessage();
      }
    }
  }
}