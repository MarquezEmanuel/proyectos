
$(document).ready(function () {

    var cantidad = 1;

    $('#formCrearRTE').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "procesarCrearRTEPF.php",
            data: $("#formCrearRTE").serialize(),
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").html(data);
            },
            error: function (msg) {
                console.log(msg);
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });

    $("#agregar").click(function (event) {
        cantidad = cantidad + 1;
        event.preventDefault();
        var print = '<fieldset id="datos" name="' + cantidad + '" class="border p-2 mt-sm-2" style="border-color: #b9b9b9 !important;">\n\
            <legend class="w-auto" style="font-size: 1em; font-weight: bold;"> \n\
                <button class="remover btn btn-sm btn-outline-danger text-right" title"Remover sujeto">\n\
                    <img src="../../lib/img/DELETE.png" width="15" height="15" >\n\
                </button>\n\
            </legend>\n\
            <div class="form-group row"> \n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Relación fondos:</label>  \n\
                <div class="col">\n\
                    <select class="form-control" id="rfondos" name="rfondos[]" title="Relación con los fondos"> \n\
                        <option value="Operador/Titular">Operador/Titular</option> \n\
                        <option value="Titular">Titular</option> \n\
                        <option value="Operador">Operador</option> \n\
                        <option value="Vinculado al producto operado">Vinculado al producto operado</option> \n\
                    </select> \n\
                </div> \n\
           </div> \n\
           <div class="form-group row"> \n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* CUIT/CUIL/CDI:</label>  \n\
                <div class="col"> \n\
                    <input type="text" class="form-control" id="cuit" name="cuit[]" placeholder="CUIT/CUIL/CDI" required> \n\
                </div> \n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de persona:</label> \n\
                <div class="col">\n\
                    <select class="form-control tipop" id="tipop" name="tipop[]" title="Tipo de persona"> \n\
                        <option value="Persona física">Persona Física</option> \n\
                        <option value="Persona Jurídica">Persona Jurídica</option> \n\
                    </select> \n\
                </div>\n\
            </div> \n\
            <div class="form-group row"> \n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Apellidos:</label>  \n\
                <div class="col">\n\
                    <input type="text" class="form-control" id="apellidos" name="apellidos[]" minlength="1" maxlength="100" placeholder="Apellidos" title="Apellidos del sujeto vinculado" required> \n\
                </div> \n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona física"> Nombres:</label>  \n\
                    <div class="col">\n\
                        <input type="text" class="form-control nombres' + cantidad + '" id="nombres" name="nombres[]" minlength="1" maxlength="100" placeholder="Nombres" title="Nombres del sujeto vinculado" required>\n\
                    </div>\n\
                </div>\n\
            <div class="form-group row">\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona física"> Tipo Documento:</label>\n\
                <div class="col">\n\
                     <select class="form-control tipodoc' + cantidad + '" id="tipodoc" name="tipodoc[]" title="Tipo de documento del sujeto vinculado">\n\
                        <option value="Documento Nacional de Identidad">DNI</option>\n\
                        <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>\n\
                        <option value="Libreta Cívica">Libreta cívica</option>\n\
                        <option value="Cédula Mercosur">Cédula Mercosur</option>\n\
                        <option value="Pasaporte">Pasaporte</option>\n\
                    </select>\n\
                </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona física"> Número:</label> \n\
                <div class="col">\n\
                    <input type="text" class="form-control dni' + cantidad + '" id="dni" name="dni[]" min="1" placeholder="Número de documento" title="Número de documento del sujeto vinculado" required>\n\
                </div>\n\
            </div>\n\
            \n\
        </fieldset>';
        $(".add").append(print);

    });

    $('#datos').on("click", "button.remover", function (e) {
        e.preventDefault();
        $(this).parent().parent('fieldset').remove();
    });

    $('#tipot').change(function () {
        var tipot = $(this).val();
        if (tipot === "Extracción") {
            $("#provincia").prop("readonly", "true");
            $("#localidad").prop("readonly", "true");
            $("#calle").prop("readonly", "true");
            $("#numero").prop("readonly", "true");
            $("#provincia").val("");
            $("#localidad").val("");
            $("#calle").val("");
            $("#numero").val("");
        } else {
            $("#provincia").prop("readonly", "");
            $("#localidad").prop("readonly", "");
            $("#calle").prop("readonly", "");
            $("#numero").prop("readonly", "");
        }
    });

    $('#datos').on("change", "select.tipop", function () {
        var numero = $(this).parent().parent().parent().attr("name");
        var tipop = $(this).val();
        if (tipop === "Persona Jurídica") {
            $('.nombres' + numero).prop("readonly", "true");
            $('.tipodoc' + numero).prop("disabled", "true");
            $('.dni' + numero).prop("readonly", "true");
        } else {
            $('.nombres' + numero).prop("readonly", "");
            $('.tipodoc' + numero).prop("disabled", "");
            $('.dni' + numero).prop("readonly", "");
        }

    });

});