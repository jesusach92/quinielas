<?php
session_start();
$session = $_SESSION["id"];
if(!isset($session)){
    header("Location: ../userLogin");
}else echo'';
// Incluye la configuración de la base de datos
include("../backend/database/config.php");

// Verifica si se ha enviado el formulario de apuestas
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apuestas = [];

    // Recorre todas las variables POST para obtener las apuestas
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'apuesta_') === 0) {
            $matchDate = substr($key, strlen('apuesta_'));
            $apuestas[$matchDate] = $value;
        }
    }

    // Procesa las apuestas (debes implementar la lógica para guardar en la base de datos)
    // Aquí puedes agregar el código para guardar las apuestas en la base de datos
    // $nombre es el nombre del usuario
    // $apuestas es un array con las apuestas de los usuarios

    // Muestra un mensaje de éxito
    echo "<h2>Apuestas de $nombre guardadas exitosamente:</h2>";
    echo "<ul>";
    foreach ($apuestas as $matchDate => $apuesta) {
        echo "<li>Fecha del Partido: $matchDate - Apuesta: $apuesta</li>";
    }
    echo "</ul>";
}

// Obtiene la fecha y hora actual
$fechaActual = date("Y-m-d H:i:s");

// Consulta para encontrar la jornada más cercana en curso basada en la fecha actual
$consultaJornadaActual = "SELECT DISTINCT journeys FROM partidos WHERE fecha_inicio <= '$fechaActual' AND fecha_fin >= '$fechaActual'";
$resultadoJornadaActual = mysqli_query($conexion, $consultaJornadaActual);

// Muestra la jornada actual y los partidos de esa jornada
if ($resultadoJornadaActual && mysqli_num_rows($resultadoJornadaActual) > 0) {
    $filaJornadaActual = mysqli_fetch_assoc($resultadoJornadaActual);
    $jornadaActual = $filaJornadaActual["journeys"];

    // Consulta para obtener los partidos de la jornada actual
    $consultaPartidosJornadaActual = "SELECT equipA, equipB, match_date FROM partidos WHERE journeys = $jornadaActual";
    $resultadoPartidosJornadaActual = mysqli_query($conexion, $consultaPartidosJornadaActual);

    echo "<h2>Jornada Actual: $jornadaActual</h2>";
    echo "<form method='post' action=''>";

    while ($filaPartido = mysqli_fetch_assoc($resultadoPartidosJornadaActual)) {
        $equipA = $filaPartido["equipA"];
        $equipB = $filaPartido["equipB"];
        $matchDate = $filaPartido["match_date"];

        echo "<p>$equipA vs $equipB - Fecha del Partido: $matchDate</p>";
        echo "<label><input type='radio' name='apuesta_$matchDate' value='$equipA'>$equipA</label>";
        echo "<label><input type='radio' name='apuesta_$matchDate' value='$equipB'>$equipB</label>";
        echo "<label><input type='radio' name='apuesta_$matchDate' value='Empate'>Empate</label>";
        echo "<br>";
    }

    echo "<input type='text' name='nombre' placeholder='Nombre' required><br>";
    echo "<input type='submit' value='Guardar Apuestas'>";
    echo "</form>";
} else {
    echo "<h2>No hay jornadas en curso en este momento.</h2>";
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>
