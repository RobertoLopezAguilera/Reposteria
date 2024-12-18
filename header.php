<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repostería Piña</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        .div-buscador {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            align-items: center;
        }
        /* Estilo para el contador del carrito */
        .cart-count {
            background-color: #ff0000;
            color: #fff;
            border-radius: 50%;
            padding: 3px 8px;
            font-size: 14px;
            position: absolute;
            top: -5px;
            right: -10px;
        }
        /* Contenedor del carrito */
        .cart-container {
            position: relative;
            display: inline-block;
        }
    </style>
</head>
<body>    
    <header>
        <div class="div-buscador">
            <img src="img/Logo.jpeg" class="img-Logo">
            <form action="catalogo.php" method="GET" class="div-buscador">
                <input type="text" name="buscar" placeholder="Buscar por nombre..." class="input-buscador">
            </form>
            <button type="submit" class="boton-buscar">Buscar</button>
        </div>
        <div>
            <nav>
                <ul>
                <li><a href="index.php">Inicio</a></li>
                        <li><a href="conocenos.php">Conocenos</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropbtn">Categorías</a>
                            <div class="dropdown-content">
                                <a href="catalogo.php?categoria=pastel">Pasteles</a>
                                <a href="catalogo.php?categoria=Galletas">Galletas</a>
                                <a href="catalogo.php?categoria=gelatina">Gelatinas</a>
                                <a href="catalogo.php?categoria=cupcake">Cupcakes</a>
                                <a href="catalogo.php">Todos los postres</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropbtn">Tamaño</a>
                            <div class="dropdown-content">
                                <a href="catalogo.php?tamaño=Grande">Grande</a>
                                <a href="catalogo.php?tamaño=Mediano">Mediano</a>
                                <a href="catalogo.php?tamaño=Chico">Chico</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropbtn">Precio</a>
                            <div class="dropdown-content">
                            <a href="catalogo.php?precio=200">Menos de $200</a>
                            <a href="catalogo.php?precio=300">Menos de $300</a>
                            <a href="catalogo.php?precio=400">Menos de $400</a>
                            <a href="catalogo.php?precio=600">Menos de $500</a>
                            <a href="catalogo.php?precio=600">Menos de $600</a>
                            <a href="catalogo.php?precio=700">Menos de $700</a>
                            <a href="catalogo.php?precio=800">Más de $700</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropbtn">Sabor</a>
                            <div class="dropdown-content">
                                <a href="catalogo.php?sabor=chocolate">Chocolate</a>
                                <a href="catalogo.php?sabor=vainilla">Vainilla</a>
                                <a href="catalogo.php?sabor=fresa">Fresa</a>
                            </div>
                        </li>
                        <li><a href="https://www.google.com/maps/search/?api=1&query=Respostería+Piña+Uriangato+Guanajuato" target="_blank">Sucursales</a></li>
                        <li><a href="Promociones.php">Promociones</a></li>
                        <li><a href="kks.php">Crear Pastel</a></li>
                        <li class="dropdown">
                        <a class="nav-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm3-3a4 4 0 1 0-6.828 2.829A6 6 0 0 0 1 14h14a6 6 0 0 0-3.172-6.172A4 4 0 0 0 11 5z"/>
                                </svg>
                                </a>
                            <div class="dropdown-content">
                                <a href="cerrar-sesion.php">Cerrar cesion</a>
                                <a href="form-postre.php">Registrar postre</a>
                                <a href="registro.php">Registrar Usuario</a>
                                <a href="calendario.php?start=2024-05-01&end=2024-05-31">Pedidos</a>
                                <a href="catalago-postres.php">Editar catalago</a>
                            </div>
                        </li>
                    <li class="cart-container">
                        <a href="ver-carrito.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                            </svg>
                            <span id="cart-count" class="cart-count" style="display: none;"></span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <script>
        // Función para mostrar el número de postres en el carrito
        function actualizarContadorCarrito() {
            const postresEnCarrito = JSON.parse(localStorage.getItem('postresEnCarrito')) || [];
            const cartCountElement = document.getElementById('cart-count');

            if (postresEnCarrito.length > 0) {
                cartCountElement.textContent = postresEnCarrito.length;
                cartCountElement.style.display = 'inline';
            } else {
                cartCountElement.style.display = 'none';
            }
        }

        // Llama a la función cuando se carga la página
        document.addEventListener('DOMContentLoaded', actualizarContadorCarrito);
    </script>
</body>
</html>
