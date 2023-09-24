<?php
session_start();
$session = $_SESSION["id"];
if(!isset($session)){
    header("Location: ./login.php");
    exit();
}else echo'';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../public/css/styles.css">
    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>Crear una Nueva Jornada</title>
</head>

<body class="flex flex-col h-screen">
   <?php require("./common/header.php") ?>
    <main class="grow flex flex-row">
     <?php  require("./common/sidebar.php")?>
        <section class="w-full flex justify-center pt-3">
            <form class="h-full p-3 px-8 w-3/4" action="" enctype="multipart/form-data" name="teams"
                method="post">
                <div class="bg-[#DCF5E6] h-4/5 rounded-lg">
                    <div class="rounded p-3 bg-[#1F8635] w-full flex flex-row gap-2 items-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1.25em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M155.6 17.3C163 3 179.9-3.6 195 1.9L320 47.5l125-45.6c15.1-5.5 32 1.1 39.4 15.4l78.8 152.9c28.8 55.8 10.3 122.3-38.5 156.6L556.1 413l41-15c16.6-6 35 2.5 41 19.1s-2.5 35-19.1 41l-71.1 25.9L476.8 510c-16.6 6.1-35-2.5-41-19.1s2.5-35 19.1-41l41-15-31.3-86.2c-59.4 5.2-116.2-34-130-95.2L320 188.8l-14.6 64.7c-13.8 61.3-70.6 100.4-130 95.2l-31.3 86.2 41 15c16.6 6 25.2 24.4 19.1 41s-24.4 25.2-41 19.1L92.2 484.1 21.1 458.2c-16.6-6.1-25.2-24.4-19.1-41s24.4-25.2 41-19.1l41 15 31.3-86.2C66.5 292.5 48.1 226 76.9 170.2L155.6 17.3zm44 54.4l-27.2 52.8L261.6 157l13.1-57.9L199.6 71.7zm240.9 0L365.4 99.1 378.5 157l89.2-32.5L440.5 71.7z"/></svg>
                    Quinielas
                    </div>
                    <div class="flex flex-col gap-2 p-5">
                        <div name="contenedorInput" class="mb-3">
                            <label for="liga" class="block text-gray-700 text-md font-bold mb-2">Liga</label>
                            <select required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                name="liga">
                                <option selected disabled>Elige la Liga</option>
                                <option value="local">Local</option>
                                <option value="Extranjera">Extranjera</option>
                            </select>
                        </div>
                        <div name="contenedorInput" class="mb-3">
                            <label for="jornada" class="block text-gray-700 text-md font-bold mb-2">Número de Jornada</label>
                            <input type="number" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="jornada" type="number" placeholder="Número de Jornada" name="jornada">
                        </div>
                        <div name="contenedorInput" class="mb-3">
                            <label for="descripcion" class="block text-gray-700 text-md font-bold mb-2">Descripción</label>
                            <input type="text" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="descripcion" type="text" placeholder="Descripción" name="descripcion">
                        </div>
                        <div name="contenedorInput" class="mb-3">
                            <label for="fecha_inicio" class="block text-gray-700 text-md font-bold mb-2">Fecha de Inicio</label>
                            <input type="date" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="fecha_inicio" name="fecha_inicio">
                        </div>
                        <div name="contenedorInput" class="mb-3">
                            <label for="fecha_fin" class="block text-gray-700 text-md font-bold mb-2">Fecha de Fin</label>
                            <input type="date" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="fecha_fin" name="fecha_fin">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" name="guardar_equipos"
                                class="focus:outline-none text-white bg-[#DCF5E6] hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-[green-700] dark:focus:ring-green-800">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
    <?php require("./common/footer.php")?>
</body>
</html>
