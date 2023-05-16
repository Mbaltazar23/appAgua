let tableVentas;
$(document).ready(function () {
    let cliente = localStorage.getItem("cliente");
    console.log("Cliente: " + cliente);
    cargarProductos();
    cargarArticulos();
});


function cargarProductos() {
    tableVentas = $('#tableProducts').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "destroy": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "lengthChange": false,
        "info": false,
        "responsive": "true",
        "bDestroy": true,
        "iDisplayLength": 3,
        "order": [
            [0, "asc"]
        ]
    });
    $.post(urlIndex + "/controladores/ProductoController.php?funcion=list", function (response) {
        var productos = JSON.parse(response);
        console.log("Productos: " + JSON.stringify(productos));
        dataProducts(productos)
    });
    document.getElementById("sectionPago").style.display = "none";
}

function dataProducts(productos) {
    var table = $('#tableProducts').DataTable();
    // Limpiar contenido existente en la tabla
    table.clear().draw();
    // Recorrer los productos y agregar filas a la tabla
    for (var i = 0; i < productos.length; i++) {
        var producto = productos[i];

        var addButton = `<div class="text-center"><button class="btn btn-sm btn-success" onClick="agregarProducto('${
            producto.nombre
        }')"><i class="fas fa-plus"></i></button></div>`;

        table.row.add([
            i + 1,
            producto.nombre,
            producto.precio,
            producto.stock,
            addButton
        ]).draw(false);
    }
}

function cargarArticulos() {
    $('#tableArticles').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "destroy": true,
        "lengthChange": false,
        "info": false,
        "searching": false,
        "iDisplayLength": 3,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }
    });
}

function agregarProducto(nombreProducto) {
    $.ajax({
        type: "POST",
        url: urlIndex + "/controladores/ProductoController.php?funcion=add",
        data: {
            nombreProduct: nombreProducto
        },
        success: function (data) {
            let datos = JSON.parse(data);
            console.log("Producto: " + JSON.stringify(datos));
            let idproducto = datos["id"];
            let nombre = datos["nombre"];
            let precio = datos["precio"];
            let stock = 1;

            // console.log("Nombre: " + nombre + " precio: " + precio);

            var banderaCoincidencia = false;
            $("#tableArticles tbody tr").each(function (row, element) {
                var id = $(element).find("td")[0].innerHTML;
                if (idproducto == id) {
                    var cantidadActual = $(element).find("td")[2].innerHTML;
                    var cantidadTotal = parseInt(cantidadActual) + parseInt(stock);
                    var precioActualizado = cantidadTotal * precio;
                    $("#tdCantidad_" + idproducto).text(cantidadTotal);
                    $("#tdPrecio_" + idproducto).text(precioActualizado);
                    banderaCoincidencia = true;
                }
            });

            if (! banderaCoincidencia) {
                var newRow = $('<tr>');
                newRow.append(`<td hidden>${idproducto}</td>`);
                newRow.append(`<td>${nombre}</td>`);
                newRow.append(`<td class='text-center' id='tdCantidad_${idproducto}'>${stock}</td>`);
                newRow.append(`<td class='text-center'>${precio}</td>`);
                newRow.append(`<td class='text-center' id='tdPrecio_${idproducto}'>${
                    precio * stock
                }</td>`);
                newRow.append(`<td>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(this);"><i class='fas fa-trash'></i></button></td>`);

                var table = $('#tableArticles').DataTable();
                table.row.add(newRow).draw(false);
            }
            cargarDetalleArticulos();
        }
    })
}

function eliminarProducto(dato) {
    var fila = dato.parentNode.parentNode;
    swal({
        title: "Eliminar Producto",
        text: "¿Realmente desea Eliminar a este Producto?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            swal("Producto Eliminado...", "El Producto fue retirado Exitosamente !!", "success");
            var table = $('#tableArticles').DataTable();
            table.row(fila).remove().draw();
    
            // Verificar si no hay filas de datos en el DataTable
            if ($('#tableArticles tbody tr').length === 0) {
                $('#sectionPago').empty();
                document.getElementById("sectionPago").style.display = "none";
            } else {
                cargarDetalleArticulos();
            }
        }
    });
    
}

function cargarDetalleArticulos() { // Vaciar el contenido actual del sectionPago
    $('#sectionPago').empty();

    // Mostrar el nombre del cliente
    let cliente = JSON.parse(localStorage.getItem("cliente"));

    let total = 0;
    $('#tableArticles tbody tr').each(function () {
        let precio = parseInt($(this).find('td:nth-child(5)').text());
        total += precio;
    });

    // Mostrar el total a pagar solo una vez
    if (total > 0) {
        $('#sectionPago').append('<div class="card"><div class="card-body"><p class="card-text">Nombre del cliente: ' + cliente.nombre + '</p><p class="card-text">Total a pagar: ' + total + '</p><button class="btn btn-primary" onClick="procesarOrden()">Continuar</button></div></div>');
    }

    document.getElementById("sectionPago").style.display = "block";
}


function procesarOrden() {
    var valorTotal = 0;
    var arregloOrden = [];
    $("#tableArticles tbody tr").each(function (row, element) {
        var idProducto = parseInt($(element).find("td")[0].innerHTML);
        var nombreProducto = $(element).find("td")[1].innerHTML;
        var cantidadV = parseInt($(element).find("td")[2].innerHTML);
        var precioV = parseInt($(element).find("td")[3].innerHTML);
        var subtotalV = parseInt($(element).find("td")[4].innerHTML);
        valorTotal += subtotalV;
        arregloOrden.push({"idProducto": idProducto, "nombre": nombreProducto, "stock": cantidadV, "precio": precioV});
    });
    console.log("Orden: " + JSON.stringify(arregloOrden) + ", Valor total: " + valorTotal);

    swal({title: "Procesar Orden", text: "¿Realmente desea procesar esta Orden?", icon: "info", buttons: true}).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/ProductoController.php?funcion=process",
                data: {
                    arregloProducts: JSON.stringify(arregloOrden) // Convertir el arreglo a formato JSON
                },
                success: function (data) {
                    if (data) {
                        var products = JSON.parse(data)
                        console.log("Orden en proceso", JSON.stringify(products));
                        swal({title: "Exito !", text: "Orden en Proceso..", icon: "success"}).then(function () {
                            window.location = urlIndex + "/view/Orden";
                        })
                    }
                }
            })
        }
    })

}

// funcion para listar la venta donde se detalle los insumos, su cantidad, el valor unico y cuanto salio al total sin poner el subtotal

// otra funcion donde se muestre el nombre del cliente, el valor de la venta aun pendiente y los insumos que escogio en una tabla
