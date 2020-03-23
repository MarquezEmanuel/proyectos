<?php
/* INICIALIZA LA SESION */
session_start();

require_once './menuReportes.php';
?>
<a href='#top'><img border='0' style='position:fixed; bottom:0; right:0;' src="../../lib/img/tope.png" title="Ir arriba" /></a>

<div class="card-header">
    <h4 class="text-center p-4">CREAR CUENTA COMITENTE - ALTA Cliente</h4>
    <div id="contenido" class="container">
        
        <form id="formAltaCliente" name="formAltaCliente" method="POST">
            <fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
                <legend class="w-auto" 
                        title="Complete los datos generales de la cuenta" 
                        style="font-size: 1.1em; font-weight: bold;">Datos generales de la cuenta</legend>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Fecha:</label> 
                    <div class="col">
                        <input type="text" class="form-control"
                               id="fecha" name="fecha" 
                               placeholder="AAAA-MM-DDT00:00:00" 
                               title="AAAA-MM-DDT00:00:00" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Estado de la cuenta:</label> 
                    <div class="col">
                        <select class="form-control" id="estado" name="estado" title="estado">
                            <option value="Activa">Activa</option>
                            <option value="Inactiva">Inactiva</option>
                            <option value="No aplica">No aplica</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Numero de cuenta depositante:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="numeroCuentaDepositante" name="numeroCuentaDepositante"
                               min="1"
                               placeholder="Numero de cuenta depositante" 
                               title="Numero de la cuenta depositante" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Numero de cuenta comitente:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="numeroCuentaComitente" name="numeroCuentaComitente"
                               min="1"
                               placeholder="Numero de cuenta comitente" 
                               title="Numero de la cuenta comitente" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Cantidad de clientes vinculados:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="cantidadVinculados" name="cantidadVinculados"
                               min="1"
                               placeholder="Cantidad de clientes vinculados" 
                               title="cantidad de clientes vinculados" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de accion:</label> 
                    <div class="col">
                        <select class="form-control" id="tipoAccion" name="tipoAccion" title="tipo de accion">
                            <option value="Apertura de cuenta">Apertura de cuenta</option>
                            <option value="Alta de condóminos u otros sujetos">Alta de condóminos u otros sujetos</option>
                        </select>
                    </div>
                </div>
                <div class="for-group row">
                    <label class="col-sm-2 col-form-label"></label> 
                    <div class="col">
                    <button class='btn btn-outline-dark' id="agregarCliente">Agregar Cliente</button>
                    &nbsp;</div>
                    <div class="col">
                    <button class='btn btn-outline-dark' id="agregarClienteVinculado">Agregar Cliente Vinculado</button>
                    &nbsp;</div>
                </div>
            </fieldset>
            <br>
             <fieldset id="datos" name="0" class="add border p-2" style="border-color: #b9b9b9 !important;">
                 
             </fieldset>
            <br>
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        <input type="submit" class="btn btn-success" id="btnCrearCuentaComitente" name="btnCrearCuentaComitente" value="Guardar">
                        <a href="cargarCuentaComitente.php"><input type="button" class="btn btn-outline-secondary" value="Cancelar"></a>
                    </div>
                </div>
            </div>   
        </form>
    </div>
    <div id="contenido2"></div>
</div>    
<script type="text/javascript" src="../../lib/JQuery/cuentaComitenteAltaCliente.js"></script>
</html>