<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root123";
$database = "ReposPiña"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
