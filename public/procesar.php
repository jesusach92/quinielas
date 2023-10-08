<?php
if (!isset($_SESSION)) session_start();


var_dump($_POST);
// Incluye el archivo de configuración de la base de datos
include "../model/backend/database/config.php";

// Verifica si se ha proporcionado la variable "jornada" en la URL
if (isset($_GET["jornada"])) {
    $jornadaSeleccionada = $_GET["jornada"];
    
    // Convierte la jornada seleccionada a un número entero seguro
    $jornadaSeleccionada = intval($jornadaSeleccionada);
    
    // Consulta para obtener los partidos de la jornada seleccionada
    // Consulta para obtener los partidos de la jornada seleccionada
$consultaPartidos = "SELECT * FROM partidosview WHERE numero_jornada = $jornadaSeleccionada";
$resultados = mysqli_query($conexion, $consultaPartidos);

if (!$resultados) {
    die("Error al obtener los resultados: " . mysqli_error($conexion));
}


    // Procesar el formulario si se ha enviado
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];
        var_dump($nombre, $telefono);
        
        // Obtener otros datos del formulario según tu estructura
        // $otroDato = $_POST["nombre_del_campo"];
        
        // Insertar datos del usuario en la tabla "usuarios"
        $sqlInsertUsuario = "INSERT INTO quinielas (name, phoneNumber) VALUES (?, ?)";
        $stmtInsertUsuario = mysqli_prepare($conexion, $sqlInsertUsuario);
        mysqli_stmt_bind_param($stmtInsertUsuario, "ss", $nombre, $telefono);
        mysqli_stmt_execute($stmtInsertUsuario);
        
        // Obtener el ID del usuario insertado
        $userId = mysqli_insert_id($conexion);
        
        // Iterar sobre las selecciones del usuario y guardarlas en la tabla "quinielas"
        foreach ($_POST["selecciones"] as $partidoId => $resultados) {
            // Procesar $partidoId y $resultados según tu estructura
            // $otroDatoPartido = $resultados["nombre_del_campo"];
            
            // Insertar datos en la tabla "quinielas"
            $sqlInsertQuiniela = "INSERT INTO quinielas (name, fkJornada, idUser) VALUES (?, ?, ?, ?, ?)";
            $stmtInsertQuiniela = mysqli_prepare($conexion, $sqlInsertQuiniela);
            mysqli_stmt_bind_param($stmtInsertQuiniela, "siiis", $jornadaSeleccionada, $partidoId, $userId, $resultados);
            mysqli_stmt_execute($stmtInsertQuiniela);
            
            // Obtener el ID de la quiniela insertada
            $quinielaId = mysqli_insert_id($conexion);
            
            // Iterar sobre los resultados del partido y guardarlos en la tabla "resultquiniela"
            foreach ($resultados as $resultado) {
                // Insertar datos en la tabla "resultquiniela"
                $sqlInsertResultado = "INSERT INTO resultquiniela (fkQuiniela, fkPartido, resultMatch) VALUES (?, ?, ?)";
                $stmtInsertResultado = mysqli_prepare($conexion, $sqlInsertResultado);
                mysqli_stmt_bind_param($stmtInsertResultado, "iis", $quinielaId, $partidoId, $resultado);
                mysqli_stmt_execute($stmtInsertResultado);
            }
        }
        
        // Cerrar las consultas preparadas
        mysqli_stmt_close($stmtInsertUsuario);
        mysqli_stmt_close($stmtInsertQuiniela);
        mysqli_stmt_close($stmtInsertResultado);
        
         // Mostrar mensaje de éxito
    echo "Tu quiniela se ha guardado correctamente.";

    // Redirigir a la misma página después de unos segundos
    header("refresh:5;url=./user.php");
    exit(); // Importante: asegúrate de salir del script después de la redirección
    }
}
?>
