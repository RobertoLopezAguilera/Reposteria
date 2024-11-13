<?php
include('includes/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $calle = $_POST['calle'];
    $numero = $_POST['numero'];
    $correo = $_POST['correo'];
    $numero_tarjeta = $_POST['numero_tarjeta'];
    $cv = $_POST['cv'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    $postresEnCarrito = json_decode($_POST['postresEnCarrito'], true);

    $conn->begin_transaction();

    try {
        $sql_domicilio = "INSERT INTO Domicilio (Calle, Numero) VALUES ('$calle', '$numero')";
        $conn->query($sql_domicilio);
        $idEntrega = $conn->insert_id;

        $fecha_pedido = date("Y-m-d");
        $estado = "Pendiente";
        $sql_orden = "INSERT INTO Orden (Nombre_Cliente, Telefono_Cliente, Correo, Fecha_Entrega, Fecha_Pedido, Estado, Entrega_idEntrega) VALUES ('$nombre', '$telefono', '$correo', '$fecha_entrega', '$fecha_pedido', '$estado', '$idEntrega')";
        $conn->query($sql_orden);
        $idOrden = $conn->insert_id;

        $sql_pago = "INSERT INTO Pago (Numero_Tarjeta, CV, Fecha, Orden_idOrden) VALUES ('$numero_tarjeta', '$cv', '$fecha_vencimiento', '$idOrden')";
        $conn->query($sql_pago);

        foreach ($postresEnCarrito as $idPostre) {
            $sql_precio = "SELECT Precio FROM Postre WHERE idPostre = $idPostre";
            $result_precio = $conn->query($sql_precio);
            if ($result_precio->num_rows == 1) {
                $row_precio = $result_precio->fetch_assoc();
                $total = $row_precio['Precio'];

                $sql_detalle_orden = "INSERT INTO DetalleOrden (Postre_idPostre, Orden_idOrden, Total) VALUES ($idPostre, $idOrden, $total)";
                if (!$conn->query($sql_detalle_orden)) {
                    throw new Exception("Error al insertar en DetalleOrden: " . $conn->error);
                }
            } else {
                throw new Exception("No se encontró el precio del postre con ID $idPostre.");
            }
        }

        $conn->commit();

        // Limpia el localStorage después de confirmar la orden
        echo "<script>
                localStorage.removeItem('postresEnCarrito');
                alert('Orden procesada correctamente.');
                window.location.href = 'detalles-orden-cliente.php?idOrden=$idOrden';
              </script>";
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $conn->close();
}
?>
