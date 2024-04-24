<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mensaje = '';
if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'inicio_sesion') {
    $mensaje = '<p style="color: red;">Debes iniciar sesión primero para acceder a esta página.</p>';
}
?>

<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        .div-Login {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: baseline;
            align-content: flex-start;
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
</head>
<body>
<div class="div-Login">
    <div class="login-container">
        <?php
        if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'inicio_sesion') {
            echo '<p style="color: red;">Debes iniciar sesión primero para acceder a esta página.</p>';
        }
        ?>
        <p>¿Aún no tienes cuenta?</p>
        <h2>Regístrate ahora</h2>
        <form class="login-form" action="procesar-registro.php" method="POST">
            <div class="form-group">
                <input type="text" id="usuario" name="usuario" required size="30px" placeholder="Usuario" required pattern="[a-zA-Z0-9_]+" minlength="7" class="input-text">
            </div>
            <div class="form-group">
                <input type="email" id="correo" name="correo" required size="30px" placeholder="Correo electrónico" class="input-text">
            </div>
            <div class="form-group">
                <input type="password" id="contrasena" name="contrasena" required size="30px" placeholder="Contraseña" class="input-text">
            </div>
            <div class="form-group">
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required size="30px" placeholder="Confirmar Contraseña" class="input-text">
            </div>
            <div class="form-group">
                <button type="submit" class="login-button">Registrarme</button>
            </div>
        </form>
    </div>
</div>


<img src="img/Group 3.png" class="img-Slogan">
<img src="img/image 26.png" class="img-Slogan">
</body>
</html>
<?php include('footer.php');?>
