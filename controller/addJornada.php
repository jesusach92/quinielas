<?php

include("../model/backend/database/config.php");

// Obtener la lista de equipos sin duplicados desde la tabla "equipos"
$consultaEquipos = "SELECT DISTINCT nombre FROM equipos";
$resultadoEquipos = mysqli_query($conexion, $consultaEquipos);

// Obtener la lista de números de jornadas sin duplicados desde la tabla "jornadas"
$consultaJornadas = "SELECT DISTINCT numero_jornada FROM jornadas";
$resultadoJornadas = mysqli_query($conexion, $consultaJornadas);

// Valor predeterminado para el campo "Número de Jornada"
$valorPredeterminadoJornada = ""; // Puedes establecer el valor que desees como predeterminado

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_quiniela"])) {
    $equipoLocal = mysqli_real_escape_string($conexion, $_POST["equipo_local"]);
    $equipoVisitante = mysqli_real_escape_string($conexion, $_POST["equipo_visitante"]);
    $fechaQuiniela = mysqli_real_escape_string($conexion, $_POST["fecha_quiniela"]);
    $numeroJornada = mysqli_real_escape_string($conexion, $_POST["numero_jornada"]);

    // Verificar si los equipos seleccionados son diferentes
    if ($equipoLocal != $equipoVisitante) {
        $stmt = mysqli_prepare($conexion, "INSERT INTO partidos (equipA, equipB, match_date, journeys) VALUES (?, ?, ?, ?)");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $equipoLocal, $equipoVisitante, $fechaQuiniela, $numeroJornada);

            if (mysqli_stmt_execute($stmt)) {
                $message = "Quiniela guardada exitosamente.";
            } else {
                $message = "Error al guardar la quiniela: " . mysqli_error($conexion);
            }

            mysqli_stmt_close($stmt);
        } else {
            $message = "Error al preparar la declaración.";
        }
    } else {
        $message = "Error: El equipo local y el equipo visitante deben ser diferentes.";
    }
}
?>