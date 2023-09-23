<?php
session_start();
$session = $_SESSION["id"];

if (!isset($session)) {
    header("Location: ../userLogin");
    exit(); // Terminar el script si no hay sesión iniciada
}

include("../backend/database/config.php");

// Variable para almacenar el mensaje de éxito o error
$mensaje = "";

// Guardar equipos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardar_equipos"])) {
    $equipoNombre = mysqli_real_escape_string($conexion, $_POST["equipo_nombre"]);
    $equipoLiga = mysqli_real_escape_string($conexion, $_POST["equipo_liga"]);

    // Verificar si se cargó una imagen de bandera
    if (isset($_FILES["equipo_bandera"]) && $_FILES["equipo_bandera"]["error"] === UPLOAD_ERR_OK) {
        $equipoBandera = "../../img/bandera/" . basename($_FILES["equipo_bandera"]["name"]);

        // Mover la imagen a la carpeta de banderas
        move_uploaded_file($_FILES["equipo_bandera"]["tmp_name"], $equipoBandera);
    } else {
        // Si no se cargó una imagen, utilizar la bandera predeterminada
        $equipoBandera = "../../img/bandera/Bandera_not.jpeg";
    }

    // Guardar el equipo en la base de datos
    $sql = "INSERT INTO equipos (nombre, bandera, liga) VALUES ('$equipoNombre', '$equipoBandera', '$equipoLiga')";

    if (mysqli_query($conexion, $sql)) {
        $mensaje = "Equipo guardado exitosamente.";
    } else {
        $mensaje = "Error al guardar el equipo: " . mysqli_error($conexion);
    }
}

// Obtener y mostrar los equipos guardados
$consultaEquipos = "SELECT nombre, bandera, liga FROM equipos";
$resultadoEquipos = mysqli_query($conexion, $consultaEquipos);

if (!$resultadoEquipos) {
    echo "Error al obtener los equipos guardados: " . mysqli_error($conexion);
    exit(); // Terminar el script si hay un error
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>Equipos</title>
</head>
<body>
    <?php require("./common/header.php"); ?>
    <main class="flex flex-row">
        <?php require('./common/sidebar.php'); ?>
        <section>
            <h2>Equipos Guardados:</h2>
            <ul>
                <?php
                while ($fila = mysqli_fetch_assoc($resultadoEquipos)) {
                    echo "<li>Nombre del Equipo: " . $fila["nombre"] . "</li>";
                    echo "<li>Liga: " . $fila["liga"] . "</li>";
                    echo "<li>Bandera: <img src='" . $fila["bandera"] . "' alt='Bandera'></li>";
                }
                ?>
            </ul>
        </section>
    </main>
    <section>
        <h2>Guardar Equipos:</h2>
        <?php
        // Mostrar el mensaje de éxito o error
        if (!empty($mensaje)) {
            echo "<p>$mensaje</p>";
        }
        ?>
        <form enctype="multipart/form-data" action="" method="POST">
            <label for="equipo_nombre">Nombre del Equipo:</label>
            <input type="text" name="equipo_nombre" id="equipo_nombre" required><br>

            <label for="equipo_bandera">Bandera:</label>
            <input type="file" name="equipo_bandera" id="equipo_bandera" accept="image/*"><br>

            <label for="equipo_liga">Liga:</label>
            <input type="text" name="equipo_liga" id="equipo_liga" required><br>

            <input type="submit" name="guardar_equipos" value="Guardar Equipo">
        </form>
    </section>
    <footer></footer>
</body>
</html>

<?php
// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>
