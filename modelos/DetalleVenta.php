<?php
class DetalleVenta {
    private $conn;
    private $table_name = "detalles_venta";

    public $id;
    public $venta_id;
    public $id_medicina;
    public $cantidad;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " SET venta_id=:venta_id, id_medicina=:id_medicina, cantidad=:cantidad";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":venta_id", $this->venta_id);
        $stmt->bindParam(":id_medicina", $this->id_medicina);
        $stmt->bindParam(":cantidad", $this->cantidad);

        return $stmt->execute();
    }

    public function leerPorVenta($venta_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE venta_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $venta_id);
        $stmt->execute();
        return $stmt;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET id_medicina=:id_medicina, cantidad=:cantidad WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":id_medicina", $this->id_medicina);
        $stmt->bindParam(":cantidad", $this->cantidad);

        return $stmt->execute();
    }
}
?>