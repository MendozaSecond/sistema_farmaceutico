<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include_once '../config/database.php';
include_once '../modelos/Inventario.php';

$database = new Database();
$db = $database->getConnection();
$inventario = new Inventario($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar Venta</title>
</head>
<body>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></h1>
        <a href="../controladores/ControladorUsuario.php?action=logout">Cerrar Sesión</a>
    </div>

    <h2>Registrar Venta</h2>

    <form action="../controladores/ControladorVenta.php?action=registrar" method="post">
        <h3>Cabecera</h3>
        <label for="nombre_cliente">Nombre del Cliente:</label>
        <input type="text" name="nombre_cliente" id="nombre_cliente" required>
        <br>
        <label for="cedula_cliente">Cédula del Cliente:</label>
        <input type="text" name="cedula_cliente" id="cedula_cliente" required>
        <br>

        <h3>Detalle</h3>
        <div id="detalles">
            <div class="detalle">
                <label for="id_medicina">Medicina:</label>
                <select name="id_medicina[]" required>
                    <?php
                    $stmt = $inventario->leer();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<option value='{$id}'>{$nombre} - {$descripcion}</option>";
                    }
                    ?>
                </select>
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad[]" min="1" required>
                <button type="button" onclick="eliminarDetalle(this)">Eliminar</button>
                <br>
            </div>
        </div>
        <button type="button" onclick="agregarDetalle()">Agregar Producto</button>
        <br><br>
        <button type="submit">Registrar Venta</button>
        ||
        <button type="button" onclick="window.history.back()">Cancelar</button>
    </form>

    <script>
        function agregarDetalle() {
            const detalles = document.getElementById('detalles');
            const detalle = document.createElement('div');
            detalle.className = 'detalle';
            detalle.innerHTML = `
                <label for="id_medicina">Medicina:</label>
                <select name="id_medicina[]" required>
                    <?php
                    $stmt = $inventario->leer();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<option value='{$id}'>{$nombre} - {$descripcion}</option>";
                    }
                    ?>
                </select>
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad[]" min="1" required>
                <button type="button" onclick="eliminarDetalle(this)">Eliminar</button>
                <br>
            `;
            detalles.appendChild(detalle);
        }

        function eliminarDetalle(button) {
            button.parentElement.remove();
        }
    </script>
</body>
</html>