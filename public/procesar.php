<?php
if(!isset($_SESSION))
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