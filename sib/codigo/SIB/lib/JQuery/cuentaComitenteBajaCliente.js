$(document).ready(function () {

    var cantidad = 0;
    var cantidadVinculado = 0;
    $('#formBajaCliente').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "procesarCrearBajaCliente.php",
            data: $("#formBajaCliente").serialize(),
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

    $("#agregarCliente").click(function (event) {
        cantidad = cantidad + 1;
        event.preventDefault();
        var print = '<fieldset id="datos" name="' + cantidad + '" class="border p-2 mt-sm-2" style="border-color: #b9b9b9 !important;">\n\
            <legend class="w-auto" style="font-size: 1em; font-weight: bold;"> \n\
                <button class="remover btn btn-sm btn-outline-danger text-right" title"Remover sujeto">\n\
                    <img src="../../lib/img/DELETE.png" width="15" height="15" >\n\
                </button>\n\
                Agregar Cliente\n\
            </legend>\n\
            <div class="form-group row"> \n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de cliente baja:</label>  \n\
                <div class="col">\n\
                    <select class="form-control" id="tipoClienteBaja" name="tipoClienteBaja[]" title="Tipo de cliente"> \n\
                        <option value="FCI">FCI</option> \n\
                        <option value="Fideicomiso">Fideicomiso</option> \n\
                        <option value="Organismo Público">Organismo Público</option> \n\
                        <option value="Otro">Otro</option> \n\
                    </select> \n\
                </div> \n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* CUIT/CUIL/CDI:</label>  \n\
                <div class="col"> \n\
                    <input type="text" class="form-control" id="cuitBaja" name="cuitBaja[]" placeholder="CUIT/CUIL/CDI"> \n\
                </div> \n\
           </div> \n\
           <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de Persona:</label>  \n\
                <div class="col">\n\
                    <select class="form-control tipoPersonaBaja" id="tipoPersonaBaja" name="tipoPersonaBaja[]" title="Tipo de persona"> \n\
                        <option value="Seleccionar">Seleccionar...</option> \n\
                        <option value="Persona humana">Persona humana</option> \n\
                        <option value="Persona humana extranjera">Persona humana extranjera</option> \n\
                        <option value="Persona jurídica">Persona jurídica</option> \n\
                        <option value="Persona jurídica extranjera">Persona jurídica extranjera</option> \n\
                    </select> \n\
                </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Apellido:</label>  \n\
                <div class="col">\n\
                        <input type="text" class="form-control apellidoBaja'+cantidad+'" id="apellidoBaja" name="apellidoBaja[]" minlength="1" maxlength="100" placeholder="Apellido" title="Apellido del sujeto vinculado" required>\n\
                </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Nombre:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control nombreBaja'+cantidad+'" id="nombreBaja" name="nombreBaja[]" minlength="1" maxlength="100" placeholder="Nombre" title="Nombre del sujeto vinculado" required>\n\
                </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Tipo de documento:</label> \n\
                <div class="col">\n\
                    <select class="form-control tipoDocumentoBaja'+cantidad+'" id="tipoDocumentoBaja" name="tipoDocumentoBaja[]" title="Tipo de documento del cliente"> \n\
                        <option value="Documento Nacional de Identidad">Documento Nacional de Identidad</option> \n\
                        <option value="Libreta de Enrolamiento">Libreta de Enrolamiento</option> \n\
                        <option value="Libreta Cívica">Libreta Cívica</option> \n\
                        <option value="Cédula Mercosur">Cédula Mercosur</option> \n\
                        <option value="Pasaporte">Pasaporte</option> \n\
                        <option value="Pasaporte EXT">Pasaporte EXT</option> \n\
                        <option value="Documento EXT">Documento EXT</option> \n\
                    </select> \n\
                </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Numero de Documento:</label>\n\
                <div class="col">\n\
                        <input type="text" class="form-control numeroDocumentoBaja'+cantidad+'" id="numeroDocumentoBaja" name="numeroDocumentoBaja[]" minlength="1" maxlength="100" placeholder="Numero de documento" title="Numero de documento" required>\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona juridica o persona juridica humana">* Denominacion:</label> \n\
                <div class="col">\n\
                    <input type="text" class="form-control denominacionBaja'+cantidad+'" id="denominacionBaja" name="denominacionBaja[]" minlength="1" maxlength="100" placeholder="Denominacion" title="Denominacion">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Fecha de Constitucion :</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control fechaConstitucionBaja'+cantidad+'" id="fechaConstitucionBaja" name="fechaConstitucionBaja[]" title="AAAA-MM-DDT00:00:00" placeholder="AAAA-MM-DDT00:00:00">\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Riesgo asignado al cliente:</label> \n\
                <div class="col">\n\
                        <select class="form-control" id="riesgoBaja" name="riesgoBaja[]" title="Riesgo asignado al cliente"> \n\
                        <option value="Seleccionar">Seleccionar...</option> \n\
                        <option value="Bajo">Bajo</option> \n\
                        <option value="Medio bajo">Medio bajo</option> \n\
                        <option value="Medio">Medio</option> \n\
                        <option value="Medio alto">Medio alto</option> \n\
                        <option value="Alto">Alto</option> \n\
                    </select> \n\
                    </div>\n\
            </div>\n\
        </fieldset>';
        $(".add").append(print);

    });
    
    
    $("#agregarClienteVinculado").click(function (event) {
        cantidad = cantidad + 1;
        event.preventDefault();
        var print = '<fieldset id="datos" name="' + cantidadVinculado + '" class="border p-2 mt-sm-2" style="border-color: #b9b9b9 !important;">\n\
            <legend class="w-auto" style="font-size: 1em; font-weight: bold;"> \n\
                <button class="remover btn btn-sm btn-outline-danger text-right" title"Remover sujeto">\n\
                    <img src="../../lib/img/DELETE.png" width="15" height="15" >\n\
                </button>\n\
                Agregar Cliente Vinculado\n\
            </legend>\n\
            <div class="form-group row"> \n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Naturaleza del vinculo:</label>  \n\
                <div class="col">\n\
                    <select class="form-control" id="naturalezaSujetoVinculado" name="naturalezaSujetoVinculado[]" title="Naturaleza del vinculo"> \n\
                        <option value="Apoderado">Apoderado</option> \n\
                        <option value="Tutor">Tutor</option> \n\
                        <option value="Curador">Curador</option> \n\
                        <option value="Representante">Representante</option> \n\
                        <option value="Garante">Garante</option> \n\
                        <option value="Fiduciario">Fiduciario</option> \n\
                        <option value="Administrador del fideicomiso">Administrador del fideicomiso</option> \n\
                        <option value="Participante en la constitución y organización del FCI/Fideicomiso">Participante en la constitución y organización del FCI/Fideicomiso</option> \n\
                        <option value="Sociedad Gerente">Sociedad Gerente</option> \n\
                    </select> \n\
                </div> \n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* CUIT/CUIL/CDI:</label>  \n\
                <div class="col"> \n\
                    <input type="text" class="form-control" id="cuitSujetoVinculado" name="cuitSujetoVinculado[]" placeholder="CUIT/CUIL/CDI"> \n\
                </div> \n\
           </div> \n\
           <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de Persona:</label>  \n\
                <div class="col">\n\
                    <select class="form-control tipoPersonaSujetoVinculado" id="tipoPersonaSujetoVinculado" name="tipoPersonaSujetoVinculado[]" title="Tipo de cliente vinculado"> \n\
                        <option value="Seleccionar">Seleccionar...</option> \n\
                        <option value="Persona humana">Persona humana</option> \n\
                        <option value="Persona humana extranjera">Persona humana extranjera</option> \n\
                        <option value="Persona jurídica">Persona jurídica</option> \n\
                        <option value="Persona jurídica extranjera">Persona jurídica extranjera</option> \n\
                    </select> \n\
                </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Apellido:</label>  \n\
                <div class="col">\n\
                        <input type="text" class="form-control apellidoSujetoVinculado'+cantidadVinculado+'" id="apellidoSujetoVinculado" name="apellidoSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Apellido" title="Apellido del sujeto vinculado" required>\n\
                </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Nombre:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control nombreSujetoVinculado'+cantidadVinculado+'" id="nombreSujetoVinculado" name="nombreSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Nombre" title="Nombre del sujeto vinculado" required>\n\
                </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Tipo de documento:</label> \n\
                <div class="col">\n\
                    <select class="form-control tipoDocumentoSujetoVinculado'+cantidadVinculado+'" id="tipoDocumentoSujetoVinculado" name="tipoDocumentoSujetoVinculado[]" title="Tipo de documento del cliente"> \n\
                        <option value="Documento Nacional de Identidad">Documento Nacional de Identidad</option> \n\
                        <option value="Libreta de Enrolamiento">Libreta de Enrolamiento</option> \n\
                        <option value="Libreta Cívica">Libreta Cívica</option> \n\
                        <option value="Cédula Mercosur">Cédula Mercosur</option> \n\
                        <option value="Pasaporte">Pasaporte</option> \n\
                        <option value="Pasaporte EXT">Pasaporte EXT</option> \n\
                        <option value="Documento EXT">Documento EXT</option> \n\
                    </select> \n\
                </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Numero de Documento:</label>\n\
                <div class="col">\n\
                        <input type="text" class="form-control numeroDocumentoSujetoVinculado'+cantidadVinculado+'" id="numeroDocumentoSujetoVinculado" name="numeroDocumentoSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Numero de documento" title="Numero de documento" required>\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona juridica o persona juridica extranjera">* Denominacion :</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control denominacionSujetoVinculado'+cantidadVinculado+'" id="denominacionSujetoVinculado" name="denominacionSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Denominacion" title="Denominacion">\n\
                    </div>\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona juridica o persona juridica extranjera">* Fecha de Constitucion:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control fechaConstitucionSujetoVinculado'+cantidadVinculado+'" id="fechaConstitucionSujetoVinculado" name="fechaConstitucionSujetoVinculado[]" title="AAAA-MM-DDT00:00:00" placeholder="AAAA-MM-DDT00:00:00">\n\
                    </div>\n\
            </div>\n\
        </fieldset>';
        $(".add").append(print);

    });

    $('#datos').on("click", "button.remover", function (e) {
        e.preventDefault();
        $(this).parent().parent('fieldset').remove();
    });
    
    $('#datos').on("change", "select.tipoPersonaBaja", function () {
        var numero = $(this).parent().parent().parent().attr("name");
        var tipop = $(this).val();
        if (tipop === "Persona jurídica" || tipop === "Persona jurídica extranjera") {
            $('.apellidoBaja' + numero).prop("readonly", "true");
            $('.nombreBaja' + numero).prop("readonly", "true");
            $('.tipoDocumentoBaja' + numero).prop("disabled", "true");
            $('.numeroDocumentoBaja' + numero).prop("readonly", "true");
            $("#apellidoBaja").val("");
            $("#nombreBaja").val("");
            $("#tipoDocumentoBaja").val("");
            $("#numeroDocumentoBaja").val("");
            $('.denominacionBaja' + numero).prop("readonly", "");
            $('.fechaConstitucionBaja' + numero).prop("readonly", "")
        } else {
        if (tipop === "Persona humana" || tipop === "Persona humana extranjera") {
            $('.denominacionBaja' + numero).prop("readonly", "true");
            $('.fechaConstitucionBaja' + numero).prop("readonly", "true");
            $("#denominacionBaja").val("");
            $("#fechaConstitucionBaja").val("");
            $('.apellidoBaja' + numero).prop("readonly", "");
            $('.nombreBaja' + numero).prop("readonly", "");
            $('.tipoDocumentoBaja' + numero).prop("disabled", "");
            $('.numeroDocumentoBaja' + numero).prop("readonly", "");
        }
    }
    });
    
    
    $('#datos').on("change", "select.tipoPersonaSujetoVinculado", function () {
        var numero = $(this).parent().parent().parent().attr("name");
        var tipop = $(this).val();
        if (tipop === "Persona jurídica" || tipop === "Persona jurídica extranjera") {
            $('.apellidoSujetoVinculado' + numero).prop("readonly", "true");
            $('.nombreSujetoVinculado' + numero).prop("readonly", "true");
            $('.tipoDocumentoSujetoVinculado' + numero).prop("disabled", "true");
            $('.numeroDocumentoSujetoVinculado' + numero).prop("readonly", "true");
            $("#apellidoSujetoVinculado").val("");
            $("#nombreSujetoVinculado").val("");
            $("#tipoDocumentoSujetoVinculado").val("");
            $("#numeroDocumentoSujetoVinculado").val("");
            $('.denominacionSujetoVinculado' + numero).prop("readonly", "");
            $('.fechaConstitucionSujetoVinculado' + numero).prop("readonly", "")
        } else {
        if (tipop === "Persona humana" || tipop === "Persona humana extranjera") {
            $('.denominacionSujetoVinculado' + numero).prop("readonly", "true");
            $('.fechaConstitucionSujetoVinculado' + numero).prop("readonly", "true");
            $("#denominacionSujetoVinculado").val("");
            $("#fechaConstitucionSujetoVinculado").val("");
            $('.apellidoSujetoVinculado' + numero).prop("readonly", "");
            $('.nombreSujetoVinculado' + numero).prop("readonly", "");
            $('.tipoDocumentoSujetoVinculado' + numero).prop("disabled", "");
            $('.numeroDocumentoSujetoVinculado' + numero).prop("readonly", "");
        }
    }
    });

});