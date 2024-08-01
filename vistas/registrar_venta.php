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
    <link rel="stylesheet" type="text/css" href="../css/style.css">
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
                <select class="medicina select_Venta" name="medicinas[]">
                 <option value="0" selected>- Seleccione medicina -</option>
                    <?php
                    $stmt = $inventario->leer();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<option value='{$id}' data-precio='{$precio}'>{$nombre}</option>";
                    }
                    ?>
                </select>
                <input type="number" class="cantidad input_venta" name="cantidad[]" min="1" value="1" oninput="actualizarTotal()">
                <input type="number" class="precio_unitario input_venta" name="precio_unitario[]" readonly>
                <input type="number" class="total_producto input_venta" name="total_producto[]" readonly>
                
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

<body class="venta">
    <div class="cabecera">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></h1>
            <a href="../controladores/ControladorUsuario.php?action=logout">Cerrar Sesión</a>
        </div>
    </div>
    <div class="titulo">
        <h1>Registrar Venta</h1>
    </div>

    <!-- Formulario para registrar venta -->
    <form action="../controladores/ControladorVenta.php?action=registrar" method="post">
        <div class="inventario_cuerpo ">
            <div class="agg_venta_box">
                <div class="login-header">
                    <span>Factura</span>
                </div>
                <div class="input_box">
                    <input type="text" id="nombre_cliente" name="nombre_cliente" class="input-field" required>
                    <label for="nombre_cliente" class="label">Nombre del Cliente:</label>
                </div>

                <div class="input_box">
                    <input type="text" id="cedula_cliente" name="cedula_cliente" class="input-field" required><br>
                    <label for="cedula_cliente" class="label">Cédula del Cliente:</label>
                </div>
                <div class="input_box">
                    <div id="productos"></div>
                </div>

                <input type="button" id="agregar_producto" value="+" class="input-submit">

                <div class="total-venta-container">
                    <label>Total de la Venta: $<span id="total_venta">0.00</span></label><br>
                </div>

                <div class="input_box">
                    <input type="submit" value="Vender" class="input-submit">
                    <br>
                    <input type="button" onclick="window.location.href='ventas.php'" value="Cancelar" class="input-submit">
                </div>
            </div>
        </div>
    </form>
</body>

</html>