<?php
class Venta {
    private $conn;
    private $table_name = "ventas";

    public $id;
    public $medicina_id;
    public $cantidad;
    public $fecha;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " SET id_medicina=:id_medicina, cantidad=:cantidad, fecha=NOW()";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_medicina", $this->medicina_id); // Ajusta el nombre del parámetro según tu base de datos
        $stmt->bindParam(":cantidad", $this->cantidad);

        return $stmt->execute();
    }

    public function leer() {
        $query = "SELECT v.id, m.nombre AS nombre_medicina, v.cantidad, v.fecha FROM " . $this->table_name . " v LEFT JOIN medicinas m ON v.id = m.id ORDER BY v.fecha DESC";
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
            $this->medicina_id = $row['id_medicina'];
            $this->cantidad = $row['cantidad'];
            $this->fecha = $row['fecha'];
        }
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET id_medicina=:id_medicina, cantidad=:cantidad WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":id_medicina", $this->medicina_id);
        $stmt->bindParam(":cantidad", $this->cantidad);

        return $stmt->execute();
    }
}