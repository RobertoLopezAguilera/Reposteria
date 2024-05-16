<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha enviado el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió el id del postre
    if (isset($_POST['idPostre']) && is_numeric($_POST['idPostre'])) {
        $idPostre = $_POST['idPostre'];
        
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $tamaño = $_POST['tamaño'];
        $sabor = $_POST['sabor'];
        $ingredientes = $_POST['ingredientes'];
        $precio = $_POST['precio'];
        $estado = $_POST['estado'];

        // Procesar la imagen (si se cargó una nueva)
        if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen_temp = $_FILES['imagen']['tmp_name'];
            $imagen_contenido = file_get_contents($imagen_temp);
        } else {
            // Si no se cargó una nueva imagen, mantener la imagen existente en la base de datos
            // Podrías hacer una consulta para obtener la imagen actual aquí si lo necesitas
            // Por simplicidad, lo omitiremos en este ejemplo
        }

        // Incluir el archivo de conexión a la base de datos
        include('includes/conexion.php');

        // Preparar la consulta SQL para actualizar el postre
        $sql = "UPDATE Postre SET 
                Nombre = '$nombre', 
                Categoria = '$categoria', 
                Tamaño = '$tamaño', 
                Sabor = '$sabor', 
                Ingredientes = '$ingredientes', 
                Precio = $precio, 
                Estado = '$estado'";

        // Si se cargó una nueva imagen, agregarla a la consulta
        if (isset($imagen_contenido)) {
            $sql .= ", Imagen = ?";
        }

        $sql .= " WHERE idPostre = $idPostre";

        // Preparar la declaración SQL
        $stmt = $conn->prepare($sql);

        // Si se cargó una nueva imagen, enlazar el parámetro
        if (isset($imagen_contenido)) {
            $stmt->bind_param("s", $imagen_contenido);
        }

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redireccionar a la página de catálogo con un mensaje de éxito
            header("Location: catalago-postres.php?mensaje=edicion_exitosa");
            exit();
        } else {
            // Si la consulta falla, mostrar un mensaje de error
            echo "Error al actualizar el postre: " . $conn->error;
        }

        // Cerrar la conexión a la base de datos
        $stmt->close();
        $conn->close();
    } else {
        // Si no se recibió el id del postre, mostrar un mensaje de error
        echo "ID de postre no válido.";
    }
} else {
    // Si no se envió un formulario POST, redireccionar a la página de error
    header("Location: error.php");
    exit();
}
?>
