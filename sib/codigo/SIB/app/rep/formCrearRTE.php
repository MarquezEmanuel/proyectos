<?php
/* INICIALIZA LA SESION */
session_start();

require_once './menuReportes.php';
?>
<div class="card-header">
    <h4 class="text-center p-4">CREAR RTE</h4>
    <div id="contenido" class="container">
        <form id="formCrearRTE" name="formCrearRTE" method="POST">
            <fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
                <legend class="w-auto" 
                        title="Complete los datos generales de la transacción" 
                        style="font-size: 1.1em; font-weight: bold;">Datos generales de la transacción</legend>
                <div class="container">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Cuenta:</label> 
                        <div class="col">
                            <input type="text" class="form-control" 
                                   id="cuenta" name="cuenta"
                                   pattern="[0-9]{2}-[0-9]{6}/[0-9]"
                                   placeholder="Cuenta inversora" 
                                   title="Cuenta inversora asociada a la transacción [0-9]{3,6}" required>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Fecha:</label> 
                        <div class="col">
                            <input type="date" class="form-control"
                                   id="fecha" name="fecha" 
                                   title="Fecha de la transaccíón" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo:</label> 
                        <div class="col">
                            <select class="form-control" id="tipot" name="tipot" title="Tipo de transacción">
                                <option value="Depósito">Depósito</option>
                                <option value="Extracción">Extracción</option>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Moneda:</label> 
                        <div class="col">
                            <select class="form-control" id="moneda" name="moneda" title="Moneda">
                                <option value="Peso Argentino">Peso Argentino</option>
                                <option value="Peso Chileno">Peso Chileno</option>
                                <option value="Dólar Estadounidense">Dólar Estadounidense</option>
                                <option value="Euro (Unidad Monetaria Europea)">Euro</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Monto de origen:</label> 
                        <div class="col">
                            <input type="number" class="form-control"
                                   id="montomo" name="montomo"
                                   min="1"
                                   placeholder="Monto total en moneda de origen" 
                                   title="Importe total en moneda de origen sin puntos ni comas" required>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Monto en pesos:</label> 
                        <div class="col">
                            <input type="number" class="form-control"
                                   id="montop" name="montop"
                                   placeholder="Monto total en pesos" 
                                   title="Importe total en pesos sin puntos ni comas" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Provincia:</label> 
                        <div class="col">
                            <input type="text" class="form-control" 
                                   id="provincia" name="provincia" value=""
                                   minlength="1" maxlength="100"
                                   placeholder="Nombre de provincia" 
                                   title="Nombre de la provincia" required>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Localidad:</label> 
                        <div class="col">
                            <input type="text" class="form-control" 
                                   id="localidad" name="localidad" value=""
                                   minlength="1" maxlength="100"
                                   placeholder="Nombre de localidad"
                                   title="Nombre de la localidad" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Calle:</label> 
                        <div class="col">
                            <input type="text" class="form-control" 
                                   id="calle" name="calle" value=""
                                   minlength="1" maxlength="100"
                                   placeholder="Nombre de calle" 
                                   title="Nombre de la calle" required>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Número:</label> 
                        <div class="col">
                            <input type="number" class="form-control" 
                                   id="numero" name="numero" value=""
                                   min="1" max="10000"
                                   minlength="1" maxlength="5"
                                   placeholder="Número de altura"
                                   title="Número de la altura" required>
                        </div>
                    </div>
                </div>
            </fieldset>
            <br>
            <fieldset id="datos" class="add border p-2" style="border-color: #b9b9b9 !important;">
                <legend class="w-auto" 
                        title="Complete los datos generales de la transacción" 
                        style="font-size: 1.1em; font-weight: bold;">Sujetos vinculados a la transacción</legend>

                <fieldset class="border p-2" style="border-color: #b9b9b9 !important;"  name="1">
                    <legend class="w-auto" 
                            title="Complete los datos generales de la transacción" 
                            style="font-size: 1em; font-weight: bold;">Sujeto vinculado N° 1</legend>
                    <div class="container">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Relación fondos:</label> 
                            <div class="col">
                                <select class="form-control" id="rfondos" name="rfondos[]" title="Relación con los fondos">
                                    <option value="Operador/Titular">Operador/Titular</option>
                                    <option value="Titular">Titular</option>
                                    <option value="Operador">Operador</option>
                                    <option value="Vinculado al producto operado">Vinculado con el producto operado</option>
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Rel. Producto:</label> 
                            <div class="col" >
                                <select class="form-control" id="rproducto" name="rproducto" title="Relación con el producto">
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* CUIT/CUIL/CDI:</label> 
                            <div class="col">
                                <input type="text" class="form-control"
                                       pattern="[0-9]{11}"
                                       id="cuit" name="cuit[]" 
                                       placeholder="CUIT/CUIL/CDI" 
                                       title="CUIT/CUIL/CDI en caso de numero de documento con 7 dígitos agregar cero aquí" required>
                            </div>
                            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de persona:</label> 
                            <div class="col">
                                <select class="form-control tipop" id="tipop" name="tipop[]" title="Tipo de persona">
                                    <option value="Persona física">Persona Física</option>
                                    <option value="Persona Jurídica">Persona Jurídica</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Apellidos:</label> 
                            <div class="col">
                                <input type="text" class="form-control" 
                                       pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}"
                                       id="apellidos" name="apellidos[]"
                                       minlength="1" maxlength="100"
                                       placeholder="Apellidos" 
                                       title="Apellidos del sujeto vinculado" required>
                            </div>
                            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Nombres:</label> 
                            <div class="col">
                                <input type="text" class="form-control nombres1" 
                                       pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}"
                                       id="nombres" name="nombres[]"
                                       minlength="1" maxlength="100"
                                       placeholder="Nombres" 
                                       title="Nombres del sujeto vinculado" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo Documento:</label> 
                            <div class="col">
                                <select class="form-control tipodoc1" id="tipodoc" name="tipodoc[]" title="Tipo de documento del sujeto vinculado">
                                    <option value="Documento Nacional de Identidad">DNI</option>
                                    <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>
                                    <option value="Libreta Cívica">Libreta cívica</option>
                                    <option value="Cédula Mercosur">Cédula Mercosur</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Número:</label> 
                            <div class="col">
                                <input type="text" class="form-control dni1" 
                                       pattern="[0-9]{7,12}" 
                                       id="dni" name="dni[]" minlength="7"
                                       min="1"
                                       placeholder="Número de documento"
                                       title="Número de documento del sujeto vinculado" required>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </fieldset>
            <BR>
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        <input type="submit" class="btn btn-success" id="btnCrearRTE" name="btnCrearRTE" value="Guardar">
                        <a href="inicioRTE.php"><input type="button" class="btn btn-outline-secondary" value="Volver"></a>
                    </div>
                </div>
            </div>   
        </form>
    </div>
    <div id="contenido2"></div>
</div>    
<script type="text/javascript" src="../../lib/JQuery/CrearRTE.js"></script>


</html>