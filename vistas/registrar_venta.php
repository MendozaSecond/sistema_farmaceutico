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
    <script>
        function actualizarTotal() {
            let totalVenta = 0;
            const productos = document.querySelectorAll('.producto');
            productos.forEach(producto => {
                const precioUnitario = parseFloat(producto.querySelector('.precio_unitario').value) || 0;
                const cantidad = parseInt(producto.querySelector('.cantidad').value) || 0;
                const totalProducto = precioUnitario * cantidad;
                producto.querySelector('.total_producto').value = totalProducto.toFixed(2);
                totalVenta += totalProducto;
            });
            document.getElementById('total_venta').innerText = totalVenta.toFixed(2);
        }

        function agregarProducto() {
            const productos = document.getElementById('productos');
            const nuevoProducto = document.createElement('div');
            nuevoProducto.className = 'producto';
            nuevoProducto.innerHTML = `
                <select class="medicina" name="medicinas[]">
                    <?php
                    $stmt = $inventario->leer();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<option value='{$id}' data-precio='{$precio}'>{$nombre}</option>";
                    }
                    ?>
                </select>
                <input type="number" class="cantidad" name="cantidad[]" min="1" value="1" oninput="actualizarTotal()">
                <input type="number" class="precio_unitario" name="precio_unitario[]" readonly>
                <input type="number" class="total_producto" name="total_producto[]" readonly>
                <br><br>
            `;
            productos.appendChild(nuevoProducto);
            actualizarPrecios();
        }

        function actualizarPrecios() {
            const productos = document.querySelectorAll('.producto');
            productos.forEach(producto => {
                const medicinaSelect = producto.querySelector('.medicina');
                medicinaSelect.addEventListener('change', function() {
                    const precio = parseFloat(this.options[this.selectedIndex].getAttribute('data-precio'));
                    producto.querySelector('.precio_unitario').value = precio.toFixed(2);
                    actualizarTotal();
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            agregarProducto();
            document.getElementById('agregar_producto').addEventListener('click', agregarProducto);
        });
    </script>
</head>
<body>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></h1>
        <a href="../controladores/ControladorUsuario.php?action=logout">Cerrar Sesión</a>
    </div>

    <h2>Registrar Venta</h2>

    <form action="../controladores/ControladorVenta.php?action=registrar" method="post">
        <label for="nombre_cliente">Nombre del Cliente:</label>
        <input type="text" id="nombre_cliente" name="nombre_cliente" required><br><br>

        <label for="cedula_cliente">Cédula del Cliente:</label>
        <input type="text" id="cedula_cliente" name="cedula_cliente" required><br><br>

        <div id="productos"></div>
        <button type="button" id="agregar_producto">Agregar Producto</button><br><br>

        <label>Total de la Venta: $<span id="total_venta">0.00</span></label><br><br>

        <button type="submit">Registrar Venta</button>
        <button type="button" onclick="window.location.href='ventas.php'">Cancelar</button>
    </form>
</body>
</html>
