<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include_once '../config/database.php';
include_once '../modelos/Venta.php';
include_once '../modelos/Inventario.php';

$database = new Database();
$db = $database->getConnection();
$venta = new Venta($db);
$inventario = new Inventario($db);

if (isset($_GET['id'])) {
    $venta->id = $_GET['id'];
    $venta->leerUno();
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
        
        <label for="id_medicina">Medicina:</label>
        <select name="id_medicina" id="id_medicina" required>
            <?php
            $stmt = $inventario->leer();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $selected = ($venta->medicina_id == $id) ? "selected" : "";
                echo "<option value='{$id}' {$selected}>{$nombre} - {$descripcion}</option>";
            }
            ?>
        </select>
        <br>
        
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" min="1" value="<?php echo $venta->cantidad; ?>" required>
        <br>
        
        <button type="submit">Actualizar Venta</button>
    </form>
</body>
</html>