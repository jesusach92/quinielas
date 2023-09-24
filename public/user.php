<?php
// Incluye el archivo de configuración de la base de datos (ajusta la ruta según tu configuración)
require_once "../model/backend/database/config.php";

function insertarQuiniela($conexion, $nombre, $partidoId, $resultado) {
    $sql = "INSERT INTO quinielas (names, partido_id, resultado) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "siss", $nombre, $partidoId, $resultado);

    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        return false;
    }
}

$nombre = "";
$resultadosSeleccionados = [];
$quinielasEnviadas = 0;

if (isset($_GET["jornada"])) {
    $jornadaSeleccionada = intval($_GET["jornada"]);
    $consulta = "SELECT * FROM partidos WHERE journeys = $jornadaSeleccionada";
    $resultados = mysqli_query($conexion, $consulta);

    if (!$resultados) {
        die("Error al obtener los resultados: " . mysqli_error($conexion));
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = mysqli_real_escape_string($conexion, $_POST["nombre"]);
        $consultaQuinielas = "SELECT COUNT(*) as total FROM quinielas WHERE names = '$nombre'";
        $resultadoQuinielas = mysqli_query($conexion, $consultaQuinielas);
        $filaQuinielas = mysqli_fetch_assoc($resultadoQuinielas);
        $quinielasEnviadas = intval($filaQuinielas["total"]);

        if ($quinielasEnviadas < 2) {
            $partidosCount = mysqli_num_rows($resultados);

            if (isset($_POST["resultado"]) && count($_POST["resultado"]) === $partidosCount) {
                foreach ($_POST["resultado"] as $partidoId => $resultado) {
                    $resultadosSeleccionados[] = array(
                        "partido_id" => $partidoId,
                        "resultado" => $resultado
                    );
                }

                foreach ($resultadosSeleccionados as $seleccion) {
                    $partidoId = $seleccion["partido_id"];
                    $resultado = $seleccion["resultado"];

                    if (insertarQuiniela($conexion, $nombre, $partidoId, $resultado)) {
                        echo "Apuesta guardada con éxito.";
                    } else {
                        echo "Error al guardar la apuesta: " . mysqli_error($conexion);
                    }
                }
            } else {
                echo "Por favor, selecciona un resultado para cada partido.";
            }
        } else {
            echo "Gracias, ya has enviado dos quinielas completas. Te contactaremos en breve.";
        }
    }

    if ($quinielasEnviadas < 2) {
        echo '<h1>Selección de Resultados para Jornada ' . $jornadaSeleccionada . '</h1>';
        echo '<form action="" method="POST">';
        echo '<label for="nombre">Nombre:</label>';
        echo '<input type="text" id="nombre" name="nombre" required><br>';
        echo '<table class="results-table">';
        echo '<tr><th>Equipo A</th><th>Resultado</th><th>Equipo B</th></tr>';

        while ($partido = mysqli_fetch_assoc($resultados)) {
            echo '<tr>';
            echo '<td class="team">' . htmlspecialchars($partido["equipA"]) . '</td>';
            echo '<td class="result">';
            echo '<label><input type="radio" name="resultado[' . $partido["id"] . ']" value="equipo_a"> L</label>';
            echo '<label><input type="radio" name="resultado[' . $partido["id"] . ']" value="empate"> E</label>';
            echo '<label><input type="radio" name="resultado[' . $partido["id"] . ']" value="equipo_b"> V</label>';
            echo '</td>';
            echo '<td class="team">' . htmlspecialchars($partido["equipB"]) . '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '<input type="hidden" name="jornada" value="' . $jornadaSeleccionada . '">';
        echo '<input type="submit" value="Enviar Selecciones">';
        echo '</form>';
    }
} else {
    echo 'Jornada no especificada.';
}

mysqli_close($conexion);
?>
