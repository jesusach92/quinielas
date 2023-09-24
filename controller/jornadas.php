<?php
// Incluye el archivo de configuración de la base de datos
include("../backend/database/config.php");

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopila los datos del formulario
    $liga = $_POST["liga"];
    $jornada = $_POST["jornada"];
    $descripcion = $_POST["descripcion"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];

    // Realiza la inserción de datos en la base de datos
    $consulta = "INSERT INTO jornadas (liga, numero_jornada, descripcion, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $consulta);

    if ($stmt) {
        // Asigna los parámetros a la consulta preparada
        mysqli_stmt_bind_param($stmt, "sssss", $liga, $jornada, $descripcion, $fecha_inicio, $fecha_fin);

        // Ejecuta la consulta preparada
        if (mysqli_stmt_execute($stmt)) {
            echo "Los datos se han guardado exitosamente en la base de datos.";
        } else {
            echo "Error al guardar los datos: " . mysqli_error($conexion);
        }

        // Cierra la consulta preparada
        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
    }
}
?>