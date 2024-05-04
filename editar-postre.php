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
    <title>Editar Postre</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
    crossorigin="anonymous">
</head>
<body>
    <?php
        include('includes/conexion.php');
        if(isset($_GET['id']) && is_numeric($_GET['id'])) {
            // Obtener el id del postre
            $idPostre = $_GET['id'];
        
            // Consultar la base de datos para obtener los detalles del postre con el id proporcionado
            $sql = "SELECT * FROM Postre WHERE idPostre = $idPostre";
            $result = $conn->query($sql);

            // Verificar si se encontró el postre
            if ($result->num_rows > 0) {
                $postre = $result->fetch_assoc();
    ?>
    <div class = "div-Login">
        <div class = "login-containerPostre">
        <h1>Editar Postre</h1>
        <form action="procesar-edicion-postre.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="idPostre" value="<?php echo $postre['idPostre']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Postre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $postre['Nombre']; ?>" required minlength="6" maxlength="35">
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select id="categoria" name="categoria" required class="form-select" onchange="actualizarTamaño()">
                    <option value="" disabled selected>Seleccione una categoría</option>
                    <option value="Pastel" <?php if($postre['Categoria'] == 'Pastel') echo 'selected'; ?>>Pastel</option>
                    <option value="Gelatina" <?php if($postre['Categoria'] == 'Gelatina') echo 'selected'; ?>>Gelatina</option>
                    <option value="Cupcake" <?php if($postre['Categoria'] == 'Cupcake') echo 'selected'; ?>>Cupcake</option>
                    <option value="Galletas" <?php if($postre['Categoria'] == 'Galletas') echo 'selected'; ?>>Galletas</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tamaño" class="form-label">Tamaño</label>
                <select id="tamaño" name="tamaño" required class="form-select">
                    <option value="" disabled selected>Seleccione un tamaño</option>
                    <?php
                        $opciones = ($postre['Categoria'] === 'Galletas' || $postre['Categoria'] === 'Cupcake') ? ["6 Pzs", "12 Pzs"] : ["Grande", "Mediano", "Chico"];
                        foreach ($opciones as $opcion) {
                            echo "<option value='$opcion'";
                            if ($postre['Tamaño'] == $opcion) {
                                echo " selected";
                            }
                            echo ">$opcion</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="sabor" class="form-label">Sabor</label>
                <input type="text" class="form-control" id="sabor" name="sabor" value="<?php echo $postre['Sabor']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="ingredientes" class="form-label">Ingredientes</label>
                <input type="text" class="form-control" id="ingredientes" name="ingredientes" value="<?php echo $postre['Ingredientes']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" value="<?php echo $postre['Precio']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="Disponible" <?php echo ($postre['Estado'] === 'Disponible') ? 'selected' : ''; ?>>Disponible</option>
                    <option value="Agotado" <?php echo ($postre['Estado'] === 'Agotado') ? 'selected' : ''; ?>>Agotado</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Postre</label>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
        </div>
    </div>
    <?php
            } else {
                echo "<p>No se encontró el postre.</p>";
            }
            $conn->close();
        }
    ?>
</body>
</html>
<?php include('footer.php'); ?>
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