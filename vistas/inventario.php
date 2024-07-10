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
    <title>Inventario</title>
</head>
<body>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></h1>
        <a href="../controladores/ControladorUsuario.php?action=logout">Cerrar Sesión</a>
    </div>

    <h2>Inventario de Medicinas</h2>

    <!-- Formulario para agregar nueva medicina -->
    <form action="../controladores/ControladorInventario.php?action=agregar" method="post">
        <h3>Agregar Medicina</h3>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br>
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" id="descripcion" required>
        <br>
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" step="0.01" required>
        <br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" required>
        <br>
        <button type="submit">Agregar</button>
    </form>

    <hr>

    <!-- Lista de medicinas en el inventario -->
    <h3>Lista de Medicinas</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once '../config/database.php';
            include_once '../modelos/Inventario.php';

            $database = new Database();
            $db = $database->getConnection();
            $inventario = new Inventario($db);
            $stmt = $inventario->leer();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$nombre}</td>";
                echo "<td>{$descripcion}</td>";
                echo "<td>{$precio}</td>";
                echo "<td>{$cantidad}</td>";
                echo "<td>";
                echo "<a href='editar_medicina.php?id={$id}'>Editar</a>";
                echo " | ";
                echo "<a href='../controladores/ControladorInventario.php?action=eliminar&id={$id}'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
