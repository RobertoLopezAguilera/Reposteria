<?php
include('includes/conexion.php');

if(isset($_GET['id'])) {
    // Obtener el id del postre
    $idPostre = $_GET['id'];
    $sql = "SELECT * FROM Postre WHERE idPostre = $idPostre";
    $result = $conn->query($sql);
    echo "<div class='carrito'>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='div-Login'>";
            echo "<div class='login-container'>";
            echo "<img src='data:image/jpeg;base64," . base64_encode($row['Imagen']) . "' alt='Imagen del postre' class='img-fluid'>";
            echo "</div>";
            echo "<div class='col-md-6'>";
            echo "<h1>" . $row['Nombre'] . "</h1>";
            echo "<p><strong>Tamaño:</strong> " . $row['Tamaño'] . "</p>";
            echo "<p><strong>Precio:</strong> $" . $row['Precio'] . "</p>";
            echo "<p><strong>Sabor:</strong> " . $row['Sabor'] . "</p>";
            echo "<button class='btn btn-outline-danger' onclick='quitarDelCarrito(" . $row['idPostre'] . ")'>Quitar</button>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>No se encontró el postre con el ID proporcionado.</p>";
    }
} else {
    echo "<p>ID de postre no válido.</p>";
}
$conn->close();
?>
</body>
</html>
