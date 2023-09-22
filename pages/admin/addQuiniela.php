<?php
session_start();
$session = $_SESSION["id"];
if(!isset($session)){
    header("Location: ../userLogin");
}else echo'';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>Agregar Quiniela</title>
</head>
<body class="flex flex-col h-screen">
    <!-- '; -->
  <?php require("./common/header.php");
   echo ' <main class="grow flex flex-row">';
 require('./common/sidebar.php');
    echo '<section class="">';
    ?>
    <div class="p-4 ">    


    </div>
    </section>

    </main>
    <footer></footer>
</body>
</html>