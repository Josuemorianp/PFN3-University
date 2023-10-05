<?php
    session_start();
    if(!isset($_SESSION["user_data"])){
        $denied = " Acceso invalido";
        echo "<script>alert('" . $denied . "')</script>";
        echo"<a href='/index.php'>Volver</a>";
        die();

        
    }elseif ($_SESSION["user_data"]["role_id"] !== 1) {
        $denied = " Acceso invalido";
        echo "<script>alert('" . $denied . "')</script>";
        echo"<a href='/index.php'>Volver</a>";
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,500;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNIVERSITY</title>
    <link href="/dist/output.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4baf7d2e5d.js" crossorigin="anonymous"></script>
</head>

<body class="flex h-screen">

    <section class=" h-[100%] w-1/4 bg-[#353a40] flex flex-col  text-white aling-center items-center justify-between ">
        <div class=" flex flex-col w-[90%] h-[100%] justify-center items-center">
            <div class="flex aling-center items-center text-white p-4 justify-around border-b border-white w-[80%]">
                <div class="bg-[url('/assest/logo.jpg')] bg-cover bg-center rounded-full w-10 h-10"></div>
                <h2>Universidad</h2>
            </div>

            <?php
            
            require_once($_SERVER["DOCUMENT_ROOT"] ."/src/config/database.php");

            try{
                $id=$_SESSION["user_data"]['usuario_id'];
            
                $stmnt=$pdo->prepare('SELECT usuarios.*, roles.role_nombre AS nombre_rol FROM usuarios JOIN roles ON  usuarios.role_id = rol_id WHERE usuarios.usuario_id =:id ');
                $stmnt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmnt->execute();

                $result=$stmnt->fetch(PDO::FETCH_ASSOC);
            
                $rol=$result["nombre_rol"];
                $nombre=$result["usuario_nombre"];
            
            }catch (PDOException $e){
                echo"Error: " . $e->getMessage();
        
            }
            ?>
            
            <div>
                <h2><?=$rol?></h2>
                <h3><?=$nombre?></h3>
            </div>
            <div class="flex flex-col border-t-2">
                <h3>MENU CLASES</h3>
                <div class="flex flex-col">
                    <div>
                        <i class="fa-solid fa-chalkboard"></i>
                        <button><a href="/src/views/admin/clases.php">Clases</a></button>
                    </div>
                </div>
            </div>
            <div class="mt-auto pb-10">
                <i class="fa-solid fa-right-from-bracket"></i>
                <button><a href="/src/models/Logout.php">Logout</a></button>
            </div>
    </section>
    <main class="w-[100%] flex flex-col  ">
        <header class=" flex   justify-between w-[100%] mb-4 items-center">
            <h1 class="text-2xl">Agregar clases</h1>
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded m-5"><a href="/src/views/admin/dashboard.php">Home</a></button>
        </header>
        <section class=" flex w-[100%] aling-center justify-center">
            <form class="flex flex-col  items-center" action="/src/models/clases/crear.php" method="POST">
                <label>Nombre de la materia</label>
                <input class="border rounded-lg w-32 h-10 px-4 py-2 mb-4" type="text" name="nombre_materia">
                <button class="btn-primary">Guardar</button>

                <?php
        
                if (isset($_SESSION["Materia_existente"])) {
                    echo "<div class='bg-red-300 p-4'>
                        Materia duplicada  
                    </div>";
                    unset($_SESSION["Materia_existente"]);
                }
                ?>
                
                <?php
                
                if (isset($_SESSION["Materia_vacia"])) {
                    echo"<div class='bg-red-300 p-4'>Por favor llene todos los campos</p></div>";
                    unset($_SESSION["Materia_vacia"]);
                }
                
                ?>
                
                <button class="btn-back"><a href="/src/views/admin/Estudiantes.php">Back</a></button>
            </form>       
        </section>
    </main>
</body>
</html>