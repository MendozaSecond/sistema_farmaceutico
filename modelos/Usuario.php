<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nombre_usuario;
    public $contrasena;
    public $rol;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $query = "SELECT id, nombre_usuario, contrasena, rol FROM " . $this->table_name . " WHERE nombre_usuario = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nombre_usuario);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(password_verify($this->contrasena, $row['contrasena'])) {
            $this->id = $row['id'];
            $this->rol = $row['rol'];
            return true;
        }
        return false;
    }
    public function crearUsuario() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre_usuario=:nombre_usuario, contrasena=:contrasena, rol=:rol";
        $stmt = $this->conn->prepare($query);
        
        // Encriptar la contraseña
        $this->contrasena = password_hash($this->contrasena, PASSWORD_BCRYPT);
        
        $stmt->bindParam(":nombre_usuario", $this->nombre_usuario);
        $stmt->bindParam(":contrasena", $this->contrasena);
        $stmt->bindParam(":rol", $this->rol);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>