<?php
// Incluir el archivo de conexión a la base de datos
include('includes/conexion.php');

// Verificar si se recibió el id del postre por POST
if(isset($_POST['idPostre'])) {
    // Obtener el id del postre desde el formulario
    $idPostre = $_POST['idPostre'];

    // Consultar la base de datos para obtener los detalles del postre con el id proporcionado
    $sql = "SELECT * FROM Postre WHERE idPostre = $idPostre";
    $result = $conn->query($sql);

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Obtener los datos del postre
        $postre = $result->fetch_assoc();

        // Iniciar o continuar la sesión para acceder al carrito
        session_start();

        // Verificar si el carrito ya existe en la sesión
        if(isset($_SESSION['carrito'])) {
            // Si el carrito ya existe, agregar el nuevo postre al carrito
            $_SESSION['carrito'][] = $postre;
        } else {
            // Si el carrito no existe, crear un nuevo carrito y agregar el postre
            $_SESSION['carrito'] = array($postre);
        }

        // Redirigir de vuelta a la página de donde se realizó la solicitud
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        // Si no se encontró el postre, mostrar un mensaje de error
        echo "No se encontró el postre.";
    }
} else {
    // Si no se recibió el id del postre por POST, mostrar un mensaje de error
    echo "No se recibió el id del postre.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
