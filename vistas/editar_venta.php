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

$venta->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Registro de venta no encontrado.');
$venta->leerUno();
$detalleVenta->id_venta = $venta->id;
$detalles = $detalleVenta->leerPorVenta($venta->id);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Venta</title>
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

        function agregarProducto(id = '', cantidad = 1, precioUnitario = 0, totalProducto = 0) {
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
                <input type="number" class="cantidad" name="cantidad[]" min="1" value="${cantidad}" oninput="actualizarTotal()">
                <input type="number" class="precio_unitario" name="precio_unitario[]" value="${precioUnitario}" readonly>
                <input type="number" class="total_producto" name="total_producto[]" value="${totalProducto}" readonly>
                <br><br>
            `;
            productos.appendChild(nuevoProducto);
            actualizarPrecios();

            // Seleccionar el producto adecuado
            if (id !== '') {
                const select = nuevoProducto.querySelector('.medicina');
                select.value = id;
                const precio = parseFloat(select.options[select.selectedIndex].getAttribute('data-precio'));
                nuevoProducto.querySelector('.precio_unitario').value = precio.toFixed(2);
                actualizarTotal();
            }
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
            <?php foreach ($detalles as $detalle) { ?>
                agregarProducto('<?php echo $detalle['id_medicina']; ?>', '<?php echo $detalle['cantidad']; ?>', '<?php echo $detalle['precio_unitario']; ?>', '<?php echo $detalle['total_producto']; ?>');
            <?php } ?>
            document.getElementById('agregar_producto').addEventListener('click', () => agregarProducto());
        });
    </script>
</head>
<body>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></h1>
        <a href="../controladores/ControladorUsuario.php?action=logout">Cerrar Sesión</a>
    </div>

    <h2>Editar Venta</h2>

    <form action="../controladores/ControladorVenta.php?action=actualizar&id=<?php echo $venta->id; ?>" method="post">
        <label for="nombre_cliente">Nombre del Cliente:</label>
        <input type="text" id="nombre_cliente" name="nombre_cliente" value="<?php echo $venta->nombre_cliente; ?>" required><br><br>

        <label for="cedula_cliente">Cédula del Cliente:</label>
        <input type="text" id="cedula_cliente" name="cedula_cliente" value="<?php echo $venta->cedula_cliente; ?>" required><br><br>

        <div id="productos"></div>
        <button type="button" id="agregar_producto">Agregar Producto</button><br><br>

        <label>Total de la Venta: $<span id="total_venta">0.00</span></label><br><br>

        <button type="submit">Actualizar Venta</button>
        <button type="button" onclick="window.location.href='ventas.php'">Cancelar</button>
    </form>
</body>
</html>
