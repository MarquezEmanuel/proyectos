/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    /* Captura el submit para validar los cambios en el mismo */
    $('#formModificarGtia').submit(function () {

        //e.preventDefault();

        if ($('#rutaImgGtiaHip')[0].files[0]) {
            var name = $('#rutaImgGtiaHip')[0].files[0]['name'];
            var long = name.length;
            if (long > 104) {
                var mensaje = "El nombre del documento para garantia de hipoteca debe ser menor a 100 caracteres";
                mostrar(mensaje);
                return false;
            }
            var index = name.indexOf("'");
            if (index != -1) {
                var mensaje = "El nombre del documento para garantia de hipoteca no debe contener comillas simples";
                mostrar(mensaje);
                return false;
            }
        }

        if ($('#rutaImgTasHip')[0].files[0]) {
            var name = $('#rutaImgTasHip')[0].files[0]['name'];
            var long = name.length;
            if (long > 104) {
                var mensaje = "El nombre del documento para tasacion de hipoteca debe ser menor a 100 caracteres";
                mostrar(mensaje);
                return false;
            }
            var index = name.indexOf("'");
            if (index != -1) {
                var mensaje = "El nombre del documento para tasacion de hipoteca no debe contener comillas simples";
                mostrar(mensaje);
                return false;
            }
        }

        if ($('#rutaImgGtiaPre')[0].files[0]) {
            var name = $('#rutaImgGtiaPre')[0].files[0]['name'];
            var long = name.length;
            if (long > 104) {
                var mensaje = "El nombre del documento para garantia de prenda debe ser menor a 100 caracteres";
                mostrar(mensaje);
                return false;
            }
            var index = name.indexOf("'");
            if (index != -1) {
                var mensaje = "El nombre del documento para garantia de prenda no debe contener comillas simples";
                mostrar(mensaje);
                return false;
            }
        }

        if ($('#rutaImgTasPre')[0].files[0]) {
            var name = $('#rutaImgTasPre')[0].files[0]['name'];
            var long = name.length;
            if (long > 104) {
                var mensaje = "El nombre del documento para tasacion de prenda debe ser menor a 100 caracteres";
                mostrar(mensaje);
                return false;
            }
            var index = name.indexOf("'");
            if (index != -1) {
                var mensaje = "El nombre del documento para tasacion de prenda no debe contener comillas simples";
                mostrar(mensaje);
                return false;
            }
        }

        if ($('#rutaImgGtiaFia')[0].files[0]) {
            var name = $('#rutaImgGtiaFia')[0].files[0]['name'];
            var long = name.length;
            if (long > 104) {
                var mensaje = "El nombre del documento para garantia de fianza debe ser menor a 100 caracteres";
                mostrar(mensaje);
                return false;
            }
            var index = name.indexOf("'");
            if (index != -1) {
                var mensaje = "El nombre del documento para garantia de fianza no debe contener comillas simples";
                mostrar(mensaje);
                return false;
            }
        }

        if ($('#rutaImgTasFia')[0].files[0]) {
            var name = $('#rutaImgTasFia')[0].files[0]['name'];
            var long = name.length;
            if (long > 104) {
                var mensaje = "El nombre del documento para tasacion de fianza debe ser menor a 100 caracteres";
                mostrar(mensaje);
                return false;
            }
            var index = name.indexOf("'");
            if (index != -1) {
                var mensaje = "El nombre del documento para tasacion de fianza no debe contener comillas simples";
                mostrar(mensaje);
                return false;
            }
        }

        if ($('#rutaImgGtiaLea')[0].files[0]) {
            var name = $('#rutaImgGtiaLea')[0].files[0]['name'];
            var long = name.length;
            if (long > 104) {
                var mensaje = "El nombre del documento para garantia de leasing debe ser menor a 100 caracteres";
                mostrar(mensaje);
                return false;
            }
            var index = name.indexOf("'");
            if (index != -1) {
                var mensaje = "El nombre del documento para garantia de leasing no debe contener comillas simples";
                mostrar(mensaje);
                return false;
            }
        }

        if ($('#rutaImgTasLea')[0].files[0]) {
            var name = $('#rutaImgTasLea')[0].files[0]['name'];
            var long = name.length;
            if (long > 104) {
                var mensaje = "El nombre del documento para tasacion de leasing debe ser menor a 100 caracteres";
                mostrar(mensaje);
                return false;
            }
            var index = name.indexOf("'");
            if (index != -1) {
                var mensaje = "El nombre del documento para tasacion de leasing no debe contener comillas simples";
                mostrar(mensaje);
                return false;
            }
        }

        if ($('#rutaImgGtiaCart')[0].files[0]) {
            var name = $('#rutaImgGtiaCart')[0].files[0]['name'];
            var long = name.length;
            if (long > 104) {
                var mensaje = "El nombre del documento para garantia de compra de cartera debe ser menor a 100 caracteres";
                mostrar(mensaje);
                return false;
            }
            var index = name.indexOf("'");
            if (index != -1) {
                var mensaje = "El nombre del documento para garantia de compra de cartera no debe contener comillas simples";
                mostrar(mensaje);
                return false;
            }
        }

        if ($('#rutaImgCont')[0].files[0]) {
            var name = $('#rutaImgCont')[0].files[0]['name'];
            var long = name.length;
            if (long > 104) {
                var mensaje = "El nombre del documento para contrato de compra de cartera debe ser menor a 100 caracteres";
                mostrar(mensaje);
                return false;
            }
            var index = name.indexOf("'");
            if (index != -1) {
                var mensaje = "El nombre del documento para contrato de compra de cartera no debe contener comillas simples";
                mostrar(mensaje);
                return false;
            }
        }

        if ($('#rutaImgPaga')[0].files[0]) {
            var name = $('#rutaImgPaga')[0].files[0]['name'];
            var long = name.length;
            if (long > 104) {
                var mensaje = "El nombre del documento para pagare de compra de cartera debe ser menor a 100 caracteres";
                mostrar(mensaje);
                return false;
            }
            var index = name.indexOf("'");
            if (index != -1) {
                var mensaje = "El nombre del documento para pagare de compra de cartera no debe contener comillas simples";
                mostrar(mensaje);
                return false;
            }
        }
        return true;
    });

    $("#btnShowHipoteca").click(function (e) {
        e.preventDefault();
        if (!$('div#camposHipoteca').is(':visible')) {
            $('div#camposHipoteca').show();
            $(this).attr({title: "Ocultar los campos de la hipoteca", class: "btn btn-outline-danger"});
        } else {
            $('div#camposHipoteca').hide();
            $(this).attr({title: "Mostrar los campos de la hipoteca", class: "btn btn-outline-success"});
        }
    });

    /* Oculta/Muestra los campos pertenecientes a la prenda */

    $("#btnShowPrenda").click(function (e) {
        e.preventDefault();
        if (!$('div#camposPrenda').is(':visible')) {
            $('div#camposPrenda').show();
            $(this).attr({title: "Ocultar los campos de la prenda", class: "btn btn-outline-danger"});
        } else {
            $('div#camposPrenda').hide();
            $(this).attr({title: "Mostrar los campos de la prenda", class: "btn btn-outline-success"});
        }
    });

    /* Oculta/Muestra los campos pertenecientes a la fianza */

    $("#btnShowFianza").click(function (e) {
        e.preventDefault();
        if (!$('div#camposFianza').is(':visible')) {
            $('div#camposFianza').show();
            $(this).attr({title: "Ocultar los campos de la fianza", class: "btn btn-outline-danger"});
        } else {
            $('div#camposFianza').hide();
            $(this).attr({title: "Mostrar los campos de la fianza", class: "btn btn-outline-success"});
        }
    });

    /* Oculta/Muestra los campos pertenecientes al leasing */

    $("#btnShowLeasing").click(function (e) {
        e.preventDefault();
        if (!$('div#camposLeasing').is(':visible')) {
            $('div#camposLeasing').show();
            $(this).attr({title: "Ocultar los campos del leasing", class: "btn btn-outline-danger"});
        } else {
            $('div#camposLeasing').hide();
            $(this).attr({title: "Mostrar los campos del leasing", class: "btn btn-outline-success"});
        }
    });

    /* Oculta/Muestra los campos pertenecientes a la cartera */

    $("#btnShowCartera").click(function (e) {
        e.preventDefault();
        if (!$('div#camposCartera').is(':visible')) {
            $('div#camposCartera').show();
            $(this).attr({title: "Ocultar los campos de la cartera", class: "btn btn-outline-danger"});
        } else {
            $('div#camposCartera').hide();
            $(this).attr({title: "Mostrar los campos de la cartera", class: "btn btn-outline-success"});
        }
    });

    /* Abre el modal con los documentos de hipoteca */

    $('button#imgHipoteca').click(function (e) {
        e.preventDefault();
        $('#mdImgHipoteca').modal({});
    });

    /* Abre el modal con los documentos de prenda */
    
    $('button#imgPrenda').click(function (e) {
        e.preventDefault();
        $('#mdImgPrenda').modal({});
    });

    /* Abre el modal con los documentos de fianza */
    
    $('button#imgFianza').click(function (e) {
        e.preventDefault();
        $('#mdImgFianza').modal({});
    });

    /* Abre el modal con los documentos de leasing */
    
    $('button#imgLeasing').click(function (e) {
        e.preventDefault();
        $('#mdImgLeasing').modal({});
    });

    /* Abre el modal con los documentos de cartera */
    
    $('button#imgCartera').click(function (e) {
        e.preventDefault();
        $('#mdImgCartera').modal({});
    });

    /* GARANTIA HIP: Lee la ruta del PDF del atributo name y lo abre en una nueva pestana. */
    $("#contenido").on("click", "a#rutaImgGtiaHipOrig", function () {
        var ruta = $(this).attr('name');
        window.open(ruta, '_blank');
    });

    /* TASACION HIP: Lee la ruta del PDF del atributo name y lo abre en una nueva pestana. */
    $("#contenido").on("click", "a#rutaImgTasHipOrig", function () {
        var ruta = $(this).attr('name');
        window.open(ruta, '_blank');
    });

    /* GARANTIA PRE: Lee la ruta del PDF del atributo name y lo abre en una nueva pestana. */
    $("#contenido").on("click", "a#rutaImgGtiaPreOrig", function () {
        var ruta = $(this).attr('name');
        window.open(ruta, '_blank');
    });

    /* TASACION PRE: Lee la ruta del PDF del atributo name y lo abre en una nueva pestana. */
    $("#contenido").on("click", "a#rutaImgTasPreOrig", function () {
        var ruta = $(this).attr('name');
        window.open(ruta, '_blank');
    });

    /* GARANTIA FIA: Lee la ruta del PDF del atributo name y lo abre en una nueva pestana. */
    $("#contenido").on("click", "a#rutaImgGtiaFiaOrig", function () {
        var ruta = $(this).attr('name');
        window.open(ruta, '_blank');
    });

    /* TASACION FIA: Lee la ruta del PDF del atributo name y lo abre en una nueva pestana. */
    $("#contenido").on("click", "a#rutaImgTasFiaOrig", function () {
        var ruta = $(this).attr('name');
        window.open(ruta, '_blank');
    });

    /* GARANTIA FIA: Lee la ruta del PDF del atributo name y lo abre en una nueva pestana. */
    $("#contenido").on("click", "a#rutaImgGtiaLeaOrig", function () {
        var ruta = $(this).attr('name');
        window.open(ruta, '_blank');
    });

    /* TASACION FIA: Lee la ruta del PDF del atributo name y lo abre en una nueva pestana. */
    $("#contenido").on("click", "a#rutaImgTasLeaOrig", function () {
        var ruta = $(this).attr('name');
        window.open(ruta, '_blank');
    });

    /* GARANTIA CAR: Lee la ruta del PDF del atributo name y lo abre en una nueva pestana. */
    $("#contenido").on("click", "a#rutaImgGtiaCartOrig", function () {
        var ruta = $(this).attr('name');
        window.open(ruta, '_blank');
    });

    /* CONTRATO CAR: Lee la ruta del PDF del atributo name y lo abre en una nueva pestana. */
    $("#contenido").on("click", "a#rutaImgContOrig", function () {
        var ruta = $(this).attr('name');
        window.open(ruta, '_blank');
    });

    /* PAGARE CAR: Lee la ruta del PDF del atributo name y lo abre en una nueva pestana. */
    $("#contenido").on("click", "a#rutaImgPagaOrig", function () {
        var ruta = $(this).attr('name');
        window.open(ruta, '_blank');
    });

    /* Muestra el mensaje recibido debajo del titulo del formulario (MODIFICAR GARANTIA) */
    function mostrar(mensaje) {
        $("h5#mensaje").remove();
        $("<h5 id='mensaje'>" + mensaje + "</h5>").insertAfter("#contenido h4");
        $('html,body').animate({scrollTop: $("#contenido").offset().top}, 300);
    }

});



