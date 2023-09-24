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
    <script src="https://cdn.tailwindcss.com"></script>
   
    <link rel="icon" href="" />
</head>
<body class="">
    <main  
    class="flex justify-between gap-5 p-[2%] items-center h-screen bg-cover bg-no-repeat bg-top bg-[url('../public/img/background/M/bg1.jpg')] lg:bg-[url('../public/img/background/XL/bg1.jpg')] lg: flex-col	md: flex-col  sm:flex-row">
        <section class="flex-[5]">
       
    </section>
    <section class="flex flex-col items-center  gap-5 h-full rounded  bg-slate-200 lg: flex-[3] md: flex-[3] sm: flex-[1]">
        <div class="p-5 sm: p-2 xl: p-5">
            <img class="object-scale-down h-56 w-96 sm: h-4 w-8" src="../public/img/logo/logo.png" alt="Quinielas Compas">
        </div>
        <form class="flex flex-col w-full p-10 lg:gap-5 xl:gap-5 md:gap-1 sm:gap-1 p-3" action="../model/backend/regist.php" method="post">
            <label for="email" class="text-[#058637] font-small text-lg">Correo Electrónico</label>
            <input id="email" type="email" class="rounded p-3" name="email" required>
        
            <label for="password" class="text-[#058637] font-small text-lg">Contraseña</label>
            <input id="password" type="password" class="rounded p-3" name="password" required>
        
            <input class="block w-full bg-[#058637] text-white rounded p-3" type="submit" value="Iniciar Sesión">
        </form>
    </section>
</main>
<?php require("./common/footer.php")?>
</body>
</html> 