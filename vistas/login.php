<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'usuario_creado'): ?>
        <p>Usuario creado exitosamente.</p>
    <?php endif; ?>

    <form action="../controladores/ControladorUsuario.php?action=login" method="post">
        <input type="hidden" name="action" value="login">
        <h2>Iniciar Sesión</h2>
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>

    <p>¿No tienes una cuenta? <a href="crear_usuario.php">Crear usuario</a></p>
</body>
</html>