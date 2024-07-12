<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include_once '../config/database.php';
include_once '../modelos/Venta.php';

$database = new Database();
$db = $database->getConnection();
$venta = new Venta($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ventas</title>
</head>
<body>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></h1>
        <a href="../controladores/ControladorUsuario.php?action=logout">Cerrar Sesión</a>
    </div>

    <h2>Ventas Registradas</h2>
    <button onclick="window.location.href='registrar_venta.php'">Registrar Nueva Venta</button>
    <br><br>

    <table border="1">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Cédula</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $venta->leer();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                echo "<td>{$fecha}</td>";
                echo "<td>{$nombre_cliente}</td>";
                echo "<td>{$cedula_cliente}</td>";
                echo "<td>{$total}</td>";
                echo "<td>";
                echo "<button onclick=\"window.location.href='editar_venta.php?id={$id}'\">Editar</button>";
                echo "<button onclick=\"window.location.href='../controladores/ControladorVenta.php?action=eliminar&id={$id}'\">Eliminar</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
