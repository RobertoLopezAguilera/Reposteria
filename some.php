<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "usuario", "contraseña", "nombreBaseDatos");

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $tamano = $_POST['tamano'];
    $sabor = $_POST['sabor'];
    $ingredientes = [];

    // Recoger los ingredientes, si están vacíos se asigna NULL
    for ($i = 1; $i <= 5; $i++) {
        $ingrediente = !empty($_POST["ingrediente$i"]) ? $_POST["ingrediente$i"] : NULL;
        if ($ingrediente) {
            $ingredientes[] = $ingrediente;
        }
    }

    // Convertimos el array de ingredientes a una cadena
    $ingredientes_str = implode(", ", $ingredientes);

    $precio = $_POST['precio'];
    
    // Estado se asigna como NULL
    $estado = NULL;

    // Manejar la imagen
    $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

    $sql = "INSERT INTO Postre (Nombre, Categoria, Tamaño, Sabor, Ingredientes, Precio, Estado, Imagen) 
            VALUES ('$nombre', '$categoria', '$tamano', '$sabor', '$ingredientes_str', '$precio', NULL, '$imagen')";

    if ($conexion->query($sql) === TRUE) {
        echo "Nuevo pastel agregado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }

    $conexion->close();
}
?>
