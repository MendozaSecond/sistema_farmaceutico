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
    <a href="registrar_venta.php">Registrar Nueva Venta</a>
    <br><br>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Cédula</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $venta->leer();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$fecha}</td>";
                echo "<td>{$nombre_cliente}</td>";
                echo "<td>{$cedula_cliente}</td>";
                echo "<td>";
                echo "<a href='editar_venta.php?id={$id}'>Editar</a> ";
                echo "<a href='../controladores/ControladorVenta.php?action=eliminar&id={$id}'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
