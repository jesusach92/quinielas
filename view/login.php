<?php
session_start();
if(isset($_SESSION['id']))
{
    header("Location: ./index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="" />
    <!-- Agregamos Tailwind CSS y Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* Agregamos algunos estilos personalizados aquí */
        /* Personaliza tus estilos según tus preferencias */
    </style>
</head>
<body class="bg-gradient-to-r from-blue-300 via-green-300 to-yellow-300 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full">
        <div class="text-center mb-6">
            <img class="w-40 mx-auto" src="../public/img/logo/logo.png" alt="Quinielas Compas">
        </div>
        <form class="space-y-4" action="../model/backend/regist.php" method="post">
            <div>
                <label for="email" class="block text-gray-700">Correo Electrónico</label>
                <input id="email" type="email" class="w-full px-4 py-2 border rounded-md" name="email" required>
            </div>
            <div>
                <label for="password" class="block text-gray-700">Contraseña</label>
                <input id="password" type="password" class="w-full px-4 py-2 border rounded-md" name="password" required>
            </div>
            <button class="w-full bg-green-700 text-white font-semibold py-2 rounded-md hover:bg-green-600 transition duration-300">
                Iniciar Sesión
            </button>
        </form>
        <div class="mt-4 text-center">
            <!-- Agregamos un ícono de usuario -->
            <i class="fas fa-user-circle text-2xl text-gray-600"></i>
        </div>
    </div>
</body>
</html>
