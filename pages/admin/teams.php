<?php
session_start();
$session = $_SESSION["id"];
if(!isset($session)){
    header("Location: ../userLogin");
}else 
echo ''
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>Guarda Equipo</title>
</head>
<body class="flex flex-col h-screen">
   <?php require("./common/header.php") ?>
    <main class="grow flex flex-row">
        <?php require('./common/sidebar.php');?>
        <section class=""></section>
    </main>
    <footer></footer>
</body>
</html>