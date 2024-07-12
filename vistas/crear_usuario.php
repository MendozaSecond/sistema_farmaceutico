<!DOCTYPE html>
<html>

<head>
    <title>Crear Usuario</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <form action="../controladores/ControladorUsuario.php?action=crear_usuario" method="post">
        <div class="wrapper">
            <div class="login_box">
                <input type="hidden" name="action" value="crear_usuario">
                <div class="login-header">
                    <span>Crear Usuario</span>
                </div>
                <div class="input_box">
                    <input type="text" name="nombre_usuario" id="nombre_usuario" class="input-field" required>
                    <label for="nombre_usuario" class="label">Nombre de Usuario:</label>
                </div>
                <div class="input_box">
                    <input type="password" name="contrasena" id="contrasena" class="input-field" required>
                    <label for="contrasena" class="label">Contraseña:</label>
                </div>
                <label for="rol">Rol:</label>
                <div class="input_box">
                    <select name="rol" id="rol" class="input-field" required>
                        <option value="bodeguero" class="">Bodeguero</option>
                        <option value="vendedor">Vendedor</option>
                    </select>
                </div>
                <div class="input_box">
                    <input type="submit" class="input-submit" value="Crear Usuario">
                </div>
                <div class="registrar">
                    <span><a href="login.php">Volver a Iniciar Sesión</a></span>
                </div>
            </div>
        </div>
    </form>
</body>

</html>