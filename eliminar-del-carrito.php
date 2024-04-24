<?php
session_start();

// Verificar si se recibió el ID del postre a eliminar
if(isset($_POST['idPostre']) && is_numeric($_POST['idPostre'])) {
    $idPostre = $_POST['idPostre'];

    // Verificar si el postre está en el carrito
    if(isset($_SESSION['carrito'][$idPostre])) {
        // Eliminar el postre del carrito
        unset($_SESSION['carrito'][$idPostre]);
    }
}

// Redirigir de regreso a la página del carrito
header("Location: ver-carrito.php");
exit;
?>
