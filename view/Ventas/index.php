<?php
require_once '../../config.php';

if (isset($_SESSION['productos'])) {
    header("Location: " . URL . "/view/Orden");
    exit; // Importante: asegúrate de terminar la ejecución del script después de la redirección
}
?>
<!DOCTYPE html>
<html>
    <?php include '../Template/header.php'; ?>
    <body>
        <?php include '../Template/menu.php'; ?>
        <div class="container my-3">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="jumbotron">
                        <h2 class="text-center">Productos</h2>
                        <hr>
                    </div>
                </div>
                <div class="col-md-8">
                    <table class="table table-hover table-striped table-responsive-lg" style="width: 100%;" id="tableProducts">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se agregarán las filas con los datos de los productos -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-8">
                    <table class="table table-hover table-striped table-responsive-lg" style="width: 100%;"  id="tableArticles">
                        <thead>
                            <tr>
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se agregarán las filas con los datos de los artículos -->
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4" id="sectionPago">

                </div>
            </div>
        </div>

        <?php include '../Template/footer.php'; ?>
<!--        <script src="https://www.paypalobjects.com/api/checkout.js?locale=es-CL"></script>-->
        <script src="<?= ASSET ?>/js/acciones/accionesVenta.js" type="text/javascript"></script>
    </body>
</html>
