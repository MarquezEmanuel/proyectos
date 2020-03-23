$(document).ready(function () {

buscar();

buscarCantSolicitudes();

function buscar(){

    $(".item").click(function(){

        var x = $(this).attr('id');
        
        $.ajax({
            type: "POST",
            url: "./BuscarSolicitudes.php",
            data: "x=" + x,
            beforeSend: function () {
                $('#cargando').show();
            },
            success: function (data) {
                $('#SolicitudesEnEspera').html(data);
                $('#tbAccesos').dataTable({
                    lengthChange: false,
                    language: {url: "../../../lib/JQuery/Spanish.json"}
                });
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#SolicitudesEnEspera").html(div);
            },
            complete: function () {
                setTimeout(function () {
                    $('#cargando').hide();
                }, 1000);
                $('html,body').animate({scrollTop: $("#SolicitudesEnEspera").offset().top}, '1250');
            }
        });
    });
}



function buscarCantSolicitudes(){

        var x = "ESPERANDO APROBACION";
        
        $.ajax({
            type: "POST",
            url: "./buscarSolicitudes.php",
            data: "x=" + x,
            beforeSend: function () {
                $('#cargando').show();
            },
            success: function (data) {
                $('#SolicitudesEnEspera').html(data);
                $('#tbAccesos').dataTable({
                    lengthChange: false,
                    language: {url: "../../../lib/JQuery/Spanish.json"}
                });
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#SolicitudesEnEspera").html(div);
            },
            complete: function () {
                setTimeout(function () {
                    $('#cargando').hide();
                }, 1000);
                $('html,body').animate({scrollTop: $("#SolicitudesEnEspera").offset().top}, '1250');
            }
        });
}

});