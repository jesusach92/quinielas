<?php
session_start();
$session = $_SESSION["id"];

if (!isset($session)) {
    header("Location: ../userLogin");
    exit(); // Terminar el script si no hay sesión iniciada
}

include("../backend/database/config.php");

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>Agregar Quiniela</title>
    <style>
        /* Agrega aquí el CSS del segundo código */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #073E1C;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header a {
            text-decoration: none;
            color: white;
            margin-left: 10px;
        }

        main {
            display: flex;
        }

        aside {
            background-color: #025D25;
            color: white;
            flex-basis: 20%;
            padding: 20px;
        }

        aside ul {
            list-style: none;
            padding: 0;
        }

        aside ul li {
            margin-bottom: 10px;
        }

        section {
            flex-grow: 1;
            padding: 20px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            background-color: #DCF5E6;
            padding: 20px;
            border-radius: 10px;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        select,
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #DCF5E6;
            color: #073E1C;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #073E1C;
            color: white;
        }

        footer {
            height: 50px;
            background-color: #073E1C;
        }
    </style>
</head>

<body>
    <?php require("./common/header.php"); ?>
    <main>
        <?php require('./common/sidebar.php'); ?>
        <section>
            <h2>Agregar Quiniela</h2>
            <?php
            if (isset($message)) {
                echo "<p>$message</p>";
            }
            ?>
            <form action="" method="POST">
                <label for="equipo_local">Equipo Local:</label>
                <select name="equipo_local" id="equipo_local">
                    <?php
                    while ($fila = mysqli_fetch_assoc($resultadoEquipos)) {
                        $equipo = $fila["nombre"];
                        echo "<option value='$equipo'>$equipo</option>";
                    }
                    ?>
                </select><br>

                <label for="equipo_visitante">Equipo Visitante:</label>
                <select name="equipo_visitante" id="equipo_visitante">
                    <?php
                    mysqli_data_seek($resultadoEquipos, 0);

                    while ($fila = mysqli_fetch_assoc($resultadoEquipos)) {
                        $equipo = $fila["nombre"];
                        echo "<option value='$equipo'>$equipo</option>";
                    }
                    ?>
                </select><br>

                <label for="fecha_quiniela">Fecha de la Quiniela:</label>
                <input type="date" name="fecha_quiniela" id="fecha_quiniela" required><br>

                <label for="numero_jornada">Número de Jornada:</label>
                <select name="numero_jornada" id="numero_jornada">
                    <option value="" <?php echo ($valorPredeterminadoJornada === "") ? "selected" : ""; ?>>Selecciona una jornada</option>
                    <?php
                    while ($fila = mysqli_fetch_assoc($resultadoJornadas)) {
                        $jornada = $fila["numero_jornada"];
                        echo "<option value='$jornada'>$jornada</option>";
                    }
                    ?>
                </select><br>

                <input type="submit" name="agregar_quiniela" value="Agregar Quiniela">
            </form>
        </section>
    </main>
    <footer></footer>
</body>

</html>
