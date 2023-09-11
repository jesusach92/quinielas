<?php
include("./database/config.php"); // Asegúrate de que config.php configure correctamente la conexión a la base de datos

if ($conexion) {
    // La conexión a la base de datos se estableció correctamente
    header("Location: ../admin/index.html");
    
    // Aquí puedes realizar otras acciones, como verificar si los datos del formulario están en la base de datos, etc.
} else {
    // Si la conexión a la base de datos falla, muestra un mensaje de error
    echo('<script>alert("Error: No se pudo establecer la conexión a la base de datos.");</script>');
}

// Luego, puedes incluir cualquier contenido adicional que desees mostrar en la página HTML
//include("contenido_adicional.php");
?>
