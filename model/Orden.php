<?php

class Orden extends Conexion
{
    public function __construct()
    {
        parent::__construct();
    }

    public function cargarRepartidores()
    {
        $statement = $this->conexion->prepare("SELECT * FROM repartidor");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function registrarOrden($nro, $tipo, $fechaOrden, $repartidorId, $clienteId, $total)
    {
        try {
            $statement = $this->conexion->prepare("INSERT INTO orden(nro,tipo,fecha,repartidor_id,cliente_id,total)
                    VALUES (:nro,:tipo,:fecha,:repartidor,:cliente,:total)");
            $statement->bindParam(":nro", $nro, PDO::PARAM_STR);
            $statement->bindParam(":tipo", $tipo, PDO::PARAM_STR);
            $statement->bindParam(":fecha", $fechaOrden, PDO::PARAM_STR);
            $statement->bindParam(":repartidor", $repartidorId, PDO::PARAM_INT);
            $statement->bindParam(":cliente", $clienteId, PDO::PARAM_INT);
            $statement->bindParam(":total", $total, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                $idOrden = $this->conexion->lastInsertId();
                return $idOrden;
            } else {
                return "No se pudo registrar la orden.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function registarDetalleOrden($nroOrden, $fecha, $idproducto, $stock)
    {
        try {
            $statement = $this->conexion->prepare("INSERT INTO detalle_orden(fecha, orden_id, producto_id,stock)
                    VALUES (:fecha,:orden,:producto,:stock)");
            $statement->bindParam(":fecha", $fecha, PDO::PARAM_STR);
            $statement->bindParam(":orden", $nroOrden, PDO::PARAM_INT);
            $statement->bindParam(":producto", $idproducto, PDO::PARAM_INT);
            $statement->bindParam(":stock", $stock, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo registrar la orden.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function actualizarTotalOrden($idOrden, $total)
    {
        try {
            $statement = $this->conexion->prepare("UPDATE orden SET total = :total WHERE id = :idOrden");
            $statement->bindParam(":total", $total, PDO::PARAM_INT);
            $statement->bindParam(":idOrden", $idOrden, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo actualizar el total de la orden.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function actualizarStockProducts($idproducto, $stock)
    {
        // Preparar la declaración
        $statement = $this->conexion->prepare("UPDATE producto SET stock = stock - :stock WHERE id = :idproducto");
        // Vincular los parámetros
        $statement->bindParam(':stock', $stock, PDO::PARAM_INT);
        $statement->bindParam(':idproducto', $idproducto, PDO::PARAM_INT);
        // Ejecutar la consulta
        $statement->execute();
        // Verificar si la consulta se ejecutó correctamente
        if ($statement->rowCount() > 0) {
            // La actualización del stock se realizó con éxito
            return true;
        } else {
            // No se pudo actualizar el stock
            return false;
        }
    }
}
