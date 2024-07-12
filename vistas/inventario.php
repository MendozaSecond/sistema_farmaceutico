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
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body class="inventario">
    <div class="cabecera">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></h1>
            <a href="../controladores/ControladorUsuario.php?action=logout">Cerrar Sesión</a>
        </div>
    </div>
    <div class="titulo">
        <h1>Inventario de Medicinas</h1>
    </div>
    <!-- Formulario para agregar nueva medicina -->
    <div class="inventario_cuerpo">
        <form action="../controladores/ControladorInventario.php?action=agregar" method="post">

            <div class="agg_inventario_box">
                <div class="login-header">
                    <span>Agregar</span>
                </div>
                <div class="input_box">
                    <input type="text" name="nombre" id="nombre" class="input-field" required>
                    <label for="nombre" class="label">Nombre:</label>
                </div>
                <div class="input_box">
                    <input type="text" name="descripcion" id="descripcion" class="input-field" required>
                    <label for="descripcion" class="label">Descripción:</label>
                </div>
                <div class="input_box">
                    <input type="number" name="precio" id="precio" step="0.01" class="input-field" required>
                    <label for="precio" class="label">Precio:</label>
                </div>
                <div class="input_box">
                    <input type="number" name="cantidad" id="cantidad" class="input-field" required>
                    <label for="cantidad" class="label">Cantidad:</label>
                </div>
                <div class="input_box">
                    <input type="submit" class="input-submit" value="Agregar">
                </div>
            </div>

        </form>
        <div class="espacio"></div>
        <!-- Lista de medicinas en el inventario -->
        <div class="medicinas_box">
            <div class="login-header">
                <span>Medicinas</span>
            </div>
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
        </div>
    </div>
</body>

</html>