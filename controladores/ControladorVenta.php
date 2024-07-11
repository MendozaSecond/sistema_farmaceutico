<?php
include_once '../config/database.php';
include_once '../modelos/Venta.php';
include_once '../modelos/DetalleVenta.php';

class ControladorVenta {
    private $db;
    private $venta;
    private $detalleVenta;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->venta = new Venta($this->db);
        $this->detalleVenta = new DetalleVenta($this->db);
    }

    public function registrar() {
        if ($_POST && isset($_POST['nombre_cliente']) && isset($_POST['cedula_cliente']) && isset($_POST['id_medicina']) && isset($_POST['cantidad'])) {
            $this->venta->nombre_cliente = $_POST['nombre_cliente'];
            $this->venta->cedula_cliente = $_POST['cedula_cliente'];

            if ($this->venta->registrar()) {
                $venta_id = $this->venta->id;

                foreach ($_POST['id_medicina'] as $index => $id_medicina) {
                    $this->detalleVenta->venta_id = $venta_id;
                    $this->detalleVenta->id_medicina = $id_medicina;
                    $this->detalleVenta->cantidad = $_POST['cantidad'][$index];
                    $this->detalleVenta->registrar();
                }

                header("Location: ../vistas/ventas.php");
                exit;
            } else {
                echo "Error al registrar la venta.";
            }
        }
    }

    public function actualizar() {
        if ($_POST && isset($_POST['id']) && isset($_POST['nombre_cliente']) && isset($_POST['cedula_cliente']) && isset($_POST['id_medicina']) && isset($_POST['cantidad']) && isset($_POST['detalle_id'])) {
            $this->venta->id = $_POST['id'];
            $this->venta->nombre_cliente = $_POST['nombre_cliente'];
            $this->venta->cedula_cliente = $_POST['cedula_cliente'];

            if ($this->venta->actualizar()) {
                foreach ($_POST['detalle_id'] as $index => $detalle_id) {
                    if ($detalle_id == 0) {
                        $this->detalleVenta->venta_id = $this->venta->id;
                        $this->detalleVenta->id_medicina = $_POST['id_medicina'][$index];
                        $this->detalleVenta->cantidad = $_POST['cantidad'][$index];
                        $this->detalleVenta->registrar();
                    } else {
                        $this->detalleVenta->id = $detalle_id;
                        $this->detalleVenta->id_medicina = $_POST['id_medicina'][$index];
                        $this->detalleVenta->cantidad = $_POST['cantidad'][$index];
                        $this->detalleVenta->actualizar();
                    }
                }

                header("Location: ../vistas/ventas.php");
                exit;
            } else {
                echo "Error al actualizar la venta.";
            }
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $this->venta->id = $_GET['id'];
            if ($this->venta->eliminar()) {
                header("Location: ../vistas/ventas.php");
                exit;
            } else {
                echo "Error al eliminar la venta.";
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
    } elseif ($_GET['action'] == 'eliminar') {
        $controladorVenta->eliminar();
    }
}
?>