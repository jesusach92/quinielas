<?php
session_start();

// Incluye el archivo de configuración de la base de datos
include "../model/backend/database/config.php";

// Verifica si se ha proporcionado la variable "jornada" en la URL
if (isset($_GET["jornada"])) {
    $jornadaSeleccionada = $_GET["jornada"];
    
    // Convierte la jornada seleccionada a un número entero seguro
    $jornadaSeleccionada = intval($jornadaSeleccionada);
    
    $consulta = "SELECT * FROM partidosview WHERE numero_jornada = $jornadaSeleccionada";
    $resultados = mysqli_query($conexion, $consulta);
    
    if (!$resultados) {
        die("Error al obtener los resultados: " . mysqli_error($conexion));
    }

    // Genera un ID de usuario único (puedes usar una función de hash para esto)
    $idUser = uniqid();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Verifica que se haya ingresado un nombre de usuario y un número de teléfono
        $names = $_POST["names"];
        $phoneNumber = $_POST["phoneNumber"];
        if (empty($names) || empty($phoneNumber)) {
            echo "Por favor, ingresa tu nombre y número de teléfono.";
        } else {
            // Preparar una consulta SQL para la inserción de datos de usuario
            $sqlInsertUser = "INSERT INTO usuarios (id, name, phoneNumber) VALUES (?, ?, ?)";
            $stmtInsertUser = mysqli_prepare($conexion, $sqlInsertUser);

            if (!$stmtInsertUser) {
                die("Error al preparar la consulta de inserción de usuario: " . mysqli_error($conexion));
            }

            // Vincular parámetros a la consulta preparada
            mysqli_stmt_bind_param($stmtInsertUser, "sss", $idUser, $names, $phoneNumber);

            // Insertar los datos del usuario en la base de datos
            if (mysqli_stmt_execute($stmtInsertUser)) {
                echo "Usuario registrado con éxito.";
            } else {
                echo "Error al registrar el usuario: " . mysqli_error($conexion);
            }

            // Cerrar la consulta preparada
            mysqli_stmt_close($stmtInsertUser);

            // Preparar una consulta SQL para la inserción de selecciones de usuario
            $sqlInsertSelections = "INSERT INTO quinielas (name, fkJornada, fkPartido, idUser, result) VALUES (?, ?, ?, ?, ?)";
            $stmtInsertSelections = mysqli_prepare($conexion, $sqlInsertSelections);

            if (!$stmtInsertSelections) {
                die("Error al preparar la consulta de inserción de selecciones: " . mysqli_error($conexion));
            }

            // Vincular parámetros a la consulta preparada
            mysqli_stmt_bind_param($stmtInsertSelections, "siiss", $names, $jornadaSeleccionada, $partidoId, $idUser, $resultado);

            // Insertar las selecciones del usuario en la base de datos
            foreach ($_POST["resultado"] as $partidoId => $resultado) {
                $partidoId = intval($partidoId);
                $resultado = mysqli_real_escape_string($conexion, $resultado);

                if (mysqli_stmt_execute($stmtInsertSelections)) {
                    echo "Selecciones guardadas con éxito.";
                } else {
                    echo "Error al guardar las selecciones: " . mysqli_error($conexion);
                }
            }

            // Cerrar la consulta preparada
            mysqli_stmt_close($stmtInsertSelections);
        }
    }}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apuesta</title>
    <!-- Agrega los estilos de Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">

    <style>
        /* Estilo del círculo verde */
        .circle-green {
            width: 60px;
            height: 60px;
            background-color: green;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 60px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        /* Estilo del círculo rojo cuando se activa */
        .circle-red {
            width: 60px;
            height: 60px;
            background-color: red;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 60px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        /* Estilo de la tabla */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: center;
            padding: 10px;
        }

        th {
            background-color: green;
            color: white;
        }

        td {
            border: none;
        }

        /* Estilo para el costo total */
        #totalPrice {
            font-size: 1.5rem;
            text-align: center;
            margin-top: 20px;
            color: green;
        }
    </style>
</head>
<body>
    <!-- Importa el encabezado desde el archivo externo -->
    <?php include_once '../view/common/header.php'; ?>

    <div class="container mx-auto mt-10">
        <form id="apuestaForm" method="post" action="./procesar.php">
            <!-- Campo para que el usuario agregue su nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <!-- Campo para que el usuario agregue su número telefónico -->
            <div class="mb-4">
                <label for="telefono" class="block text-gray-700 font-bold mb-2">Número Telefónico:</label>
                <input type="tel" id="telefono" name="telefono" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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
            <div id="totalPrice">Costo total: $0.00</div>
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
        });
    </script>
</body>
</html>
