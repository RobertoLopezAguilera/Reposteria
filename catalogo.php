<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Postres</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        .catalogo {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-gap: 20px;
            padding: 20px;
        }
        .postre {
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.315);

        }
        .postre img {
            width: 100%; /* Hace que la imagen ocupe todo el ancho del contenedor */
            height: 200px; /* Fija una altura específica para las imágenes */
            object-fit: cover; /* Ajusta la imagen manteniendo su proporción */
            border-radius: 10px;
        }
        .btn {
            margin: 5px 0;
            padding: 8px 12px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            color: #fff;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
    </style>
</head>
<body>
<h1>Catálogo de Postres</h1>
<?php
$sql = "SELECT * FROM Postre WHERE Estado = 'Disponible'";

if(isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
    $sql .= " AND Nombre LIKE '%$buscar%'";
}

if(isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
    $sql .= " AND Categoria='$categoria'";
}

if(isset($_GET['precio'])) {
    $precio = $_GET['precio'];
    $sql .= " AND Precio < $precio";
}

if(isset($_GET['tamaño'])) {
    $tamaño = $_GET['tamaño'];
    $sql .= " AND Tamaño='$tamaño'";
}

if(isset($_GET['sabor'])) {
    $sabor = $_GET['sabor'];
    $sql .= " AND Sabor='$sabor'";
}

include('includes/conexion.php');

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='catalogo'>";
    while($row = $result->fetch_assoc()) {
        echo "<div class='postre'>";
        echo "<h3>" . $row['Nombre'] . "</h3>";
        echo "<p>$" . $row['Precio'] . "</p>";
        echo "<img src='data:image/jpeg;base64," . base64_encode($row['Imagen']) . "' alt='Imagen del postre'>";
        echo "<form action='form-orden.php' method='POST'>";
        echo "<input type='hidden' name='idPostre' value='" . $row['idPostre'] . "'>";
        echo "<button type='submit' class='btn btn-primary'>Comprar</button>";
        echo "</form>";
        echo "<a href='ver_postre.php?id=" . $row['idPostre'] . "'><button class='btn btn-secondary'>Ver</button></a>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "No se encontraron postres.";
}

$conn->close();
?>
</body>
</html>
<?php include('footer.php'); ?>
