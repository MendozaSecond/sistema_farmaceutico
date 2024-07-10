<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include_once '../config/database.php';
include_once '../modelos/Venta.php';
include_once '../modelos/DetalleVenta.php';
include_once '../modelos/Inventario.php';

$database = new Database();
$db = $database->getConnection();
$venta = new Venta($db);
$detalleVenta = new DetalleVenta($db);
$inventario = new Inventario($db);

if (isset($_GET['id'])) {
    $venta->id = $_GET['id'];
    $venta->leerUno();
    $stmtDetalle = $detalleVenta->leerPorVenta($venta->id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Venta</title>
</head>
<body>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></h1>
        <a href="../controladores/ControladorUsuario.php?action=logout">Cerrar Sesión</a>
    </div>

    <h2>Editar Venta</h2>

    <form action="../controladores/ControladorVenta.php?action=actualizar" method="post">
        <input type="hidden" name="id" value="<?php echo $venta->id; ?>">

        <h3>Cabecera</h3>
        <label for="nombre_cliente">Nombre del Cliente:</label>
        <input type="text" name="nombre_cliente" id="nombre_cliente" value="<?php echo $venta->nombre_cliente; ?>" required>
        <br>
        <label for="cedula_cliente">Cédula del Cliente:</label>
        <input type="text" name="cedula_cliente" id="cedula_cliente" value="<?php echo $venta->cedula_cliente; ?>" required>
        <br>

        <h3>Detalle</h3>
        <div id="detalles">
            <?php
            while ($rowDetalle = $stmtDetalle->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='detalle'>";
                echo "<input type='hidden' name='detalle_id[]' value='{$rowDetalle['id']}'>";
                echo "<label for='id_medicina'>Medicina:</label>";
                echo "<select name='id_medicina[]' required>";
                $stmt = $inventario->leer();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($rowDetalle['id_medicina'] == $row['id']) ? "selected" : "";
                    echo "<option value='{$row['id']}' {$selected}>{$row['nombre']} - {$row['descripcion']}</option>";
                }
                echo "</select>";
                echo "<label for='cantidad'>Cantidad:</label>";
                echo "<input type='number' name='cantidad[]' min='1' value='{$rowDetalle['cantidad']}' required>";
                echo "<button type='button' onclick='eliminarDetalle(this)'>Eliminar</button>";
                echo "<br>";
                echo "</div>";
            }
            ?>
        </div>
        <button type="button" onclick="agregarDetalle()">Agregar Producto</button>
        <br><br>
        <button type="submit">Actualizar Venta</button>
    </form>

    <script>
        function agregarDetalle() {
            const detalles = document.getElementById('detalles');
            const detalle = document.createElement('div');
            detalle.className = 'detalle';
            detalle.innerHTML = `
                <input type='hidden' name='detalle_id[]' value='0'>
                <label for='id_medicina'>Medicina:</label>
                <select name='id_medicina[]' required>
                    <?php
                    $stmt = $inventario->leer();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['nombre']} - {$row['descripcion']}</option>";
                    }
                    ?>
                </select>
                <label for='cantidad'>Cantidad:</label>
                <input type='number' name='cantidad[]' min='1' required>
                <button type='button' onclick='eliminarDetalle(this)'>Eliminar</button>
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