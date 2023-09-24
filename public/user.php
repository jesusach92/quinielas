<?php
// Incluye el archivo de configuración de la base de datos
include "../model/backend/database/config.php";

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
    
    // Verifica que $resultados sea un objeto mysqli_result antes de usar mysqli_fetch_assoc
    if ($resultados instanceof mysqli_result) {
        // Procesar el formulario si se ha enviado
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Verifica que se haya ingresado un nombre de usuario (obligatorio)
            $names = $_POST["names"];
            if (empty($names)) {
                echo "Por favor, ingresa tu nombre.";
            } else {
                // Preparar una consulta SQL para la inserción
                $sql = "INSERT INTO quinielas (names, partido_id, resultado) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conexion, $sql);

                if (!$stmt) {
                    die("Error al preparar la consulta: " . mysqli_error($conexion));
                }

                // Vincular parámetros a la consulta preparada
                mysqli_stmt_bind_param($stmt, "sis", $names, $partidoId, $resultado);

                // Insertar los datos en la base de datos
                foreach ($_POST["resultado"] as $partidoId => $resultado) {
                    $partidoId = intval($partidoId);
                    $resultado = mysqli_real_escape_string($conexion, $resultado);

                    if (mysqli_stmt_execute($stmt)) {
                        echo "Selecciones guardadas con éxito.";
                    } else {
                        echo "Error al guardar las selecciones: " . mysqli_error($conexion);
                    }
                }

                // Cerrar la consulta preparada
                mysqli_stmt_close($stmt);

                // Mostrar los datos enviados por el usuario en una tabla
                echo '<h2>Datos enviados por ' . htmlspecialchars($names) . ':</h2>';
                echo '<table>';
                echo '<tr><th>Partido</th><th>Resultado</th></tr>';
                foreach ($_POST["resultado"] as $partidoId => $resultado) {
                    // Consulta para obtener el nombre de los equipos
                    $consultaEquipos = "SELECT equipA, equipB FROM partidos WHERE id = $partidoId";
                    $resultEquipos = mysqli_query($conexion, $consultaEquipos);
                    $equipos = mysqli_fetch_assoc($resultEquipos);
                    $equipA = htmlspecialchars($equipos["equipA"]);
                    $equipB = htmlspecialchars($equipos["equipB"]);
                    echo "<tr><td>$equipA vs $equipB</td><td>$resultado</td></tr>";
                }
                echo '</table>';
            }
        }

        // Mostrar un formulario para que el usuario seleccione sus predicciones
        echo '<h1>Selección de Predicciones para Jornada ' . $jornadaSeleccionada . '</h1>';
        echo '<form action="" method="POST">';

        // Campo de entrada para el nombre del usuario (obligatorio)
        echo '<label for="names">Nombre:</label>';
        echo '<input type="text" id="names" name="names" required><br>';

        // Mostrar los partidos y permitir que el usuario haga sus selecciones
        while ($partido = mysqli_fetch_assoc($resultados)) {
            echo '<h3>' . $partido["equipA"] . ' vs ' . $partido["equipB"] . '</h3>';
            echo '<label><input type="radio" name="resultado[' . $partido["id"] . ']" value="local"> Gana ' . $partido["equipA"] . '</label>';
            echo '<label><input type="radio" name="resultado[' . $partido["id"] . ']" value="empate"> Empate</label>';
            echo '<label><input type="radio" name="resultado[' . $partido["id"] . ']" value="visitante"> Gana ' . $partido["equipB"] . '</label>';
        }

        echo '<input type="submit" value="Guardar Predicciones">';
        echo '</form>';
    } else {
        // Si no se proporciona la variable "jornada" en la URL, muestra un mensaje de error o redirige a otra página.
        echo 'Jornada no especificada.';
    }
} else {
    // Si no se proporciona la variable "jornada" en la URL, muestra un mensaje de error o redirige a otra página.
    echo 'Jornada no especificada.';
}

// Cierra la conexión a la base de datos cuando ya no se necesita
mysqli_close($conexion);
?>
