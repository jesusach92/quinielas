<?php
// Incluir archivo de configuración de la base de datos
include_once 'config.php'; 

// Inicializar variables para mensajes de error y redirección
$mensaje = '';
$redireccionar = false;

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados por el formulario
    $usuario = $_POST['username'];
    $contrasena = $_POST['password'];

    // Conectar a la base de datos
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Verificar si la conexión es exitosa
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Preparar la consulta SQL para buscar el usuario en la tabla
    $sql = "SELECT * FROM usuarios WHERE username = '$usuario'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Verificar si la contraseña coincide
            if (password_verify($contrasena, $row['password'])) {
                // Inicio de sesión exitoso, configurar mensaje y redirección
                $mensaje = 'Inicio de sesión exitoso.';
                $redireccionar = true;
            } else {
                // Inicio de sesión fallido, configurar mensaje de error
                $mensaje = 'Usuario o contraseña incorrectos.';
            }
        } else {
            // Usuario no encontrado en la base de datos
            $mensaje = 'Usuario o contraseña incorrectos.';
        }
    } else {
        // Error en la consulta SQL
        $mensaje = 'Error en la consulta SQL: ' . mysqli_error($conn);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}

// Si se debe redirigir al usuario, hacerlo
if ($redireccionar) {
    header("Location: index.html"); // Reemplaza "index.html" con la URL de la página a la que deseas redirigir
    exit; // Detiene el código para que no se siga ejecutando después de la redirección
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body>
    <h1>Iniciar sesión</h1>

    <?php
    // Mostrar mensajes de error o éxito si existen
    if (!empty($mensaje)) {
        echo '<p>' . $mensaje . '</p>';
    }
    ?>

    <form method="post" action="">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
