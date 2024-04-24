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

<?php include('includes/conexion.php'); ?>

<?php
    $sql = "SELECT idOrden, Estado, Fecha_Entrega FROM Orden";
    $result = $conn->query($sql);
    $eventos = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $color = '';
            switch ($row['Estado']) {
                case 'Pendiente':
                    $color = '#FFA500';
                    break;
                case 'Preparación':
                    $color = '#FFFF00';
                    break;
                case 'Entregado':
                    $color = '#008000';
                    break;
                default:
                    $color = '#007bff';
            }

            $evento = [
                'id' => $row['idOrden'],
                'title' => $row['Estado'],
                'start' => $row['Fecha_Entrega'],
                'color' => $color,
            ];
            $eventos[] = $evento;
        }
    }
?>

<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <style>
        .containerCalendar {
            background-image: linear-gradient(to left, rgb(169, 240, 245), rgb(255, 172, 248), #e3f1ff);
        }
        
    </style>
</head>
<body>
    <div class="containerCalendar">
        <div class="col-md-10 offset-md-1">
            <div id='calendar'></div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: <?php echo json_encode($eventos); ?>,
                eventClick: function(info) {
                    console.log(info.event.id);
                    var form = document.createElement('form');
                    form.method = 'post';
                    form.action = 'detalles-orden.php';
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'idOrden';
                    input.value = info.event.id;
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
            calendar.render();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <?php 
        // Consulta para obtener la suma de los postres vendidos
        $sql_suma_postres = "SELECT SUM(d.Total) AS total_venta, DATE_FORMAT(o.Fecha_Entrega, '%Y-%m-%d') AS fecha FROM DetalleOrden d
        INNER JOIN Orden o ON d.Orden_idOrden = o.idOrden
        WHERE o.Fecha_Entrega BETWEEN ? AND ?
        GROUP BY DATE_FORMAT(o.Fecha_Entrega, '%Y-%m-%d')";

        // Obtener la fecha de inicio y fin basada en la vista actual del calendario
        $start = $_GET['start'];
        $end = $_GET['end'];

        // Preparar y ejecutar la consulta para la suma de postres vendidos
        $stmt = $conn->prepare($sql_suma_postres);
        $stmt->bind_param('ss', $start, $end);
        $stmt->execute();
        $suma_postres = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        // Mostrar la tabla con la suma de postres vendidos
        echo "<p></p>";
        echo "<table class='table-datos'>";
        echo "<tr><th>Fecha</th><th>Total de ventas</th><th>Acciones</th></tr>";
        foreach ($suma_postres as $venta) {
            echo "<tr>";
            echo "<td> {$venta['fecha']}</td>";
            echo "<td>  \${$venta['total_venta']}</td>";
            echo "<td><a href='detalles-venta.php?fecha={$venta['fecha']}' class='boton-buscar'>Ver</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p></p>";
    ?>
</body>
</html>
<?php include('footer.php'); ?>
<?php $conn->close(); ?>
