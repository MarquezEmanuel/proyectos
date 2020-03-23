
/* 
 * Mi perfil.
 */
$(document).ready(function () {

    $("#btnCambiarAvatar").click(function () {
        if ($('#cardAvatares').is(':visible')) {
            $('#cardAvatares').hide();
        } else {
            $('#cardAvatares').show();
        }
    });

    $("#formCambiarAvatar").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificarMiPerfil.php",
            data: $("#formCambiarAvatar").serialize(),
            success: function (data) {
                $('#resultado').html(data[0]['resultado']);
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#resultado").html(div);
            },
            complete: function () {
                $('html, body').animate({scrollTop: $("#resultado").offset().top}, '1250');
            }
        });
    });
});

