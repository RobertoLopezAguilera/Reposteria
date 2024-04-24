<?php
include('includes/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $calle = $_POST['calle'];
    $numero = $_POST['numero'];
    $idPostre = $_POST['idPostre'];
    $correo = $_POST['correo'];

    $numero_tarjeta = $_POST['numero_tarjeta'];
    $cv = $_POST['cv'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    $conn->begin_transaction();

    $sql_domicilio = "INSERT INTO Domicilio (Calle, Numero) VALUES ('$calle', '$numero')";
    if ($conn->query($sql_domicilio) === TRUE) {
        $idEntrega = $conn->insert_id;
        $fecha_pedido = date("Y-m-d");
        $estado = "Pendiente";

        $sql_orden = "INSERT INTO Orden (Nombre_Cliente, Telefono_Cliente, Correo, Fecha_Entrega, Fecha_Pedido, Estado, Entrega_idEntrega) VALUES ('$nombre', '$telefono', '$correo','$fecha_entrega', '$fecha_pedido', '$estado', '$idEntrega')";
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
