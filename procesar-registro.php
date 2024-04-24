<?php
include('includes/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    if ($contrasena !== $confirmar_contrasena) {
        header("Location: registro.php?error=contrasena");
        exit();
    }

    $contrasena_hasheada = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Administrador (Nombre, Correo, Contraseña, Orden_idOrden) VALUES (?, ?, ?, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $usuario, $correo, $contrasena_hasheada);

    if ($stmt->execute()) {
        header("Location: login.php?registro=exito");
        exit();
    } else {
        header("Location: registro.php?error=registro");
        exit();
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: registro.php");
    exit();
}
?>
