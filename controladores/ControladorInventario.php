<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once '../config/database.php';
include_once '../modelos/Inventario.php';

class ControladorInventario {
    private $db;
    private $inventario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->inventario = new Inventario($this->db);
    }

    public function agregar() {
        if ($_POST && isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['precio']) && isset($_POST['cantidad'])) {
            $this->inventario->nombre = $_POST['nombre'];
            $this->inventario->descripcion = $_POST['descripcion'];
            $this->inventario->precio = $_POST['precio'];
            $this->inventario->cantidad = $_POST['cantidad'];

            if ($this->inventario->agregar()) {
                header("Location: ../vistas/inventario.php");
                exit;
            } else {
                echo "Error al agregar la medicina.";
            }
        } else {
            echo "Datos incompletos.";
        }
    }

    public function editar() {
        if ($_POST && isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['precio']) && isset($_POST['cantidad'])) {
            $this->inventario->id = $_POST['id'];
            $this->inventario->nombre = $_POST['nombre'];
            $this->inventario->descripcion = $_POST['descripcion'];
            $this->inventario->precio = $_POST['precio'];
            $this->inventario->cantidad = $_POST['cantidad'];

            if ($this->inventario->editar()) {
                header("Location: ../vistas/inventario.php");
                exit;
            } else {
                echo "Error al editar la medicina.";
            }
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $this->inventario->id = $_GET['id'];
            if ($this->inventario->eliminar()) {
                header("Location: ../vistas/inventario.php");
                exit;
            } else {
                echo "Error al eliminar la medicina.";
            }
        }
    }
}

$inventarioControlador = new ControladorInventario();
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'agregar') {
        $inventarioControlador->agregar();
    } elseif ($_GET['action'] == 'editar') {
        $inventarioControlador->editar();
    } elseif ($_GET['action'] == 'eliminar') {
        $inventarioControlador->eliminar();
    }
}
?>