<?php
session_start();
$session = $_SESSION["id"];

if (!isset($session)) {
    header("Location: ../userLogin");
    exit(); // Terminar el script si no hay sesión iniciada
}

include("../backend/database/config.php");

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
                echo "Quiniela guardada exitosamente.";
            } else {
                echo "Error al guardar la quiniela: " . mysqli_error($conexion);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error al preparar la declaración.";
        }
    } else {
        echo "Error: El equipo local y el equipo visitante deben ser diferentes.";
    }
}

// Obtener la lista de nombres de equipos desde la tabla "equipos"
$consultaEquipos = "SELECT nombre FROM equipos";
$resultadoEquipos = mysqli_query($conexion, $consultaEquipos);

// Obtener los nombres de los equipos
$equipos = array();
while ($fila = mysqli_fetch_assoc($resultadoEquipos)) {
    $equipos[] = $fila["nombre"];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>Agregar Quiniela</title>
</head>
<body class="flex flex-col h-screen">
    <?php require("./common/header.php"); ?>
    <main class="grow flex flex-row">
        <?php require('./common/sidebar.php'); ?>
        <section>
            <h2>Agregar Quiniela</h2>
            <form action="" method="POST">
                <label for="equipo_local">Equipo Local:</label>
                <select name="equipo_local" id="equipo_local">
                    <?php
                    foreach ($equipos as $equipo) {
                        echo "<option value='$equipo'>$equipo</option>";
                    }
                    ?>
                </select><br>

                <label for="equipo_visitante">Equipo Visitante:</label>
                <select name="equipo_visitante" id="equipo_visitante">
                    <?php
                    foreach ($equipos as $equipo) {
                        echo "<option value='$equipo'>$equipo</option>";
                    }
                    ?>
                </select><br>

                <label for="fecha_quiniela">Fecha de la Quiniela:</label>
                <input type="date" name="fecha_quiniela" id="fecha_quiniela" required><br>

                <label for="numero_jornada">Número de Jornada:</label>
                <input type="number" name="numero_jornada" id="numero_jornada" required><br>

                <input type="submit" name="agregar_quiniela" value="Agregar Quiniela">
            </form>
        </section>
    </main>
    <footer></footer>
</body>
</html>
