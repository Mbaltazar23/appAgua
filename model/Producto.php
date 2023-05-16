<?php

class Producto extends Conexion
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $statement = $this->conexion->prepare("SELECT * FROM producto");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function buscarProducto($nombreProduct)
    {
        try {
            $statement = $this->conexion->prepare("SELECT * FROM producto WHERE nombre =:nombre");
            $statement->bindParam(":nombre", $nombreProduct, PDO::PARAM_STR);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    // Agregar un producto a la sesión
    public function agregarProducto($producto)
    {
        // Inicializar la sesión si no está iniciada
        if (!isset($_SESSION['productos'])) {
            $_SESSION['productos'] = array();
        }

        // Verificar si el producto ya existe en el arreglo
        $indice = -1;
        foreach ($_SESSION['productos'] as $key => $prod) {
            if ($prod['idProducto'] == $producto['idProducto']) {
                $indice = $key;
                break;
            }
        }

        if ($indice >= 0) {
            // El producto ya existe, actualizar la información
            $_SESSION['productos'][$indice]['stock'] += $producto['stock'];
            $_SESSION['productos'][$indice]['precio'] = $producto['precio'];
        } else {
            // El producto no existe, agregarlo al arreglo
            $_SESSION['productos'][] = $producto;
        }

        // Devolver el arreglo de productos actualizado
        return $_SESSION['productos'];
    }

    // Obtener los productos guardados en la sesión
    public function obtenerProductos()
    {
        // Devolver un array vacío si no hay productos en la sesión
        if (!isset($_SESSION['productos'])) {
            return array();
        }
        // Devolver los productos guardados en la sesión
        return $_SESSION['productos'];
    }

    public function removerProductos()
    {
        if (isset($_SESSION['productos'])) {
            unset($_SESSION['productos']);
        }
        return 1;
    }
}
