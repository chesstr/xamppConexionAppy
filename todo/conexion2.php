<?php
class Conexion extends PDO{
    //Credenciales
    private $password = '';
    private $host = 'localhost';
    private $usuario = 'root';
    private $db = 'cardenastec';
    private $puerto = '';

    public function __construct(){
        try {
            parent::__construct('mysql:host=' . $this->host . ';port=' . $this->puerto . ';dbname=' . $this->db, $this->usuario, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));     
        } catch (PDOExeption $e) {
            echo'Error: '.$e->getMessage();
            exit;
        }
    }
}
?>