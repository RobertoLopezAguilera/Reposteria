<?php 
include('header.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Carrito</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
</head>
<body>
    <h2>Carrito de Compras</h2>
    <script>
        var postresEnCarrito = localStorage.getItem('postresEnCarrito');
        var idsPostres = postresEnCarrito ? JSON.parse(postresEnCarrito) : [];
        
    </script>
    <button class="btn btn-danger">Limpiar carrito</button>
</body>
</html>

<?php include('footer.php'); ?>
