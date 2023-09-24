<?php
// Incluye el archivo de configuración de la base de datos
include("../backend/database/config.php");

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopila los datos del formulario
    $liga = $_POST["liga"];
    $jornada = $_POST["jornada"];
    $descripcion = $_POST["descripcion"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];

    // Realiza la inserción de datos en la base de datos
    $consulta = "INSERT INTO jornadas (liga, numero_jornada, descripcion, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $consulta);

    if ($stmt) {
        // Asigna los parámetros a la consulta preparada
        mysqli_stmt_bind_param($stmt, "sssss", $liga, $jornada, $descripcion, $fecha_inicio, $fecha_fin);

        // Ejecuta la consulta preparada
        if (mysqli_stmt_execute($stmt)) {
            echo "Los datos se han guardado exitosamente en la base de datos.";
        } else {
            echo "Error al guardar los datos: " . mysqli_error($conexion);
        }

        // Cierra la consulta preparada
        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>Crear una Nueva Jornada</title>
</head>

<body class="flex flex-col h-screen">
    <header class="basis-1 flex justify-between bg-[#073E1C]  w-full pl-5">
        <div class="w-20 pl-3 py-3">
            <img src="../../img/logo/logo2.png" alt="Quinielas Compas" class="object-scale-down">
        </div>
        <nav>
            <ul>
                <li><a href="../signup">cerrar sesion</a></li>
                <li>inicio</li>
                <li></li>
            </ul>
        </nav>
    </header>
    <main class="grow flex flex-row">
        <aside class="basis-1/8 bg-[#025D25] h-full text-white">
            <div class="rounded-t-lg">
                <ul class=" py-10 pl-8 pr-6 pt-10 flex flex-col gap-5 group ">
                    <li class="hover:bg-slate-100"><a href='addQuiniela.php'> Agregar Quiniela</a> </li>
                    <li><a href='teams.html'>Cargar Equipos</a></li>
                    <li class="hover:bg-slate-100"><a href='matches.php'> Consultar Quinielas</a> </li>
                    <li>Cargar Resultados</li>
                    <li>Borrar Quinielas</li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </aside>
        <section class="w-full flex justify-center pt-3">
            <form class="h-full p-3 px-8 w-3/4" action="" enctype="multipart/form-data" name="teams"
                method="post">
                <div class="bg-[#DCF5E6] h-4/5 rounded-lg">
                    <div class="rounded p-3 bg-[#1F8635] w-full flex flex-row gap-2 items-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.25em"
                            viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <style>
                                svg {
                                    fill: #ffffff
                                }
                            </style>
                            <path
                                d="M417.3 360.1l-71.6-4.8c-5.2-.3-10.3 1.1-14.5 4.2s-7.2 7.4-8.4 12.5l-17.6 69.6C289.5 445.8 273 448 256 448s-33.5-2.2-49.2-6.4L189.2 372c-1.3-5-4.3-9.4-8.4-12.5s-9.3-4.5-14.5-4.2l-71.6 4.8c-17.6-27.2-28.5-59.2-30.4-93.6L125 228.3c4.4-2.8 7.6-7 9.2-11.9s1.4-10.2-.5-15l-26.7-66.6C128 109.2 155.3 89 186.7 76.9l55.2 46c4 3.3 9 5.1 14.1 5.1s10.2-1.8 14.1-5.1l55.2-46c31.3 12.1 58.7 32.3 79.6 57.9l-26.7 66.6c-1.9 4.8-2.1 10.1-.5 15s4.9 9.1 9.2 11.9l60.7 38.2c-1.9 34.4-12.8 66.4-30.4 93.6zM256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm14.1-325.7c-8.4-6.1-19.8-6.1-28.2 0L194 221c-8.4 6.1-11.9 16.9-8.7 26.8l18.3 56.3c3.2 9.9 12.4 16.6 22.8 16.6h59.2c10.4 0 19.6-6.7 22.8-16.6l18.3-56.3c3.2-9.9-.3-20.7-8.7-26.8l-47.9-34.8z" />
                        </svg>
                        Crear una Nueva Jornada
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
    <footer></footer>
</body>
</html>
