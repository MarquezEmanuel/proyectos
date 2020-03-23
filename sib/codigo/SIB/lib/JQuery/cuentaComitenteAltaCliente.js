$(document).ready(function () {

    var cantidad = 0;
    var cantidadVinculado = 0;
    $('#formAltaCliente').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "procesarCrearAltaCliente.php",
            data: $("#formAltaCliente").serialize(),
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
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de cliente alta:</label>  \n\
                <div class="col">\n\
                    <select class="form-control" id="tipoClienteAlta" name="tipoClienteAlta[]" title="Tipo de cliente"> \n\
                        <option value="FCI">FCI</option> \n\
                        <option value="Fideicomiso">Fideicomiso</option> \n\
                        <option value="Organismo Público">Organismo Público</option> \n\
                        <option value="Otro">Otro</option> \n\
                    </select> \n\
                </div> \n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* CUIT/CUIL/CDI:</label>  \n\
                <div class="col"> \n\
                    <input type="text" class="form-control" id="cuitAlta" name="cuitAlta[]" placeholder="CUIT/CUIL/CDI"> \n\
                </div> \n\
           </div> \n\
           <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de Persona:</label>  \n\
                <div class="col">\n\
                    <select class="form-control tipoPersonaAlta" id="tipoPersonaAlta" name="tipoPersonaAlta[]" title="Tipo de persona"> \n\
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
                        <input type="text" class="form-control apellidoAlta'+cantidad+'" id="apellidoAlta" name="apellidoAlta[]" minlength="1" maxlength="100" placeholder="Apellido" title="Apellido del sujeto vinculado" required>\n\
                </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Nombre:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control nombreAlta'+cantidad+'" id="nombreAlta" name="nombreAlta[]" minlength="1" maxlength="100" placeholder="Nombre" title="Nombre del sujeto vinculado" required>\n\
                </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Tipo de documento:</label> \n\
                <div class="col">\n\
                    <select class="form-control tipoDocumentoAlta'+cantidad+'" id="tipoDocumentoAlta" name="tipoDocumentoAlta[]" title="Tipo de documento del cliente"> \n\
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
                        <input type="text" class="form-control numeroDocumentoAlta'+cantidad+'" id="numeroDocumentoAlta" name="numeroDocumentoAlta[]" minlength="1" maxlength="100" placeholder="Numero de documento" title="Numero de documento" required>\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Genero:</label> \n\
                <div class="col"> \n\
                    <select class="form-control generoAlta'+cantidad+'" id="generoAlta" name="generoAlta[]" title="Genero del cliente"> \n\
                        <option value="Masculino">Masculino</option> \n\
                        <option value="Femenino">Femenino</option> \n\
                    </select> \n\
                </div> \n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Nacionalidad cliente:</label>\n\
                <div class="col">\n\
                        <input type="text" class="form-control nacionalidadAlta'+cantidad+'" id="nacionalidadAlta" name="nacionalidadAlta[]" minlength="1" maxlength="100" placeholder="Nacionalidad del cliente" title="Nacionalidad del cliente" required>\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Pais de nacimiento cliente:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control paisNacimientoAlta'+cantidad+'" id="paisNacimientoAlta" name="paisNacimientoAlta[]" minlength="1" maxlength="100" placeholder="Pais de nacimiento cliente" title="Pais de nacimiento cliente" required>\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Lugar de nacimiento:</label>\n\
                <div class="col">\n\
                        <input type="text" class="form-control lugarNacimientoAlta'+cantidad+'" id="lugarNacimientoAlta" name="lugarNacimientoAlta[]" minlength="1" maxlength="100" placeholder="Lugar de nacimiento del cliente" title="Lugar de nacimiento del cliente" required>\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Fecha de nacimiento:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control fechaNacimientoAlta'+cantidad+'" id="fechaNacimientoAlta" name="fechaNacimientoAlta[]" title="AAAA-MM-DDT00:00:00" placeholder="AAAA-MM-DDT00:00:00" required>\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Declara ser PEP:</label>\n\
                <div class="col">\n\
                    <select class="form-control pepAlta'+cantidad+'" id="pepAlta" name="pepAlta[]" title="Genero del cliente"> \n\
                        <option value="Si">Si</option> \n\
                        <option value="No">No</option> \n\
                    </select> \n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona juridica o persona juridica humana">* Denominacion:</label> \n\
                <div class="col">\n\
                    <input type="text" class="form-control denominacionAlta'+cantidad+'" id="denominacionAlta" name="denominacionAlta[]" minlength="1" maxlength="100" placeholder="Denominacion" title="Denominacion">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Fecha de Constitucion :</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control fechaConstitucionAlta'+cantidad+'" id="fechaConstitucionAlta" name="fechaConstitucionAlta[]" title="AAAA-MM-DDT00:00:00" placeholder="AAAA-MM-DDT00:00:00" required>\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Riesgo asignado al cliente:</label> \n\
                <div class="col">\n\
                        <select class="form-control" id="riesgoAlta" name="riesgoAlta[]" title="Riesgo asignado al cliente"> \n\
                        <option value="Bajo">Bajo</option> \n\
                        <option value="Medio bajo">Medio bajo</option> \n\
                        <option value="Medio">Medio</option> \n\
                        <option value="Medio alto">Medio alto</option> \n\
                        <option value="Alto">Alto</option> \n\
                    </select> \n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Pais :</label>\n\
                <div class="col">\n\
                    <select class="form-control paisAlta" id="paisAlta" name="paisAlta[]" title="Pais cliente"> \n\
                        <option value="Seleccionar">Seleccionar...</option> \n\
                        <option value="Argentina">Argentina</option> \n\
                        <option value="Otro">Otro</option> \n\
                    </select> \n\
                    </div>\n\
            </div>\n\
            <hr /><hr />\n\
            <h5>Completar solo si pais es Argentina</h5>\n\
            <hr /><hr />\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Argentina">* Provincia:</label> \n\
                <div class="col">\n\
                        <select class="form-control provinciaAlta'+cantidad+'" id="provinciaAlta" name="provinciaAlta[]" title="Provincia"> \n\
                        <option value="Ninguna">Ninguna</option> \n\
                        <option value="CABA">CABA</option> \n\
                        <option value="Buenos Aires">Buenos Aires</option> \n\
                        <option value="Catamarca">Catamarca</option> \n\
                        <option value="Córdoba">Córdoba</option> \n\
                        <option value="Corrientes">Corrientes</option> \n\
                        <option value="Chaco">Chaco</option> \n\
                        <option value="Chubut">Chubut</option> \n\
                        <option value="Entre Ríos">Entre Ríos</option> \n\
                        <option value="Formosa">Formosa</option> \n\
                        <option value="Jujuy">Jujuy</option> \n\
                        <option value="La Pampa">La Pampa</option> \n\
                        <option value="La Rioja">La Rioja</option> \n\
                        <option value="Mendoza">Mendoza</option> \n\
                        <option value="Misiones">Misiones</option> \n\
                        <option value="Neuquén">Neuquén</option> \n\
                        <option value="Río Negro">Río Negro</option> \n\
                        <option value="Salta">Salta</option> \n\
                        <option value="San Juan">San Juan</option> \n\
                        <option value="San Luis">San Luis</option> \n\
                        <option value="Santa Cruz">Santa Cruz</option> \n\
                        <option value="Santa Fé">Santa Fé</option> \n\
                        <option value="Santiago Del Estero">Santiago Del Estero</option> \n\
                        <option value="Tucumán">Tucumán</option> \n\
                        <option value="Tierra del Fuego">Tierra del Fuego</option> \n\
                    </select> \n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Argentina">* Localidad:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control localidadAlta'+cantidad+'" id="localidadAlta" name="localidadAlta[]" minlength="1" maxlength="100" placeholder="Localidad alta cliente" title="Localidad alta de cliente">\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Argentina">* Calle:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control calleAlta'+cantidad+'" id="calleAlta" name="calleAlta[]" minlength="1" maxlength="100" placeholder="Calle alta cliente" title="Calle alta de cliente">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Argentina">* Numero:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control numeroAlta'+cantidad+'" id="numeroAlta" name="numeroAlta[]" minlength="1" maxlength="100" placeholder="Numero alta cliente" title="Numero alta de cliente">\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Argentina">* Piso:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control pisoAlta'+cantidad+'" id="pisoAlta" name="pisoAlta[]" minlength="1" maxlength="100" placeholder="Piso alta cliente" title="Piso alta de cliente">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Argentina">* Departamento:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control departamentoAlta'+cantidad+'" id="departamentoAlta" name="departamentoAlta[]" minlength="1" maxlength="100" placeholder="Departamento alta cliente" title="Departamento alta de cliente">\n\
                    </div>\n\
            </div>\n\
            <hr /><hr />\n\
            <h5>Completar solo si pais es Otro</h5>\n\
            <hr /><hr />\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Otro">* Otro Pais:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control otroPaisAlta'+cantidad+'" id="otroPaisAlta" name="otroPaisAlta[]" minlength="1" maxlength="100" placeholder="Otro pais alta cliente" title="Otro pais alta de cliente">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Otro">* Provincia/Estado:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control provinciaEstadoAlta'+cantidad+'" id="provinciaEstadoAlta" name="provinciaEstadoAlta[]" minlength="1" maxlength="100" placeholder="Provincia / Estado alta cliente" title="Provincia / Estado alta de cliente">\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Otro">* Localidad/Ciudad:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control localidadCiudadAlta'+cantidad+'" id="localidadCiudadAlta" name="localidadCiudadAlta[]" minlength="1" maxlength="100" placeholder="Localidad / Ciudad alta cliente" title="Localidad / Ciudad alta de cliente">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Otro">* Domicilio / Direccion:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control domicilioDireccionAlta'+cantidad+'" id="domicilioDireccionAlta" name="domicilioDireccionAlta[]" minlength="1" maxlength="100" placeholder="Domicilio /Direccion alta cliente" title="Domicilio / Direccion alta de cliente">\n\
                    </div>\n\
            </div>\n\
            <hr /><hr />\n\
            <h5>Campos no obligatorios</h5>\n\
            <hr /><hr />\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label">* Codigo Postal:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control" id="codigoPostalAlta" name="codigoPostalAlta[]" minlength="1" maxlength="100" placeholder="Codigo postal alta cliente" title="Codigo postal alta de cliente">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label">* Codigo de area:</label> \n\
                <div class="col">\n\
                        <input type="number" class="form-control" id="codigoAreaAlta" name="codigoAreaAlta[]" minlength="1" maxlength="100" placeholder="Codigo de area alta cliente" title="Codigo de area alta de cliente">\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label">* Telefono:</label>\n\
                <div class="col">\n\
                    <input type="number" class="form-control" id="telefonoAlta" name="telefonoAlta[]" minlength="1" maxlength="100" placeholder="Telefono alta cliente" title="Telefono alta de cliente">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label">* Correo electronico:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control" id="correoElectronicoAlta" name="correoElectronicoAlta[]" minlength="1" maxlength="100" placeholder="Correo electronico alta cliente" title="Correo electronico alta de cliente">\n\
                    </div>\n\
            </div>\n\
        </fieldset>';
        $(".add").append(print);

    });
    
    
    $("#agregarClienteVinculado").click(function (event) {
        cantidadVinculado = cantidadVinculado + 1;
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
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Genero:</label> \n\
                <div class="col"> \n\
                    <select class="form-control generoSujetoVinculado'+cantidadVinculado+'" id="generoSujetoVinculado" name="generoSujetoVinculado[]" title="Genero del cliente"> \n\
                        <option value="Masculino">Masculino</option> \n\
                        <option value="Femenino">Femenino</option> \n\
                    </select> \n\
                </div> \n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Nacionalidad cliente:</label>\n\
                <div class="col">\n\
                        <input type="text" class="form-control nacionalidadSujetoVinculado'+cantidadVinculado+'" id="nacionalidadSujetoVinculado" name="nacionalidadSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Nacionalidad del cliente" title="Nacionalidad del cliente" required>\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Pais de nacimiento cliente:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control paisNacimientoSujetoVinculado'+cantidadVinculado+'" id="paisNacimientoSujetoVinculado" name="paisNacimientoSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Pais de nacimiento cliente" title="Pais de nacimiento cliente" required>\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Lugar de nacimiento:</label>\n\
                <div class="col">\n\
                        <input type="text" class="form-control lugarNacimientoSujetoVinculado'+cantidadVinculado+'" id="lugarNacimientoSujetoVinculado" name="lugarNacimientoSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Lugar de nacimiento del cliente" title="Lugar de nacimiento del cliente" required>\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona humana o persona humana extranjera">* Fecha de nacimiento:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control fechaNacimientoSujetoVinculado'+cantidadVinculado+'" id="fechaNacimientoSujetoVinculado" name="fechaNacimientoSujetoVinculado[]" title="AAAA-MM-DDT00:00:00" placeholder="AAAA-MM-DDT00:00:00" required>\n\
                    </div>\n\
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona juridica o persona juridica extranjera">* Denominacion :</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control denominacionSujetoVinculado'+cantidadVinculado+'" id="denominacionSujetoVinculado" name="denominacionSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Denominacion" title="Denominacion">\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona juridica o persona juridica extranjera">* Fecha de Constitucion:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control fechaConstitucionSujetoVinculado'+cantidadVinculado+'" id="fechaConstitucionSujetoVinculado" name="fechaConstitucionSujetoVinculado[]" title="AAAA-MM-DDT00:00:00" placeholder="AAAA-MM-DDT00:00:00" required>\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Pais :</label>\n\
                <div class="col">\n\
                    <select class="form-control paisSujetoVinculado" id="paisSujetoVinculado" name="paisSujetoVinculado[]" title="Pais sujeto vinculado"> \n\
                        <option value="Seleccionar">Seleccionar...</option> \n\
                        <option value="Argentina">Argentina</option> \n\
                        <option value="Otro">Otro</option> \n\
                    </select> \n\
                    </div>\n\
            </div>\n\
            <hr /><hr />\n\
            <h5>Completar solo si pais es Argentina</h5>\n\
            <hr /><hr />\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Argentina">* Provincia:</label> \n\
                <div class="col">\n\
                        <select class="form-control provinciaSujetoVinculado'+cantidadVinculado+'" id="provinciaSujetoVinculado" name="provinciaSujetoVinculado[]" title="Provincia"> \n\
                        <option value="Ninguna">Ninguna</option> \n\
                        <option value="CABA">CABA</option> \n\
                        <option value="Buenos Aires">Buenos Aires</option> \n\
                        <option value="Catamarca">Catamarca</option> \n\
                        <option value="Córdoba">Córdoba</option> \n\
                        <option value="Corrientes">Corrientes</option> \n\
                        <option value="Chaco">Chaco</option> \n\
                        <option value="Chubut">Chubut</option> \n\
                        <option value="Entre Ríos">Entre Ríos</option> \n\
                        <option value="Formosa">Formosa</option> \n\
                        <option value="Jujuy">Jujuy</option> \n\
                        <option value="La Pampa">La Pampa</option> \n\
                        <option value="La Rioja">La Rioja</option> \n\
                        <option value="Mendoza">Mendoza</option> \n\
                        <option value="Misiones">Misiones</option> \n\
                        <option value="Neuquén">Neuquén</option> \n\
                        <option value="Río Negro">Río Negro</option> \n\
                        <option value="Salta">Salta</option> \n\
                        <option value="San Juan">San Juan</option> \n\
                        <option value="San Luis">San Luis</option> \n\
                        <option value="Santa Cruz">Santa Cruz</option> \n\
                        <option value="Santa Fé">Santa Fé</option> \n\
                        <option value="Santiago Del Estero">Santiago Del Estero</option> \n\
                        <option value="Tucumán">Tucumán</option> \n\
                        <option value="Tierra del Fuego">Tierra del Fuego</option> \n\
                    </select> \n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Argentina">* Localidad:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control localidadSujetoVinculado'+cantidadVinculado+'" id="localidadSujetoVinculado" name="localidadSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Localidad alta cliente" title="Localidad alta de cliente">\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Argentina">* Calle:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control calleSujetoVinculado'+cantidadVinculado+'" id="calleSujetoVinculado" name="calleSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Calle alta cliente" title="Calle alta de cliente">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Argentina">* Numero:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control numeroSujetoVinculado'+cantidadVinculado+'" id="numeroSujetoVinculado" name="numeroSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Numero alta cliente" title="Numero alta de cliente">\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Argentina">* Piso:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control pisoSujetoVinculado'+cantidadVinculado+'" id="pisoSujetoVinculado" name="pisoSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Piso alta cliente" title="Piso alta de cliente">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Argentina">* Departamento:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control departamentoSujetoVinculado'+cantidadVinculado+'" id="departamentoSujetoVinculado" name="departamentoSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Departamento alta cliente" title="Departamento alta de cliente">\n\
                    </div>\n\
            </div>\n\
            <hr /><hr />\n\
            <h5>Completar solo si pais es Otro</h5>\n\
            <hr /><hr />\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Otro">* Otro Pais:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control otroPaisSujetoVinculado'+cantidadVinculado+'" id="otroPaisSujetoVinculado" name="otroPaisSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Otro pais alta cliente" title="Otro pais alta de cliente">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Otro">* Provincia/Estado:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control provinciaEstadoSujetoVinculado'+cantidadVinculado+'" id="provinciaEstadoSujetoVinculado" name="provinciaEstadoSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Provincia / Estado alta cliente" title="Provincia / Estado alta de cliente">\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Otro">* Localidad/Ciudad:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control localidadCiudadSujetoVinculado'+cantidadVinculado+'" id="localidadCiudadSujetoVinculado" name="localidadCiudadSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Localidad / Ciudad alta cliente" title="Localidad / Ciudad alta de cliente">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label" title="Campo obligatorio solo si el pais es Otro">* Domicilio / Direccion:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control domicilioDireccionSujetoVinculado'+cantidadVinculado+'" id="domicilioDireccionSujetoVinculado" name="domicilioDireccionSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Domicilio /Direccion alta cliente" title="Domicilio / Direccion alta de cliente">\n\
                    </div>\n\
            </div>\n\
            <hr /><hr />\n\
            <h5>Campos no obligatorios</h5>\n\
            <hr /><hr />\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label">* Codigo Postal:</label>\n\
                <div class="col">\n\
                    <input type="text" class="form-control" id="codigoPostalSujetoVinculado" name="codigoPostalSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Codigo postal alta cliente" title="Codigo postal alta de cliente">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label">* Codigo de area:</label> \n\
                <div class="col">\n\
                        <input type="number" class="form-control" id="codigoAreaSujetoVinculado" name="codigoAreaSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Codigo de area alta cliente" title="Codigo de area alta de cliente">\n\
                    </div>\n\
            </div>\n\
            <div class="form-group row">\n\
            <label class="col-sm-2 col-form-label">* Telefono:</label>\n\
                <div class="col">\n\
                    <input type="number" class="form-control" id="telefonoSujetoVinculado" name="telefonoSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Telefono alta cliente" title="Telefono alta de cliente">\n\
                    </div>\n\
                <label class="col-sm-2 col-form-label">* Correo electronico:</label> \n\
                <div class="col">\n\
                        <input type="text" class="form-control" id="correoElectronicoSujetoVinculado" name="correoElectronicoSujetoVinculado[]" minlength="1" maxlength="100" placeholder="Correo electronico alta cliente" title="Correo electronico alta de cliente">\n\
                    </div>\n\
            </div>\n\
        </fieldset>';
        $(".add").append(print);

    });

    $('#datos').on("click", "button.remover", function (e) {
        e.preventDefault();
        $(this).parent().parent('fieldset').remove();
    });
    
    $('#datos').on("change", "select.tipoPersonaAlta", function () {
        var numero = $(this).parent().parent().parent().attr("name");
        var tipop = $(this).val();
        if (tipop === "Persona jurídica" || tipop === "Persona jurídica extranjera") {
            $('.apellidoAlta' + numero).prop("readonly", "true");
            $('.nombreAlta' + numero).prop("readonly", "true");
            $('.tipoDocumentoAlta' + numero).prop("disabled", "true");
            $('.numeroDocumentoAlta' + numero).prop("readonly", "true");
            $('.generoAlta' + numero).prop("disabled", "true");
            $('.nacionalidadAlta' + numero).prop("readonly", "true");
            $('.paisNacimientoAlta' + numero).prop("readonly", "true");
            $('.lugarNacimientoAlta' + numero).prop("readonly", "true");
            $('.fechaNacimientoAlta' + numero).prop("readonly", "true");
            $('.pepAlta' + numero).prop("disabled", "true");
            $("#apellidoAlta").val("");
            $("#nombreAlta").val("");
            $("#tipoDocumentoAlta").val("");
            $("#numeroDocumentoAlta").val("");
            $("#generoAlta").val("");
            $("#nacionalidadAlta").val("");
            $("#paisNacimientoAlta").val("");
            $("#lugarNacimientoAlta").val("");
            $("#fechaNacimientoAlta").val("");
            $("#pepAlta").val("");
            $('.denominacionAlta' + numero).prop("readonly", "");
            $('.fechaConstitucionAlta' + numero).prop("readonly", "")
        } else {
        if (tipop === "Persona humana" || tipop === "Persona humana extranjera") {
            $('.denominacionAlta' + numero).prop("readonly", "true");
            $('.fechaConstitucionAlta' + numero).prop("readonly", "true");
            $("#denominacionAlta").val("");
            $("#fechaConstitucionAlta").val("");
            $('.apellidoAlta' + numero).prop("readonly", "");
            $('.nombreAlta' + numero).prop("readonly", "");
            $('.tipoDocumentoAlta' + numero).prop("disabled", "");
            $('.numeroDocumentoAlta' + numero).prop("readonly", "");
            $('.generoAlta' + numero).prop("disabled", "");
            $('.nacionalidadAlta' + numero).prop("readonly", "");
            $('.paisNacimientoAlta' + numero).prop("readonly", "");
            $('.lugarNacimientoAlta' + numero).prop("readonly", "");
            $('.fechaNacimientoAlta' + numero).prop("readonly", "");
            $('.pepAlta' + numero).prop("disabled", "");
        }
    }
    });
    
    
    
    $('#datos').on("change", "select.paisAlta", function () {
        var numero = $(this).parent().parent().parent().attr("name");
        var tipop = $(this).val();
        if (tipop === "Argentina") {
            $('.otroPaisAlta' + numero).prop("readonly", "true");
            $('.provinciaEstadoAlta' + numero).prop("readonly", "true");
            $('.localidadCiudadAlta' + numero).prop("readonly", "true");
            $('.domicilioDireccionAlta' + numero).prop("readonly", "true");
            $("#otroPaisAlta").val("");
            $("#provinciaEstadoAlta").val("");
            $("#localidadCiudadAlta").val("");
            $("#domicilioDireccionAlta").val("");
            $('.provinciaAlta' + numero).prop("disabled", "");
            $('.localidadAlta' + numero).prop("readonly", "");
            $('.calleAlta' + numero).prop("readonly", "");
            $('.numeroAlta' + numero).prop("readonly", "");
            $('.pisoAlta' + numero).prop("readonly", "");
            $('.departamentoAlta' + numero).prop("readonly", "");
        } else {
        if (tipop === "Otro") {
            $('.provinciaAlta' + numero).prop("disabled", "true");
            $('.localidadAlta' + numero).prop("readonly", "true");
            $('.calleAlta' + numero).prop("readonly", "true");
            $('.numeroAlta' + numero).prop("readonly", "true");
            $('.pisoAlta' + numero).prop("readonly", "true");
            $('.departamentoAlta' + numero).prop("readonly", "true");
            $('#provinciaAlta').val("");
            $('#localidadAlta').val("");
            $('#calleAlta').val("");
            $('#numeroAlta').val("");
            $('#pisoAlta').val("");
            $('#departamentoAlta').val("");
            $('.otroPaisAlta' + numero).prop("readonly", "");
            $('.provinciaEstadoAlta' + numero).prop("readonly", "");
            $('.localidadCiudadAlta' + numero).prop("readonly", "");
            $('.domicilioDireccionAlta' + numero).prop("readonly", "");
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
            $('.generoSujetoVinculado' + numero).prop("disabled", "true");
            $('.nacionalidadSujetoVinculado' + numero).prop("readonly", "true");
            $('.paisNacimientoSujetoVinculado' + numero).prop("readonly", "true");
            $('.lugarNacimientoSujetoVinculado' + numero).prop("readonly", "true");
            $('.fechaNacimientoSujetoVinculado' + numero).prop("readonly", "true");
            $("#apellidoSujetoVinculado").val("");
            $("#nombreSujetoVinculado").val("");
            $("#tipoDocumentoSujetoVinculado").val("");
            $("#numeroDocumentoSujetoVinculado").val("");
            $("#generoSujetoVinculado").val("");
            $("#nacionalidadSujetoVinculado").val("");
            $("#paisNacimientoSujetoVinculado").val("");
            $("#lugarNacimientoSujetoVinculado").val("");
            $("#fechaNacimientoSujetoVinculado").val("");
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
            $('.generoSujetoVinculado' + numero).prop("disabled", "");
            $('.nacionalidadSujetoVinculado' + numero).prop("readonly", "");
            $('.paisNacimientoSujetoVinculado' + numero).prop("readonly", "");
            $('.lugarNacimientoSujetoVinculado' + numero).prop("readonly", "");
            $('.fechaNacimientoSujetoVinculado' + numero).prop("readonly", "");
        }
    }
    });
    
    
    
    $('#datos').on("change", "select.paisSujetoVinculado", function () {
        var numero = $(this).parent().parent().parent().attr("name");
        var tipop = $(this).val();
        if (tipop === "Argentina") {
            $('.otroPaisSujetoVinculado' + numero).prop("readonly", "true");
            $('.provinciaEstadoSujetoVinculado' + numero).prop("readonly", "true");
            $('.localidadCiudadSujetoVinculado' + numero).prop("readonly", "true");
            $('.domicilioDireccionSujetoVinculado' + numero).prop("readonly", "true");
            $("#otroPaisSujetoVinculado").val("");
            $("#provinciaEstadoSujetoVinculado").val("");
            $("#localidadCiudadSujetoVinculado").val("");
            $("#domicilioDireccionSujetoVinculado").val("");
            $('.provinciaSujetoVinculado' + numero).prop("disabled", "");
            $('.localidadSujetoVinculado' + numero).prop("readonly", "");
            $('.calleSujetoVinculado' + numero).prop("readonly", "");
            $('.numeroSujetoVinculado' + numero).prop("readonly", "");
            $('.pisoSujetoVinculado' + numero).prop("readonly", "");
            $('.departamentoSujetoVinculado' + numero).prop("readonly", "");
        } else {
        if (tipop === "Otro") {
            $('.provinciaSujetoVinculado' + numero).prop("disabled", "true");
            $('.localidadSujetoVinculado' + numero).prop("readonly", "true");
            $('.calleSujetoVinculado' + numero).prop("readonly", "true");
            $('.numeroSujetoVinculado' + numero).prop("readonly", "true");
            $('.pisoSujetoVinculado' + numero).prop("readonly", "true");
            $('.departamentoSujetoVinculado' + numero).prop("readonly", "true");
            $('#provinciaSujetoVinculado').val("");
            $('#localidadSujetoVinculado').val("");
            $('#calleSujetoVinculado').val("");
            $('#numeroSujetoVinculado').val("");
            $('#pisoSujetoVinculado').val("");
            $('#departamentoSujetoVinculado').val("");
            $('.otroPaisSujetoVinculado' + numero).prop("readonly", "");
            $('.provinciaEstadoSujetoVinculado' + numero).prop("readonly", "");
            $('.localidadCiudadSujetoVinculado' + numero).prop("readonly", "");
            $('.domicilioDireccionSujetoVinculado' + numero).prop("readonly", "");
        }
    }
    });

});