<?php
require_once './config.php';
if (isset($_SESSION['productos'])) {
    header("Location: " . URL . "/view/Orden");
    exit; // Importante: asegúrate de terminar la ejecución del script después de la redirección
}
?>
<!DOCTYPE html>
<html>
    <?php include './view/Template/header.php'; ?>
    <body>
        <?php include './view/Template/menu.php'; ?>
        <div class="container my-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="jumbotron">
                        <h2 class="display-7">Buscar Clientes</h2>
                        <p class="lead">
                        <div class="input-group">
                            <input type="text" class="form-control" name="txtNombreCli" id="txtNombreCli" placeholder="Nombre del cliente">
                            <div class="form-group mx-sm-3 mb-2 buttons-group">
                                <button onclick="buscarCliente();" class="btn btn-primary mb-2">Buscar</button>
                                <button onclick="" class="btn btn-secondary mb-2">Nuevo</button>
                                <button onclick="cargarClientes();" class="btn btn-secondary mb-2">Todos</button>
                            </div>
                        </div>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table table-hover table-striped table-responsive-lg" style="width: 100%;" id="tableClients">
                        <thead>
                            <tr>
                                <th>Empresa</th>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Telefono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <?php include './view/Template/footer.php'; ?>
        <script src="<?= ASSET ?>/js/acciones/accionesBanner.js" type="text/javascript"></script>
    </body>
</html>
