<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

if (isset($_GET['id'])) {
    $inventario->id = $_GET['id'];
    $inventario->leerUno();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar Medicina</title>
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
        <h1>Actualizar</h1>
    </div>

    <!-- Formulario para editar medicina -->
    <form action="../controladores/ControladorInventario.php?action=editar" method="post">
        <div class="inventario_cuerpo">
            <div class="agg_inventario_box">
                <div class="login-header">
                    <span>Medicina</span>
                </div>
                <input type="hidden" name="id" value="<?php echo $inventario->id; ?>">
                <div class="input_box">
                    <input type="text" name="nombre" id="nombre" class="input-field" value="<?php echo $inventario->nombre; ?>" required>
                    <label for="nombre" class="label">Nombre:</label>
                </div>
                <div class="input_box">
                <input type="text" name="descripcion" id="descripcion" class="input-field" value="<?php echo $inventario->descripcion; ?>" required>
                <label for="descripcion" class="label">Descripción:</label>
                </div> 
                <div class="input_box">
                <input type="number" name="precio" id="precio" step="0.01" class="input-field" value="<?php echo $inventario->precio; ?>" required>
                <label for="precio" class="label">Precio:</label>
                </div>
                <div class="input_box">
                <input type="number" name="cantidad" id="cantidad" class="input-field" value="<?php echo $inventario->cantidad; ?>" required>
                <label for="cantidad" class="label">Cantidad:</label>
                </div> 
                <div class="input_box">
                <input type="submit" value="Actualizar" class="input-submit">
                <br>
                <input type="button" onclick="window.history.back()" value="Cancelar" class="input-submit">
            </div>
        </div>
    </form>

</body>

</html>