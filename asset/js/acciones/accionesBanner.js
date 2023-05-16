var clientesCargados = false;

$(document).ready(function () {

    $('#tableClients').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "destroy": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }
    });
});


function cargarClientes() {
    var table = $('#tableClients').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "destroy": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }
    });

    $.post(urlIndex + "/controladores/ClienteController.php?funcion=list", function (response) {
        var clientes = JSON.parse(response);
        // Limpia la tabla antes de agregar nuevas filas
        table.clear();

        cargarData(clientes, table)
    });
}


function buscarCliente() {
    let txtSearch = document.querySelector("#txtNombreCli").value;
    if (txtSearch != "") {
        var table = $('#tableClients').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "destroy": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        });

        $.post(urlIndex + "/controladores/ClienteController.php?funcion=search", {
            nombreCli: txtSearch
        }, function (response) {
            var clientes = JSON.parse(response);
            console.log("Clientes : " + JSON.stringify(clientes));
            // Limpia la tabla antes de agregar nuevas filas
            table.clear();
            cargarData(clientes, table)
        });
    } else {
        swal("Error !!", "Debe ingresar un nombre para buscar un cliente", "error")
        return;
    }

}


function cargarData(clientes, table) {
    for (var i = 0; i < clientes.length; i++) {
        var empresa = clientes[i].empresa;
        var nombre = clientes[i].nombre;
        var direccion = clientes[i].domicilio;
        var telefono = clientes[i].telefono;

        // Crea los botones de acción
        var editarButton = '<button class="btn btn-sm btn-primary mr-1"  style="text-decoration: none;"><i class="fas fa-edit"></i></button>';
        var procesarButton = `<button class="btn btn-sm btn-success" onClick="procesarAccion('venta','${
            encodeURIComponent(nombre)
        }')" style="text-decoration: none;"><i class="fas fa-cash-register"></i></button>`;
        // Agrega una nueva fila con los datos y los botones de acción
        table.row.add([
            empresa,
            nombre,
            direccion,
            telefono,
            editarButton + procesarButton
        ]).draw(false);
    }
}


function procesarAccion(opcion, nombreCli) {
    $.post(urlIndex + "/controladores/ClienteController.php?funcion=" + opcion, {
        nombreCli: nombreCli
    }, function (response) {
        var cliente = JSON.parse(response);
        console.log(cliente);
    
        // Guardar los datos del cliente en el Local Storage
        localStorage.setItem("cliente", JSON.stringify(cliente));
    
        // Redirigir a otra ventana con la ruta urlIndex concatenada con /Venta/
        window.location.href = urlIndex + "/view/Ventas/";
    });
    
}
