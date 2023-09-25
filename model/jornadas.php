<?php
include("../model/backend/database/config.php");
$consultaJornadas = "SELECT * FROM jornadas";
$resultadoJornadas = mysqli_query($conexion, $consultaJornadas);

?>