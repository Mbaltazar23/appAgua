$(document).ready(function () {
    getOrdenWithClient();
    cargarRepartidores();
});

function getOrdenWithClient() {
    let cliente = JSON.parse(localStorage.getItem("cliente"));
    console.log("Cliente: " + cliente);
    $.post(urlIndex + "/controladores/ProductoController.php?funcion=get", function (response) {
        var productos = JSON.parse(response);
        console.log("Productos: " + JSON.stringify(productos));

        // Imprimir nombre y domicilio en los id's clienteOr y domicilioOr
        document.getElementById("clienteOr").innerText = cliente.nombre;
        document.getElementById("domicilioOr").innerText = cliente.domicilio;

        // Generar un numero aleatorio de 4 cifras para el id nroOr
        var randomNum = Math.floor(1000 + Math.random() * 9000);
        document.getElementById("nroOr").innerText = randomNum;

        // Obtener la fecha y hora actual
        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Agregar cero delante si el mes es de 1 a 9
        var year = currentDate.getFullYear();
        var formattedDate = day + "-" + month + "-" + year;
        var formattedTime = currentDate.getHours() + ":" + currentDate.getMinutes();
        document.getElementById("fechaOr").innerText = formattedDate;
        document.getElementById("horaOr").innerText = formattedTime;

        // Calcular el total utilizando los productos
        var total = 0;
        for (var i = 0; i < productos.length; i++) {
            var precio = productos[i].precio;
            var stock = productos[i].stock;
            var subtotal = precio * stock;
            total += subtotal;
        }
        document.getElementById("totalOr").innerText = total;

        // Obtener el tbody de la tabla
        var tbody = document.getElementById("tableOrder").getElementsByTagName("tbody")[0];

        // Limpiar cualquier contenido previo en el tbody
        tbody.innerHTML = "";

        // Imprimir el contenido en la tabla
        for (var i = 0; i < productos.length; i++) {
            var row = tbody.insertRow();
            var nombreCell = row.insertCell(0);
            var cantidadCell = row.insertCell(1);
            var totalCell = row.insertCell(2);

            nombreCell.innerText = productos[i].nombre;
            cantidadCell.innerText = productos[i].stock;
            totalCell.innerText = productos[i].precio * productos[i].stock;
        }
    });
}

function cargarRepartidores() {
    $.ajax({
        type: "POST",
        url: urlIndex + "/controladores/OrdenController.php?funcion=repartidors",
        success: function (data) {
            $('.selectDespatcher select').html(data).fadeIn();
        }
    });
}


function procesarOrdenRes() {
    let error = false;
    let nroOrden = document.querySelector('#nroOr').textContent;
    let cliente = JSON.parse(localStorage.getItem("cliente"));
    var repartidor = document.querySelector("#selectRepartidor").value;
    var radios = document.getElementsByName('checkPay');
    var selectedValue = '';

    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            selectedValue = radios[i].value;
            break;
        }
    }

    if (repartidor == 0) {
        mensaje = "Debe seleccionar un repartidor para la Orden";
        error = true;
    } else if (selectedValue == "") {
        mensaje = "Debe seleccionar un metodo de pago para la Orden";
        error = true;
    }

    if (error == true) {
        swal('Oops...', mensaje, 'error');
        return false;
    } else {
        swal({title: "Emitir Orden", text: "¿Realmente desea emitir y enviar esta Orden?", icon: "info", buttons: true}).then((isClosed) => {
            if (isClosed) {
                $.ajax({
                    type: "POST",
                    url: urlIndex + "/controladores/OrdenController.php?funcion=create",
                    data: {
                        nroOrde: nroOrden,
                        idCliente: cliente.id,
                        idRepartidor: repartidor,
                        tipoPago: selectedValue
                    },
                    success: function (data) {
                        if (data) {
                            removeDataOrder();
                            swal({title: "Exito !", text: "Orden Emitida Exitosamente !!", icon: "success"}).then(function () {
                                window.location = urlIndex;
                            });
                        }
                    }
                });
            }
        })
    }
    // console.log("NRO: ", nroOrden, ", Cliente : " + cliente.id, ", Radio : ", selectedValue, ", Repartidor : " + repartidor);
}

function removeDataOrder() {
    $.post(urlIndex + "/controladores/OrdenController.php?funcion=remove", function (response) {
        if (response) {
            localStorage.removeItem("cliente");
        }
    })
}
