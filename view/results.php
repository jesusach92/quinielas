<?php
// Incluye el archivo de configuración de la base de datos
include "../model/backend/database/config.php";

// Variable para almacenar la jornada seleccionada
$jornadaSeleccionada = null;

// Verifica si se ha enviado el formulario de selección de jornada
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["seleccionar_jornada"])) {
    $jornadaSeleccionada = $_POST["jornada"];
}

// Consulta para obtener las jornadas disponibles
$consultaJornadas = "SELECT DISTINCT journeys FROM partidos";
$resultadosJornadas = mysqli_query($conexion, $consultaJornadas);

if (!$resultadosJornadas) {
    die("Error al obtener las jornadas: " . mysqli_error($conexion));
}

// Consulta para obtener los partidos de la jornada seleccionada (si se ha seleccionado una jornada)
$resultadosPartidos = array(); // Inicializa un array vacío para almacenar los partidos

if ($jornadaSeleccionada !== null) {
    $consultaPartidos = "SELECT p.id, e1.nombre AS teamLocal, e2.nombre AS teamVisitor FROM partidos p
                        INNER JOIN equipos e1 ON p.teamLocal = e1.id
                        INNER JOIN equipos e2 ON p.teamVisitor = e2.id
                        WHERE p.journeys = $jornadaSeleccionada";
    $resultadosPartidos = mysqli_query($conexion, $consultaPartidos);

    if (!$resultadosPartidos) {
        die("Error al obtener los partidos: " . mysqli_error($conexion));
    }
}

// Verifica si se ha enviado el formulario para guardar resultados
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["guardar_resultados"])) {
    // Procesar y guardar los resultados en la tabla "results"
    foreach ($_POST["resultado"] as $partidoId => $resultado) {
        $partidoId = intval($partidoId);
        $resultado = mysqli_real_escape_string($conexion, $resultado);

        // Verificar si ya existe un registro en la tabla "results" para este partido
        $consultaExistencia = "SELECT COUNT(*) FROM results WHERE fkmatch = ?";
        $stmtExistencia = mysqli_prepare($conexion, $consultaExistencia);

        if (!$stmtExistencia) {
            die("Error al preparar la consulta de existencia: " . mysqli_error($conexion));
        }

        mysqli_stmt_bind_param($stmtExistencia, "i", $partidoId);
        mysqli_stmt_execute($stmtExistencia);
        mysqli_stmt_bind_result($stmtExistencia, $existencia);
        mysqli_stmt_fetch($stmtExistencia);
        mysqli_stmt_close($stmtExistencia);

        if ($existencia > 0) {
            // Si ya existe un registro, actualiza el resultado en lugar de insertar uno nuevo
            $actualizarResultado = "UPDATE results SET result = ? WHERE fkmatch = ?";
            $stmtActualizar = mysqli_prepare($conexion, $actualizarResultado);

            if (!$stmtActualizar) {
                die("Error al preparar la consulta de actualización: " . mysqli_error($conexion));
            }

            mysqli_stmt_bind_param($stmtActualizar, "si", $resultado, $partidoId);

            if (!mysqli_stmt_execute($stmtActualizar)) {
                die("Error al ejecutar la consulta de actualización: " . mysqli_error($conexion));
            }

            mysqli_stmt_close($stmtActualizar);
        } else {
            // Si no existe un registro, inserta uno nuevo
            $insertarResultado = "INSERT INTO results (fkmatch, result) VALUES (?, ?)";
            $stmt = mysqli_prepare($conexion, $insertarResultado);

            if (!$stmt) {
                die("Error al preparar la consulta de inserción: " . mysqli_error($conexion));
            }

            mysqli_stmt_bind_param($stmt, "is", $partidoId, $resultado);

            if (!mysqli_stmt_execute($stmt)) {
                die("Error al ejecutar la consulta de inserción: " . mysqli_error($conexion));
            }

            mysqli_stmt_close($stmt);
        }
    }

    // Después de guardar los resultados, puedes mostrar un mensaje de éxito
    echo "Resultados guardados con éxito.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>Cargar Resultados</title>
    <!-- Agregar los estilos de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <header class="bg-green-700 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <img src="../public/img/logo/logo2.png" alt="Quinielas Compas" class="w-20">
            </div>
            <nav>
                <ul class="space-x-4">
                    <li><a href="../signup" class="text-white">Cerrar Sesión</a></li>
                    <li>Inicio</li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="grow flex flex-row">
        <?php require('./common/sidebar.php'); ?>
        <h2 class="text-3xl font-semibold mb-5">Cargar Resultados de la Jornada:</h2>
        <!-- Paso 1: Formulario para seleccionar la jornada -->
        <form method="POST" action="" class="space-y-3">
            <div>
                <label for="jornada" class="block text-gray-700 text-md font-bold mb-2">Seleccionar Jornada:</label>
                <select name="jornada"
                    class="w-full bg-gray-200 text-gray-800 rounded-lg py-2 px-4 focus:outline-none focus:ring focus:ring-green-600">
                    <option value="" selected disabled>Seleccionar una jornada</option>
                    <?php
                    // Iterar sobre las jornadas disponibles y crear opciones en el select
                    while ($row = mysqli_fetch_assoc($resultadosJornadas)) {
                        $jornada = $row['journeys'];
                        $selected = ($jornadaSeleccionada === $jornada) ? "selected" : "";
                        echo "<option value='{$jornada}' $selected>Jornada {$jornada}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" name="seleccionar_jornada"
                    class="text-white bg-green-600 py-2 px-6 rounded-lg font-semibold hover:bg-green-700 transition duration-300 ease-in-out">Seleccionar
                    Jornada</button>
            </div>
        </form>
        <!-- Paso 2: Mostrar los partidos de la jornada seleccionada -->
        <?php if (!empty($resultadosPartidos)) : ?>
            <form method="POST" action="" class="space-y-3">
                <?php
                while ($partido = mysqli_fetch_assoc($resultadosPartidos)) {
                    $partidoId = $partido['id'];
                    $equipA = $partido['teamLocal'];
                    $equipB = $partido['teamVisitor'];
                    echo "<div>";
                    echo "<label for='resultado_partido{$partidoId}' class='block text-gray-700 text-md font-bold mb-2'>{$equipA} vs {$equipB}:</label>";
                    echo "<select name='resultado[{$partidoId}]' required class='w-full bg-gray-200 text-gray-800 rounded-lg py-2 px-4 focus:outline-none focus:ring focus:ring-green-600'>";
                    echo "<option value='Gano {$equipA}'>Gano {$equipA}</option>";
                    echo "<option value='Empate'>Empate</option>";
                    echo "<option value='Gano {$equipB}'>Gano {$equipB}</option>";
                    echo "</select>";
                    echo "</div>";
                }
                ?>
                <div class="flex justify-end">
                    <button type="submit" name="guardar_resultados"
                        class="text-white bg-green-600 py-2 px-6 rounded-lg font-semibold hover:bg-green-700 transition duration-300 ease-in-out">Guardar
                        Resultados</button>
                </div>
            </form>
        <?php elseif ($jornadaSeleccionada !== null) : ?>
            <p>No se encontraron partidos para la jornada seleccionada.</p>
        <?php endif; ?>
    </main>
    <?php require("./common/footer.php")?>
</body>
</html>
