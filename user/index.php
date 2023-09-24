<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Resultados</title>
</head>
<body>
<?php
// Incluye el archivo de configuración de la base de datos
include("../pages/backend/database/config.php");
// Verifica si se ha proporcionado la variable "jornada" en la URL
if (isset($_GET["jornada"])) {
    $jornadaSeleccionada = $_GET["jornada"];

    // Convierte la jornada seleccionada a un número entero seguro
    $jornadaSeleccionada = intval($jornadaSeleccionada);

    // Realiza una consulta para obtener los partidos de la jornada seleccionada
    $consulta = "SELECT * FROM partidos WHERE journeys = $jornadaSeleccionada";

    $resultados = mysqli_query($conexion, $consulta);

    if (!$resultados) {
        die("Error al obtener los resultados: " . mysqli_error($conexion));
    }

    // Muestra un formulario para que el usuario seleccione los resultados
    echo '<h1>Selección de Resultados para Jornada ' . $jornadaSeleccionada . '</h1>';
    echo '<form action="" method="POST">';
    echo '<table>';
    echo '<tr><th>Equipo A</th><th>Resultado</th><th>Equipo B</th></tr>';

    while ($partido = mysqli_fetch_assoc($resultados)) {
        echo '<tr>';
        echo '<td>' . $partido["equipA"] . '</td>';
        echo '<td>';
        echo '<label>';
        echo '<input type="radio" name="resultado[' . $partido["id"] . ']" value="equipo_a"> L';
        echo '<input type="radio" name="resultado[' . $partido["id"] . ']" value="empate"> E';
        echo '<input type="radio" name="resultado[' . $partido["id"] . ']" value="equipo_b"> V';
        echo '</label>';
        echo '</td>';
        echo '<td>' . $partido["equipB"] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '<input type="hidden" name="jornada" value="' . $jornadaSeleccionada . '">';
    echo '<input type="submit" value="Enviar Selecciones">';
    echo '</form>';
} else {
    // Si no se proporciona la variable "jornada" en la URL, muestra un mensaje de error o redirige a otra página.
    echo 'Jornada no especificada.';
}
?>
</body>
</html>
