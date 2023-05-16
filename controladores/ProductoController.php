<?php
require_once '../config.php';
require_once '../model/Conexion.php';
require_once '../model/Producto.php';

$producto = new Producto();
$funcion = "";

if (isset($_GET["funcion"])) {
    $funcion = $_GET["funcion"];
    if ($funcion == "list") {
        $listaProducts = $producto->listar();
        echo json_encode($listaProducts);
    } else if ($funcion == "add") {
        $nombreProduct = (isset($_POST["nombreProduct"])) ? $_POST["nombreProduct"] : "";
        $productSearch = $producto->buscarProducto($nombreProduct);
        echo json_encode($productSearch);
    } else if ($funcion == "process") {
        $arregloProducts = (isset($_POST["arregloProducts"])) ? json_decode($_POST["arregloProducts"], true) : "";

        if (!empty($arregloProducts)) {
            $producto = new Producto();
            $productosActualizados = array();

            foreach ($arregloProducts as $product) {
                $productosActualizados = $producto->agregarProducto($product);
            }

            // Devolver el arreglo de productos actualizado como respuesta JSON
            echo json_encode($productosActualizados);
        }
    } else if ($funcion == "get") {
        $arregloProducts = $producto->obtenerProductos();
        echo json_encode($arregloProducts);
    }
} else {
    echo "<script>$(location).attr('href', '" . URL . "');</script>";
}
