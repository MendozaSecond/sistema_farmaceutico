<!DOCTYPE html>
<html>
<head>
    <title>Crear Usuario</title>
</head>
<body>
    <form action="../controladores/ControladorUsuario.php?action=crear_usuario" method="post">
        <input type="hidden" name="action" value="crear_usuario">
        <h2>Crear Usuario</h2>
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>
        <br>
        <label for="rol">Rol:</label>
        <select name="rol" id="rol" required>
            <option value="bodeguero">Bodeguero</option>
            <option value="vendedor">Vendedor</option>
        </select>
        <br>
        <button type="submit">Crear Usuario</button>
    </form>

    <p><a href="login.php">Volver a Iniciar Sesión</a></p>
</body>
</html>