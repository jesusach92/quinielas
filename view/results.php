<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/Icon/icon.png" />
    <title>Crear Jornada</title>
    <!-- Agregar los estilos de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <header class="bg-green-700 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <img src="../public/img/logo/logo2.png" alt="Quinielas Compas" class="w-20">
            </div>
            <nav>
                <ul class="space-x-4">
                    <li><a href="../signup" class="text-white">Cerrar Sesión</a></li>
                    <li>Inicio</li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="grow flex flex-row">
    <?php require('./common/sidebar.php');?>
        <h2 class="text-3xl font-semibold mb-5">Crear Nueva Jornada:</h2>
        <form method="POST" action="" class="space-y-3">
            <div>
                <label for="liga" class="block text-gray-700 text-md font-bold mb-2">Liga:</label>
                <input type="text" name="liga" required
                    class="w-full bg-gray-200 text-gray-800 rounded-lg py-2 px-4 focus:outline-none focus:ring focus:ring-green-600">
            </div>
            <div>
                <label for="numero_jornada" class="block text-gray-700 text-md font-bold mb-2">Número de Jornada:</label>
                <input type="number" name="numero_jornada" required
                    class="w-full bg-gray-200 text-gray-800 rounded-lg py-2 px-4 focus:outline-none focus:ring focus:ring-green-600">
            </div>
            <div>
                <label for="descripcion" class="block text-gray-700 text-md font-bold mb-2">Descripción:</label>
                <textarea name="descripcion" required
                    class="w-full bg-gray-200 text-gray-800 rounded-lg py-2 px-4 focus:outline-none focus:ring focus:ring-green-600"></textarea>
            </div>
            <div>
                <label for="fecha_inicio" class="block text-gray-700 text-md font-bold mb-2">Fecha de Inicio:</label>
                <input type="datetime-local" name="fecha_inicio" required
                    class="w-full bg-gray-200 text-gray-800 rounded-lg py-2 px-4 focus:outline-none focus:ring focus:ring-green-600">
            </div>
            <div>
                <label for="fecha_fin" class="block text-gray-700 text-md font-bold mb-2">Fecha de Fin:</label>
                <input type="datetime-local" name="fecha_fin" required
                    class="w-full bg-gray-200 text-gray-800 rounded-lg py-2 px-4 focus:outline-none focus:ring focus:ring-green-600">
            </div>
            <div class="flex justify-end">
                <button type="submit" name="guardar_jornada"
                    class="text-white bg-green-600 py-2 px-6 rounded-lg font-semibold hover:bg-green-700 transition duration-300 ease-in-out">Guardar
                    Jornada</button>
            </div>
        </form>
    </main>
    <?php require("./common/footer.php")?>
</body>
</html>