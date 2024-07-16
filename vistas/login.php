<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <div class="sesion">
        <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'usuario_creado') : ?>
            <p1>Usuario creado exitosamente.</p1>
        <?php endif; ?>
        <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'usuario_incorrecto') : ?>
            <strong>
                <p1>Nombre de usuario o contraseña incorrectos.</p1>
            </strong>
        <?php endif; ?>
    </div>

    <form action="../controladores/ControladorUsuario.php?action=login" method="post">
        <div class="wrapper">

            <div class="login_box">
                <input type="hidden" name="action" value="login">
                <div class="login-header">
                    <span>Iniciar Sesión</span>
                </div>
                <div class="input_box">
                    <input type="text" name="nombre_usuario" id="nombre_usuario" class="input-field" required>
                    <label for="nombre_usuario" class="label">Nombre de Usuario:</label>
                </div>
                <div class="input_box">
                    <input type="password" name="contrasena" id="contrasena" class="input-field" required>
                    <label for="contrasena" class="label">Contraseña:</label>
                </div>
                <div class="input_box">
                    <input type="submit" class="input-submit" value="Iniciar Sesión">
                </div>
                <div class="registrar">
                    <span>¿No tienes una cuenta? <a href="crear_usuario.php">Crear usuario</a></span>
                </div>
            </div>
        </div>
    </form>

</body>

</html>