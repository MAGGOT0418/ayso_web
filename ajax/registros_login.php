<?php

class Conexion {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "consultorio_bd2";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Comprobar si hubo algún error en la conexión
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function ejecutarConsulta($sql) {
        return $this->conn->query($sql);
    }

    public function cerrarConexion() {
        $this->conn->close();
    }

    // Método para registrar un nuevo usuario
    public function registrarUsuario($nombre, $email, $password, $rol = 2) {
        $sql = "INSERT INTO usuarios (nombre, correo, password, id_rol) 
                VALUES ('$nombre', '$email', '$password', $rol)";
        return $this->ejecutarConsulta($sql);
    }

    // Método para iniciar sesión
    public function iniciarSesion($email, $password) {
        $sql = "SELECT * FROM usuarios WHERE correo = '$email' AND password = '$password'";
        $result = $this->ejecutarConsulta($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc(); // Devuelve los datos del usuario si las credenciales son correctas
        } else {
            return false; // Usuario no encontrado
        }
    }
}


function ejecutarConsulta($sql) {
    $conexion = new Conexion();
    $result = $conexion->ejecutarConsulta($sql);
    $conexion->cerrarConexion();
    return $result;
}

?>
