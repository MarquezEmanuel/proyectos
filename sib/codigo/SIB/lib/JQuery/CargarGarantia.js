
$(document).ready(function () {

    /* Oculta/Muestra los campos pertenecientes a la hipoteca */
    
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

});