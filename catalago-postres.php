<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mensaje = '';
if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'inicio_sesion') {
    $mensaje = '<p style="color: red;">Debes iniciar sesión primero para acceder a esta página.</p>';
    echo "alert('Debes de iniciar secion para acceder')";
}
?>
<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <style>
        .catalogo {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        grid-gap: 20px;
        padding: 20px;
        }
    </style>
</head>
<body>
    <?php 
        $sql = "SELECT * FROM Postre";
        include('includes/conexion.php');

        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            echo "<div class='catalogo'>";
            while($row = $result->fetch_assoc()) {
                echo "<div class='postre'>";
                echo "<h3>" . $row['Nombre'] . "</h3>";
                echo "<p>$" . $row['Precio'] . "</p>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($row['Imagen']) . "' alt='Imagen del postre'>";
                echo "<form action='borrar-postre.php' method='POST'>";
                echo "<input type='hidden' name='idPostre' value='" . $row['idPostre'] . "'>";
                echo "<button type='submit'class='btn btn-danger' >Borrar</button>";
                echo "</form>";
                echo "<a href='editar-postre.php?id=" . $row['idPostre'] . "'><button class='btn btn-primary'>Editar</button></a>";
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