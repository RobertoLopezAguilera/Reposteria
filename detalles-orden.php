<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mensaje = '';
if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'inicio_sesion') {
    $mensaje = '<p style="color: red;">Debes iniciar sesión primero para acceder a esta página.</p>';
}
?>
<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la orden</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
    .div-Login{
        display: flex;
    }
    select{
        default dropdown arro
        appearance: none;
        background-color: transparent;
        border: none;
        padding: 0 1em 0 0;
        margin: 0;
        width: 100%;
        font-family: inherit;
        font-size: inherit;
        cursor: inherit;
        line-height: inherit;
        z-index: 1;
        &::-ms-expand {
            display: none;
        }
    }
</style>

</head>
<body>
<?php
    if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'inicio_sesion') {
        echo '<p style="color: red;">Debes iniciar sesión primero para acceder a esta página.</p>';
    }
    include('includes/conexion.php');

    if (isset($_POST['idOrden']) && is_numeric($_POST['idOrden'])) {
        $idOrden = $_POST['idOrden'];
        $sql_orden = "SELECT * FROM Orden WHERE idOrden = $idOrden";
        $result_orden = $conn->query($sql_orden);
        if ($result_orden->num_rows > 0) {
            $row_orden = $result_orden->fetch_assoc();
            $nombreCliente = $row_orden['Nombre_Cliente'];
            $telefonoCliente = $row_orden['Telefono_Cliente'];
            $fechaEntrega = $row_orden['Fecha_Entrega'];
            $estado = $row_orden['Estado'];
            $fechaPedido = $row_orden['Fecha_Pedido'];

            // Mostrar los detalles de la orden
            echo "<div class='div-Login'>";
            echo "<div class='login-container'>";
            echo "<h2>Detalles de la Orden</h2>";
            echo "<form action='actualizar-estado.php' method='post'>";
            echo "<input type='hidden' name='idOrden' value='$idOrden'>";
            echo "<p>Cliente: $nombreCliente</p>";
            echo "<p>Teléfon: $telefonoCliente</p>";
            echo "<p>Fecha de Entrega: $fechaEntrega</p>";
            echo "<p>Fecha en que se pidio: $fechaPedido</p>";
            echo "<p>Estado actual: $estado</p>";
            echo "<label for='nuevoEstado'>Seleccionar nuevo estado:</label>";
            echo "<select name='nuevoEstado' id='nuevoEstado'>";
            echo "<option value='Pendiente'".($estado == 'Pendiente' ? ' selected' : '').">Pendiente</option>";
            echo "<option value='Preparación'".($estado == 'Preparación' ? ' selected' : '').">Preparación</option>";
            echo "<option value='Entregado'".($estado == 'Entregado' ? ' selected' : '').">Entregado</option>";
            echo "<br><br>";
            echo "<input type='submit' class='btn btn-primary' value='Guardar'>";
            echo "</form>";
            echo "</div>";
            

            // Mostrar los detalles de pago
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
            // Obtener los detalles de la entrega domicialio
            $sql_domilicio = "SELECT * FROM `domicilio`;";
            $result_domicilio = $conn->query($sql_domilicio);

            if ($result_domicilio->num_rows > 0) {
                $row_domicilio = $result_domicilio->fetch_assoc();
                $calle = $row_domicilio['Calle'];
                $numero = $row_domicilio['Numero'];
                echo"<div class='login-container'>";
                echo "<h2>Tipo de entrega</h2>";
                echo "<p>Domicilio: $calle</p>";
                echo "<p>numero: $numero</p>";
                echo "</div>";
                echo "</div>";
            } else {
                echo "No se encontró el postre asociado a esta orden.";
            }
        } else {
            echo "No se encontró la orden con el ID proporcionado.";
        }
    } else {
        echo "ID de orden no válido.";
    }
    echo "</div>";
    $conn->close();
    
?>
<form action="borrar-orden.php" method="post">
    <input type="hidden" name="idOrden" value="<?php echo $idOrden; ?>">
    <input type="submit" class="btn btn-danger" value="Borrar">
</form>

</body>
</html>

<?php include('footer.php'); ?>
