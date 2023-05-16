<?php

class Personal extends Conexion {

    public function login($correo, $clave) {
        try {
            $claveEncript = md5($clave);
            $statement = $this->conexion->prepare("SELECT * FROM personal WHERE CorreoPersonal=:correo AND ClavePersonal=:clave");
            $statement->bindParam(":correo", $correo, PDO::PARAM_STR);
            $statement->bindParam(":clave", $claveEncript, PDO::PARAM_STR);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            //$filas = count($resultado);
            if (!empty($resultado)) {
                //Si existe el usuario
                session_start();
                $_SESSION['id'] = $resultado["idPersonal"];
                $_SESSION['email-personal'] = $resultado["CorreoPersonal"];
                $_SESSION['cargo-usuario'] = $resultado["CargoPersonal"];
                $_SESSION['graficas'] = "accionesGraficosPersonal.js";
                return $resultado;
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function registrarCargo($clienteCargo, $NegocioCargo) {
        try {
            $statement = $this->conexion->prepare("INSERT INTO detallecargocliente(ClienteCargo, NegocioCargo)"
                    . "VALUES(:cargoCli,:negocioCargo)");
            $statement->bindParam(":cargoCli", $clienteCargo, PDO::PARAM_INT);
            $statement->bindParam(":negocioCargo", $NegocioCargo, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo registrar el cargo.";
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        return true;
    }

    public function guardarRegistro($idCliente, $idPersonal, $fecha) {
        try {
            $statement = $this->conexion->prepare("INSERT INTO registro(ClienteRegistrado,Personal,FechaRegistro) "
                    . "VALUES(:idCli,:idPer,:fecha)");
            $statement->bindParam(":idCli", $idCliente, PDO::PARAM_INT);
            $statement->bindParam(":idPer", $idPersonal, PDO::PARAM_INT);
            $statement->bindParam(":fecha", $fecha, PDO::PARAM_STR);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo registrar el registro.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function buscarPersonal($idPer) {
        $statement = $this->conexion->prepare("SELECT * FROM personal WHERE idPersonal=:id");
        $statement->bindParam(":id", $idPer);
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

}
