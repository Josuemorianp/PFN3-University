<?php
    session_start();
    if(!isset($_SESSION["user_data"])){
        echo"debes iniciar sesion<br>";
        echo"<a href='/index.php'>Login</a>";
        die();

        
    }elseif ($_SESSION["user_data"]["role_id"] !== "3") {
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
    <title>Alunmno_dashboard</title>
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
            <h1 class="text-2xl">Lista de Materias</h1>
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded m-5"><a
                    href="/views/alumno/editar.php?id=<?=$id?>">Perfil</a></button>
        </header>
        
        <section class="w-[100%]">
        <table class="min-w-full border border-solid rounded-lg">
            <thead>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materia</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Darse de Baja</th>
            </thead>
            <tbody>
            <?php
            require_once($_SERVER["DOCUMENT_ROOT"] ."/config/database.php");
             $alumno_id=$_SESSION["user_data"]['usuario_id'];
             try{
            $stmt = $pdo->query("SELECT m.materia_id, m.materia_nombre
            FROM materias AS m
            JOIN almnos_materias AS am ON m.materia_id = am.materia_id
            WHERE am.alumno_id = $alumno_id");
             
            while($materia=$stmt->fetch(PDO::FETCH_ASSOC)){
                
                ?>  
                <tr>
                    <td class="px-4 py-2 text-center"><?=$materia["materia_id"] ?></td>
                    <td class="px-4 py-2 text-center"><?=$materia["materia_nombre"] ?></td>
                    <td class="px-4 py-2 text-center"><button><a class="text-red-300" href='/handledb/estudiantes/baja.php?id=<?=$materia["materia_id"]?>'><i class="fa-solid fa-user-slash"></i></a></button></td>
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
        <section class="flex justify-center items-center ">
            <form class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg" action="/handledb/estudiantes/add_classs.php" Method="POST">
                <input type="number" hidden name="alumno_id" value="<?=$_SESSION["user_data"]['usuario_id']?>"> 
                <select class="w-48 h-10 bg-gray-100 rounded-md" name="materia">
                    <?php 
        require_once($_SERVER["DOCUMENT_ROOT"] ."/config/database.php");
        $alumno_id=$_SESSION["user_data"]['usuario_id'];
        try{
                $sql = "SELECT m.materia_id, m.materia_nombre
                FROM materias AS m
                LEFT JOIN almnos_materias AS am
                ON m.materia_id = am.materia_id AND am.alumno_id = :alumno_id
                WHERE am.alumno_id IS NULL
                OR (am.alumno_id IS NOT NULL AND am.alumno_id <> :alumno_id)
                OR am.alumno_id IS NULL";
            
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':alumno_id', $alumno_id, PDO::PARAM_INT);
                $stmt->execute();
            
                
              while($materias = $stmt->FETCH(PDO::FETCH_ASSOC)){
                var_dump($materias);
              ?>
                    <Option value="<?=$materias["materia_id"]?>"><?=$materias["materia_nombre"]?></Option>

                    <?php
          }
                



        }catch (PDOException $e){
            echo" Error: " . $e->getMessage();
        
        };

        
       
         ?>

                </select>
                <button class= "bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 ml-4 rounded focus:outline-none focus:ring focus:ring-blue-300" type="submint">Enrolarse</button>
            </form>


        </section>





    </main>


</body>

</html>