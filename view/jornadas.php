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
            <form class="h-full p-3 px-8 w-3/4" action="../controller/jornadas.php" name="teams" method="post">
                <div class="bg-[#DCF5E6] h-4/5 rounded-lg">
                    <div class="rounded p-3 bg-[#1F8635] w-full flex flex-row gap-2 items-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1.25em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M400 0H176c-26.5 0-48.1 21.8-47.1 48.2c.2 5.3 .4 10.6 .7 15.8H24C10.7 64 0 74.7 0 88c0 92.6 33.5 157 78.5 200.7c44.3 43.1 98.3 64.8 138.1 75.8c23.4 6.5 39.4 26 39.4 45.6c0 20.9-17 37.9-37.9 37.9H192c-17.7 0-32 14.3-32 32s14.3 32 32 32H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H357.9C337 448 320 431 320 410.1c0-19.6 15.9-39.2 39.4-45.6c39.9-11 93.9-32.7 138.2-75.8C542.5 245 576 180.6 576 88c0-13.3-10.7-24-24-24H446.4c.3-5.2 .5-10.4 .7-15.8C448.1 21.8 426.5 0 400 0zM48.9 112h84.4c9.1 90.1 29.2 150.3 51.9 190.6c-24.9-11-50.8-26.5-73.2-48.3c-32-31.1-58-76-63-142.3zM464.1 254.3c-22.4 21.8-48.3 37.3-73.2 48.3c22.7-40.3 42.8-100.5 51.9-190.6h84.4c-5.1 66.3-31.1 111.2-63 142.3z"/></svg>    Crear una Nueva Jornada
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
                                class="focus:outline-none text-white bg-[#DCF5E6] hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-[green-700] dark:focus:ring-green-800">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>

    </main>
    <?php require("./common/footer.php")?>
</body>
</html>
