<?php
require_once '../../config.php';
?>
<!DOCTYPE html>
<html>
    <?php include '../Template/header.php'; ?>
    <body>
        <?php include '../Template/menu.php'; ?>

        <div class="container py-lg-4 py-md-3 py-2">
            <div class="row">
                <div class="col-md-8 col-12 offset-md-2">
                    <div class="card bg-light shadow">
                        <div class="card-header bg-light text-center">
                            <h3>Detalle de Orden</h3>
                        </div>
                        <div class="card-body">
                            <div class="row container">
                                <div class="col-md-6">
                                    <p class="mb-3"><strong>N°:</strong> &nbsp;<label id="nroOr"></label></p>
                                    <p class="mb-3"><strong>Fecha:</strong>&nbsp; <label id="fechaOr"></label></p>
                                    <p class="mb-3"><strong>Hora:</strong> &nbsp;<label id="horaOr"></label></p>
                                    <p class="mb-3"><strong>Cliente:</strong>&nbsp; <label id="clienteOr"></label></p>
                                    <p class="mb-3"><strong>Domicilio:</strong>&nbsp; <label id="domicilioOr"></label></p>
                                    <p class="mb-3"><strong>Total:</strong>&nbsp; <label id="totalOr"></label> </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-3"><strong>Pago por:</strong>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="checkPay" value="Boleta">
                                        <label class="form-check-label" for="checkPay">Boleta</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="checkPay"value="Guia">
                                        <label class="form-check-label" for="checkPay">Guia</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="checkPay" value="Factura">
                                        <label class="form-check-label" for="checkPay">Factura</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="checkPay" value="Recarga Gratis">
                                        <label class="form-check-label" for="checkPay">Recarga Gratis</label>
                                    </div>
                                    </p>
                                    <p class="mb-2"><strong>Despachador:</strong></p>
                                    <div class="form-group selectDespatcher">
                                        <select class="form-control" id="selectRepartidor" name="selectRepartidor">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <table class="table mt-4" id="tableOrder">
                                <thead>
                                    <tr>
                                        <th>NOMBRE</th>
                                        <th>CANTIDAD</th>
                                        <th>PRECIO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <div class="btn-group custom-btn-group">
                                        <button class="btn btn-primary" onclick="procesarOrdenRes()">Procesar</button>
                                        <button class="btn btn-secondary">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../Template/footer.php'; ?>
<!--        <script src="https://www.paypalobjects.com/api/checkout.js?locale=es-CL"></script>-->
        <script src="<?= ASSET ?>/js/acciones/accionesOrdenes.js" type="text/javascript"></script>
    </body>
</html>
