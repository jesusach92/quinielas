<?php
session_start();
include("./database/config.php");

// Función para realizar el inicio de sesión
function loginUser($conexion, $email, $password) {
    $sql = "SELECT id, email, passwordUser FROM users WHERE email = ?"; // Consulta SQL para obtener los datos
    $stmt = $conexion->prepare($sql); // Prepara la consulta SQL
    $stmt->bind_param('s', $email); // Vincula el correo electrónico proporcionado como un parámetro seguro
    $stmt->execute(); // Ejecuta la consulta SQL
    $result = $stmt->get_result(); // obtiene el resultado de la consulta
    if ($result->num_rows > 0) { // Si se encontró un usuario con el correo electrónico proporcionado
        $row = $result->fetch_assoc(); // Obtiene los datos del usuario
        if (password_verify($password, $row['passwordUser'])) { // Verifica la contraseña proporcionada
            $_SESSION['id'] = $row['id']; // Almacena el ID del usuario en la sesión
            header("Location: ../../view/index.php"); // Redirige al usuario a la página de inicio de sesión
             exit(); // Finaliza el script
        } else {
            return "Credenciales inválidas."; // Si la contraseña no coincide, devuelve un mensaje de error
        }
    } else {
        return "Usuario no encontrado."; // Si no se encuentra un usuario con el correo electrónico proporcionado
    }
}

if (!empty($_POST['email']) && !empty($_POST['password'])) { // Si se proporcionó un correo electrónico y una contraseña
    $loginMessage = loginUser($conexion, $_POST['email'], $_POST['password']); // Llama a la función para realizar el inicio de sesión
    if ($loginMessage !== null) {
        header("Location: ../../view/login.php");
        echo '<script>alert("Error: ' . $loginMessage . '");</script>'; // Muestra un mensaje de error si el inicio de sesión falla
    }
} else {
    echo '<script>alert("Error: Debes proporcionar un correo electrónico y una contraseña.");</script>'; // Muestra un mensaje de error si no se proporcionan correo electrónico y contraseña
}
?>
