<?php
session_start();
$session = $_SESSION["id"];

if (!isset($session)) {
    header("Location: ./login.php");
    exit(); // Terminar el script si no hay sesión iniciada
}
require("../controller/addJornada.php")
?>

<!DOCTYPE html>
<html lang="en">

<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../public/img/Icon/icon.png" />
    <title>Agregar Quiniela</title>
    <link rel="stylesheet" href="../public/css/styles.css">
</head>

<body>
    <?php require("./common/header.php"); ?>
    <main>
        <?php require('./common/sidebar.php'); ?>
        <section>
            <h2>Agregar Quiniela</h2>
            <?php
            if (isset($message)) {
                echo "<p>$message</p>";
            }
            ?>
            <form action="" method="POST">
                <label for="equipo_local">Equipo Local:</label>
                <select name="equipo_local" id="equipo_local">
                    <?php
                    while ($fila = mysqli_fetch_assoc($resultadoEquipos)) {
                        $equipo = $fila["nombre"];
                        echo "<option value='$equipo'>$equipo</option>";
                    }
                    ?>
                </select><br>

                <label for="equipo_visitante">Equipo Visitante:</label>
                <select name="equipo_visitante" id="equipo_visitante">
                    <?php
                    mysqli_data_seek($resultadoEquipos, 0);

                    while ($fila = mysqli_fetch_assoc($resultadoEquipos)) {
                        $equipo = $fila["nombre"];
                        echo "<option value='$equipo'>$equipo</option>";
                    }
                    ?>
                </select><br>

                <label for="fecha_quiniela">Fecha de la Quiniela:</label>
                <input type="date" name="fecha_quiniela" id="fecha_quiniela" required><br>

                <label for="numero_jornada">Número de Jornada:</label>
                <select name="numero_jornada" id="numero_jornada">
                    <option value="" <?php echo ($valorPredeterminadoJornada === "") ? "selected" : ""; ?>>Selecciona una jornada</option>
                    <?php
                    while ($fila = mysqli_fetch_assoc($resultadoJornadas)) {
                        $jornada = $fila["numero_jornada"];
                        echo "<option value='$jornada'>$jornada</option>";
                    }
                    ?>
                </select><br>

                <input type="submit" name="agregar_quiniela" value="Agregar Quiniela">
            </form>
        </section>
    </main>
    <footer></footer>
</body>

</html>
