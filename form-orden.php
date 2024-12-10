<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Orden</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        .div-Login {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: baseline;
    align-content: flex-start;
    margin: 1rem 0;
}

/* Adaptación para pantallas pequeñas */
@media (max-width: 768px) {
    .div-Login {
        flex-direction: column; /* Cambia la dirección a columna para pantallas pequeñas */
        align-items: center;
    }
}

.input-text {
    box-shadow: inset #e571c7 0 0 0 2px;
    border: 0;
    background: rgba(255, 255, 255);
    appearance: none;
    width: 100%; /* Ocupará todo el ancho disponible */
    max-width: 300px; /* Máximo ancho para mantener consistencia */
    position: relative;
    border-radius: 0px;
    padding: 0px 10px;
    line-height: 1.4;
    color: rgb(0, 0, 0);
    font-size: 16px;
    font-weight: 400;
    height: 40px;
    transition: all .2s ease;
    border-radius: 10px;
    margin: 0.3rem;
}

/* Estilos de enfoque y hover para mejorar usabilidad */
.input-text:hover {
    box-shadow: 0 0 0 0 #fff inset, #1de9b6 0 0 0 2px;
}

.input-text:focus {
    background: #fff;
    outline: 0;
    box-shadow: 0 0 0 0 #fff inset, #1de9b6 0 0 0 3px;
}

/* Información del postre */
.postre-info {
    text-align: center;
    margin: 2rem 0;
}

.postre-info img {
    max-width: 200px;
    margin-bottom: 20px;
}

.postre-info h3 {
    margin-top: 0;
}

/* Responsividad para pantallas pequeñas */
@media (max-width: 768px) {
    .postre-info img {
        max-width: 150px; /* Reducir tamaño en pantallas pequeñas */
    }
}

/* Estilo para el input pequeño */
.input-textTarjeta {
    box-shadow: inset #e571c7 0 0 0 2px;
    border: 0;
    background: rgba(255, 255, 255);
    appearance: none;
    width: 5rem; /* Ancho específico para este campo */
    max-width: 80%; /* Mantener responsividad */
    position: relative;
    border-radius: 0px;
    padding: 0px 10px;
    line-height: 1.4;
    color: rgb(0, 0, 0);
    font-size: 16px;
    font-weight: 400;
    height: 40px;
    transition: all .2s ease;
    border-radius: 10px;
}

/* Agrupación de formulario */
.form-groupTarjeta {
    display: flex;
    flex-wrap: wrap; /* Permitir ajuste de elementos */
    gap: 10px; /* Espacio entre elementos */
    justify-content: space-around; /* Distribuir de manera uniforme */
}

/* Media queries para pantallas más pequeñas */
@media (max-width: 768px) {
    .form-groupTarjeta {
        flex-direction: column; /* Columna en lugar de fila en pantallas pequeñas */
        align-items: center;
    }
}

/* Ajustes generales para pequeños dispositivos */
@media (max-width: 480px) {
    .input-text {
        width: 100%; /* Ocupa todo el ancho disponible */
    }

    .input-textTarjeta {
        width: 100%; /* Ajustar también en pantallas pequeñas */
        max-width: 200px; /* Controlar el tamaño máximo */
    }
}

    </style>
</head>
<body>
    <h2>Realiza tu pedido en nuestra sucursal
    <a href="https://www.google.com/maps/search/?api=1&query=Respostería+Piña">Sucursal en tu zona</a>
    </h2>
    
    <div class="div-Login">
        <div class="login-container">
        <div class="postre-info">
                <h2>Detalles de tu postre</h2>
                <?php
                include('includes/conexion.php');

                if(isset($_POST['idPostre']) && is_numeric($_POST['idPostre'])) {
                    $idPostre = $_POST['idPostre'];
                    $sql = "SELECT Nombre, Precio, Imagen FROM Postre WHERE idPostre = $idPostre";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<h3>" . $row['Nombre'] . "</h3>";
                        echo "<p>Precio: $" . $row['Precio'] . "</p>";
                        echo "<img src='data:image/jpeg;base64," . base64_encode($row['Imagen']) . "' alt='Imagen del pastel'>";
                    } else {
                        echo "No se encontró información del pastel.";
                    }
                } else {
                    echo "No se proporcionó un ID de pastel válido.";
                }

                $conn->close();
                ?>
            </div>
        </div>
        <div class="login-container">
            <h2>Pedir a domicilio</h2>
            <form action="procesar-orden.php" method="POST" onsubmit="return validarFecha()">
                <input type="hidden" name="idPostre" value="<?php echo isset($_POST['idPostre']) ? $_POST['idPostre'] : ''; ?>">
                <div class="form-group">
                    <input type="text" placeholder="   Nombre Completo" id="nombre" name="nombre" class="input-text" minlength="10" required pattern="[A-Za-z]*">
                </div>

                <div class="form-group">
                    <input  type="text" placeholder="   Ejemplo@gmail.com" id="correo" name="correo" class="input-text" 
                    pattern="[A-Za-z]*+@[A-Za-z]*+\.[A-Za-z]*\.[A-Za-z]{2,}" required>
                    
                </div>
                
                <div class="form-group">
                    <label for="telefono">Teléfono del Cliente:</label>
                    <input type="tel" placeholder="   10 Digitos" id="telefono" name="telefono" class="input-text" required minlength="10" maxlength="10"
                    pattern="[0-9]*">
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
                    <input type="text" placeholder="  Numero exterior #" placeholder="10 Digitos" id="numero" name="numero" class="input-text" required pattern="[0-9]*">
                </div>
                
                <div class="form-group">
                    <label for="numero_tarjeta">Datos de Tarjeta:</label>
                    <input type="text" placeholder="#### #### #### ####" id="numero_tarjeta" name="numero_tarjeta" class="input-text" minlength="16" maxlength="16" pattern="[0-9]*">
                </div>
                <div class="form-groupTarjeta">
                    <div>
                        <input type="text" placeholder="CVV" id="cv" name="cv" class="input-textTarjeta" required minlength="3" maxlength="4" pattern="[0-9]*">
                        <input placeholder=" 00/00" type="text" id="fecha_vencimiento" name="fecha_vencimiento" class="input-textTarjeta" required minlength="5" maxlength="5">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Enviar Orden</button>
            </form>
        </div>
        <div class="login-container">
            <h2>Retirar en sucursal</h2>
            <form action="procesar-orden-sucursal.php" method="POST" onsubmit="return validarFecha()">
                <input type="hidden" name="idPostre" value="<?php echo isset($_POST['idPostre']) ? $_POST['idPostre'] : ''; ?>">       
                <div class="form-group">
                    <input type="text" placeholder="   Nombre Completo" id="nombre" name="nombre" class="input-text" required pattern="[A-Za-z]*" minlength="10">
                </div>
                <div class="form-group">
                    <label for="fecha_entrega">Fecha de Entrega:</label>
                    <input type="date"  id="fecha_entrega" name="fecha_entrega" class="input-text" required>
                </div>
                <div class="form-group">
                    <label for="numero_tarjeta">Datos de Tarjeta:</label>
                    <input type="text" placeholder="#### #### #### ####" id="numero_tarjeta" name="numero_tarjeta" class="input-text" minlength="16" maxlength="16" pattern="[0-9]*">
                </div>
                <div class="form-groupTarjeta">
                    <div>
                        <input type="text" placeholder="CVV" id="cv" name="cv" class="input-textTarjeta" required minlength="3" maxlength="3" pattern="[0-9]*">
                        <input placeholder=" 00/00" type="text" id="fecha_vencimiento" name="fecha_vencimiento" class="input-textTarjeta" required minlength="5" maxlength="5">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Enviar Orden</button>
            </form>
        </div>
    </div>

    <script>
        function validarFecha() {
            var fechaEntrega = document.getElementById('fecha_entrega').value;
            var hoy = new Date();
            var fechaSeleccionada = new Date(fechaEntrega);
            var tresDiasDespues = new Date();
            tresDiasDespues.setDate(hoy.getDate() + 3);

            if (fechaSeleccionada < tresDiasDespues) {
                alert('La fecha de entrega debe ser al menos 3 días en el futuro.');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
<?php include('footer.php'); ?>
