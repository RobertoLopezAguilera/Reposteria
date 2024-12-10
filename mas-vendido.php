<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postres Más Vendidos</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        .catalogo {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-gap: 20px;
            padding: 20px;
        }
        .postre {
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.315);
            text-align: center;
        }
        .postre img {
            width: 100%; /* Hace que la imagen ocupe todo el ancho del contenedor */
            height: 200px; /* Fija una altura específica para las imágenes */
            object-fit: cover; /* Ajusta la imagen para que se recorte sin distorsionarse */
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include('includes/conexion.php'); ?>

    <h1>Postres Más Vendidos</h1>
    <?php
    $sql_mas_vendidos = "SELECT Postre_idPostre, COUNT(*) AS total_ventas FROM DetalleOrden GROUP BY Postre_idPostre ORDER BY total_ventas DESC LIMIT 5";
    $result_mas_vendidos = $conn->query($sql_mas_vendidos);

    if ($result_mas_vendidos->num_rows > 0) {
        echo "<div class='catalogo'>";
        while ($row_mas_vendidos = $result_mas_vendidos->fetch_assoc()) {
            $idPostre = $row_mas_vendidos['Postre_idPostre'];
            $totalVentas = $row_mas_vendidos['total_ventas'];

            // Consultar información del postre
            $sql_postre_info = "SELECT * FROM Postre WHERE idPostre = $idPostre";
            $result_postre_info = $conn->query($sql_postre_info);

            if ($result_postre_info->num_rows > 0) {
                $row_postre_info = $result_postre_info->fetch_assoc();
                $nombrePostre = $row_postre_info['Nombre'];
                $precioPostre = $row_postre_info['Precio'];
                $imagenPostre = $row_postre_info['Imagen'];

                // Mostrar información del postre
                echo "<div class='postre'>";
                echo "<h3>$nombrePostre</h3>";
                echo "<p>Precio: $$precioPostre</p>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($imagenPostre) . "' alt='Imagen del postre'>";
                echo "<form action='form-orden.php' method='POST'>";
                echo "<input type='hidden' name='idPostre' value='$idPostre'>";
                echo "<button type='submit' class='btn btn-primary'>Comprar</button>";
                echo "</form>";
                echo "<a href='ver_postre.php?id=$idPostre'><button class='btn btn-secondary'>Ver</button></a>";
                echo "</div>";
            }
        }
        echo "</div>";
    } else {
        echo "No se encontraron postres más vendidos.";
    }

    $conn->close();
    ?>
</body>
</html>
