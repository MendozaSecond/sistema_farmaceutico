<?php
class DetalleVenta {
    private $conn;
    private $table_name = "detalles_venta";

    public $id;
    public $id_venta;
    public $id_medicina;
    public $cantidad;
    public $precio_unitario;
    public $total_producto;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " SET id_venta=:id_venta, id_medicina=:id_medicina, cantidad=:cantidad, precio_unitario=:precio_unitario, total_producto=:total_producto";
        $stmt = $this->conn->prepare($query);

        $this->id_venta = htmlspecialchars(strip_tags($this->id_venta));
        $this->id_medicina = htmlspecialchars(strip_tags($this->id_medicina));
        $this->cantidad = htmlspecialchars(strip_tags($this->cantidad));
        $this->precio_unitario = htmlspecialchars(strip_tags($this->precio_unitario));
        $this->total_producto = htmlspecialchars(strip_tags($this->total_producto));

        $stmt->bindParam(':id_venta', $this->id_venta);
        $stmt->bindParam(':id_medicina', $this->id_medicina);
        $stmt->bindParam(':cantidad', $this->cantidad);
        $stmt->bindParam(':precio_unitario', $this->precio_unitario);
        $stmt->bindParam(':total_producto', $this->total_producto);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function leerPorVenta($id_venta) {
        $query = "SELECT dv.*, m.nombre, m.descripcion FROM " . $this->table_name . " dv LEFT JOIN medicinas m ON dv.id_medicina = m.id WHERE dv.id_venta = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_venta);
        $stmt->execute();
        return $stmt;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET id_medicina=:id_medicina, cantidad=:cantidad WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":id_medicina", $this->id_medicina);
        $stmt->bindParam(":cantidad", $this->cantidad);
        $stmt->bindParam(':precio_unitario', $this->precio_unitario);
        $stmt->bindParam(':total_producto', $this->total_producto);

        return $stmt->execute();
    }

    public function eliminarPorVenta($id_venta) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_venta = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_venta);
        return $stmt->execute();
    }
}
?>