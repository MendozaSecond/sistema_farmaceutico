<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo "Conexión exitosa";
} else {
    echo "Error de conexión";
}
?>
