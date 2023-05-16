let tableClientes;
$(document).ready(function () {

    if (document.querySelector("#btnTodos")) {
        cargarClientes();
    }
});

function VerCliente(idCliente) {
    $.post(urlIndex + "/controladores/ClienteController.php?funcion=search", {
        idCliente: idCliente
    }, function (response) {
        var cliente = JSON.parse(response);
        $("#nombreCli").text(cliente["NombreCliente"]);
        $("#correoCli").text(cliente["CorreoVinculado"]);
        $("#cargoCli").text(cliente["NegocioCliente"]);
        $("#telefonoCli").text(cliente["TelefonoCliente"]);
        $("#cargoDesc").text(cliente["CargoCliente"]);
    });
}

function buscarClienteD(idCliente) {
    swal({
        title: "Inhabilitar Cuenta del Cliente",
        text: "¿Realmente desea Inhabilitar a esta Cuenta?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/ClienteController.php?funcion=delete",
                data: {
                    idCliente: idCliente
                },
                success: function (data) {
                    if (data) {
                        swal({title: "Exito !!", text: "Cuenta Inhabilitada Exitosamente !!", icon: "success"}).then(function () {
                            tableClientes.ajax.reload();
                        });
                    }
                }
            });
        }
    });
}

function activarCliente(idCliente) {
    swal({
        title: "Habilitar Cuenta del Cliente",
        text: "¿Realmente desea Habilitar a esta Cuenta?",
        icon: "info",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/ClienteController.php?funcion=activate",
                data: {
                    idCliente: idCliente
                },
                success: function (data) {
                    if (data) {
                        swal({title: "Exito !!", text: "Cuenta Activada Exitosamente !!", icon: "success"}).then(function () {
                            tableClientes.ajax.reload();
                        });
                    }
                }
            });
        }
    });
}

function cargarClientes() {
    $.post(urlIndex + "/controladores/ClienteController.php?funcion=list", function (response) {
        var clientes = JSON.parse(response);
        var table = document.getElementById("tableClients").getElementsByTagName("tbody")[0];
        for (var i = 0; i < clientes.length; i++) {
            var row = table.insertRow(-1);
            // Inserta una nueva fila al final de la tabla

            // Crea las celdas para cada campo del registro
            var empresaCell = row.insertCell(0);
            var nombreCell = row.insertCell(1);
            var direccionCell = row.insertCell(2);
            var telefonoCell = row.insertCell(3);
            var accionesCell = row.insertCell(4);

            // Agrega los datos a las celdas correspondientes
            empresaCell.innerHTML = clientes[i].empresa;
            nombreCell.innerHTML = clientes[i].nombre;
            direccionCell.innerHTML = clientes[i].direccion;
            telefonoCell.innerHTML = clientes[i].telefono;

            // Crea los botones de acción y los agrega a la celda de acciones
            var editarButton = document.createElement("button");
            editarButton.classList.add("btn", "btn-sm", "btn-primary", "mr-1");
            editarButton.innerHTML = '<i class="fas fa-edit"></i>';
            editarButton.onclick = function () { // Acción al presionar el botón de editar
            };
            accionesCell.appendChild(editarButton);

            var procesarButton = document.createElement("button");
            procesarButton.classList.add("btn", "btn-sm", "btn-success");
            procesarButton.innerHTML = '<i class="fas fa-cash-register"></i>';
            procesarButton.onclick = function () { // Acción al presionar el botón de procesar venta
            };
            accionesCell.appendChild(procesarButton);
        }

    });
}
