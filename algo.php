<?php
session_start();
$session = $_SESSION["id"];
if(!isset($session)){
    header("Location: ./login.php");
    exit();
}else echo'';  
require("../model/backend/database/config.php")
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../public/css/styles.css">
    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>Partidos</title>
</head>
<body class="flex flex-col h-screen">
<?php require("./common/header.php") ?>
<main class="grow flex flex-row">
<?php  require("./common/sidebar.php")?> 
<section class="w-full flex justify-center pt-3">
     <form class="h-full p-3 px-8 w-3/4" method="post" action="">
        <label for="numero_jornada">Número de Jornada:</label>
        <select name="numero_jornada" id="numero_jornada">
            <option value="1">Jornada 1</option>
            <option value="2">Jornada 2</option>
        </select>
        <input type="submit" value="Mostrar Partidos">
    </form>
    <div>
    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numero_jornada = $_POST["numero_jornada"];
        $sql = "SELECT * FROM partidos WHERE journeys = $numero_jornada";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
     
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Fecha del Partido</th>
                        <th>Equipo A</th>
                        <th>Equipo B</th>
                        <th>Jornada</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['match_date']}</td>
                        <td>{$row['equipA']}</td>
                        <td>{$row['equipB']}</td>
                        <td>{$row['journeys']}</td>
                        <td>{$row['fecha_inicio']}</td>
                        <td>{$row['fecha_fin']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron partidos para la jornada seleccionada.";
        }

        $conexion->close();
    } else {
    ?>
    <?php
    }
    ?>
    </div>
</section>

</main>
   
   
</body>
</html>
