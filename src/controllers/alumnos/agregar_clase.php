<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/src/config/database.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $materia_id = $_POST["materia"];
  $alumno_id=$_POST["alumno_id"];

  try {
    $sql = "INSERT INTO almnos_materias (alumno_id, materia_id) VALUES (:alumno_id, :materia_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':alumno_id', $alumno_id, PDO::PARAM_INT);
    $stmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: /src/views/alumno/dashboard.php");
    exit();
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}
?>
