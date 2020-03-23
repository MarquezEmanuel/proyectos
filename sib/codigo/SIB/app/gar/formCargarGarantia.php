<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}
require_once './menuGarantias.php';
?>

<div class="container">
    <div id="contenido">
        <h4 class="text-center p-4">CARGAR GARANTIA</h4>
        <div id="centro" class="container">
            <form action="procesarCargarGarantia.php" method="post" enctype="multipart/form-data">
                <div class="container">
                    <div class="row"> <div class="col"> <h5>DATOS COMUNES</h5> <hr/></div> </div>
                    <div class="form-group row">
                        <label for="sucursal" class="col-sm-2 col-form-label" title="Sucursal">Sucursal:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="sucursal" name="sucursal" min="1" max="9999"
                                   title="Sucursal" placeholder="Sucursal">
                        </div>
                        <label for="moneda" class="col-sm-2 col-form-label" title="Moneda">Moneda:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="moneda" name="moneda" min="1"
                                   title="Moneda" placeholder="Moneda">
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaAlta" class="col-sm-2 col-form-label" title="Fecha de alta de la operaci&oacute;n">Fecha Alta OP:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fechaAlta" name="fechaAlta" min="2000-01-01" 
                                   title="Fecha de alta de la operaci&oacute;n">
                        </div>
                        <label for="fechaVto" class="col-sm-2 col-form-label" title="Fecha de vencimiento de la operaci&oacute;n">Fecha Vto OP:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fechaVto" name="fechaVto" min="2000-01-01" 
                                   title="Fecha de vencimiento de la operaci&oacute;n">
                        </div>
                        <div class="w-100"></div>
                        <label for="numeroCli" class="col-sm-2 col-form-label" title="N&uacute;mero de cliente">N&uacute;mero Cliente:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="numeroCli" name="numeroCli" min="1"
                                   title="N&uacute;mero de Cliente" placeholder="N&uacute;mero de Cliente">
                        </div>
                        <label for="nombreCliente" class="col-sm-2 col-form-label" title="Nombre de cliente">Nombre Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="nombreCliente" name="nombreCliente" 
                                   maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ ]{1,150}"
                                   title="Nombre de Cliente" placeholder="Nombre de Cliente">
                        </div>
                        <div class="w-100"></div>
                        <label for="descripcionProd" class="col-sm-2 col-form-label" title="Descripci&oacute;n del producto">Desc. Producto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="descripcionProd" name="descripcionProd" 
                                   maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                   title="Descripci&oacute;n del Producto" placeholder="Descripci&oacute;n del Producto">
                        </div>
                        <label for="oper" class="col-sm-2 col-form-label" title="Operaci&oacute;n/Relaci&oacute;n">Operaci&oacute;n/Relaci&oacute;n:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="oper" name="oper" min="1"
                                   title="Operaci&oacute;n/Relaci&oacute;n" placeholder="Operaci&oacute;n/Relaci&oacute;n">
                        </div>
                        <div class="w-100"></div>
                        <label for="sav" class="col-sm-2 col-form-label" title="N&uacute;mero valor no dinerario">SAV:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="sav" name="sav" min="1" 
                                   title="N&uacute;mero Valor no Dinerario" placeholder="N&uacute;mero Valor no Dinerario">
                        </div>
                        <label for="prodCred" class="col-sm-2 col-form-label" title="Producto del credito">Producto Cred:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="ProdCred" name="prodCred" min="1"
                                   title="Producto del Credito" placeholder="Producto del Cr&eacute;dito">
                        </div>
                        <div class="w-100"></div>
                        <label for="entregaGar" class="col-sm-2 col-form-label" title="Entrega garantia">Entrega Gtia:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="entregaGar" name="entregaGar" 
                                   maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                   title="Entrega de Garantia" placeholder="Entrega de Garantia">
                        </div>
                        <label for="gestionCan" class="col-sm-2 col-form-label" title="Gesti&oacute;n de cancelaci&oacute;n">Gesti&oacute;n de Canc:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="gestionCan" name="gestionCan" maxlength="100"
                                   pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,100}"
                                   title="Gesti&oacute;n de Cancelaci&oacute;n" placeholder="Gesti&oacute;n de Cancelaci&oacute;n">
                        </div>
                        <div class="w-100"></div>
                        <label for="origen" class="col-sm-2 col-form-label" title="Original">Original:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="origen" name="origen" title="Original">
                                <option value='Si'>Si</option>
                                <option value='No'>No</option>
                            </select>
                        </div>
                        <label for="estado" class="col-sm-2 col-form-label" title="Estado">Estado:</label>
                        <div class="col">
                            <select name="estado" id="estado" class="form-control mb-2" title="Estado">
                                <?php
                                include_once 'conf/BDConexion.php';
                                $query = "SELECT * FROM estado";
                                $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
                                if ($estados = sqlsrv_fetch_array($result)) {
                                    do {
                                        echo "<option value=" . $estados["id_estado"] . ">" . $estados["nombre"] . "</option>";
                                    } while ($estados = sqlsrv_fetch_array($result));
                                }
                                ?>
                            </select>
                        </div>
                        <div class="w-100"></div>
                        <label for="valorNomi" class="col-sm-2 col-form-label" title="Valor nominal">Valor Nominal:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="valorNomi" name="valorNomi" step="0.01" min="1" 
                                   title="Valor Nominal" placeholder="Valor Nominal">
                        </div>
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col"></div>
                        <div class="w-100"></div>
                        <label for="observacion" class="col-sm-2 col-form-label" title="Observaci&oacute;n">Observaci&oacute;n:</label>
                        <div class="col">
                            <textarea class="form-control mb-2" id="observacion" name="observacion" maxlength="150"
                                      maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                      title="Observaci&oacute;n" placeholder="Observaciones"></textarea>
                        </div>
                    </div>
                    <hr/>
                </div>
                <div class="container">
                    <div class="row"> 
                        <div class="col"> <h5>HIPOTECA</h5> </div>
                        <div class="col text-right"> 
                            <button id="btnShowHipoteca" class="btn btn-outline-success" title="Mostrar los campos de la hipoteca">
                                <img src='../../lib/img/EYE.png' width="15" height="15">
                            </button>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row" id="camposHipoteca" style="display: none">
                        <label for="prodGtiaHip" class="col-sm-2 col-form-label" title="Producto de garantia">Producto Garantia:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="prodGtiaHip" name="prodGtiaHip" min="1"
                                   title="Producto de Garantia" placeholder="Producto de Garantia">
                        </div>
                        <label for="numGtiaHip" class="col-sm-2 col-form-label" title="N&uacute;mero de garantia">Número Garantia:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="numGtiaHip" name="numGtiaHip" min="1"
                                   title="N&uacute;mero de Garantia" placeholder="N&uacute;mero de Garantia">
                        </div>
                        <div class="w-100"></div>
                        <label for="fecVtoGtiaHip" class="col-sm-2 col-form-label" title="Fecha de vencimiento de garantia">Fecha Vencimiento:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fecVtoGtiaHip" name="fecVtoGtiaHip" 
                                   title="Fecha de vencimiento de la garantia">
                        </div>
                        <label for="fechaHip" class="col-sm-2 col-form-label" title="Fecha de inscripci&oacute;n">Fecha Inscripci&oacute;n:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fechaHip" name="fechaHip" 
                                   title="Fecha de inscripci&oacute;n">
                        </div>
                        <div class="w-100"></div>
                        <label for="cotizacionHip" class="col-sm-2 col-form-label" title="Cotizaci&oacute;n">Cotizaci&oacute;n:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="cotizacionHip" name="cotizacionHip" min="1" step="0.01"
                                   title="Tasaci&oacute;n" placeholder="Tasaci&oacute;n">
                        </div>
                        <label for="numInsHip" class="col-sm-2 col-form-label" title="N&uacute;mero de inscripci&oacute;n">N&uacute;mero Inscripci&oacute;n:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="numInsHip" name="numInsHip" min="1"
                                   title="N&uacute;mero Inscripci&oacute;n" placeholder="N&uacute;mero Inscripci&oacute;n">
                        </div>
                        <div class="w-100"></div>
                        <label for="escDominioHip" class="col-sm-2 col-form-label" title="Esc. dominio">Esc. Dominio:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="escDominioHip" name="escDominioHip" min="1"
                                   title="N&uacute;mero de escritura" placeholder="N&uacute;mero de Escritura">
                        </div>
                        <label for="deudorHip" class="col-sm-2 col-form-label" title="Hipotecante">Hipotecante:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="deudorHip" name="deudorHip" 
                                   maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                   title="Hipotecante" placeholder="Hipotecante">
                        </div>
                        <div class="w-100"></div>
                        <label for="seguroHip" class="col-sm-2 col-form-label" title="Nombre del seguro">Nombre Seguro:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="seguroHip" name="seguroHip" 
                                   maxlength="50" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,50}"
                                   title="Nombre compañia aseguradora" placeholder="Nombre Compañia Aseguradora">
                        </div>
                        <label for="vencHip" class="col-sm-2 col-form-label" title="Vencimiento del seguro">Vto. Seguro:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="vencHip" name="vencHip" 
                                   pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,50}"
                                   title="Vencimiento del seguro" placeholder="Vencimiento del Seguro">
                        </div>
                        <div class="w-100"></div>
                        <label for="monto" class="col-sm-2 col-form-label" title="Monto">Monto:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="montoHip" name="montoHip" min="1" step="0.01"
                                   title="Monto" placeholder="Monto">
                        </div>
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col"></div>
                        <div class="w-100"></div>
                        <label for="datosGarHip" class="col-sm-2 col-form-label" title="Datos de la garantia">Datos Garantia:</label>
                        <div class="col">
                            <textarea type="text" class="form-control mb-2" 
                                      id="datosGarHip" name="datosGarHip" 
                                      maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                      title="Datos de garantia" placeholder="Datos de Garantia"></textarea>
                        </div>
                        <div class="w-100"></div>
                        <label for="imagenGarHip" class="col-sm-2 col-form-label" title="Documentos de garantia">Imagen Garantia:</label>
                        <div class="col">
                            <input type="file" id="imagenGarHip" name="imagenGarHip[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                        </div>
                        <div class="w-100"></div>
                        <label for="imagenTasHip" class="col-sm-2 col-form-label" title="Documentos de tasaci&oacute;n">Imagen Tasaci&oacute;n:</label>
                        <div class="col">
                            <input type="file" id="imagenTasHip" name="imagenTasHip[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                        </div>
                    </div>
                    <hr/>
                </div>
                <div class="container">
                    <div class="row"> 
                        <div class="col"> <h5>PRENDA</h5> </div>
                        <div class="col text-right"> 
                            <button id="btnShowPrenda" class="btn btn-outline-success" title="Mostrar los campos de la prenda">
                                <img src='../../lib/img/EYE.png' width="15" height="15">
                            </button>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row" id="camposPrenda" style="display: none">
                        <label for="prodGtiaPren" class="col-sm-2 col-form-label" title="Producto de garantia">Producto Garantia:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="prodGtiaPren" name="prodGtiaPren" min="1"
                                   title="Producto de Garantia" placeholder="Producto de Garantia">
                        </div>
                        <label for="numGtiaPren" class="col-sm-2 col-form-label" title="N&uacute;mero de garantia">Número Garantia:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="numGtiaPren" name="numGtiaPren" min="1"
                                   title="N&uacute;mero de Garantia" placeholder="N&uacute;mero de Garantia">
                        </div>
                        <div class="w-100"></div>
                        <label for="fecVtoGtiaPren" class="col-sm-2 col-form-label" title="Fecha de vencimiento de garantia">Fecha Vencimiento:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fecVtoGtiaPren" name="fecVtoGtiaPren" 
                                   title="Fecha de vencimiento de la garantia">
                        </div>
                        <label for="cotizacionPren" class="col-sm-2 col-form-label" title="Cotizaci&oacute;n">Cotizacion:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="cotizacionPren" name="cotizacionPren" min="1" step="0.01"
                                   title="Tasaci&oacute;n" placeholder="Tasaci&oacute;n">
                        </div>
                        <div class="w-100"></div>
                        <label for="seguroPren" class="col-sm-2 col-form-label" title="Nombre del seguro">Nombre Seguro:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="seguroPren" name="seguroPren" 
                                   maxlength="50" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,50}"
                                   title="Nombre de compañia aseguradora" placeholder="Nombre de Compañia Aseguradora">
                        </div>
                        <label for="vencimientoPren" class="col-sm-2 col-form-label" title="Vencimiento del seguro">Vto. Seguro:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="vencimientoPren" name="vencimientoPren"
                                   maxlength="50" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,50}"
                                   title="Vencimiento del seguro" placeholder="Vencimiento del Seguro">
                        </div>
                        <div class="w-100"></div>
                        <label for="numInscripcionPren" class="col-sm-2 col-form-label" title="N&uacute;mero de inscripci&oacute;n">N&uacute;mero Inscripci&oacute;n:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="numInscripcionPren" name="numInscripcionPren" min="1"
                                   title="N&uacute;mero de Inscripci&oacute;n" placeholder="N&uacute;mero de Inscripci&oacute;n">
                        </div>
                        <label for="fechaInsPren" class="col-sm-2 col-form-label" title="Fecha de inscripci&oacute;n">Fecha Inscripci&oacute;n:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fechaInsPren" name="fechaInsPren" min="2000-01-01" 
                                   title="Fecha de certificaci&oacute;n">
                        </div>
                        <div class="w-100"></div>
                        <label for="deudorPren" class="col-sm-2 col-form-label" title="Deudor">Deudor:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="deudorPren" name="deudorPren" 
                                   maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                   title="Deudor" placeholder="Deudor">
                        </div>
                        <label for="montoPren" class="col-sm-2 col-form-label" title="Monto">Monto:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="montoPren" name="montoPren" min="1" step="0.01"
                                   title="Monto" placeholder="Monto">
                        </div>
                        <div class="w-100"></div>
                        <label for="bienGtiaPren" class="col-sm-2 col-form-label" title="Datos de garantia">Datos Garantia:</label>
                        <div class="col">
                            <textarea type="text" class="form-control mb-2" 
                                      id="bienGtiaPren" name="bienGtiaPren" maxlength="150"
                                      title="Datos de garantia" placeholder="Datos de Garantia"></textarea>
                        </div>
                        <div class="w-100"></div>
                        <label for="imagenGarPren" class="col-sm-2 col-form-label" title="Documentos de garantia">Imagen Garantia:</label>
                        <div class="col">
                            <input type="file" id="imagenGarPren" name="imagenGarPren[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                        </div>
                        <div class="w-100"></div>
                        <label for="imagenTasPren" class="col-sm-2 col-form-label" title="Documentos de tasaci&oacute;n">Imagen Tasaci&oacute;n:</label>
                        <div class="col">
                            <input type="file" id="imagenTasPren" name="imagenTasPren[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                        </div>
                    </div>
                    <hr/>
                </div>
                <div class="container">
                    <div class="row"> 
                        <div class="col"> <h5>FIANZA</h5> </div>
                        <div class="col text-right"> 
                            <button id="btnShowFianza" class="btn btn-outline-success" title="Mostrar los campos de la fianza">
                                <img src='../../lib/img/EYE.png' width="15" height="15">
                            </button>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row" id="camposFianza" style="display: none">
                        <label for="prodGtiaFia" class="col-sm-2 col-form-label" title="Producto de garantia">Producto Garantia:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="prodGtiaFia" name="prodGtiaFia" min="1"
                                   title="Producto de Garantia" placeholder="Producto de Garantia">
                        </div>
                        <label for="numGtiaFia" class="col-sm-2 col-form-label" title="N&uacute;mero de garantia">Número Garantia:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="numGtiaFia" name="numGtiaFia" min="1"
                                   title="N&uacute;mero de Garantia" placeholder="N&uacute;mero de Garantia">
                        </div>
                        <div class="w-100"></div>
                        <label for="fecVtoGtiaFia" class="col-sm-2 col-form-label" title="Fecha de vencimiento de garantia">Fecha Vencimiento:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fecVtoGtiaFia" name="fecVtoGtiaFia" 
                                   title="Fecha de vencimiento de la garantia">
                        </div>
                        <label for="fechaEscribaniaFian" class="col-sm-2 col-form-label" title="Fecha de la escribania">Fecha Escribania:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fechaEscribaniaFian" name="fechaEscribaniaFian" min="2000-01-01"
                                   title="Fecha de certificaci&oacute;n escribania" placeholder="Fecha Certificaci&oacute;n Escribania">
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaInstFian" class="col-sm-2 col-form-label" title="Fecha de instrumentaci&oacute;n">Fecha Inst:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fechaInstFian" name="fechaInstFian" min="2000-01-01"
                                   title="Fecha de la instrumentaci&oacute;n">
                        </div>
                        <label for="monto" class="col-sm-2 col-form-label" title="Monto">Monto:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="montoFian" name="montoFian" min="1" step="0.01"
                                   title="Monto" placeholder="Monto">
                        </div>
                        <div class="w-100"></div>
                        <label for="datosAcuerdoFian" class="col-sm-2 col-form-label" title="Datos del acuerdo">Datos del Acuerdo:</label>
                        <div class="col">
                            <textarea class="form-control mb-2" 
                                      id="datosAcuerdoFian" name="datosAcuerdoFian"
                                      maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                      title="Datos del acuerdo" placeholder="Datos del Acuerdo"></textarea>
                        </div>
                        <div class="w-100"></div>
                        <label for="datosFiadorFian" class="col-sm-2 col-form-label" title="Datos del fiador">Datos del Fiador:</label>
                        <div class="col">
                            <textarea  class="form-control mb-2" 
                                       id="datosFiadorFian" name="datosFiadorFian" 
                                       maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                       title="Datos del fiador" placeholder="Datos del Fiador"></textarea>
                        </div>
                        <div class="w-100"></div>
                        <label for="imagenGarFian" class="col-sm-2 col-form-label" title="Documentos de la garantia">Imagen Garantia:</label>
                        <div class="col">
                            <input type="file" id="imagenGarFian" name="imagenGarFian[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                        </div>
                    </div>
                    <hr/>
                </div>
                <div class="container">
                    <div class="row"> 
                        <div class="col"> <h5>LEASING</h5> </div>
                        <div class="col text-right"> 
                            <button id="btnShowLeasing" class="btn btn-outline-success" title="Mostrar los campos del leasing">
                                <img src='../../lib/img/EYE.png' width="15" height="15">
                            </button>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row" id="camposLeasing" style="display: none">
                        <label for="prodGtiaLea" class="col-sm-2 col-form-label" title="Producto de garantia">Producto Garantia:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="prodGtiaLea" name="prodGtiaLea" min="1"
                                   title="Producto de Garantia" placeholder="Producto de Garantia">
                        </div>
                        <label for="numGtiaLea" class="col-sm-2 col-form-label" title="N&uacute;mero de garantia">Número Garantia:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="numGtiaLea" name="numGtiaLea" min="1"
                                   title="N&uacute;mero de Garantia" placeholder="N&uacute;mero de Garantia">
                        </div>
                        <div class="w-100"></div>
                        <label for="fecVtoGtiaLea" class="col-sm-2 col-form-label" title="Fecha de vencimiento de garantia">Fecha Vencimiento:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fecVtoGtiaLea" name="fecVtoGtiaLea" 
                                   title="Fecha de vencimiento de la garantia">
                        </div>
                        <label for="fechaInsLea" class="col-sm-2 col-form-label" title="Fecha de la escribania">Fecha Escribania:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fechaInsLea" name="fechaInsLea" min="2000-01-01" 
                                   title="Fecha de certificaci&oacute;n escribania">
                        </div>
                        <div class="w-100"></div>
                        <label for="seguroLea" class="col-sm-2 col-form-label" title="Nombre del seguro">Nombre Seguro:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="seguroLea" name="seguroLea" 
                                   maxlength="50" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,50}"
                                   title="Nombre de compañia aseguradora" placeholder="Nombre de Compañia Aseguradora">
                        </div>
                        <label for="vtoLea" class="col-sm-2 col-form-label" title="Vencimiento del seguro">Vto. Seguro:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="vtoLea" name="vtoLea" 
                                   maxlength="50" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,50}"
                                   title="vencimiento del seguro" placeholder="Vencimiento del Seguro">
                        </div>
                        <div class="w-100"></div>
                        <label for="numInsLea" class="col-sm-2 col-form-label" title="N&uacute;mero de inscripci&oacute;n">N&uacute;mero Inscripci&oacute;n:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="numInsLea" name="numInsLea" min="1"
                                   title="N&uacute;mero de inscripci&oacute;n" placeholder="N&uacute;mero de Inscripci&oacute;n">
                        </div>
                        <label for="cotizacionLea" class="col-sm-2 col-form-label" title="Cotizaci&oacute;n">Cotizaci&oacute;n:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="cotizacionLea" name="cotizacionLea" min="1" step="0.01"
                                   title="Tasaci&oacute;n" placeholder="Tasaci&oacute;n">
                        </div>
                        <div class="w-100"></div>
                        <label for="montoLea" class="col-sm-2 col-form-label" title="Monto">Monto:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="montoLea" name="montoLea" min="1" step="0.01"
                                   title="Monto" placeholder="Monto">
                        </div>
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col"></div>
                        <div class="w-100"></div>
                        <label for="datosLeasingLea" class="col-sm-2 col-form-label" title="Datos de garantia">Datos Garantia:</label>
                        <div class="col">
                            <textarea class="form-control mb-2" 
                                      id="datosLeasingLea" name="datosLeasingLea"
                                      maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                      title="Datos del bien" placeholder="Datos del Bien"></textarea>
                        </div>
                        <div class="w-100"></div>
                        <label for="imagenGarLea" class="col-sm-2 col-form-label" title="Documentos de contrato">Imagen Contrato:</label>
                        <div class="col">
                            <input type="file" id="imagenGarLea" name="imagenGarLea[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                        </div>
                        <div class="w-100"></div>
                        <label for="imagenTasLea" class="col-sm-2 col-form-label" title="Documentos de tasaci&oacute;n">Imagen Tasacion:</label>
                        <div class="col">
                            <input type="file" id="imagenTasLea" name="imagenTasLea[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                        </div>
                    </div>
                    <hr/>
                </div>
                <div class="container">
                    <div class="row"> 
                        <div class="col"> <h5>COMPRA DE CARTERA</h5> </div>
                        <div class="col text-right"> 
                            <button id="btnShowCartera" class="btn btn-outline-success" title="Mostrar los campos de la compra de cartera">
                                <img src='../../lib/img/EYE.png' width="15" height="15">
                            </button>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row" id="camposCartera" style="display: none">
                        <label for="prodGtiaCar" class="col-sm-2 col-form-label" title="Producto de garantia">Producto Garantia:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="prodGtiaCar" name="prodGtiaCar" min="1"
                                   title="Producto de Garantia" placeholder="Producto de Garantia">
                        </div>
                        <label for="numGtiaCar" class="col-sm-2 col-form-label" title="N&uacute;mero de garantia">Número Garantia:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="numGtiaCar" name="numGtiaCar" min="1"
                                   title="N&uacute;mero de Garantia" placeholder="N&uacute;mero de Garantia">
                        </div>
                        <div class="w-100"></div>
                        <label for="fecVtoGtiaCar" class="col-sm-2 col-form-label" title="Fecha de vencimiento de garantia">Fecha Vencimiento:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fecVtoGtiaCar" name="fecVtoGtiaCar" 
                                   title="Fecha de vencimiento de la garantia">
                        </div>
                        <label for="fechaInstCar" class="col-sm-2 col-form-label" title="Fecha de instrumentaci&oacute;n">Fecha Inst:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fechaInstCar" name="fechaInstCar" 
                                   title="Fecha de la instrumentaci&oacute;n">
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaEscribaniaCar" class="col-sm-2 col-form-label" title="Fecha de la escribania">Fecha Escribania:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   id="fechaEscribaniaCar" name="fechaEscribaniaCar" 
                                   title="Fecha de certificaci&oacute;n escribania">
                        </div>
                        <label for="montoCar" class="col-sm-2 col-form-label" title="Monto">Monto:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" 
                                   id="montoCar" name="montoCar" min="1" step="0.01"
                                   title="Monto" placeholder="Monto">
                        </div>
                        <div class="w-100"></div>
                        <label for="datosCarteraCar" class="col-sm-2 col-form-label" title="Datos del cedente">Datos Cedente:</label>
                        <div class="col">
                            <textarea class="form-control mb-2" 
                                      id="datosCarteraCar" name="datosCarteraCar" 
                                       maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                      title="Datos del cedente" placeholder="Datos del cedente"></textarea>
                        </div>
                        <div class="w-100"></div>
                        <label for="imagenGarCar" class="col-sm-2 col-form-label" title="Documentos de la garantia">Imagen Garantia:</label>
                        <div class="col">
                            <input type="file" id="imagenGarCar" name="imagenGarCar[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                        </div>
                        <div class="w-100"></div>
                        <label for="imagenConCar" class="col-sm-2 col-form-label" title="Documentos del contrato">Imagen Contrato:</label>
                        <div class="col">
                            <input type="file" id="imagenConCar" name="imagenConCar[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                        </div>
                        <div class="w-100"></div>
                        <label for="imagenPagCar" class="col-sm-2 col-form-label" title="Documentos de pagare">Imagen Pagare:</label>
                        <div class="col">
                            <input type="file" id="imagenPagCar" name="imagenPagCar[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                        </div>
                    </div>
                    <hr/>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-success" id="btnGuardar" name="btnGuardar" value="Guardar">
                            <button type="reset" class="btn btn-info">Borrar Campos</button>
                            <a href="inicioGarantias.php"><input type="button" class="btn btn-outline-secondary" value="Cancelar"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/CargarGarantia.js"></script>
</html>
