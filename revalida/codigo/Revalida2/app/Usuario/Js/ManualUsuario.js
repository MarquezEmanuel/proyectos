/* 
 * Controla los eventos 
 */
$(document).ready(function () {

    $(".ocultar").click(function () {
        var seccion = $(this).attr("name");
        $("#body-" + seccion).hide();
        $("#mostrar-" + seccion).show();
        $(this).hide();
    });

    $(".mostrar").click(function () {
        var seccion = $(this).attr("name");
        $("#body-" + seccion).show();
        $("#ocultar-" + seccion).show();
        $(this).hide();
    });

    $(".seccion").click(function () {
        var seccion = $(this).attr("name");
        $('html, body').animate({scrollTop: $("#" + seccion).offset().top}, '1250');
    });
});

