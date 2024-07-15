<?php
class Venta {
    private $conn;
    private $table_name = "ventas";

    public $id;
    public $fecha;
    public $nombre_cliente;
    public $cedula_cliente;
    public $total;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        //$query = "INSERT INTO " . $this->table_name . " SET fecha=:fecha, nombre_cliente=:nombre_cliente, cedula_cliente=:cedula_cliente, total=:total";
        //$query = "INSERT INTO " . $this->table_name . " (fecha, nombre_cliente, cedula_cliente, total) VALUES (:fecha, :nombre_cliente, :cedula_cliente, :total)";
        $query = "INSERT INTO " . $this->table_name . " (fecha, nombre_cliente, cedula_cliente, total) VALUES (NOW(), :nombre_cliente, :cedula_cliente, :total)";
        
        $stmt = $this->conn->prepare($query);

        //$this->fecha = htmlspecialchars(strip_tags($this->fecha));
        //$this->fecha = date('Y-m-d H:i:s');
        $this->nombre_cliente = htmlspecialchars(strip_tags($this->nombre_cliente));
        $this->cedula_cliente = htmlspecialchars(strip_tags($this->cedula_cliente));
        $this->total = htmlspecialchars(strip_tags($this->total));

        //$stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':nombre_cliente', $this->nombre_cliente);
        $stmt->bindParam(':cedula_cliente', $this->cedula_cliente);
        $stmt->bindParam(':total', $this->total);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function leer() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE estado = 'A'; ORDER BY fecha id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->fecha = $row['fecha'];
        $this->nombre_cliente = $row['nombre_cliente'];
        $this->cedula_cliente = $row['cedula_cliente'];
        $this->total = $row['total'];
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET nombre_cliente=:nombre_cliente, cedula_cliente=:cedula_cliente, total=:total WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->nombre_cliente = htmlspecialchars(strip_tags($this->nombre_cliente));
        $this->cedula_cliente = htmlspecialchars(strip_tags($this->cedula_cliente));
        $this->total = htmlspecialchars(strip_tags($this->total));

        $stmt->bindParam(':nombre_cliente', $this->nombre_cliente);
        $stmt->bindParam(':cedula_cliente', $this->cedula_cliente);
        $stmt->bindParam(':total', $this->total);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function eliminar() {
        $query = "UPDATE " . $this->table_name . " SET estado = 'I' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return $stmt->execute();
    }
}
?>