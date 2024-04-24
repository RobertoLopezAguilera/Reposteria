<?php
include('includes/conexion.php');

// Verificar si se enviaron datos desde el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $tamaño = $_POST['tamaño'];
    $sabor = $_POST['sabor'];
    $ingredientes = $_POST['ingredientes'];
    $precio = $_POST['precio'];
    $estado = $_POST['estado'];

    // Procesar la imagen
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Ruta temporal del archivo subido
        $ruta_temporal = $_FILES['imagen']['tmp_name'];

        // Leer el nombre original de la imagen
        $nombre_imagen = $_FILES['imagen']['name'];

        // Leer la imagen en memoria
        $imagen_binaria = file_get_contents($ruta_temporal);

        // Escapar los caracteres especiales para evitar problemas de SQL injection
        $imagen_binaria = mysqli_real_escape_string($conn, $imagen_binaria);
        $nombre_imagen = mysqli_real_escape_string($conn, $nombre_imagen);
    } else {
        // Si no se ha enviado una imagen, asignar un valor predeterminado
        $imagen_binaria = null;
        $nombre_imagen = null;
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO Postre (Nombre, Categoria, Tamaño, Sabor, Ingredientes, Precio, Estado, Imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ssssssis", $nombre, $categoria, $tamaño, $sabor, $ingredientes, $precio, $estado, $imagen_binaria);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Postre registrado con éxito, redirigir al usuario a alguna página de éxito
        header("Location: index.php");
        exit();
    } else {
        // Error al registrar el postre, redirigir al usuario de vuelta al formulario de registro con un mensaje de error
        header("Location: form-postre.php?error=registro");
        exit();
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    // Si se intenta acceder a esta página directamente sin enviar datos desde el formulario, redirigir al usuario a la página de registro
    header("Location: index.php");
    exit();
}
?>
