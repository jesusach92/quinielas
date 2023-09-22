<?php
session_start();
$session = $_SESSION["id"];
if(!isset($session)){
    header("Location: ../userLogin");
}else echo'';
include("../backend/database/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipo1 = $_POST["equipo1"];
    $equipo2 = $_POST["equipo2"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];
    $fecha_partido = $_POST["fecha_partido"];
    $jornadas = $_POST["jornada"];

    // Verifica si las fechas son válidas utilizando strtotime
    if (
        ($timestamp_inicio = strtotime($fecha_inicio)) === false ||
        ($timestamp_fin = strtotime($fecha_fin)) === false ||
        ($timestamp_partido = strtotime($fecha_partido)) === false
    ) {
        echo "Una de las fechas ingresadas no es válida.";
    } else {
        // Las fechas son válidas, convierte la fecha y hora al formato adecuado sin segundos para la base de datos
        $fecha_inicio_formato = date("Y-m-d H:i", $timestamp_inicio);
        $fecha_fin_formato = date("Y-m-d H:i", $timestamp_fin);
        $fecha_partido_formato = date("Y-m-d H:i", $timestamp_partido); // Formato para la fecha del partido

        // Verificar si ya existe un partido con las mismas características (mismo año, mes y día)
        $consultaExistente = "SELECT * FROM partidos WHERE equipA = '$equipo1' AND equipB = '$equipo2' AND DATE(match_date) = DATE('$fecha_partido_formato') AND journeys = $jornadas";
        $resultadoExistente = mysqli_query($conexion, $consultaExistente);

        if (mysqli_num_rows($resultadoExistente) > 0) {
            echo "Este partido ya existe en la base de datos para la misma fecha (año, mes y día), equipos y jornada.";
        } else {
            // Inserta los datos en la base de datos utilizando la variable de conexión $conexion
            $sql = "INSERT INTO partidos (equipA, equipB, fecha_inicio, fecha_fin, match_date, journeys) VALUES ('$equipo1', '$equipo2', '$fecha_inicio_formato', '$fecha_fin_formato', '$fecha_partido_formato', $jornadas)";

            if (mysqli_query($conexion, $sql)) {
                echo "Los datos se han guardado exitosamente en la base de datos.";
            } else {
                echo "Error al guardar los datos: " . mysqli_error($conexion);
            }
        }
    }
}

// Obtener y mostrar los partidos guardados
$consultaPartidos = "SELECT equipA, equipB, fecha_inicio, fecha_fin, match_date, journeys FROM partidos";
$resultadoPartidos = mysqli_query($conexion, $consultaPartidos);

if ($resultadoPartidos) {
   echo ' <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" href="../../img/Icon/icon.png" />
        <title>Quiniela</title>
    </head>
    <body>
    <body class="flex flex-col h-screen">';
    require("./common/header.php");
     echo '<main class="grow flex flex-row">';
     require('./common/sidebar.php');
     echo    '<section class="">';
      echo "<h2>Partidos Guardados:</h2>";
    echo "<ul>";
    while ($fila = mysqli_fetch_assoc($resultadoPartidos)) {
        echo "<li>" . $fila["equipA"] . " vs " . $fila["equipB"] . " - Inicio: " . $fila["fecha_inicio"] . " - Fin: " . $fila["fecha_fin"] . " - Fecha del Partido: " . $fila["match_date"] . " - Jornadas: " . $fila["journeys"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Error al obtener los partidos guardados: " . mysqli_error($conexion);
}
    echo' </section>
     </main>
     <footer></footer>
    </body>
    </html> ';
   

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>
