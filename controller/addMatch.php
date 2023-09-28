<?php
if(!isset($_SESSION))
session_start();
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
    
    $numeroJornada = mysqli_real_escape_string($conexion, $_POST["numero_jornada"]);
    $equipoLocal = mysqli_real_escape_string($conexion, $_POST["equipo_local"]);
    $equipoVisitante = mysqli_real_escape_string($conexion, $_POST["equipo_visitante"]);
    $fechaPartido = mysqli_real_escape_string($conexion, $_POST["fecha_partido"]);
    
    $channel = mysqli_real_escape_string($conexion, $_POST["channel"]);

    // Verificar si los equipos seleccionados son diferentes
    if ($equipoLocal != $equipoVisitante) {
        $stmt = mysqli_prepare($conexion, "INSERT INTO partidos (teamLocal,teamVisitor, match_date, fkJornada, channel) VALUES (?, ?, ?, ?,?)");

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
            header("Location: ../view/failPage.php ");
                $_SESSION["nextPage"] = "./addMatch.php";
                $_SESSION["message"] = "Error al guardar los datos: " . mysqli_error($conexion);
            $message = "Error al preparar la declaración.";
        }
    } else {
        header("Location: ../view/failPage.php ");
                $_SESSION["nextPage"] = "./addMatch.php";
                $_SESSION["message"] = "Error al guardar los datos: " . mysqli_error($conexion);
        $message = "Error: El equipo local y el equipo visitante deben ser diferentes.";
    }
}
?>