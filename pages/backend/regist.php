<?php
session_start();
include("./database/config.php"); // Incluye la configuración de la conexión a la base de datos

// Función para realizar el inicio de sesión
function loginUser($conexion, $email, $password) {
    $sql = 'SELECT id, email, passwordUser FROM users WHERE email = ?'; // Consulta SQL para obtener los datos del usuario por su correo electrónico
    $stmt = $conexion->prepare($sql); // Prepara la consulta SQL
    $stmt->bind_param('s', $email); // Vincula el correo electrónico proporcionado como un parámetro seguro
    $stmt->execute(); // Ejecuta la consulta SQL
    $result = $stmt->get_result(); // Obtiene el resultado de la consulta

    if ($result->num_rows > 0) { // Si se encontró un usuario con el correo electrónico proporcionado
        $row = $result->fetch_assoc(); // Obtiene los datos del usuario
        if (password_verify($password, $row['passwordUser'])) { // Verifica la contraseña proporcionada con el hash almacenado en la base de datos
            $_SESSION['id'] = $row['id']; // Almacena el ID del usuario en la sesión
            header("Location: ../admin/index.html"); // Redirige al usuario a la página de inicio de sesión exitoso
            exit(); // Finaliza el script
        } else {
            return "Credenciales inválidas."; // Si la contraseña no coincide, devuelve un mensaje de error
        }
    } else {
        return "Usuario no encontrado."; // Si no se encuentra un usuario con el correo electrónico proporcionado, devuelve un mensaje de error
    }
}

if (!empty($_POST['email']) && !empty($_POST['password'])) { // Si se proporcionó un correo electrónico y una contraseña en el formulario
    $loginMessage = loginUser($conexion, $_POST['email'], $_POST['password']); // Llama a la función para realizar el inicio de sesión
    if ($loginMessage !== null) {
        echo '<script>alert("Error: ' . $loginMessage . '");</script>'; // Muestra un mensaje de error si el inicio de sesión falla
    }
} else {
    echo '<script>alert("Error: Debes proporcionar un correo electrónico y una contraseña.");</script>'; // Muestra un mensaje de error si no se proporcionan datos en el formulario
}
?>
