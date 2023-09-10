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
    /* Mostrar mensajes de error o éxito si existen
    if (!empty($mensaje)) {
        echo '<p>' . $mensaje . '</p>';
    }*/
    ?>

    <form method="post">
        <label for="nameUser">Usuario:</label>
        <input type="text" id="nameUser" name="nameUser" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="passwordUser">Contraseña:</label>
        <input type="password" id="passwordUser" name="passwordUser" required><br><br>

        <input type="submit" value="Iniciar sesión">
    </form>
    <?php
    include("regist.php")
    ?>
</body>
</html>
