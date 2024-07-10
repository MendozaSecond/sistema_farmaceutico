<?php
session_start();
include_once '../config/database.php';
include_once '../modelos/Usuario.php';

class ControladorUsuario {
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function login() {
        if ($_POST && isset($_POST['action']) && $_POST['action'] == 'login') {
            $this->usuario->nombre_usuario = $_POST['nombre_usuario'];
            $this->usuario->contrasena = $_POST['contrasena'];
            if ($this->usuario->login()) {
                $_SESSION['usuario_id'] = $this->usuario->id;
                $_SESSION['nombre_usuario'] = $this->usuario->nombre_usuario;
                $_SESSION['rol'] = $this->usuario->rol;
                header("Location: ../index.php");
            } else {
                echo "Nombre de usuario o contraseña incorrectos.";
            }
        } else {
            echo "No se recibió un formulario de inicio de sesión válido.";
        }
    }

    public function crearUsuario() {
        if ($_POST && isset($_POST['action']) && $_POST['action'] == 'crear_usuario') {
            $this->usuario->nombre_usuario = $_POST['nombre_usuario'];
            $this->usuario->contrasena = $_POST['contrasena'];
            $this->usuario->rol = $_POST['rol'];

            if ($this->usuario->crearUsuario()) {
                header("Location: ../vistas/login.php?mensaje=usuario_creado");
            } else {
                echo "Error al crear el usuario.";
            }
        } else {
            echo "No se recibió un formulario de creación de usuario válido.";
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ../vistas/login.php");
    }
}

$usuarioControlador = new ControladorUsuario();
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'logout') {
        $usuarioControlador->logout();
    } elseif ($_GET['action'] == 'crear_usuario') {
        $usuarioControlador->crearUsuario();
    } else {
        $usuarioControlador->login();
    }
} else {
    $usuarioControlador->login();
}
?>