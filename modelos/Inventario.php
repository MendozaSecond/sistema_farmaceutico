<?php
class Inventario {
    private $conn;
    private $table_name = "medicinas";

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $cantidad;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leer() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE estado = 'A'";
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

        $this->nombre = $row['nombre'];
        $this->descripcion = $row['descripcion'];
        $this->precio = $row['precio'];
        $this->cantidad = $row['cantidad'];
    }

    public function agregar() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, descripcion=:descripcion, precio=:precio, cantidad=:cantidad";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":cantidad", $this->cantidad);
    
         if($stmt->execute()) {
             return true;
         }
         return false;
        // return $stmt->execute();
    }

    public function editar() {
        $query = "UPDATE " . $this->table_name . " SET nombre=:nombre, descripcion=:descripcion, precio=:precio, cantidad=:cantidad WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":cantidad", $this->cantidad);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
        //  if($stmt->execute()) {
        //      return true;
        //  }
        //  return false;
    }

    public function eliminar() {
        $query = "UPDATE " . $this->table_name . " SET estado='I' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        //return $stmt->execute();
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>