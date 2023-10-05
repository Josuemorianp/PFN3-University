<?php
    session_start();
    if(!isset($_SESSION["user_data"])){
        echo"debes iniciar sesion<br>";
        echo"<a href='/index.php'>Login</a>";
        die();

        
    }elseif ($_SESSION["user_data"]["role_id"] !== 3) {
        echo "No eres alumno <br>";
        echo "vuelve a iniciar sesion<br>";
        echo"<a href='/index.php'>Login</a>";

        die();
    }
    
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alunmno_Editar</title>
    <link href="/dist/output.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4baf7d2e5d.js" crossorigin="anonymous"></script>
</head>

<body class="flex">
    <section class="h-screen w-1/4 bg-[#353a40] flex flex-col  text-white aling-center items-center">
        <div class="flex aling-center items-center text-white p-4 justify-around border-b border-white w-[80%]">
            <div class="bg-[url('/assest/logo.jpg')] bg-cover bg-center rounded-full w-10 h-10">

            </div>

            <h2>Universidad</h2>
        </div>
        <?php
        require_once($_SERVER["DOCUMENT_ROOT"] ."/config/database.php");

        try{
            //var_dump($_SESSION["user_data"]);
            $id=$_SESSION["user_data"]['usuario_id'];
            
            $stmnt=$pdo->prepare('SELECT usuarios.*, roles.role_nombre AS nombre_rol FROM usuarios JOIN roles ON  usuarios.role_id = rol_id WHERE usuarios.usuario_id =:id ');
            $stmnt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmnt->execute();

            $result=$stmnt->fetch(PDO::FETCH_ASSOC);
            //var_dump($result);
            $rol=$result["nombre_rol"];
            $nonmbre=$result["usuario_nombre"];
            
            //var_dump($rol);

        }catch (PDOException $e){
            echo" Error: " . $e->getMessage();
        
        }
        ?>
        <div>
            <h2><?=$rol?></h2>
            <h3><?=$nonmbre?></h3>
        </div>



        <div>
        <i class="fa-solid fa-right-from-bracket"></i>
        <button><a href="/handledb/logout.php">Logout</a></button>
        </div>
        
    </section>
    <main class=w-[100%]>
    <header class=" bg-white flex   justify-between w-[100%] mb-4 items-center">
            <h1 class="text-2xl">Edita Tu informacion</h1>
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded m-5"><a
                    href="/views/alumno/dashboard.php">volver</a></button>
        </header>
        <section class="w-[100%]">
            <?php
            $maestro_id = $_SESSION["user_data"]["usuario_id"];

            require_once($_SERVER["DOCUMENT_ROOT"] ."/config/database.php");
            try{
                
                $stmnt=$pdo->query("SELECT * FROM usuarios WHERE  usuario_id = '$maestro_id' ");
                    if($stmnt->rowCount() === 1 ){
                        $result=$stmnt->fetch(PDO::FETCH_ASSOC);
                        
                        
    
                    }
    
                }catch (PDOException $e){
                    echo" Error: " . $e->getMessage();
                
                }
               
                ?>
            
            <form class="flex flex-col  bg-white p-4 border rounded shadow-lg" 
            action="/handledb/estudiantes/Editar_perfil.php" method="POST">
                <input type="number" hidden name="user_id" value="<?=$maestro_id?>">
                <label class="block text-gray-700 font-bold mb-2">Correo Electronico</label>
                <input class="border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500" type="email" name="correo" value="<?=$result["correo"]?>">
                <label class="block text-gray-700 font-bold mt-2 mb-2">contraseña ingresa para cambiar la contraseña</label>
                <input class="border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500" type="password" required name="contrasena">
                <label class="block text-gray-700 font-bold mb-2 mt-2">Nombres</label>
                <input class="border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500" type="text" name="nombre" value='<?=$result["usuario_nombre"]?>'>
                <label class="block text-gray-700 font-bold mb-2 mt-2">Direcccion</label>
                <input class="border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500" type="text" name="direccion" value="<?=$result["direccion"]?>">
                <label class="block text-gray-700 font-bold mb-2 mt-2">Fecha de Nacimiento</label>
                <input class="border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500"type="text" name="fecha" value="<?=$result['fecha_nacimientgo']?>">

                <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded m-5">Enviar</button>
                
            </form>


            
            
            
            
            
            
        </section>
    </main>

