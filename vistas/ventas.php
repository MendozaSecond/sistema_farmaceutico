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
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body class="venta">
    <div class="cabecera">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></h1>
            <a href="../controladores/ControladorUsuario.php?action=logout">Cerrar Sesión</a>
        </div>
    </div>
    <div class="titulo">
        <h1>Ventas Registradas</h1>
    </div>
    <div class="inventario_cuerpo">
        <div class="agg_inventario_box">
            <div class="login-header">
                <span>Caja</span>
            </div>
            <div class="input_box">
                <img class="centrar_imagen" src="../img/caja.png" alt="Caja Venta" onclick="window.location.href='registrar_venta.php'">
                <br>
                <input type="submit" class="input-submit" onclick="window.location.href='registrar_venta.php'" value="Registrar Nueva Venta">
            </div>
        </div>

        <div class="espacio"></div>
        <!-- Lista de Facturas -->
        <div class="medicinas_box">
            <div class="login-header">
                <span>Facturas</span>
            </div>
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
                        echo "<a href='editar_venta.php?id={$id}'>Editar</a>";
                        echo " | ";
                        echo "<a href='../controladores/ControladorVenta.php?action=eliminar&id={$id}'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>