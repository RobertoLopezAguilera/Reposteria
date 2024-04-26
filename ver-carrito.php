<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Carrito</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h2 id="carrito">Carrito de Compras</h2>
    <div id="listaPostres">
    <script>
        let postresEnCarrito = JSON.parse(localStorage.getItem("postresEnCarrito"));
        let listaPostres = document.getElementById("listaPostres");
        if (postresEnCarrito) {
            // Recorrer cada ID de postre y hacer una solicitud AJAX
            postresEnCarrito.forEach(function(postre) {
                $.ajax({
                    url: 'obtener-detalles-postre.php?id=' + postre.id,
                    type: 'GET',
                    success: function(response) {
                        listaPostres.innerHTML += response;
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener detalles del postre:', error);
                    }
                });
            });
        } else {
            // Si no hay postres en el carrito, mostrar un mensaje
            listaPostres.innerHTML = "<p>El carrito está vacío.</p>";
        }

        // Función para limpiar el carrito
        function limpiarCarrito() {
            localStorage.removeItem('postresEnCarrito');
            location.reload();
        }
    </script>
    </div>
    <h2 id="total">Total: </h2>
    <div>
       <button class="btn btn-danger" onclick="limpiarCarrito()">Limpiar carrito</button> 
       <button class="btn btn-primary" onclick="comprarCarrito()">Comprar</button>
    </div>

    <script>
        let postresEnCarrito = JSON.parse(localStorage.getItem("postresEnCarrito"));
        var total = 0;
        if (postresEnCarrito) {
            postresEnCarrito.forEach(function(postre) {
                total += parseInt(postre.precio);
            });
        }
        document.getElementById("total").innerHTML = "Total: $" + total.toFixed(2);
    </script>
    
</body>
</html>
<?php include('footer.php'); ?>
