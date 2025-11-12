<?php
include(__DIR__ . "/conexion.php");

header("Content-Type:application/json");
$metodo = $_SERVER["REQUEST_METHOD"];
//print_r($metodo);

switch ($metodo) {
    case "GET":
        // echo "Consulta del metodo GET\n";
        consulta($conn);
        break;
    case "POST":
        // echo "Consulta del metodo POST\n";
        insertar($conn);
        break;
    case "PUT":
        // echo "Consulta del metodo PUT\n";
        actualizar($conn);
        break;
    case "DELETE":
        // echo "Consulta del metodo DELETE\n";
        eliminar($conn);
        break;
    case "DEFAULT":
        echo "Método no válido\n";
        break;
}

function consulta($conn)
{
    $sql = "SELECT * FROM alumnos";
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $datos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(["mensaje" => "No hay registros"]);
    }
}

function insertar($conn)
{
    $dato = json_decode(file_get_contents("php://input"), true);

    // Obtener los campos
    $matricula = $dato["Matricula"] ?? '';
    $nombre = $dato["Nombre"] ?? '';
    $apaterno = $dato["Apaterno"] ?? '';
    $amaterno = $dato["Amaterno"] ?? '';
    $email = $dato["Email"] ?? '';
    $celular = $dato["Celular"] ?? '';
    $cp = $dato["CP"] ?? '';
    $sexo = $dato["Sexo"] ?? '';

    $sql = "INSERT INTO alumnos (Matricula, Nombre, Apaterno, Amaterno, Email, Celular, CP, Sexo)
            VALUES ('$matricula', '$nombre', '$apaterno', '$amaterno', '$email', '$celular', '$cp', '$sexo')";

    $resultado = $conn->query($sql);

    if ($resultado) {
        echo json_encode(["mensaje" => "Alumno registrado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al insertar: " . $conn->error]);
    }
}

function actualizar($conn)
{
    $dato = json_decode(file_get_contents("php://input"), true);

    $id = $dato["Id"] ?? null;
    if (!$id) {
        echo json_encode(["error" => "ID no proporcionado"]);
        return;
    }

    $matricula = $dato["Matricula"] ?? '';
    $nombre = $dato["Nombre"] ?? '';
    $apaterno = $dato["Apaterno"] ?? '';
    $amaterno = $dato["Amaterno"] ?? '';
    $email = $dato["Email"] ?? '';
    $celular = $dato["Celular"] ?? '';
    $cp = $dato["CP"] ?? '';
    $sexo = $dato["Sexo"] ?? '';

    $sql = "UPDATE alumnos 
            SET Matricula='$matricula', Nombre='$nombre', Apaterno='$apaterno', Amaterno='$amaterno',
                Email='$email', Celular='$celular', CP='$cp', Sexo='$sexo'
            WHERE Id=$id";

    $resultado = $conn->query($sql);

    if ($resultado) {
        echo json_encode(["mensaje" => "Alumno actualizado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al actualizar el alumno: " . $conn->error]);
    }
}


function eliminar($conn)
{
    $dato = json_decode(file_get_contents("php://input"), true);
    $id = $dato["Id"] ?? $_GET["Id"] ?? null;

    if (!$id) {
        echo json_encode(["error" => "ID no proporcionado"]);
        return;
    }

    $sql = "DELETE FROM alumnos WHERE Id = $id";
    $resultado = $conn->query($sql);

    if ($resultado) {
        echo json_encode(["mensaje" => "Alumno eliminado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al eliminar el alumno: " . $conn->error]);
    }
}
