<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include_once '../config/database.php';
include_once '../modelos/Inventario.php';

$database = new Database();
$db = $database->getConnection();
$inventario = new Inventario($db);

if (isset($_GET['id'])) {
    $inventario->id = $_GET['id'];
    $inventario->leerUno();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Medicina</title>
</head>
<body>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Bienvenido, <?php echo $_SESSION['usuario_id']; ?></h1>
        <a href="../controladores/ControladorUsuario.php?action=logout">Cerrar Sesión</a>
    </div>

    <h2>Editar Medicina</h2>

    <!-- Formulario para editar medicina -->
    <form action="../controladores/ControladorInventario.php?action=editar" method="post">
        <input type="hidden" name="id" value="<?php echo $inventario->id; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $inventario->nombre; ?>" required>
        <br>
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" id="descripcion" value="<?php echo $inventario->descripcion; ?>" required>
        <br>
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" step="0.01" value="<?php echo $inventario->precio; ?>" required>
        <br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" value="<?php echo $inventario->cantidad; ?>" required>
        <br>
        <br>
        <button type="submit">Actualizar</button>
        ||
        <button type="button" onclick="window.history.back()">Cancelar</button>
    </form>

</body>
</html>