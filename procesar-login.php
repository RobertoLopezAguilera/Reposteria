<?php
include('includes/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT Contraseña FROM Administrador WHERE Nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        $contrasena_hasheada_bd = $fila['Contraseña'];

        if (password_verify($contrasena, $contrasena_hasheada_bd)) {
            session_start();
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php");
            exit();
        } else {
            session_start();
            $_SESSION['error'] = "La contraseña es incorrecta.";
            header("Location: login.php");
            exit();
        }
    } else {
        session_start();
        $_SESSION['error'] = "El usuario no existe.";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: login.php");
    exit();
}
?>
