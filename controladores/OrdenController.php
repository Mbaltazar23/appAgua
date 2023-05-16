<?php
require_once '../config.php';
require_once '../model/Conexion.php';
require_once '../model/Orden.php';
require_once '../model/Producto.php';

$orden = new Orden();
$producto = new Producto();

$funcion = "";

if (isset($_GET["funcion"])) {
    $funcion = $_GET["funcion"];

    if ($funcion == "create") {
        $fecha = date("Y-m-d H:i:s");
        $nroOrde = (isset($_POST["nroOrde"])) ? $_POST["nroOrde"] : "";
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $idRepartidor = (isset($_POST["idRepartidor"])) ? $_POST["idRepartidor"] : "";
        $tipoPago = (isset($_POST["tipoPago"])) ? $_POST["tipoPago"] : "";
        $productosList = $producto->obtenerProductos();

        // Registrar la orden
        $idOrden = $orden->registrarOrden($nroOrde, $tipoPago, $fecha, $idRepartidor, $idCliente, 0);

        if (is_numeric($idOrden)) {
            // Variable para almacenar el total de la orden
            $totalOrden = 0;
            // Recorrer los productos
            foreach ($productosList as $producto) {
                $idProducto = $producto['idProducto'];
                $stock = $producto['stock'];
                // Registrar el detalle de la orden
                $orden->registarDetalleOrden($idOrden, $fecha, $idProducto, $stock);
                // Actualizar el stock del producto
                $orden->actualizarStockProducts($idProducto, $stock);
                // Calcular el subtotal del producto y agregarlo al total de la orden
                $subtotal = $producto['precio'] * $stock;
                $totalOrden += $subtotal;
            }
            // Actualizar el total de la orden en la base de datos
            $orden->actualizarTotalOrden($idOrden, $totalOrden);
            // Puedes retornar una respuesta de éxito, redireccionar o realizar cualquier otra acción necesaria
            echo json_encode($idOrden);
        } else {
            // Hubo un error al registrar la orden
            // Puedes retornar un mensaje de error o manejarlo de acuerdo a tu lógica de aplicación
            echo "";
        }
    } else if ($funcion == "repartidors") {
        $listRepartidors = $orden->cargarRepartidores();
        echo '<option value="0"> Seleccione un Repartidor </option>';
        for ($i = 0; $i < count($listRepartidors); $i++) {
            echo '<option value="' . $listRepartidors[$i]['id'] . '">' . $listRepartidors[$i]['nombre'] . '</option>';
        }
    } else if ($funcion == "remove") {
        $removeProductos = $producto->removerProductos();
        echo json_encode($removeProductos);
    }
} else {
    echo "<script>$(location).attr('href', '" . URL . "');</script>";
}
