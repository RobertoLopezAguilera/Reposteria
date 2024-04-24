<?php
include('includes/conexion.php');

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
