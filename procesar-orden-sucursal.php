<?php
include('includes/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $idPostre = $_POST['idPostre'];

    $numero_tarjeta = $_POST['numero_tarjeta'];
    $cv = $_POST['cv'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    $conn->begin_transaction();
    $sql_domicilio = "SELECT * FROM `domicilio` WHERE idEntrega = 1;";
    if ($conn->query($sql_domicilio)) {
        $fecha_pedido = date("Y-m-d");
        $estado = "Pendiente";

        $sql_orden = "INSERT INTO Orden (Nombre_Cliente, Fecha_Entrega, Fecha_Pedido, Estado, Entrega_idEntrega) VALUES ('$nombre','$fecha_entrega', '$fecha_pedido', '$estado', '1')";
        if ($conn->query($sql_orden) === TRUE) {
            $idOrden = $conn->insert_id;

            $sql_pago = "INSERT INTO Pago (Numero_Tarjeta, CV, Fecha, Orden_idOrden) VALUES ('$numero_tarjeta', '$cv', '$fecha_vencimiento', '$idOrden')";
            if ($conn->query($sql_pago) === TRUE) {
                $sql_precio = "SELECT Precio FROM Postre WHERE idPostre = $idPostre";
                $result_precio = $conn->query($sql_precio);
                if ($result_precio->num_rows == 1) {
                    $row_precio = $result_precio->fetch_assoc();
                    $total = $row_precio['Precio'];

                    $sql_detalle_orden = "INSERT INTO DetalleOrden (Postre_idPostre, Orden_idOrden, Total) VALUES ($idPostre, $idOrden, $total)";
                    if ($conn->query($sql_detalle_orden) === TRUE) {
                        $conn->commit();
                        echo "Orden procesada correctamente.";
                        header("Location: detalles-orden-cliente.php?idOrden=$idOrden");
                    } else {
                        $conn->rollback();
                        echo "Error al insertar en la tabla DetalleOrden: " . $conn->error;
                    }
                    
                } else {
                    $conn->rollback();
                    echo "No se encontró el precio del postre.";
                }
            } else {
                $conn->rollback();
                echo "Error al insertar en la tabla Pago: " . $conn->error;
            }
        } else {
            $conn->rollback();
            echo "Error al insertar en la tabla Orden: " . $conn->error;
        }
    } else {
        $conn->rollback();
        echo "Error al insertar en la tabla Domicilio: " . $conn->error;
    }

    $conn->close();
}
?>
