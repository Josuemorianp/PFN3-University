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
  <title>UNIVERSITY</title>
</head>
<body class="bg-[#fff5d2]">
  <main class="flex flex-col justify-center items-center">
    <div class="flex flex-col h-screen w-screen justify-center items-center">
      <div class="h-64">
        <img src="/src/images/logo.jpg" alt="logo" class="h-80">
      </div>
    <div class=" flex justify-center flex-col items-center bg-white w-72 h-48 shadow-xl rounded-md">
      <h1 class="text-xs text-[Open Sans] text-[#787577] font-medium my-4 ">Bienvenido Ingresa con tu cuenta</h1>
      <form action="/src/models/Login.php" method="post" class>
        <div class="flex flex-row justify-between items-center border-solid border-2 border-[#ececec] rounded-sm w-60 h-8 mb-3">
          <input class="pl-2 border-0 focus:border-0 outline-transparent" type="email" placeholder="Email" name="correo" autofocus require>
          <span class="material-symbols-outlined pr-1">mail</span>
        </div>
        <div class="flex flex-row justify-between items-center border-solid border-2 border-[#ececec] rounded-sm w-60 h-8 mb-3">
          <input class="pl-2 border-0 focus:border-0 outline-transparent" type="password" placeholder="Password" name="contrasena" require>
          <span class="material-symbols-outlined pr-1">lock</span>
        </div>
        <div class="flex flex-col justify-end items-end mb-4">
          <button class="bg-[#0379ff] text-center text-white px-2 py-1 rounded" type="submit">Ingresar</button>
        </div>
      </form>
    </div>
    </div>
  </main>
</body>
</html>