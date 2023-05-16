<?php

require_once '../config.php';
require_once '../model/Conexion.php';
require_once '../model/Cliente.php';

$cliente = new Cliente();

$funcion = "";

if (isset($_GET["funcion"])) {
    $funcion = $_GET["funcion"];
    if ($funcion == "search") {
        $nombreCli = (isset($_POST["nombreCli"])) ? $_POST["nombreCli"] : "";
        $result = $cliente->filtrarClientes($nombreCli);
        echo json_encode($result);
    } else if ($funcion == "list") {
        $clientes = $cliente->listar();
        echo json_encode($clientes);
    } else if ($funcion == "venta") {
        $nombreCli = (isset($_POST["nombreCli"])) ? $_POST["nombreCli"] : "";
        $result = $cliente->obtenerCliente($nombreCli);
        echo json_encode($result);
    } else if ($funcion == "edit") {

    }
} else {
    echo "<script>$(location).attr('href', '" . URL . "');</script>";
}
