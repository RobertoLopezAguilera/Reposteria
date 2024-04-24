<?php
if (isset($_POST['idOrden'], $_POST['nuevoEstado'])) {
    include('includes/conexion.php');
    $idOrden = $_POST['idOrden'];
    $nuevoEstado = $_POST['nuevoEstado'];

    if (in_array($nuevoEstado, ['Pendiente', 'Preparación', 'Entregado'])) {
        $sql = "UPDATE Orden SET Estado = '$nuevoEstado' WHERE idOrden = $idOrden";

        if ($conn->query($sql) === TRUE) {
            header("Location: calendario.php?");
            exit();
        } else {
            echo "Error al actualizar el estado de la orden: " . $conn->error;
        }
    } else {
        echo "Error: El nuevo estado no es válido.";
    }

    $conn->close();
} else {
    header("Location: calendario.php");
    exit();
}
?>
