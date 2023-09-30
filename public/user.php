<?php
if(!isset($_SESSION))
session_start();
require("./procesar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apuesta</title>
    <!-- Agrega los estilos de Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/user.css">k
</head>
<body>
    <!-- Importa el encabezado desde el archivo externo -->
    <?php include_once '../view/common/header.php'; ?>

    <div class="container mx-auto mt-10">
        <form id="apuestaForm" method="post" action="./procesar.php">
            <!-- Campo para que el usuario agregue su nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <!-- Campo para que el usuario agregue su número telefónico -->
            <div class="mb-4">
                <label for="telefono" class="block text-gray-700 font-bold mb-2">Número Telefónico:</label>
                <input type="tel" id="telefono" name="telefono" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <table>
                <thead>
                    <tr>
                        <th class="py-2 px-4">Gana Local</th>
                        <th class="py-2 px-4">Equipo Local</th>
                        <th class="py-2 px-4">Empate</th>
                        <th class="py-2 px-4">Equipo Visitante</th>
                        <th class="py-2 px-4">Gana Visitante</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Ejemplo de consulta a la base de datos utilizando mysqli_fetch_assoc
                    while ($partido = mysqli_fetch_assoc($resultados)) {
                        $partidoId = $partido["id"];
                    ?>
                    <tr>
                        <td>
                            <div class="circle-green hover:bg-green-700 text-xl" onclick="toggleResult(this, <?= $partidoId ?>, 'local')">L</div>
                        </td>
                        <td>
                            <p class="text-lg"><?= $partido["nombreLocal"] ?></p>
                            <img src="<?= $partido['banderaLocal'] ?>" alt="Bandera Local" style="width: 20%; height: auto; margin: 0 auto; display: block;">
                        </td>
                        <td>
                            <div class="circle-green hover:bg-green-700 text-xl" onclick="toggleResult(this, <?= $partidoId ?>, 'empate')">E</div>
                        </td>
                        <td>
                            <p class="text-lg"><?= $partido["nombreVisitor"] ?></p>
                            <img src="<?= $partido['banderaVisitor'] ?>" alt="Bandera Visitante" style="width: 20%; height: auto; margin: 0 auto; display: block;">
                        </td>
                        <td>
                            <div class="circle-green hover:bg-green-700 text-xl" onclick="toggleResult(this, <?= $partidoId ?>, 'visitante')">V</div>
                        </td>
                    </tr>
                    <?php } // Fin del bucle while ?>
                </tbody>
            </table>
            <div id="totalPrice">Costo total: $ 0.00</div>
            <input type="submit" value="Enviar Apuesta" class="mt-4 bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full sm:w-auto">
        </form>
    </div>

    <script>
        // Objeto para almacenar las selecciones del usuario
        const userSelections = {};

        // Función para alternar el estado del resultado
        function toggleResult(element, partidoId, resultado) {
            if (element.classList.contains('circle-green')) {
                element.classList.remove('circle-green');
                element.classList.add('circle-red');
                // Almacena la selección del usuario en el objeto
                if (!userSelections[partidoId]) {
                    userSelections[partidoId] = [];
                }
                userSelections[partidoId].push(resultado);
            } else {
                element.classList.remove('circle-red');
                element.classList.add('circle-green');
                // Elimina la selección del usuario del objeto
                if (userSelections[partidoId]) {
                    const index = userSelections[partidoId].indexOf(resultado);
                    if (index !== -1) {
                        userSelections[partidoId].splice(index, 1);
                    }
                }
            }

            // Calcula el precio total
            calculateTotalPrice();
        }

        // Función para calcular el precio total
 function calculateTotalPrice() {
    const partidoIds = Object.keys(userSelections);
    let totalPrice = 10;
    partidoIds.forEach(partidoId => {
        const selections = userSelections[partidoId];
        if (selections.length === 3) 
            totalPrice = (totalPrice * 2) * 2.5;
        if(selections.length === 2)
         totalPrice = totalPrice *2 ;
    });
    document.getElementById('totalPrice').textContent = `Costo total: $${totalPrice}.00`;
}
        // Agrega una función para enviar el formulario con las selecciones del usuario
        document.getElementById('apuestaForm').addEventListener('submit', function (event) {
            // Agrega las selecciones del usuario como un campo oculto en el formulario
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selecciones';
            input.value = JSON.stringify(userSelections);
            this.appendChild(input);

            const total = document.createElement('input');
            total.type = 'hidden';
            total.name = 'totalPrice';
            total.value = JSON.stringify(totalPrice);
            this.appendChild(total);
        });
    </script>
</body>
</html>
