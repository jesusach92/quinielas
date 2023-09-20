<?php
session_start();
$session = $_SESSION["id"];
if(!isset($session)){
    header("Location: ../userLogin");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>admin</title>
</head>
<body class="flex flex-col h-screen">
    <header class="basis-1 flex justify-between bg-[#25274C] w-full">
        <div class="w-28 pl-3 pt-2">
            <img src="../../img/logo/logo2.png" alt="Quinielas Compas" class="object-scale-down">
        </div>
        <nav>
            <ul>
                <li><a href= "../signup">cerrar sesion</a></li>
                <li>inicio</li>
                <li></li>
            </ul>
        </nav>
    </header>
    <main class="grow flex flex-row">
        <aside class="basis-1/8 bg-[#25274C] h-full text-white">
            <div>
                <ul class=" py-10 pl-8 pr-6 pt-10 flex flex-col gap-5">
                <li><button> Agregar Quiniela</button> </li>
                <li>Cargar Equipos</li>
                <li>Consultar Quinielas</li>
                <li>Cargar Resultados</li>
                <li>Borrar Quinielas</li>
                <li></li>
                <li></li></ul>
            </div>
        </aside>
        <section class="">Principal</section>
    </main>
    <footer></footer>
</body>
</html>