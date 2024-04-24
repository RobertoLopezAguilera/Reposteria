<?php
    include('includes/conexion.php');

    if (isset($_POST['idOrden']) && is_numeric($_POST['idOrden'])) {
        $idOrden = $_POST['idOrden'];
        $sql_delete_detalles = "DELETE FROM DetalleOrden WHERE Orden_idOrden = $idOrden";
        if ($conn->query($sql_delete_detalles) === TRUE) {
            $sql_delete_pago = "DELETE FROM Pago WHERE Orden_idOrden = $idOrden";
            if ($conn->query($sql_delete_pago) === TRUE) {
                $sql_delete_orden = "DELETE FROM Orden WHERE idOrden = $idOrden";
                if ($conn->query($sql_delete_orden) === TRUE) {
                    header("Location: calendario.php");
                    exit();
                } else {
                    echo "Error al eliminar la orden: " . $conn->error;
                }
            } else {
                echo "Error al eliminar el pago: " . $conn->error;
            }
        } else {
            echo "Error al eliminar los detalles de la orden: " . $conn->error;
        }
    } else {
        echo "ID de orden no válido.";
    }
    $conn->close();
?>
