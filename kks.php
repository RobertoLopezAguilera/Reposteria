<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Pastel</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        .select-text {
    box-shadow: inset #e571c7 0 0 0 2px;
    border: 0;
    background: rgba(255, 255, 255);
    appearance: none;
    width: 100%;
    position: relative;
    border-radius: 0px;
    padding: 0px 10px; /* Añadido un poco de padding horizontal */
    line-height: 1.4;
    color: rgb(0, 0, 0);
    font-size: 16px;
    font-weight: 400;
    height: 40px;
    transition: all .2s ease;
    border-radius: 10px;
}

.select-text:hover {
    box-shadow: 0 0 0 0 #fff inset, #1de9b6 0 0 0 2px;
}

.select-text:focus {
    background: #fff;
    outline: 0;
    box-shadow: 0 0 0 0 #fff inset, #1de9b6 0 0 0 3px;
}

/* Agregar un icono de flecha de selección personalizado */
.select-text::after {
    content: "▼";
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    pointer-events: none;
    color: #e571c7;
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
        .figura {
    display: inline-block;
    padding: 10px;
    border: 2px solid #ccc;
    cursor: pointer;
    margin: 5px;
    transition: background-color 0.3s, color 0.3s, border 0.3s;
    text-align: center;
}
.figura.selected {
    color: white;
    border: 2px solid black;
}
#circulo {
    border-radius: 50%;
    width: 60px;
    height: 60px;
    line-height: 60px;
}
#cuadrado {
    width: 60px;
    height: 60px;
    line-height: 60px;
}
#rectangulo {
    border-radius: 5px;
    width: 100px;
    height: 60px;
    line-height: 60px;
}
.ingrediente {
    display: inline-block;
    padding: 10px;
    border: 2px solid #ccc;
    cursor: pointer;
    margin: 5px;
    text-align: center;
    transition: background-color 0.3s, color 0.3s;
}
.ingrediente.selected {
    color: white;
    border: 2px solid black;
}
    </style>
    <script>
        let ingredientesSeleccionados = 0;

        function seleccionarFigura(figura) {
            var figuras = document.getElementsByClassName("figura");
            for (var i = 0; i < figuras.length; i++) {
                if (figuras[i].id === figura) {
                    figuras[i].classList.add("selected");
                    figuras[i].classList.remove("unselected");
                    cambiarColor(figura);
                } else {
                    figuras[i].classList.remove("selected");
                    figuras[i].style.backgroundColor = "";
                    figuras[i].style.color = "";
                    figuras[i].style.border = "2px solid #ccc";
                }
            }
            document.getElementById("figuraSeleccionada").value = figura;
        }

        function cambiarColor(figura) {
            var sabor = document.getElementById("sabor").value;
            var color;
            switch (sabor) {
                case "fresa":
                    color = "pink";
                    break;
                case "vainilla":
                    color = "yellow";
                    break;
                case "chocolate":
                    color = "#d2b48c";
                    break;
                case "nutella":
                    color = "#5b3a29";
                    break;
                case "cacahuate":
                    color = "#f5f5dc";
                    break;
                case "3 leches":
                    color = "white";
                    break;
                case "napolitano":
                    color = "gray";
                    break;
                default:
                    color = "#ccc";
            }
            var figuraElemento = document.getElementById(figura);
            figuraElemento.style.backgroundColor = color;
        }

        function seleccionarIngrediente(ingrediente, color) {
            const ingredienteElemento = document.getElementById(ingrediente);

            if (!ingredienteElemento.classList.contains("selected")) {
                if (ingredientesSeleccionados < 5) {
                    ingredienteElemento.classList.add("selected");
                    ingredienteElemento.style.backgroundColor = color;
                    ingredientesSeleccionados++;
                } else {
                    alert("Solo puedes seleccionar un máximo de 5 ingredientes.");
                }
            } else {
                ingredienteElemento.classList.remove("selected");
                ingredienteElemento.style.backgroundColor = "";
                ingredientesSeleccionados--;
            }

            actualizarPrecio(); // Actualizar el precio después de seleccionar/deseleccionar un ingrediente
        }

        function reiniciarIngredientes() {
            const ingredientes = document.getElementsByClassName("ingrediente");
            for (let i = 0; i < ingredientes.length; i++) {
                ingredientes[i].classList.remove("selected");
                ingredientes[i].style.backgroundColor = "";
            }
            ingredientesSeleccionados = 0;
            actualizarPrecio(); // Actualizar el precio después de reiniciar los ingredientes
        }

        function actualizarPrecio() {
            var tamano = document.getElementById("tamano").value;
            var precioBase;

            // Precio base según el tamaño
            switch (tamano) {
                case "chico":
                    precioBase = 80;
                    break;
                case "mediano":
                    precioBase = 120;
                    break;
                case "grande":
                    precioBase = 200;
                    break;
                case "extra grande":
                    precioBase = 280;
                    break;
                default:
                    precioBase = 0;
            }

            // Precio adicional por cada ingrediente seleccionado
            const precioPorIngrediente = 20;
            var precioTotal = precioBase + (ingredientesSeleccionados * precioPorIngrediente);

            document.getElementById("precio").value = precioTotal;
        }
    </script>
</head>
<body>
<div class="div-Login">
<div class="login-container">
    <h1>Crea tu propio pastel</h1>
    <form action="insertar_pastel.php" method="POST">        
        <label for="tamano">Tamaño:</label><br>
        <select id="tamano" name="tamano" onchange="actualizarPrecio()" required class="select-text">
            <option value="chico">Chico</option>
            <option value="mediano">Mediano</option>
            <option value="grande">Grande</option>
            <option value="extra grande">Extra Grande</option>
        </select><br><br>
        
        <label for="sabor">Sabor:</label><br>
        <select class="select-text" id="sabor" name="sabor" onchange="actualizarPrecio(); cambiarColor('circulo'); cambiarColor('cuadrado'); cambiarColor('rectangulo');" required>
            <option value="fresa">Fresa</option>
            <option value="vainilla">Vainilla</option>
            <option value="chocolate">Chocolate</option>
            <option value="cacahuate">Cacahuate</option>
            <option value="nutella">Nutella</option>
            <option value="3 leches">3 Leches</option>
            <option value="napolitano">Napolitano</option>
        </select><br><br>

        <label for="precio">Precio:</label><br>
        <input type="number" id="precio" name="precio" value="80" readonly class="input-text"><br><br>

        <!-- Botones para seleccionar figura -->
        <h2>Selecciona la figura:</h2>
        <div class="figura" id="circulo" onclick="seleccionarFigura('circulo')">Círculo</div>
        <div class="figura" id="cuadrado" onclick="seleccionarFigura('cuadrado')">Cuadrado</div>
        <div class="figura" id="rectangulo" onclick="seleccionarFigura('rectangulo')">Rectángulo</div>
        
        <!-- Campo oculto para guardar la figura seleccionada -->
        <input type="hidden" id="figuraSeleccionada" name="figuraSeleccionada">

        <!-- Leyenda e ingredientes -->
        <h2>Puedes seleccionar hasta un máximo de 5 ingredientes:</h2>
        <div class="ingrediente" id="fresas" onclick="seleccionarIngrediente('fresas', 'pink')">Fresas</div>
        <div class="ingrediente" id="frambuesas" onclick="seleccionarIngrediente('frambuesas', 'red')">Frambuesas</div>
        <div class="ingrediente" id="platano" onclick="seleccionarIngrediente('platano', 'yellow')">Plátano</div>
        <div class="ingrediente" id="mms" onclick="seleccionarIngrediente('mms', '#d2b48c')">M&Ms</div>
        <div class="ingrediente" id="uvas" onclick="seleccionarIngrediente('uvas', 'green')">Uvas</div>
        <div class="ingrediente" id="nutella" onclick="seleccionarIngrediente('nutella', '#5b3a29')">Nutella</div>
        <div class="ingrediente" id="oreos" onclick="seleccionarIngrediente('oreos', 'white')">Oreos</div>

        <!-- Botón de reiniciar -->
        <button class="btn btn-secondary" type="button" onclick="reiniciarIngredientes()">Reiniciar</button><br><br>

        <input class="btn btn-primary" type="submit" value="Comprar pastel pastel">
    </form>
    </div>
    </div>
</body>
</html>
<?php include('footer.php'); ?>
