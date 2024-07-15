<?php
include_once '../config/database.php';
include_once '../modelos/Venta.php';
include_once '../modelos/DetalleVenta.php';

$database = new Database();
$db = $database->getConnection();

$venta = new Venta($db);
$detalle_venta = new DetalleVenta($db);

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'registrar':
        $venta->nombre_cliente = $_POST['nombre_cliente'];
        $venta->cedula_cliente = $_POST['cedula_cliente'];
        $venta->total = array_sum($_POST['total_producto']);

        if ($venta->registrar()) {
            foreach ($_POST['medicinas'] as $index => $id_medicina) {
                $detalle_venta->id_venta = $venta->id;
                $detalle_venta->id_medicina = $id_medicina;
                $detalle_venta->cantidad = $_POST['cantidad'][$index];
                $detalle_venta->precio_unitario = $_POST['precio_unitario'][$index];
                $detalle_venta->total_producto = $_POST['total_producto'][$index];
                $detalle_venta->registrar();
            }
            header("Location: ../vistas/ventas.php");
        } else {
            echo "Error al registrar la venta.";
        }
        break;

    case 'eliminar':
        $venta->id = $_GET['id'];
        if ($venta->eliminar()) {
            header("Location: ../vistas/ventas.php");
        } else {
            echo "Error al eliminar la venta.";
        }
        break;

    case 'actualizar':
        $venta->id = $_GET['id'];
        $venta->nombre_cliente = $_POST['nombre_cliente'];
        $venta->cedula_cliente = $_POST['cedula_cliente'];
        $venta->total = array_sum($_POST['total_producto']);

        if ($venta->actualizar()) {
            $detalle_venta->id_venta = $venta->id;
            $detalle_venta->eliminarPorVenta($venta->id);

            foreach ($_POST['medicinas'] as $index => $id_medicina) {
                $detalle_venta->id_venta = $venta->id;
                $detalle_venta->id_medicina = $id_medicina;
                $detalle_venta->cantidad = $_POST['cantidad'][$index];
                $detalle_venta->precio_unitario = $_POST['precio_unitario'][$index];
                $detalle_venta->total_producto = $_POST['total_producto'][$index];
                $detalle_venta->registrar();
            }
            header("Location: ../vistas/ventas.php");
        } else {
            echo "Error al actualizar la venta.";
        }
        break;
}
