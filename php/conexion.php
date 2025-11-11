
<?php
$servername = "localhost";
$username = "root";
$password = "";
$bd = "api";

// Crear conexion

$conn = new mysqli($servername, $username, $password, $bd);

// Checar conexion

if ($conn->connect_error) {
    die("Conexion". $conn->connect_error);
}

// echo "Conexion exitosa";

?>
