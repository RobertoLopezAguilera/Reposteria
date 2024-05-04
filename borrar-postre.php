<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idPostre'])) {
        include('includes/conexion.php');

        // Obtener el ID del postre a eliminar
        $idPostre = $_POST['idPostre'];

        // Consulta SQL para eliminar el postre
        $sql_delete = "DELETE FROM Postre WHERE idPostre = $idPostre";

        if ($conn->query($sql_delete) === TRUE) {
            echo "<script>alert('El postre ha sido eliminado correctamente.');</script>";
            header("Location: borrar-postre.php");
        } else {
            echo "<script>alert('Error al eliminar el postre.');</script>";
        }

        $conn->close();
    }
?>
