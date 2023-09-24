<?php
session_start();
$session = $_SESSION["id"];
if(!isset($session)){
    header("Location: ./login.php");
}else 
echo ''
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../public/css/styles.css">
    <link rel="icon" href="../public/img/icon/icon.png" />
    <title>Guarda Equipo</title>
</head>

<body class="flex flex-col h-screen">
    <?php require("./common/header.php") ?>
    <main class="grow flex flex-row">
        <?php require('./common/sidebar.php');?>
        <section class="w-full flex justify-center pt-3">
            <form class="h-full p-3 px-8 w-3/4" action="../controller/teams.php" enctype="multipart/form-data" name="teams"
                method="post">
                <div class="bg-[#DCF5E6] h-4/5 rounded-lg">
                    <div class="rounded p-3 bg-[#1F8635] w-full flex flex-row gap-2 items-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1.25em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M72 88a56 56 0 1 1 112 0A56 56 0 1 1 72 88zM64 245.7C54 256.9 48 271.8 48 288s6 31.1 16 42.3V245.7zm144.4-49.3C178.7 222.7 160 261.2 160 304c0 34.3 12 65.8 32 90.5V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V389.2C26.2 371.2 0 332.7 0 288c0-61.9 50.1-112 112-112h32c24 0 46.2 7.5 64.4 20.3zM448 416V394.5c20-24.7 32-56.2 32-90.5c0-42.8-18.7-81.3-48.4-107.7C449.8 183.5 472 176 496 176h32c61.9 0 112 50.1 112 112c0 44.7-26.2 83.2-64 101.2V416c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32zm8-328a56 56 0 1 1 112 0A56 56 0 1 1 456 88zM576 245.7v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM320 32a64 64 0 1 1 0 128 64 64 0 1 1 0-128zM240 304c0 16.2 6 31 16 42.3V261.7c-10 11.3-16 26.1-16 42.3zm144-42.3v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM448 304c0 44.7-26.2 83.2-64 101.2V448c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V405.2c-37.8-18-64-56.5-64-101.2c0-61.9 50.1-112 112-112h32c61.9 0 112 50.1 112 112z"/></svg>
                        Agregar Equipo
                    </div>
                    <div class="flex flex-col gap-2 p-5">
                        <div name="contenedorInput" class="mb-3">
                            <label for="liga" class="block text-gray-700 text-md font-bold mb-2">Liga</label>
                            <select required name="liga"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option selected disabled>Elige la Liga</option>
                                <option value="local">Local</option>
                                <option value="Extranjera">Extranjera</option>
                            </select>
                        </div>
                        <div name="contenedorInput" class="mb-3">
                            <label for="name" class="block text-gray-700 text-md font-bold mb-2">Nombre del
                                Equipo</label>
                            <input type="text" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="name" type="text" placeholder="Nombre" name="name">
                        </div>
                        <div name="contenedorInput" class="mb-3">
                            <label class="block text-gray-700 text-md font-bold mb-2" for="escudo">Cargar
                                Escudo</label>
                            <input required
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                aria-describedby="ariaLabel" id="escudo" name="escudo" type="file">
                            <p class="mt-1 text-sm text-gray-500" id="ariaLabel">SVG, PNG, JPG
                                or GIF (MAX. 800x400px).</p>

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