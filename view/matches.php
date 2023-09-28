<?php
session_start();
$session = $_SESSION["id"];
if(!isset($session)){
    header("Location: ./login.php");
    exit();
}else echo'';  
require("../model/backend/database/config.php");
require("../model/jornadas.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../public/css/styles.css">
    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>Partidos</title>
</head>
<body class="flex flex-col h-screen">
<?php require("./common/header.php") ?>
<main class="grow flex flex-row">
<?php  require("./common/sidebar.php")?> 
<section class="w-full flex justify-center pt-3">
    <form class="h-full p-3 px-8 w-3/4" method="post" action="">
        <div class="bg-[#DCF5E6] h-4/5 rounded-lg">
            <div class="rounded p-3 bg-[#1F8635] w-full flex flex-row gap-2 items-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" height="1.25em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M400 0H176c-26.5 0-48.1 21.8-47.1 48.2c.2 5.3 .4 10.6 .7 15.8H24C10.7 64 0 74.7 0 88c0 92.6 33.5 157 78.5 200.7c44.3 43.1 98.3 64.8 138.1 75.8c23.4 6.5 39.4 26 39.4 45.6c0 20.9-17 37.9-37.9 37.9H192c-17.7 0-32 14.3-32 32s14.3 32 32 32H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H357.9C337 448 320 431 320 410.1c0-19.6 15.9-39.2 39.4-45.6c39.9-11 93.9-32.7 138.2-75.8C542.5 245 576 180.6 576 88c0-13.3-10.7-24-24-24H446.4c.3-5.2 .5-10.4 .7-15.8C448.1 21.8 426.5 0 400 0zM48.9 112h84.4c9.1 90.1 29.2 150.3 51.9 190.6c-24.9-11-50.8-26.5-73.2-48.3c-32-31.1-58-76-63-142.3zM464.1 254.3c-22.4 21.8-48.3 37.3-73.2 48.3c22.7-40.3 42.8-100.5 51.9-190.6h84.4c-5.1 66.3-31.1 111.2-63 142.3z"/></svg>  
                Mostrar Partidos
            </div>
            <div class="flex flex-col gap-2 p-5">
                <div name="contenedorInput" class="mb-3">
                    <label class="block text-gray-700 text-md font-bold mb-2" for="numero_jornada">Selecciona una Jornada:</label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="numero_jornada" id="numero_jornada">
                        <?php if (mysqli_num_rows($resultadoJornadas) === 0) : ?>
                            <option value=0 selected disabled>No hay jornadas registradas</option>
                            <?php else : ?>
                            <option value=0 selected >Selecciona una jornada</option>
                        <?php
                            while ($fila = mysqli_fetch_assoc($resultadoJornadas)) 
                                {
                                    $numero_jornada = $fila["numero_jornada"];
                                    $id = $fila["id"];
                                    echo "<option value=$id>$numero_jornada</option>";
                                }
                        ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" 
                    class="focus:outline-none text-white bg-[#DCF5E6] hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-[green-700] dark:focus:ring-green-800">
                    Mostrar Partidos
                    </button>
                </div>
            </div>
            <div class="flex flex-col gap-2 p-5" >
            <div>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idJornada = $_POST["numero_jornada"];
    if($idJornada != 0){
    $sql = "SELECT * FROM partidosview WHERE jornada = $idJornada";}
    else {
        $sql = "SELECT * FROM partidosview";
    }
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        echo "<div class='overflow-x-auto'>";
        echo "<table class='min-w-full bg-white shadow-md rounded-lg overflow-hidden'>";
        echo "<thead class='bg-green-800 text-white'>";
        echo "<tr>";
        echo "<th class='py-2 px-4'>Fecha del Partido</th>";
        echo "<th class='py-2 px-4'>Local</th>";
        echo "<th class='py-2 px-4'>Visitante</th>";
        echo "<th class='py-2 px-4'>Jornada</th>";
        echo "<th class='py-2 px-4'>Canal de Transmicion</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr class='transition-transform transform'>";
            echo "<td class='py-2 px-4'>{$row['match_date']}</td>";
            echo "<td class='py-2 px-4'>{$row['nombreLocal']}<br><img src='{$row['banderaLocal']}' alt='Bandera Local' class='w-20 h-20'></td>";
            echo "<td class='py-2 px-4'>{$row['nombreVisitor']}<br><img src='{$row['banderaVisitor']}' alt='Bandera Visitante' class='w-20 h-20'></td>";
            echo "<td class='py-2 px-4'>{$row['numero_jornada']}</td>";
            echo "<td class='py-2 px-4'>{$row['channel']}</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "No se encontraron partidos para la jornada seleccionada.";
    }

    $conexion->close();
} else {
?>
<!-- Coloca aquí tu código HTML para el caso en que no sea una solicitud POST -->
<?php
}
?>

    </div>
            </div>
        </div>

        
    </form>
  
</section>

</main>
   
   
</body>
</html>
