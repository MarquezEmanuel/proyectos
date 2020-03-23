

$(document).ready(function () {

    $("#formBuscarRTE").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "procesarBuscarRTE.php",
            data: $("#formBuscarRTE").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tablaRTE').DataTable({
                    dom: 'Bfrtip',
                    paging: false,
                    responsive: true,
                    scrollX: true,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Reporte de Transacciones en Efectivo'
                        }, {
                            extend: 'pdfHtml5',
                            title: 'Reporte de Transacciones en Efectivo',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]}
                        }
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });

    $("#contenido2").on("change", "#seleccionarTodos", function () {
        if ($(this).is(':checked')) {
            $("input[name='transacciones[]']").each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $("input[name='transacciones[]']").each(function () {
                $(this).prop('checked', false);
            });
        }
    });

    $("#contenido2").on("click", "#btnBorrarRTE", function (e) {
		var mensaje = confirm("¿Quiere eliminar el RTE?");
//Detectamos si el usuario acepto el mensaje
if (mensaje) {
e.preventDefault();
        var cantidad = contarTransacciones();
        if (cantidad > 0) {
            $.ajax({
                type: "POST",
                url: "procesarBorrarRTE.php",
                data: $("#formProcesarBuscarRTE").serialize(),
                success: function (data) {
                    $("#contenido2").html(data);
                },
                error: function (data) {
                    console.log(data);
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
        } else {
            $("#mensaje").html('<div class="alert alert-warning text-center" role="alert">Seleccione al menos un registro para borrar</div>');
            $('#mdAdvertencia').modal({});
        }
}
//Detectamos si el usuario denegó el mensaje
else {
alert("¡Eliminacion cancelada!");
}
    });

    $("#contenido2").on("click", "#btnModificarRTE", function (e) {
        e.preventDefault();
        var cantidad = contarTransacciones();
        if (cantidad === 1) {
            $.ajax({
                type: "POST",
                url: "formModificarRTE.php",
                data: $("#formProcesarBuscarRTE").serialize(),
                success: function (data) {
                    $("#contenido2").empty();
                    $("#mdAdvertencia").remove();
                    $("#mdProcesando").remove();
                    $("#contenido").html(data);
                },
                error: function (data) {
                    console.log(data);
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
        } else {
            $("#mensaje").html('<div class="alert alert-warning text-center" role="alert">Seleccione solo un registro para modificar</div>');
            $('#mdAdvertencia').modal({});
        }
    });

    $("#contenido2").on("click", "#btnDetalleRTE", function (e) {
        e.preventDefault();
        var cantidad = contarTransacciones();
        if (cantidad === 1) {
            $.ajax({
                type: "POST",
                url: "formDetalleRTE.php",
                data: $("#formProcesarBuscarRTE").serialize(),
                success: function (data) {
                    $("#contenido2").empty();
                    $("#mdAdvertencia").remove();
                    $("#mdProcesando").remove();
                    $("#contenido").html(data);
                },
                error: function (data) {
                    console.log(data);
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la peticiÃ³n </div>');
                }
            });
        } else {
            $("#mensaje").html('<div class="alert alert-warning text-center" role="alert">Seleccione solo un registro para ver detalle</div>');
            $('#mdAdvertencia').modal({});
        }
    });

    $("#contenido2").on("click", "#btnAgregarVinculado", function (e) {
        e.preventDefault();
        var cantidad = contarTransacciones();
        if (cantidad === 1) {
            $.ajax({
                type: "POST",
                url: "formVincularRTE.php",
                data: $("#formProcesarBuscarRTE").serialize(),
                success: function (data) {
                    $("#contenido2").remove();
                    $("#mdAdvertencia").remove();
                    $("#mdProcesando").remove();
                    $("#contenido").html(data);
                },
                error: function (data) {
                    console.log(data);
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
        } else {
            $("#mensaje").html('<div class="alert alert-warning text-center" role="alert">Seleccione solo un registro para agregar vinculado</div>');
            $('#mdAdvertencia').modal({});
        }
    });

    $("#contenido2").on("click", "#btnGenerarXML", function (e) {
        e.preventDefault();
        var cantidad = contarTransacciones();
        if (cantidad > 0) {
            $('#mdProcesando').modal({});
            $.ajax({
                type: "POST",
                url: "procesarGenerarRTE.php",
                data: $("#formProcesarBuscarRTE").serialize(),
                success: function (data) {
                    $("#contenido2").empty();
                    $("#contenido").html(data);
                },
                error: function (data) {
                    console.log(data);
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                    $('#mdProcesando').modal("toggle");
                },
                complete: function () {
                    setTimeout(function () {
                        $('#mdProcesando').modal("toggle");
                    }, 1000);
                }
            });

        } else {
            $("#mensaje").html('<div class="alert alert-warning text-center" role="alert">Seleccione al menos un registro para generar XML</div>');
            $('#mdAdvertencia').modal({});
        }
    });

    /* CUENTA LA CANTIDAD DE REGISTROS QUE SE HAN SELECCIONADO DESDE LA TABLA */

    function contarTransacciones() {
        var cantidad = 0;
        $("input[name='transacciones[]']").each(function () {
            if ($(this).is(':checked')) {
                cantidad = cantidad + 1;
            }
        });
        return cantidad;
    }

    /* LLEVA AL TOPE DE LA PANTALLA */

    $("#contenido2").on("click", "#btnTop", function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 1250);
        return false;
    });


    $("#contenido").on("click", "#btnTopDetalleRTE", function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 1250);
        return false;
    });

    $("#contenido").on("click", "#btnContinuarModificandoRTE", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "formModificarRTE.php",
            data: $("#formContinuarModRTE").serialize(),
            success: function (data) {
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function (data) {
                console.log(data);
                $("#contenido2").empty();
                $("#contenido").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });

});

