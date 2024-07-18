<?php
// class Database {
//     // private $host = "localhost";
//     // private $db_name = "sistema_farmaceutico";
//     // private $username = "root";
//     // private $password = "Edw024men..";
//     // public $conn;

//     private $host = "monorail.proxy.rlwy.net";
//     private $db_name = "sistema_farmaceutico";
//     private $username = "root";
//     private $password = "qOyKXZ5bEuRCVUzwlIlolinlftbiryxG";
//     private $port = "31135"; // Agregar el puerto
//     public $conn;

//     public function getConnection() {
//         $this->conn = null;
//         try {
//             $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
//             $this->conn->exec("set names utf8");
//         } catch (PDOException $exception) {
//             echo "Error de conexión: " . $exception->getMessage();
//         }
//         return $this->conn;
//     }
// }

class Database {
    private $host = "monorail.proxy.rlwy.net";
    private $db_name = "sistema_farmaceutico"; // Nombre correcto de la base de datos
    private $username = "mi_usuario";
    private $password = "mi_contraseña";
    private $port = "31135"; // Agregar el puerto
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

?>