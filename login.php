<?php
session_start();
?>
<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="css/estilo.css">
        <style>
            .div-Login{
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
    <?php
        if (isset($_SESSION['error'])) {
            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        ?>
    <div class="div-Login">
        <div class="login-container">
            <p>¿Ya tienes cuenta?</p>
            <h2>Inicia sesíon aquí</h2>
            <form class="login-form" action="procesar-login.php" method="POST">
                <div class="form-group">
                    <input type="text" id="usuario" name="usuario" required size="30px" placeholder="   Usuario"
                    required pattern="[a-zA-Z0-9_]+" minlength="7" class="input-text">
                </div>
                <div class="form-group">
                    <input type="password" id="contrasena" name="contrasena" required size="30px" placeholder="   Constraseña"
                    class="input-text">
                </div>
                <div class="form-group">
                    <input type="checkbox"><label for="">Mantener sesíon iniciada</label>
                </div>
                <div class="form-group">
                    <button type="submit" class="login-button">Iniciar Sesión</button>
                </div>
            </form>
            <p><a class="register-link" href="registro.php">Registrar</a></p>
        </div>
    </div>
</body>
</html>
<?php include('footer.php');?>