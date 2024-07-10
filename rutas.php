<?php
session_start();

if(!isset($_SESSION['usuario_id'])) {
    header("Location: vistas/login.php");
    exit;
}

if($_SESSION['rol'] == 'bodeguero') {
    header("Location: vistas/inventario.php");
} elseif($_SESSION['rol'] == 'vendedor') {
    header("Location: vistas/ventas.php");
}
?>