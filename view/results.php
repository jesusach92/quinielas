<?php
session_start();
$session = $_SESSION["id"];
if(!isset($session)){
    header("Location: ./login.php");
    exit();
}else echo'';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>Crear una Nueva Jornada</title>
</head>

<body class="flex flex-col h-screen">
   <?php require("./common/header.php") ?>
    <main class="grow flex flex-row">
     <?php  require("./common/sidebar.php")?>
        <section class="w-full flex justify-center pt-3">
          
        </section>
    </main>
    <footer></footer>
</body>
</html>
