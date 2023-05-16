<?php

class Cliente extends Conexion
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $statement = $this->conexion->prepare("SELECT * FROM cliente");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function filtrarClientes($nombreSearch)
    {
        try {
            $statement = $this->conexion->prepare("SELECT * FROM cliente WHERE nombre LIKE :nombreCli");
            $nombreSearch = '%' . $nombreSearch . '%';
            $statement->bindParam(":nombreCli", $nombreSearch, PDO::PARAM_STR);
            $statement->execute();
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function obtenerCliente($nombreCliente)
    {
        try {
            $statement = $this->conexion->prepare("SELECT * FROM cliente WHERE nombre = :nombreCli");
            $statement->bindParam(":nombreCli", $nombreCliente, PDO::PARAM_STR);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        
    }

}
