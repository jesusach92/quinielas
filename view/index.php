<?php
session_start();
$session = $_SESSION["id"];
if(!isset($session)){
    header("Location: ./login.php");
    exit();
}else header("Location: ./jornadas.php");
?>
