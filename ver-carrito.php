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
    <style>
        .div-Login {
            display: flex;
            flex-wrap: nowrap;
            justify-content: center;
            align-items: baseline;
            align-content: flex-start;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.315);
            max-width: auto;
            height: auto;
            margin: 1rem;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            margin-top: 0px;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.315);
            max-width: 300px;
            height: auto;
            margin: 1rem;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            margin-top: 30px;
        }
        .input-text {
            box-shadow: inset #e571c7 0 0 0 2px;
            border: 0;
            background: rgba(255, 255, 255);
            appearance: none;
            width: 100%;
            position: relative;
            border-radius: 0px;
            padding: 0px 0px;
            line-height: 1.4;
            color: rgb(0, 0, 0);
            font-size: 16px;
            font-weight: 400;
            height: 40px;
            transition: all .2s ease;
            border-radius: 10px;

            :hover {
                box-shadow: 0 0 0 0 #fff inset, #1de9b6 0 0 0 2px;
            }

            :focus {
                background: #fff;
                outline: 0;
                box-shadow: 0 0 0 0 #fff inset, #1de9b6 0 0 0 3px;
            }
        }

        .postre-info {
            text-align: center;
        }
        .postre-info img {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .postre-info h3 {
            margin-top: 0;
        }
        .input-textTarjeta{
            box-shadow: inset #e571c7 0 0 0 2px;
            border: 0;
            background: rgba(255, 255, 255);
            appearance: none;
            width: 5rem;
            position: relative;
            border-radius: 0px;
            padding: 0px 0px;
            line-height: 1.4;
            color: rgb(0, 0, 0);
            font-size: 16px;
            font-weight: 400;
            height: 40px;
            transition: all .2s ease;
            border-radius: 10px;
        }
        .form-groupTarjeta{
            display: flex;
        }
    </style>
</head>
<body>

    <h2 id="carrito">Carrito de Compras</h2>
    <div class="div-Login">
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
        <div class="login-container">
            <h2>Datos del cliente:</h2>
            <form action="procesar-orden-varios.php" method="POST" onsubmit="return validarFecha()">
                <input type="hidden" name="idPostre" value="<?php echo isset($_POST['idPostre']) ? $_POST['idPostre'] : ''; ?>">
                <div class="form-group">
                    <input type="text" placeholder="   Nombre Completo" id="nombre" name="nombre" class="input-text" required>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="   Ejemplo@gmail.com" id="correo" name="correo" class="input-text" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono del Cliente:</label>
                    <input type="tel" placeholder="   10 Digitos" id="telefono" name="telefono" class="input-text" required minlength="10" maxlength="10">
                </div>
                <div class="form-group">
                    <label for="fecha_entrega">Fecha de Entrega:</label>
                    <input type="date"  id="fecha_entrega" name="fecha_entrega" class="input-text" required>
                </div>
                <div class="form-group">
                    <label for="calle">Calle:</label>
                    <input type="text" placeholder="  Nombre completo de la calle" id="calle" name="calle" class="input-text" required minlength="10">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="  Numero exterior #" placeholder="10 Digitos" id="numero" name="numero" class="input-text" required>
                </div>
                
                <div class="form-group">
                    <label for="numero_tarjeta">Datos de Tarjeta:</label>
                    <input type="text" placeholder="#### #### #### ####" id="numero_tarjeta" name="numero_tarjeta" class="input-text" minlength="16" maxlength="16">
                </div>
                <div class="form-groupTarjeta">
                    <div>
                        <input type="text" placeholder="CVV" id="cv" name="cv" class="input-textTarjeta" required minlength="3" maxlength="4">
                        <input placeholder=" 00/00" type="text" id="fecha_vencimiento" name="fecha_vencimiento" class="input-textTarjeta" required minlength="5" maxlength="5">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" onclick="limpiarCarrito()"> Enviar Orden</button>
            </form>
        </div>
    </div>

    
    <h2 id="total">Total: </h2>
    <div>
       <button class="btn btn-danger" onclick="limpiarCarrito()">Limpiar carrito</button>
    </div>

    <script>
        let postresEnCarrito = JSON.parse(localStorage.getItem("postresEnCarrito"));
        var total = 0;
        if (postresEnCarrito) {
            postresEnCarrito.forEach(function(postre) {
                total += parseInt(postre.precio);
            });
            document.getElementById("total").innerHTML = "Total: $" + total.toFixed(2);
        }
        
    </script>
    <script>
    function quitarDelCarrito(idPostre) {
        let postresEnCarrito = JSON.parse(localStorage.getItem("postresEnCarrito"));
        postresEnCarrito = postresEnCarrito.filter(postre => postre.id !== idPostre);

        localStorage.setItem("postresEnCarrito", JSON.stringify(postresEnCarrito));

        location.reload();
    }
    </script>
</body>
</html>
<?php include('footer.php'); ?>