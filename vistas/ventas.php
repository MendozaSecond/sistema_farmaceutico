<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
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

    <h2>Registro de Ventas</h2>

    <!-- Formulario para registrar nueva venta -->
    <form action="../controladores/ControladorVenta.php?action=registrar" method="post">
        <h3>Registrar Venta</h3>
        <label for="medicina_id">Medicina:</label>
        <select name="medicina_id" id="medicina_id" required>
            <?php
            include_once '../config/database.php';
            include_once '../modelos/Inventario.php';

            $database = new Database();
            $db = $database->getConnection();
            $medicina = new Inventario($db);
            $stmt = $medicina->leer(); // Método para obtener medicinas activas

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<option value='{$id}'>{$nombre} - {$descripcion}</option>";
            }
            ?>
        </select>
        <br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" min="1" required>
        <br>
        <button type="submit">Registrar Venta</button>
    </form>

    <hr>

    <!-- Lista de ventas registradas -->
    <h3>Historial de Ventas</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Medicina</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once '../modelos/Venta.php';

            $venta = new Venta($db);
            $stmt = $venta->leer(); // Método para obtener todas las ventas

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$nombre_medicina}</td>";
                echo "<td>{$cantidad}</td>";
                echo "<td>{$fecha}</td>";
                echo "<td>";
                echo "<a href='editar_venta.php?id={$id}'>Editar</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>