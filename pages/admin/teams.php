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
    $equipoNombre = mysqli_real_escape_string($conexion, $_POST["name"]);
    $equipoLiga = mysqli_real_escape_string($conexion, $_POST["liga"]);

    // Verificar si se cargó una imagen de bandera
    if (isset($_FILES["escudo"]) && $_FILES["escudo"]["error"] === UPLOAD_ERR_OK) {
        $equipoBandera = "../../img/bandera/" . basename($_FILES["escudo"]["name"]);

        // Mover la imagen a la carpeta de banderas
        move_uploaded_file($_FILES["escudo"]["tmp_name"], $equipoBandera);
    } else {
        // Si no se cargó una imagen, utilizar la bandera predeterminada
        $equipoBandera = "../../img/bandera/Bandera_not.jpeg";
    }

    // Guardar el equipo en la base de datos
    $sql = "INSERT INTO equipos (nombre, bandera, liga) VALUES ('$equipoNombre', '$equipoBandera', '$equipoLiga')";

    if (mysqli_query($conexion, $sql)) {
        $mensaje = "Equipo guardado exitosamente.";
        echo 'alert("Equipo Guardado Correctamente")';
        header("Location: ./teams.html");
    } else {
        $mensaje = "Error al guardar el equipo: " . mysqli_error($conexion);
    }
}
?>

<?php
// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>
