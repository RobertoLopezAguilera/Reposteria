<?php include('header.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de orden</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        .div-Login{
            display: flex;
        }
    </style>
</head>
<body>
    <h2>Se envio una copia  de tu pedido al correo proporcionado</h2>
<?php
include('includes/conexion.php');

if (isset($_GET['idOrden']) && is_numeric($_GET['idOrden'])) {
    $idOrden = $_GET['idOrden'];

    // Consulta para obtener la información de la orden
    $sql_orden = "SELECT * FROM Orden WHERE idOrden = $idOrden";
    $result_orden = $conn->query($sql_orden);
    
    if ($result_orden->num_rows > 0) {
        $row_orden = $result_orden->fetch_assoc();
        $nombreCliente = $row_orden['Nombre_Cliente'];
        $telefonoCliente = $row_orden['Telefono_Cliente'];
        $fechaEntrega = $row_orden['Fecha_Entrega'];
        $estado = $row_orden['Estado'];
        $fechaPedido = $row_orden['Fecha_Pedido'];

        // Mostrar la información de la orden
        echo "<div class='div-Login'>";
        echo "<div class='login-container'>";
        echo "<form>";
        echo "<h2>Detalles de su Orden</h2>";
        echo "<p>ID de Orden: $idOrden</p>";
        echo "<p>Nombre: $nombreCliente</p>";
        echo "<p>Teléfono: $telefonoCliente</p>";
        echo "<p>Fecha de Entrega: $fechaEntrega</p>";
        echo "<p>Fecha de Pedido: $fechaPedido</p>";
        echo "</form>";
        echo "</div>";

        $sql_pago = "SELECT * FROM Pago WHERE Orden_idOrden = $idOrden";
            $result_pago = $conn->query($sql_pago);

            if ($result_pago->num_rows > 0) {
                $row_pago = $result_pago->fetch_assoc();
                $numeroTarjeta = $row_pago['Numero_Tarjeta'];
                $cv = $row_pago['CV'];
                $fechaPago = $row_pago['Fecha'];

                // Mostrar los detalles del pago
                echo "<div class='login-container'>";
                echo "<h2>Detalles del Pago</h2>";
                echo "<p>Número de Tarjeta: $numeroTarjeta</p>";
                echo "<p>CV: $cv</p>";
                echo "<p>Fecha de Pago: $fechaPago</p>";
                echo "</div>";
            } else {
                echo "No se encontraron detalles de pago para esta orden.";
            }
            // Obtener los detalles del postre pedido
            $sql_detalle = "SELECT * FROM DetalleOrden WHERE Orden_idOrden = $idOrden";
            $result_detalle = $conn->query($sql_detalle);

            // Verificar si se encontraron detalles del postre
            if ($result_detalle->num_rows > 0) {
                $row_detalle = $result_detalle->fetch_assoc();
                $idPostre = $row_detalle['Postre_idPostre'];

                // Obtener los detalles del postre de la base de datos
                $sql_postre = "SELECT * FROM Postre WHERE idPostre = $idPostre";
                $result_postre = $conn->query($sql_postre);
                if ($result_postre->num_rows > 0) {
                    $row_postre = $result_postre->fetch_assoc();
                    $nombrePostre = $row_postre['Nombre'];
                    $precioPostre = $row_postre['Precio'];
                    $imagenPostre = $row_postre['Imagen'];
                    echo"<div class='login-container'>";
                    echo "<h2>Postre pedido</h2>";
                    echo "<p>Nombre del Postre: $nombrePostre</p>";
                    echo "<p>Precio: $precioPostre</p>";
                    echo '<img src="data:image/jpeg;base64,'.base64_encode($imagenPostre).'" style="max-width: 200px;" />';
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "No se encontró el postre asociado a esta orden.";
                }
            } else {
                echo "No se encontraron detalles del postre para esta orden.";
            }
        
        echo "</div>";
    } else {
        echo "No se encontró la orden con el ID proporcionado.";
    }
} else {
    echo "ID de orden no válido.";
}

$conn->close();
?>
</body>
</html>
<?php include('footer.php') ?>