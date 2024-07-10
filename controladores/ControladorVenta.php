<?php
include_once '../config/database.php';
include_once '../modelos/Venta.php';

class ControladorVenta {
    private $db;
    private $venta;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->venta = new Venta($this->db);
    }

    public function registrar() {
        if ($_POST && isset($_POST['id_medicina']) && isset($_POST['cantidad'])) {
            $this->venta->medicina_id = $_POST['id_medicina'];
            $this->venta->cantidad = $_POST['cantidad'];

            if ($this->venta->registrar()) {
                header("Location: ../vistas/ventas.php");
                exit;
            } else {
                echo "Error al registrar la venta.";
            }
        }
    }

    public function actualizar() {
        if ($_POST && isset($_POST['id']) && isset($_POST['id_medicina']) && isset($_POST['cantidad'])) {
            $this->venta->id = $_POST['id'];
            $this->venta->medicina_id = $_POST['id_medicina'];
            $this->venta->cantidad = $_POST['cantidad'];

            if ($this->venta->actualizar()) {
                header("Location: ../vistas/ventas.php");
                exit;
            } else {
                echo "Error al actualizar la venta.";
            }
        }
    }
}

$controladorVenta = new ControladorVenta();
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'registrar') {
        $controladorVenta->registrar();
    } elseif ($_GET['action'] == 'actualizar') {
        $controladorVenta->actualizar();
    }
}
?>