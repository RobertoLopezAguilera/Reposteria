<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <?php
    if (isset($_GET['fecha'])) {
        $fecha = $_GET['fecha'];
        include('includes/conexion.php');

        try {
            // Detalles de las ventas para la fecha específica
            $sql_detalles_venta = "SELECT o.idOrden, d.Total, d.Postre_idPostre, p.Nombre AS NombrePostre
                                FROM Orden o
                                INNER JOIN DetalleOrden d ON o.idOrden = d.Orden_idOrden
                                INNER JOIN Postre p ON d.Postre_idPostre = p.idPostre
                                WHERE DATE_FORMAT(o.Fecha_Entrega, '%Y-%m-%d') = ?";
            $stmt = $conn->prepare($sql_detalles_venta);
            $stmt->bind_param("s", $fecha);
            $stmt->execute();
            $result = $stmt->get_result();

            // Mostrar detalles de las ventas
            if ($result->num_rows > 0) {
                echo "<h2>Ventas del día $fecha</h2>";
                echo "<table class='table-datos'>";
                echo "<tr><th>ID de Orden</th><th>Nombre del Postre</th><th>Total</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['idOrden']}</td>";
                    echo "<td>{$row['NombrePostre']}</td>";
                    echo "<td> \$ {$row['Total']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No se encontraron ventas para la fecha $fecha.</p>";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        $stmt->close();
        $conn->close();
    } else {
        echo "<p>No se proporcionó una fecha válida.</p>";
    }
    ?>
    <p></p>
    <div>
        <a href="calendario.php?start=2024-04-01&end=2024-04-30" class="boton-buscar">Volver</a>
    </div>
    <p></p>
</body>
</html>
<?php include('footer.php'); ?>