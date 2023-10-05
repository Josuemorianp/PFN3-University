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
if ($_SERVER["REQUEST_METHOD"] === "GET") {
  
  try {

    require_once($_SERVER["DOCUMENT_ROOT"] . "/src/config/database.php");
    
    $pdo->beginTransaction();
    $materia_id = $_GET['id'];

    $borrarEnMaestros = $pdo->query("DELETE FROM maestros_materias WHERE materia_id='$materia_id'");
    $borrarEnAlumnos = $pdo->query("DELETE FROM almnos_materias WHERE materia_id='$materia_id'");
    $borrarmateria = $pdo->query("DELETE FROM materias WHERE materia_id='$materia_id'");

    $pdo->commit();
    header("Location: /src/views/admin/clases.php");
  } catch (PDOException $e) {

    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
  }
}
