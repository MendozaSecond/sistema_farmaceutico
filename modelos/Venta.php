<?php
class Venta {
    private $conn;
    private $table_name = "ventas";

    public $id;
    public $fecha;
    public $nombre_cliente;
    public $cedula_cliente;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " SET fecha=NOW(), nombre_cliente=:nombre_cliente, cedula_cliente=:cedula_cliente";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre_cliente", $this->nombre_cliente);
        $stmt->bindParam(":cedula_cliente", $this->cedula_cliente);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        } else {
            return false;
        }
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
        if ($row) {
            $this->fecha = $row['fecha'];
            $this->nombre_cliente = $row['nombre_cliente'];
            $this->cedula_cliente = $row['cedula_cliente'];
        }
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET nombre_cliente=:nombre_cliente, cedula_cliente=:cedula_cliente WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nombre_cliente", $this->nombre_cliente);
        $stmt->bindParam(":cedula_cliente", $this->cedula_cliente);

        return $stmt->execute();
    }

    public function eliminar() {
        $query = "UPDATE " . $this->table_name . " SET estado = 'I' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        return $stmt->execute();
    }
}
?>