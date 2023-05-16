<?php

class Conexion {

    private $host = HOST;
    private $db = DB;
    private $user = USER;
    private $pass = PASS;
    protected $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->exec("SET CHARACTER SET utf8");
            return $this->conexion;
        } catch (Exception $e) {
            echo "Linea: " . $e->getLine() . "<br>";
            echo "Error: " . $e->getMessage();
        }
    }

}
