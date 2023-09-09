<?php
// Definir usuarios y contraseñas válidos (puedes reemplazarlos por una base de datos real)
$usuarios = array(
    'usuario1' => 'contraseña1',
    'usuario2' => 'contraseña2'
);

// Inicializar variables para mensajes de error y redirección
$mensaje = '';
$redireccionar = false;

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados por el formulario
    $usuario = $_POST['username'];
    $contrasena = $_POST['password'];

    // Verificar si el usuario y la contraseña son válidos
    if (isset($usuarios[$usuario]) && $usuarios[$usuario] === $contrasena) {
        //isset dice si la variable esta ocupada o null
        // Inicio de sesión exitoso, configurar mensaje y redirección
        $mensaje = 'Inicio de sesión exitoso.';
        $redireccionar = true;
    } else {
        // Inicio de sesión fallido, configurar mensaje de error
        $mensaje = 'Usuario o contraseña incorrectos.';
    }
}
//ahora la redireccion para la pagina de las quiniela

// Si se debe redirigir al usuario, hacerlo
if ($redireccionar) {
    header("Location: PP.php"); // Reemplaza "otra_pagina.php" con la URL de la página a la que deseas redirigir
    /*echo '<meta http-equiv="refresh" content="0;url=PP.php">'; otro metodo de redireccion */
    /* echo '<script>window.location.href = "PP.php";</script>'; otro metodo de redireccion  */
    exit;//detiene el codigo para que no se siga ejecutando despues de que se va a la pagina 
}
?>