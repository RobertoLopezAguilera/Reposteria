<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postre</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<?php
include('includes/conexion.php');

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Obtener el id del postre
    $idPostre = $_GET['id'];

    // Consultar la base de datos para obtener los detalles del postre con el id proporcionado
    $sql = "SELECT * FROM Postre WHERE idPostre = $idPostre";
    $result = $conn->query($sql);

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Mostrar los detalles del postre
        echo "<div class='container-img'>";
        while($row = $result->fetch_assoc()) {
            echo "<div class='row'>";
            echo "<div class='col-md-6'>";
            echo "<img src='data:image/jpeg;base64," . base64_encode($row['Imagen']) . "' alt='Imagen del postre' class='img-fluid'>";
            echo "</div>";
            echo "<div class='col-md-6'>";
            echo "<h1>" . $row['Nombre'] . "</h1>";
            echo "<p><strong>Tamaño:</strong> " . $row['Tamaño'] . "</p>";
            echo "<p><strong>Precio:</strong> $" . $row['Precio'] . "</p>";
            echo "<p><strong>Sabor:</strong> " . $row['Sabor'] . "</p>";
            echo "<p><strong>Ingredientes:</strong> " . $row['Ingredientes'] . "</p>";
            echo "<p><strong>Disponibilidad:</strong> " . ($row['Estado'] == 'Disponible' ? 'Disponible' : 'Agotado') . "</p>";
            // Agregar formulario para redirigir al formulario de orden con el ID del postre
            echo "<form action='form-orden.php' method='POST'>";
            echo "<input type='hidden' name='idPostre' value='" . $row['idPostre'] . "'>";
            echo "<button type='submit'class='btn btn-primary' >Comprar</button>";
            echo "</form>";
            echo "<button type='button' class='btn btn-secondary' onclick='agregarAlCarrito(" . $row['idPostre'] . ", \"" . $row['Nombre'] . "\", " . $row['Precio'] . ", \"" . base64_encode($row['Imagen']) . "\")'>Agregar al carrito</button>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "No se encontró el postre.";
    }
} else {
    header("Location: catalogo.php");
    exit;
}
$conn->close();
?>

<script>
    function agregarAlCarrito(idPostre, nombre, precio, imagenBase64) {
    // Obtener los postres en el carrito del localStorage
    var postresEnCarrito = localStorage.getItem('postresEnCarrito');
    var postres = postresEnCarrito ? JSON.parse(postresEnCarrito) : [];

    // Agregar el nuevo postre al carrito
    postres.push({ id: idPostre, nombre: nombre, precio: precio, imagen: imagenBase64 });
    
    // Guardar el carrito actualizado en el localStorage
    localStorage.setItem('postresEnCarrito', JSON.stringify(postres));

    // Mostrar un mensaje de éxito
    alert('El postre ha sido agregado al carrito de compras.');
}

</script>


</body>
</html>
<?php include('footer.php');?>
