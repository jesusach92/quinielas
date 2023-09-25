<?php
if (!isset($_SESSION)) {
    session_start();
}
include("../model/backend/database/config.php");

// Obtener la lista de equipos sin duplicados desde la tabla "equipos"
$consultaEquipos = "SELECT * FROM equipos";
$resultadoEquipos = mysqli_query($conexion, $consultaEquipos);

// Obtener la lista de números de jornadas sin duplicados desde la tabla "jornadas"
$consultaJornadas = "SELECT * FROM jornadas";
$resultadoJornadas = mysqli_query($conexion, $consultaJornadas);

// Valor predeterminado para el campo "Número de Jornada"
$valorPredeterminadoJornada = ""; // Puedes establecer el valor que desees como predeterminado

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_quiniela"])) {
    $equipoLocal = mysqli_real_escape_string($conexion, $_POST["equipo_local"]);
    $equipoVisitante = mysqli_real_escape_string($conexion, $_POST["equipo_visitante"]);
    $fechaPartido = mysqli_real_escape_string($conexion, $_POST["fecha_partido"]);
    $numeroJornada = mysqli_real_escape_string($conexion, $_POST["numero_jornada"]);
    $channel = mysqli_real_escape_string($conexion, $_POST["channel"]);

    // Verificar si los equipos seleccionados son diferentes
    if ($equipoLocal != $equipoVisitante) {
        // Verificar si el número de jornada existe en la tabla "jornadas"
        $consultaVerificarJornada = "SELECT id FROM jornadas WHERE id = ?";
        $stmtVerificarJornada = mysqli_prepare($conexion, $consultaVerificarJornada);
        mysqli_stmt_bind_param($stmtVerificarJornada, "i", $numeroJornada);
        mysqli_stmt_execute($stmtVerificarJornada);
        mysqli_stmt_store_result($stmtVerificarJornada);

        if (mysqli_stmt_num_rows($stmtVerificarJornada) > 0) {
            // El número de jornada existe en la tabla "jornadas", ahora puedes realizar la inserción en la tabla "partidos"
            $stmt = mysqli_prepare($conexion, "INSERT INTO partidos (teamLocal, teamVisitor, match_date, fkJornada, channel) VALUES (?, ?, ?, ?, ?)");

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssis", $equipoLocal, $equipoVisitante, $fechaPartido, $numeroJornada, $channel);
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: ../view/successPage.php");
                    $_SESSION["exito"] = 1;
                    $_SESSION["nextPage"] = "./addMatch.php";
                } else {
                    header("Location: ../view/failPage.php ");
                    $_SESSION["nextPage"] = "./addMatch.php";
                    $_SESSION["message"] = "Error al guardar los datos: " . mysqli_error($conexion);
                }
                mysqli_stmt_close($stmt);
            } else {
                $message = "Error al preparar la declaración.";
            }
        } else {
            // El número de jornada no existe en la tabla "jornadas", muestra un mensaje de error
            $message = "Error: El número de jornada no existe.";
        }
        mysqli_stmt_close($stmtVerificarJornada);
    } else {
        $message = "Error: El equipo local y el equipo visitante deben ser diferentes.";
    }
}
?>
