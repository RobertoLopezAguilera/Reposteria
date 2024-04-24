<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nuevo Postre</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
            .div-Login{
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: baseline;
                align-content: flex-start;
            }

            .login-container {
                background-color: rgba(255, 255, 255, 0.315);
                max-width: 300px;
                height: 545px;
                margin: 1rem;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                text-align: center;
                margin-top: 50px;
            }

            .input-text{
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
                    :hover{
                        box-shadow: 0 0 0 0 #fff inset, #1de9b6 0 0 0 2px;
                    }
                    :focus{
                        background: #fff;
                        outline: 0;
                        box-shadow: 0 0 0 0 #fff inset, #1de9b6 0 0 0 3px;
                    }
                
            }
        </style>
    <script>
        function actualizarTamaño() {
            var categoria = document.getElementById("categoria").value;
            var tamañoSelect = document.getElementById("tamaño");

            tamañoSelect.innerHTML = '';

            if (categoria === "Galletas" || categoria === "Cupcake") {
                var opciones = ["6 Pzs", "12 Pzs"];
            } else {
                var opciones = ["Grande", "Mediano", "Chico"];
            }
            for (var i = 0; i < opciones.length; i++) {
                var opcion = opciones[i];
                var elemento = document.createElement("option");
                elemento.textContent = opcion;
                tamañoSelect.appendChild(elemento);
            }
        }
    </script>
</head>
<body>
    <div class="div-Login">
        <div class="login-container">
            <h2>Registrar Nuevo Postre</h2>
            <form class="registro-form" action="registro-postre.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" id="nombre" name="nombre" required placeholder="Nombre del postre" class="input-text">
                </div>
                <div class="form-group">
                    <select id="categoria" name="categoria" required class="input-text" onchange="actualizarTamaño()">
                        <option value="" disabled selected>Seleccione una categoría</option>
                        <option value="Pastel">Pastel</option>
                        <option value="Gelatina">Gelatina</option>
                        <option value="Cupcake">Cupcake</option>
                        <option value="Galletas">Galletas</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="tamaño" name="tamaño" required class="input-text">
                        <option value="" disabled selected>Seleccione un tamaño</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" id="sabor" name="sabor" required placeholder="Sabor" class="input-text">
                </div>
                <div class="form-group">
                    <input type="text" id="ingredientes" name="ingredientes" required placeholder="Ingredientes" class="input-text">
                </div>
                <div class="form-group">
                    <input type="number" id="precio" name="precio" required placeholder="Precio" class="input-text">
                </div>
                <div class="form-group">
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>
                <div class="form-group">
                    <select id="estado" name="estado" required class="input-text">
                        <option value="" disabled selected>Seleccione el estado</option>
                        <option value="Disponible">Disponible</option>
                        <option value="Agotado">Agotado</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-secondary">Registrar Postre</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php include('footer.php');?>