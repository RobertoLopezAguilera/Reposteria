<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Carrito</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .div-Login {
            display: flex;
            flex-wrap: nowrap;
            justify-content: center;
            align-items: baseline;
            flex-direction: column;
        }

        .login-container,
        .postre-info {
            background-color: rgba(255, 255, 255, 0.315);
            max-width: 300px;
            margin: 1rem;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .postre-info img {
            max-width: 200px;
            margin-bottom: 20px;
        }

        .input-text {
            width: 100%;
            height: 40px;
            border-radius: 10px;
            border: 0;
            box-shadow: inset #e571c7 0 0 0 2px;
            transition: all .2s ease;
        }
    </style>
</head>

<body>
    <h2 id="carrito">Carrito de Compras</h2>
    <div class="div-Login">
    <div id="listaPostres"></div>
    <div class="login-container">
        <h2>Datos del cliente:</h2>
        <form action="procesar-orden-varios.php" method="POST" onsubmit="return validarFormulario()">
            <!-- Campos del formulario existentes -->
            <div class="form-group">
                <input type="text" placeholder="Nombre Completo" id="nombre" name="nombre" class="input-text" required>
            </div>
            <div class="form-group">
                <input type="text" placeholder="Ejemplo@gmail.com" id="correo" name="correo" class="input-text" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono del Cliente:</label>
                <input type="tel" placeholder="10 Dígitos" id="telefono" name="telefono" class="input-text" required minlength="10" maxlength="10">
            </div>
            <div class="form-group">
                <label for="fecha_entrega">Fecha de Entrega:</label>
                <input type="date" id="fecha_entrega" name="fecha_entrega" class="input-text" required>
            </div>
            <div class="form-group">
                <label for="calle">Calle:</label>
                <input type="text" placeholder="Nombre completo de la calle" id="calle" name="calle" class="input-text" required minlength="10">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Número exterior #" id="numero" name="numero" class="input-text" required>
            </div>
            <div class="form-group">
                <label for="numero_tarjeta">Datos de Tarjeta:</label>
                <input type="text" placeholder="#### #### #### ####" id="numero_tarjeta" name="numero_tarjeta" class="input-text" minlength="16" maxlength="16" required>
            </div>
            <div class="form-groupTarjeta">
                <input type="text" placeholder="CVV" id="cv" name="cv" class="input-text" required minlength="3" maxlength="4">
                <input placeholder="00/00" type="text" id="fecha_vencimiento" name="fecha_vencimiento" class="input-text" required minlength="5" maxlength="5">
            </div>
            
            <!-- Campo oculto para enviar los IDs de los postres del carrito -->
            <input type="hidden" id="postresEnCarritoInput" name="postresEnCarrito">

            <button type="submit" class="btn btn-primary">Enviar Orden</button>
        </form>
    </div>
</div>

<script>
    function validarFormulario() {
        // Obtener los IDs de los postres en el carrito desde localStorage
        const postresEnCarrito = JSON.parse(localStorage.getItem("postresEnCarrito")) || [];

        // Asignar el valor en el campo oculto
        document.getElementById("postresEnCarritoInput").value = JSON.stringify(postresEnCarrito);

        // Validar otros campos del formulario si es necesario
        return true;
    }
</script>


    <h2 id="total">Total: $0.00</h2>
    <button class="btn btn-danger" onclick="limpiarCarrito()">Limpiar carrito</button>

    <script>
    let postresEnCarrito = JSON.parse(localStorage.getItem("postresEnCarrito")) || [];
    let preciosEnCarrito = JSON.parse(localStorage.getItem("preciosEnCarrito")) || [];
    let listaPostres = document.getElementById("listaPostres");
    let total = 0;

    // Función para calcular y mostrar el total de los precios
    function calcularTotal() {
        total = preciosEnCarrito.reduce((acc, precio) => acc + parseFloat(precio), 0);
        document.getElementById("total").innerHTML = "Total: $" + total.toFixed(2);
    }

    // Mostrar los postres y calcular el total
    if (postresEnCarrito.length > 0) {
        postresEnCarrito.forEach(function (idPostre, index) {
            $.ajax({
                url: 'obtener-detalles-postre.php',
                type: 'GET',
                data: { id: idPostre },
                success: function (response) {
                    listaPostres.innerHTML += response;

                    // Agregar el precio del postre al arreglo de precios si no existe
                    if (!preciosEnCarrito[index]) {
                        let tempDiv = document.createElement('div');
                        tempDiv.innerHTML = response;
                        let precio = parseFloat(tempDiv.querySelector('.postre-info p').textContent.replace('Precio: $', ''));
                        preciosEnCarrito.push(precio);
                        localStorage.setItem("preciosEnCarrito", JSON.stringify(preciosEnCarrito));
                    }

                    // Calcular el total después de añadir el precio
                    calcularTotal();
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener detalles del postre:', error);
                }
            });
        });
    } else {
        listaPostres.innerHTML = "<p>El carrito está vacío.</p>";
        document.getElementById("total").innerHTML = "Total: $0.00";
    }

    // Función para limpiar el carrito
    function limpiarCarrito() {
        localStorage.removeItem('postresEnCarrito');
        localStorage.removeItem('preciosEnCarrito');
        location.reload();
    }

    // Función para quitar un postre específico del carrito
    function quitarDelCarrito(idPostre) {
        // Eliminar el ID del postre y su precio correspondiente
        const index = postresEnCarrito.indexOf(idPostre);
        if (index > -1) {
            postresEnCarrito.splice(index, 1);
            preciosEnCarrito.splice(index, 1);

            // Actualizar localStorage
            localStorage.setItem("postresEnCarrito", JSON.stringify(postresEnCarrito));
            localStorage.setItem("preciosEnCarrito", JSON.stringify(preciosEnCarrito));
            
            // Recargar la página para actualizar el carrito
            location.reload();
        }
    }
</script>


</body>

</html>
<?php include('footer.php'); ?>