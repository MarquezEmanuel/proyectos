<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la garantia seleccionada */

/* Se obtiene el id para obtener los datos de la BD */
$idGarantia = $_POST['seleccionado'];
$query = "SELECT * FROM garantia g
            LEFT JOIN cartera c ON g.id_cartera = c.id_cartera
            LEFT JOIN fianza f ON g.id_fianza = f.id_fianza 
            LEFT JOIN hipoteca h ON g.id_hipoteca = h.id_hipoteca 
            LEFT JOIN leasing l ON g.id_leasing = l.id_leasing 
            LEFT JOIN prenda p ON g.id_prenda = p.id_prenda
                        WHERE g.id_garantia =" . $idGarantia;
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
?>
<div class="container">
    <div id="contenido">
        <h4 class="text-center p-4">MODIFICAR GARANTIA</h4>
        <div id="centro" class="container">
            <?php
            if (!$idGarantia || !$result) {
                $log = new Log();
                $log->writeLine("[No se obtuvo idGarantia o fallo la consulta a la BD][QUERY: $query]");
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvieron datos de la garantia seleccionada </div>';
            } else {
                $gtia = sqlsrv_fetch_array($result);

                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */

                $fecAltaOpe = isset($gtia['fecAltaOpe']) ? $gtia['fecAltaOpe']->format('Y-m-d') : "";
                $fecVtoOpe = isset($gtia['fecVtoOpe']) ? $gtia['fecVtoOpe']->format('Y-m-d') : "";
                /* fechas de hipoteca */
                $fecVtoGtiaHip = isset($gtia['fecVtoGtiaHip']) ? $gtia['fecVtoGtiaHip']->format('Y-m-d') : "";
                $fecInscHip = isset($gtia['fecInscHip']) ? $gtia['fecInscHip']->format('Y-m-d') : "";
                /* fechas de prenda */
                $fecVtoGtiaPre = isset($gtia['fecVtoGtiaPre']) ? $gtia['fecVtoGtiaPre']->format('Y-m-d') : "";
                $fecEscPre = isset($gtia['fecEscPre']) ? $gtia['fecEscPre']->format('Y-m-d') : "";
                /* fechas de fianza */
                $fecVtoGtiaFia = isset($gtia['fecVtoGtiaFia']) ? $gtia['fecVtoGtiaFia']->format('Y-m-d') : "";
                $fecEscFia = isset($gtia['fecEscFia']) ? $gtia['fecEscFia']->format('Y-m-d') : "";
                $fecInscFia = isset($gtia['fecInscFia']) ? $gtia['fecInscFia']->format('Y-m-d') : "";
                /* fechas de leasing*/
                $fecVtoGtiaLea = isset($gtia['fecVtoGtiaLea']) ? $gtia['fecVtoGtiaLea']->format('Y-m-d') : "";
                $fecEscLea = isset($gtia['fecEscLea']) ? $gtia['fecEscLea']->format('Y-m-d') : "";
                /* fechas de cartera */
                $fecVtoGtiaCart = isset($gtia['fecVtoGtiaCart']) ? $gtia['fecVtoGtiaCart']->format('Y-m-d') : "";
                $fecEscCart = isset($gtia['fecEscCart']) ? $gtia['fecEscCart']->format('Y-m-d') : "";
                $fecInscCart = isset($gtia['fecInscCart']) ? $gtia['fecInscCart']->format('Y-m-d') : "";
                ?>
                <form action="procesarModificarGarantia.php" id='formModificarGtia' name='formModificarGtia' method="post" enctype="multipart/form-data">
                    <div class="container">

                        <!--Datos Comunes -->
                        <div class="row"> <div class="col"> <h5>DATOS COMUNES</h5> <hr/> </div> </div>
                        <div class="form-group row">
                            <input type="hidden" id="id_garantia" name="id_garantia" value="<?= $gtia['id_garantia'] ?>">

                            <label for="sucursal" class="col-sm-2 col-form-label" title="Sucursal">Sucursal:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="sucursal" name="sucursal" 
                                       min="1" max="9999"
                                       title="Sucursal" placeholder="Sucursal" 
                                       value="<?= $gtia['sucursal']; ?>">
                            </div>
                            <label for="moneda" class="col-sm-2 col-form-label" title="Moneda">Moneda:</label>
                            <div class="col" >
                                <input type="number" class="form-control mb-2" 
                                       id="moneda" name="moneda" min="1" 
                                       title="Moneda" placeholder="Moneda" 
                                       value="<?= $gtia['moneda']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="fecAltaOpe" class="col-sm-2 col-form-label" title="Fecha de alta de la operaci&oacute;n">Fecha Alta OP:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecAltaOpe" name="fecAltaOpe" min="2000-01-01" 
                                       title="Fecha de alta de la operaci&oacute;n" 
                                       value="<?= $fecAltaOpe; ?>">
                            </div>
                            <label for="fecVtoOpe" class="col-sm-2 col-form-label" title="Fecha de vencimiento de la operaci&oacute;n">Fecha Vto. OP:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecVtoOpe" name="fecVtoOpe" min="2000-01-01" 
                                       title="Fecha de vencimiento de la operaci&oacute;n" 
                                       value="<?= $fecVtoOpe; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="nroCli" class="col-sm-2 col-form-label" title="N&uacute;mero de cliente">N&uacute;mero Cliente:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="nroCli" name="nroCli" min="1"
                                       title="N&uacute;mero de Cliente" placeholder="N&uacute;mero Cliente" 
                                       value="<?= $gtia['nroCli']; ?>">
                            </div>
                            <label for="nomCli" class="col-sm-2 col-form-label" title="Nombre de cliente">Nombre Cliente:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="nomCli" name="nomCli"
                                       maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ ]{1,150}"
                                       title="Nombre de Cliente" placeholder="Nombre Cliente" 
                                       value="<?= $gtia['nomCli']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="descProd" class="col-sm-2 col-form-label" title="Descripci&oacute;n del producto">Desc. Producto:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="descProd" name="descProd" 
                                       maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                       title="Descripci&oacute;n del Producto" placeholder="Descripci&oacute;n del Producto" 
                                       value="<?= $gtia['descProd']; ?>">
                            </div>
                            <label for="opeRela" class="col-sm-2 col-form-label" title="Operaci&oacute;n/Relaci&oacute;n">Operaci&oacute;n/Relaci&oacute;n:</label>
                            <div class="col" >
                                <input type="number" class="form-control mb-2" 
                                       id="opeRela" name="opeRela" min="1"
                                       title="Operaci&oacute;n/Relaci&oacute;n" placeholder="Operaci&oacute;n/Relaci&oacute;n" 
                                       value="<?= $gtia['opeRela']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="sav" class="col-sm-2 col-form-label" title="N&uacute;mero valor no dinerario">SAV:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="sav" name="sav" 
                                       placeholder="N&uacute;mero Valor no Dinerario" title="N&uacute;mero Valor no Dinerario" 
                                       value="<?= $gtia['sav']; ?>">
                            </div>
                            <label for="prodCred" class="col-sm-2 col-form-label" title="Producto del credito">Producto Cred:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="prodCred" name="prodCred" 
                                       title="Producto del Credito" placeholder="Producto del Cr&eacute;dito"
                                       value="<?= $gtia['prodCred']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="entGtia" class="col-sm-2 col-form-label" title="Entrega garantia">Entrega Gtia:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="entGtia" name="entGtia" 
                                       maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                       title="Entrega de Garantia" placeholder="Entrega de Garantia" 
                                       value="<?= $gtia['entGtia']; ?>">
                            </div>
                            <label for="gesCan" class="col-sm-2 col-form-label" title="Gesti&oacute;n de cancelaci&oacute;n">Gesti&oacute;n de Canc:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="gesCan" name="gesCan" maxlength="100"
                                       pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,100}"
                                       title="Gesti&oacute;n de Cancelaci&oacute;n" placeholder="Gesti&oacute;n de Cancelaci&oacute;n"
                                       value="<?= $gtia['gesCan']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="oriGtia" class="col-sm-2 col-form-label" title="Original">Original:</label>
                            <div class="col">
                                <select class="form-control mb-2" id="oriGtia" name="oriGtia" title="Original">
                                    <?php
                                    if ($gtia['oriGtia'] === "SI") {
                                        echo "<option value='SI' selected>SI</option> <option value='NO'>NO</option>";
                                    } else {
                                        echo "<option value='SI'>SI</option> <option value='NO' selected>NO</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <label for="estado" class="col-sm-2 col-form-label" title="Estado">Estado:</label>
                            <div class="col" class="col-sm-2 col-form-label">
                                <select class="form-control mb-2" name="estado" id="estado">
                                    <?php
                                    $query = "SELECT * FROM estado";
                                    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
                                    if ($estados = sqlsrv_fetch_array($result)) {
                                        do {
                                            if ($gtia['estado'] == $estados["id_estado"]) {
                                                echo "<option value=" . $estados["id_estado"] . " selected>" . $estados["nombre"] . "</option>";
                                            } else {
                                                echo "<option value=" . $estados["id_estado"] . ">" . $estados["nombre"] . "</option>";
                                            }
                                        } while ($estados = sqlsrv_fetch_array($result));
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="w-100"></div>
                            <label for="valNomi" class="col-sm-2 col-form-label" title="Valor nominal">Valor Nominal:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="valNomi" name="valNomi" step="0.01" min="1" 
                                       placeholder="Valor Nominal" 
                                       title="Valor Nominal" value="<?= $gtia['valNomi']; ?>">
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
                            <div class="w-100"></div>
                            <label for="observacion" class="col-sm-2 col-form-label" title="Observaci&oacute;n">Observaci&oacute;n:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" 
                                          id="observacion" name="observacion" maxlength="150"
                                          maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                          title="Observaci&oacute;n" placeholder="Observaciones" ><?= $gtia['observacion']; ?></textarea>
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
                        <div class="form-group row" id="camposHipoteca" name="camposHipoteca" style="display: none">
                            <input type="hidden" id="id_hipoteca" name="id_hipoteca" value="<?= $gtia['id_hipoteca'] ?>">
                            <label for="prodGtiaHip" class="col-sm-2 col-form-label" title="Producto de garantia">Producto Garantia:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="prodGtiaHip" name="prodGtiaHip" min="1"
                                       value="<?= $gtia['prodGtiaHip'] ?>"
                                       title="Producto de Garantia" placeholder="Producto de Garantia">
                            </div>
                            <label for="numGtiaHip" class="col-sm-2 col-form-label" title="N&uacute;mero de garantia">Número Garantia:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="numGtiaHip" name="numGtiaHip" min="1"
                                       value="<?= $gtia['nroGtiaHip'] ?>"
                                       title="N&uacute;mero de Garantia" placeholder="N&uacute;mero de Garantia">
                            </div>
                            <div class="w-100"></div>
                            <label for="fecVtoGtiaHip" class="col-sm-2 col-form-label" title="Fecha de vencimiento de garantia">Fecha Vencimiento:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecVtoGtiaHip" name="fecVtoGtiaHip" 
                                       value="<?= $fecVtoGtiaHip; ?>"
                                       title="Fecha de vencimiento de la garantia">
                            </div>
                            <label for="fecInscHip" class="col-sm-2 col-form-label" title="Fecha de inscripci&oacute;n">Fecha Inscripci&oacute;n:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecInscHip" name="fecInscHip" 
                                       min="2000-01-01" title="Fecha de inscripcion" 
                                       value="<?= $fecInscHip; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="cotizaHip" class="col-sm-2 col-form-label" title="Cotizaci&oacute;n">Cotizaci&oacute;n:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="cotizaHip" name="cotizaHip" step="0.01" min="1" 
                                       title="Tasaci&oacute;n" placeholder="Tasaci&oacute;n"
                                       value="<?= $gtia['cotizaHip']; ?>">
                            </div>
                            <label for="nroInscHip" class="col-sm-2 col-form-label" title="N&uacute;mero de inscripci&oacute;n">N&uacute;mero Inscripci&oacute;n:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="nroInscHip" name="nroInscHip" min="1"
                                       title="N&uacute;mero Inscripci&oacute;n" placeholder="N&uacute;mero de Inscripci&oacute;n" 
                                       value="<?= $gtia['nroInscHip']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="escDomHip" class="col-sm-2 col-form-label" title="Esc. dominio">Esc. Dominio:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="escDomHip" name="escDomHip" min="1" 
                                       title="N&uacute;mero de escritura" placeholder="N&uacute;mero de Escritura"
                                       value="<?= $gtia['escDomHip']; ?>">
                            </div>
                            <label for="deudorHip" class="col-sm-2 col-form-label" title="Hipotecante">Hipotecante:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="deudorHip" name="deudorHip" 
                                       maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                       title="Hipotecante" placeholder="Hipotecante"
                                       value="<?= $gtia['deudorHip']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="nomSegHip" class="col-sm-2 col-form-label" title="Nombre del seguro">Nombre Seguro:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="nomSegHip" name="nomSegHip" 
                                       maxlength="50" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,50}"
                                       title="Nombre compañia aseguradora" placeholder="Nombre Compañia Aseguradora"
                                       value="<?= $gtia['nomSegHip']; ?>">
                            </div>
                            <label for="vtoSegHip" class="col-sm-2 col-form-label" title="Vencimiento del seguro">Vto. Seguro:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="vtoSegHip" name="vtoSegHip" 
                                       pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,50}"
                                       title="Vencimiento del seguro" placeholder="Vencimiento del Seguro"
                                       value="<?= $gtia['vtoSegHip']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="monto" class="col-sm-2 col-form-label" title="Monto">Monto:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="montoHip" name="montoHip" min="1" step="0.01"
                                       title="Monto" placeholder="Monto"
                                       value="<?= $gtia['montoHip']; ?>">
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
                            <div class="w-100"></div>
                            <label for="datGtiaHip" class="col-sm-2 col-form-label" title="Datos de la garantia">Datos Garantia:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" 
                                          id="datGtiaHip" name="datGtiaHip" 
                                          maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                          title="Datos de garantia" placeholder="Datos de Garantia"><?= $gtia['datGtiaHip']; ?></textarea>
                            </div>
                            <div class="w-100"></div>
                            <label for="rutaImgGtiaHip" class="col-sm-2 col-form-label" title="Documentos de garantia">Imagen Garantia:</label>
                            <div class="col">
                                <input type="file" id="imagenGarHip" name="imagenGarHip[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                            </div>
                            <hr ></hr>
                            <div class="w-100"></div>
                            <label for="rutaImgTasHip" class="col-sm-2 col-form-label" title="Documentos de tasaci&oacute;n">Imagen Tasaci&oacute;n:</label>
                            <div class="col">
                                <input type="file" id="imagenTasHip" name="imagenTasHip[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                            </div>
                            <div class="w-100"></div>
                            <label class="col-sm-2 col-form-label" title="Documentos de hipoteca">Documentos:</label>
                            <div class="col">
                                <button id="imgHipoteca" class='btn btn-sm btn-outline-info' title="Ver documentos de hipoteca">
                                    <img src='../../lib/img/SHOW.png' width='18' height='18' >
                                </button>
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
                        <div class="form-group row" id="camposPrenda" name="camposPrenda" style="display: none">
                            <input type="hidden" id="id_prenda" name="id_prenda" value="<?= $gtia['id_prenda'] ?>">
                            <label for="prodGtiaPren" class="col-sm-2 col-form-label" title="Producto de garantia">Producto Garantia:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="prodGtiaPren" name="prodGtiaPren" min="1"
                                       value="<?= $gtia['prodGtiaPre'] ?>"
                                       title="Producto de Garantia" placeholder="Producto de Garantia">
                            </div>
                            <label for="numGtiaPren" class="col-sm-2 col-form-label" title="N&uacute;mero de garantia">Número Garantia:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="numGtiaPren" name="numGtiaPren" min="1"
                                       value="<?= $gtia['nroGtiaPre'] ?>"
                                       title="N&uacute;mero de Garantia" placeholder="N&uacute;mero de Garantia">
                            </div>
                            <div class="w-100"></div>
                            <label for="fecVtoGtiaPren" class="col-sm-2 col-form-label" title="Fecha de vencimiento de garantia">Fecha Vencimiento:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecVtoGtiaPren" name="fecVtoGtiaPren"
                                       value="<?= $fecVtoGtiaPre ?>"
                                       title="Fecha de vencimiento de la garantia">
                            </div>
                            <label for="cotizaPre" class="col-sm-2 col-form-label" title="Cotizaci&oacute;n">Cotizaci&oacute;n:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="cotizaPre" name="cotizaPre" step="0.01" min="1" 
                                       title="Tasaci&oacute;n" placeholder="Tasaci&oacute;n" 
                                       value="<?= $gtia['cotizaPre']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="nomSegPre" class="col-sm-2 col-form-label" title="Nombre del seguro">Nombre Seguro:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="nomSegPre" name="nomSegPre" 
                                       maxlength="50" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,50}"
                                       title="Nombre de compañia aseguradora" placeholder="Nombre de Compañia Aseguradora"
                                       value="<?= $gtia['nomSegPre']; ?>">
                            </div>
                            <label for="vtoSegPre" class="col-sm-2 col-form-label" title="Vencimiento del seguro">Vto. Seguro:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="vtoSegPre" name="vtoSegPre" 
                                       maxlength="50" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,50}"
                                       title="Vencimiento del seguro" placeholder="Vencimiento del Seguro"
                                       value="<?= $gtia['vtoSegPre']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="nroInscPre" class="col-sm-2 col-form-label" title="N&uacute;mero de inscripci&oacute;n">N&uacute;mero Inscripci&oacute;n:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="nroInscPre" name="nroInscPre" min="1"
                                       title="N&uacute;mero de Inscripci&oacute;n" placeholder="N&uacute;mero de Inscripci&oacute;n"
                                       value="<?= $gtia['nroInscPre']; ?>">
                            </div>
                            <label for="fecEscPre" class="col-sm-2 col-form-label" title="Fecha de inscripci&oacute;n">Fecha Inscripci&oacute;n:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecEscPre" name="fecEscPre" min="2000-01-01" 
                                       title="Fecha de inscripcion" 
                                       value="<?= $fecEscPre; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="deudorPre" class="col-sm-2 col-form-label" title="Deudor">Deudor:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="deudorPre" name="deudorPre" 
                                       maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                       title="Deudor" placeholder="Deudor" 
                                       value="<?= $gtia['deudorPre']; ?>">
                            </div>
                            <label for="montoPren" class="col-sm-2 col-form-label" title="Monto">Monto:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="montoPren" name="montoPren" min="1" step="0.01"
                                       title="Monto" placeholder="Monto"
                                       value="<?= $gtia['montoPre']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="datGtiaPre" class="col-sm-2 col-form-label" title="Datos de garantia">Datos Garantia:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" 
                                          id="datGtiaPre" name="datGtiaPre" 
                                          maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                          title="Datos de garantia" placeholder="Datos de Garantia"><?= $gtia['datGtiaPre']; ?></textarea>
                            </div>
                            <div class="w-100"></div>
                            <label for="rutaImgGtiaPre" class="col-sm-2 col-form-label" title="Documentos de garantia">Imagen Garantia:</label>
                            <div class="col">
                                <input type="file" id="rutaImgGtiaPre" name="rutaImgGtiaPre[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                            </div>
                            <div class="w-100"></div>
                            <label for="rutaImgTasPre" class="col-sm-2 col-form-label" title="Documentos de tasaci&oacute;n">Imagen Tasaci&oacute;n:</label>
                            <div class="col">
                                <input type="file" id="rutaImgTasPre" name="rutaImgTasPre[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                            </div>
                            <div class="w-100"></div>
                            <label class="col-sm-2 col-form-label" title="Documentos de prenda">Documentos:</label>
                            <div class="col">
                                <button id="imgPrenda" class='btn btn-sm btn-outline-info' title="Ver documentos de prenda">
                                    <img src='../../lib/img/SHOW.png' width='18' height='18' >
                                </button>
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
                        <div class="form-group row" id="camposFianza" name="camposFianza" style="display: none">
                            <input type="hidden" id="id_fianza" name="id_fianza" value="<?= $gtia['id_fianza'] ?>">
                            <label for="prodGtiaFia" class="col-sm-2 col-form-label" title="Producto de garantia">Producto Garantia:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="prodGtiaFia" name="prodGtiaFia" min="1"
                                       title="Producto de Garantia" placeholder="Producto de Garantia"
                                       value="<?= $gtia['prodGtiaFia'] ?>">
                            </div>
                            <label for="numGtiaFia" class="col-sm-2 col-form-label" title="N&uacute;mero de garantia">Número Garantia:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="numGtiaFia" name="numGtiaFia" min="1"
                                       value="<?= $gtia['nroGtiaFia'] ?>"
                                       title="N&uacute;mero de Garantia" placeholder="N&uacute;mero de Garantia">
                            </div>
                            <div class="w-100"></div>
                            <label for="fecVtoGtiaFia" class="col-sm-2 col-form-label" title="Fecha de vencimiento de garantia">Fecha Vencimiento:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecVtoGtiaFia" name="fecVtoGtiaFia"
                                       value="<?= $fecVtoGtiaFia?>"
                                       title="Fecha de vencimiento de la garantia">
                            </div>
                            <label for="fecEscFia" class="col-sm-2 col-form-label" title="Fecha de la escribania">Fecha Escribania:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecEscFia" name="fecEscFia" min="2000-01-01"
                                       title="Fecha de certificaci&oacute;n escribania" placeholder="Fecha Certificaci&oacute;n Escribania" value="<?= $fecEscFia; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="fecInscFia" class="col-sm-2 col-form-label" title="Fecha de instrumentaci&oacute;n">Fecha Inst:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecInscFia" name="fecInscFia" min="2000-01-01"
                                       title="Fecha de la instrumentaci&oacute;n"
                                       value="<?= $fecInscFia; ?>">
                            </div>
                            <label for="monto" class="col-sm-2 col-form-label">Monto:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="montoFia" name="montoFia" step="0.01" min="1" 
                                       title="Monto" placeholder="Monto" 
                                       value="<?= $gtia['montoFia']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="datAcue" class="col-sm-2 col-form-label" title="Datos del acuerdo">Datos Acuerdo:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" 
                                          id="datAcue" name="datAcue" 
                                          maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                          title="Datos del acuerdo" placeholder="Datos del Acuerdo"><?= $gtia['datAcue']; ?></textarea>
                            </div>
                            <div class="w-100"></div>
                            <label for="datFiad" class="col-sm-2 col-form-label" title="Datos del fiador">Datos Fiador:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" 
                                          id="datFiad" name="datFiad" 
                                          maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                          placeholder="Datos del fiador" ><?= $gtia['datFiad']; ?></textarea>
                            </div>
                            <div class="w-100"></div>
                            <label for="rutaImgGtiaFia" class="col-sm-2 col-form-label" title="Documentos de la garantia">Imagen Garantia:</label>
                            <div class="col">
                                <input type="file" id="rutaImgGtiaFia" name="rutaImgGtiaFia[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                            </div>
                            <div class="w-100"></div>
                            <label class="col-sm-2 col-form-label" title="Documentos de fianza">Documentos:</label>
                            <div class="col">
                                <button id="imgFianza" class='btn btn-sm btn-outline-info' title="Ver documentos de fianza">
                                    <img src='../../lib/img/SHOW.png' width='18' height='18' >
                                </button>
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
                        <div class="form-group row" id="camposLeasing" name="camposLeasing" style="display: none">
                            <input type="hidden" id="id_leasing" name="id_leasing" value="<?= $gtia['id_leasing'] ?>">
                            <label for="prodGtiaLea" class="col-sm-2 col-form-label" title="Producto de garantia">Producto Garantia:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="prodGtiaLea" name="prodGtiaLea" min="1"
                                       value="<?= $gtia['prodGtiaLea'] ?>"
                                       title="Producto de Garantia" placeholder="Producto de Garantia">
                            </div>
                            <label for="numGtiaLea" class="col-sm-2 col-form-label" title="N&uacute;mero de garantia">Número Garantia:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="numGtiaLea" name="numGtiaLea" min="1"
                                       value="<?= $gtia['nroGtiaLea'] ?>"
                                       title="N&uacute;mero de Garantia" placeholder="N&uacute;mero de Garantia">
                            </div>
                            <div class="w-100"></div>
                            <label for="fecVtoGtiaLea" class="col-sm-2 col-form-label" title="Fecha de vencimiento de garantia">Fecha Vencimiento:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecVtoGtiaLea" name="fecVtoGtiaLea" 
                                       value="<?= $fecVtoGtiaLea ?>"
                                       title="Fecha de vencimiento de la garantia">
                            </div>
                            <label for="fecEscLea" class="col-sm-2 col-form-label" title="Fecha de la escribania">Fecha Escribania:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecEscLea" name="fecEscLea" min="2000-01-01" 
                                       title="Fecha de certificaci&oacute;n escribania"
                                       value="<?= $fecEscLea; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="nomSegLea" class="col-sm-2 col-form-label" title="Nombre del seguro">Nombre Seguro:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="nomSegLea" name="nomSegLea"  
                                       maxlength="50" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,50}"
                                       title="Nombre de compañia aseguradora" placeholder="Nombre de Compañia Aseguradora" 
                                       value="<?= $gtia['nomSegLea']; ?>">
                            </div>
                            <label for="vtoSegLea" class="col-sm-2 col-form-label" title="Vencimiento del seguro">Vto. Seguro:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="vtoSegLea" name="vtoSegLea" 
                                       maxlength="50" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,50}"
                                       title="vencimiento del seguro" placeholder="Vencimiento del Seguro"
                                       value="<?= $gtia['vtoSegLea']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="nroInscLea" class="col-sm-2 col-form-label" title="N&uacute;mero de inscripci&oacute;n">N&uacute;mero Inscripci&oacute;n:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="nroInscLea" name="nroInscLea" min="1"
                                       title="N&uacute;mero de inscripci&oacute;n" placeholder="N&uacute;mero de Inscripci&oacute;n"
                                       value="<?= $gtia['nroInscLea']; ?>">
                            </div>
                            <label for="cotizaLea" class="col-sm-2 col-form-label" title="Cotizaci&oacute;n">Cotizaci&oacute;n:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="cotizaLea" name="cotizaLea" step="0.01" min="1" 
                                       title="Tasaci&oacute;n" placeholder="Tasaci&oacute;n"
                                       value="<?= $gtia['cotizaLea']; ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="montoLea" class="col-sm-2 col-form-label" title="Monto">Monto:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="montoLea" name="montoLea" min="1" step="0.01"
                                       title="Monto" placeholder="Monto"
                                       value="<?= $gtia['montoLea']; ?>">
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
                            <div class="w-100"></div>
                            <label for="datGtiaLea" class="col-sm-2 col-form-label" title="Datos de garantia">Datos Garantia:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" 
                                          id="datGtiaLea" name="datGtiaLea" 
                                          maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                          title="Datos del bien" placeholder="Datos del Bien"><?= $gtia['datGtiaLea']; ?></textarea>
                            </div>
                            <div class="w-100"></div>
                            <label for="rutaImgGtiaLea" class="col-sm-2 col-form-label" title="Documentos de contrato">Imagen Contrato:</label>
                            <div class="col">
                                <input type="file" id="rutaImgGtiaLea" name="rutaImgGtiaLea[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                            </div>
                            <div class="w-100"></div>
                            <label for="rutaImgTasLea" class="col-sm-2 col-form-label" title="Documentos de tasaci&oacute;n">Imagen Tasaci&oacute;n:</label>
                            <div class="col">
                                <input type="file" id="rutaImgTasLea" name="rutaImgTasLea[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                            </div>
                            <div class="w-100"></div>
                            <label class="col-sm-2 col-form-label" title="Documentos de leasing">Documentos:</label>
                            <div class="col">
                                <button id="imgLeasing" class='btn btn-sm btn-outline-info' title="Ver documentos de leasing">
                                    <img src='../../lib/img/SHOW.png' width='18' height='18' >
                                </button>
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
                        <div class="form-group row" id="camposCartera" name="camposCartera" style="display: none">
                            <input type="hidden" id="id_cartera" name="id_cartera" value="<?= $gtia['id_cartera'] ?>">
                            <label for="prodGtiaCar" class="col-sm-2 col-form-label" title="Producto de garantia">Producto Garantia:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="prodGtiaCar" name="prodGtiaCar" min="1"
                                       value="<?= $gtia['prodGtiaCart'] ?>"
                                       title="Producto de Garantia" placeholder="Producto de Garantia">
                            </div>
                            <label for="numGtiaCar" class="col-sm-2 col-form-label" title="N&uacute;mero de garantia">Número Garantia:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="numGtiaCar" name="numGtiaCar" min="1"
                                       value="<?= $gtia['nroGtiaCart'] ?>"
                                       title="N&uacute;mero de Garantia" placeholder="N&uacute;mero de Garantia">
                            </div>
                            <div class="w-100"></div>
                            <label for="fecVtoGtiaCar" class="col-sm-2 col-form-label" title="Fecha de vencimiento de garantia">Fecha Vencimiento:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecVtoGtiaCar" name="fecVtoGtiaCar"
                                       value="<?= $fecVtoGtiaCart ?>"
                                       title="Fecha de vencimiento de la garantia">
                            </div>
                            <label for="fecInscCart" class="col-sm-2 col-form-label">Fecha Inst:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" id="fecInscCart" 
                                       name="fecInscCart" min="2000-01-01" 
                                       title="Fecha de inscripcion" value="<?= $fecInscCart ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="fecEscCart" class="col-sm-2 col-form-label" title="Fecha de la escribania">Fecha Escribania:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2" 
                                       id="fecEscCart" name="fecEscCart" min="2000-01-01" 
                                       title="Fecha de certificaci&oacute;n escribania" 
                                       value="<?= $fecEscCart; ?>">
                            </div>
                            <label for="montoCar" class="col-sm-2 col-form-label" title="Monto">Monto:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" 
                                       id="montoCar" name="montoCar" min="1" step="0.01"
                                       title="Monto" placeholder="Monto"
                                       value="<?= $gtia['montoCart'] ?>">
                            </div>
                            <div class="w-100"></div>
                            <label for="datCart" class="col-sm-2 col-form-label" title="Datos del cedente">Datos Cedente:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" 
                                          id="datCart" name="datCart" 
                                          maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                          title="Datos del cedente" placeholder="Datos del Cedente"><?= $gtia['datCart']; ?></textarea>
                            </div>
                            <div class="w-100"></div>
                            <label for="rutaImgGtiaCart" class="col-sm-2 col-form-label" title="Documentos de la garantia">Imagen Garantia:</label>
                            <div class="col">
                                <input type="file" id="rutaImgGtiaCart" name="rutaImgGtiaCart[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                            </div>
                            <hr /><hr />
                            <div class="w-100"></div>
                            <label for="rutaImgCont" class="col-sm-2 col-form-label" title="Documentos del contrato">Imagen Contrato:</label>
                            <div class="col">
                                <input type="file" id="rutaImgCont" name="rutaImgCont[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                            </div>
                            <div class="w-100"></div>
                            <label for="rutaImgPaga" class="col-sm-2 col-form-label" title="Documentos de pagare">Imagen Pagare:</label>
                            <div class="col">
                                <input type="file" id="rutaImgPaga" name="rutaImgPaga[]" class="file" multiple data-show-upload="true" data-show-caption="true">
                            </div>
                            <div class="w-100"></div>
                            <label class="col-sm-2 col-form-label" title="Documentos de compra de cartera">Documentos:</label>
                            <div class="col">
                                <button id="imgCartera" class='btn btn-sm btn-outline-info' title="Ver documentos de compra de cartera">
                                    <img src='../../lib/img/SHOW.png' width='18' height='18' >
                                </button>
                            </div>
                        </div>
                        <hr/>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <input type="submit" class="btn btn-success" id="btnGuardar" name="btnGuardar" value="Guardar">
                                <a href="formBuscarGarantia.php"><input type="button" class="btn btn-outline-secondary" value="Cancelar"></a>
                            </div>
                        </div>
                    </div><br>
                </form>
            <?php } // ELSE         ?>
        </div>
    </div>
    <div id="contenido2"></div>
    <?php
    /* MODAL PARA MOSTRAR LOS DOCUMENTOS DE HIPOTECA */

    echo '
        <div class="modal" id="mdImgHipoteca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">DOCUMENTOS DE HIPOTECA</h4>
                    </div>
                    <div class="modal-body">';
    $query = "SELECT * FROM imagenesHipoteca WHERE " . $gtia['id_hipoteca'] . " = idHipoteca";
    $resultHipoteca = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    if ($resultHipoteca) {

        if (sqlsrv_has_rows($resultHipoteca)) {
            echo '
            <table class="table table-sm  table-bordered table-hover">
                <thead style="background-color:#739cc7;">
                <tr> 
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Ver</th>
                    <th>Eliminar</th>
                 </tr>
                </thead>
                <tbody style="background-color: white;">';
            while ($row = sqlsrv_fetch_array($resultHipoteca, SQLSRV_FETCH_ASSOC)) {
                $path = explode("\\", $row['ruta']);
                $size = count($path);
                echo '
                <tr>
                    <td>' . $row['tipo'] . '</td>
                    <td>' . $path[$size - 1] . '</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-info">
                            <a href="procesarDescargaPDF.php?path=' . $row['ruta'] . '" target="_blank" > <img src="../../lib/img/SHOW.png" width="18" height="18" > </a>
                        </button> 
                    </td>
                    <td class="text-center">
                    <form name="cualquiera" method="post" action="procesarBorrarPDF.php">
                        <input type="hidden" id="ruta" name="ruta" value="' . $row['ruta'] . '">
                        <input type="hidden" id="identificador" name="identificador" value="' . $row['id'] . '">
                        <input type="hidden" id="tipo" name="tipo" value="hipoteca">
                        <button class="btn btn-sm btn-outline-info" type="submit"><img src="../../lib/img/DELETE.png" width="18" height="18"></button> 
                        </form>
                    </td>
                </tr>';
            }
            echo '                        
                </tbody>
            </table>';
        } else {
            echo '<div class="alert alert-warning text-center" role="alert"> No hay documentos de hipoteca para mostrar</div>';
        }
    } else {
        $log = new Log();
        $log->writeLine("[Error al consultar las imagenes de hipoteca][QUERY: $query]");
        echo '<div class="alert alert-danger text-center" role="alert">Error al consultar documentos de hipoteca</div>';
    }
    echo'
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="Aceptar" data-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>';

    /* MODAL PARA MOSTRAR LOS DOCUMENTOS DE PRENDA */

    echo '
        <div class="modal" id="mdImgPrenda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">DOCUMENTOS DE PRENDA</h4>
                    </div>
                    <div class="modal-body">';
    $query = "SELECT * FROM imagenesPrenda WHERE " . $gtia['id_prenda'] . " = idPrenda";
    $resultPrenda = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    if ($resultPrenda) {

        if (sqlsrv_has_rows($resultPrenda)) {
            echo '
            <table class="table table-sm  table-bordered table-hover">
                <thead style="background-color:#739cc7;">
                <tr> 
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Ver</th>
                    <th>Eliminar</th>
                 </tr>
                </thead>
                <tbody style="background-color: white;">';
            while ($row = sqlsrv_fetch_array($resultPrenda, SQLSRV_FETCH_ASSOC)) {
                $path = explode("\\", $row['ruta']);
                $size = count($path);
                echo '
                <tr>
                    <td>' . $row['tipo'] . '</td>
                    <td>' . $path[$size - 1] . '</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-info">
                            <a href="procesarDescargaPDF.php?path=' . $row['ruta'] . '" target="_blank" > <img src="../../lib/img/SHOW.png" width="18" height="18" > </a>
                        </button> 
                    </td>
                    <td class="text-center">
                    <form name="cualquiera" method="post" action="procesarBorrarPDF.php">
                        <input type="hidden" id="ruta" name="ruta" value="' . $row['ruta'] . '">
                        <input type="hidden" id="identificador" name="identificador" value="' . $row['id'] . '">
                        <input type="hidden" id="tipo" name="tipo" value="prenda">
                        <button class="btn btn-sm btn-outline-info" type="submit"><img src="../../lib/img/DELETE.png" width="18" height="18"></button> 
                        </form>
                    </td>
                </tr>';
            }
            echo '                        
                </tbody>
            </table>';
        } else {
            echo '<div class="alert alert-warning text-center" role="alert"> No hay documentos de prenda para mostrar</div>';
        }
    } else {
        $log = new Log();
        $log->writeLine("[Error al consultar las imagenes de prenda][QUERY: $query]");
        echo '<div class="alert alert-danger text-center" role="alert">Error al consultar documentos de prenda</div>';
    }
    echo'
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="Aceptar" data-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>';

    /* MODAL PARA MOSTRAR LOS DOCUMENTOS DE FIANZA */

    echo '
        <div class="modal" id="mdImgFianza" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">DOCUMENTOS DE FIANZA</h4>
                    </div>
                    <div class="modal-body">';
    $query = "SELECT * FROM imagenesFianza WHERE " . $gtia['id_fianza'] . " = idFianza";
    $resultFianza = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    if ($resultFianza) {

        if (sqlsrv_has_rows($resultFianza)) {
            echo '
            <table class="table table-sm  table-bordered table-hover">
                <thead style="background-color:#739cc7;">
                <tr> 
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Ver</th>
                    <th>Eliminar</th>
                 </tr>
                </thead>
                <tbody style="background-color: white;">';
            while ($row = sqlsrv_fetch_array($resultFianza, SQLSRV_FETCH_ASSOC)) {
                $path = explode("\\", $row['ruta']);
                $size = count($path);
                echo '
                <tr>
                    <td>' . $row['tipo'] . '</td>
                    <td>' . $path[$size - 1] . '</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-info">
                            <a href="procesarDescargaPDF.php?path=' . $row['ruta'] . '" target="_blank" > <img src="../../lib/img/SHOW.png" width="18" height="18" > </a>
                        </button> 
                    </td>
                    <td class="text-center">
                    <form name="cualquiera" method="post" action="procesarBorrarPDF.php">
                        <input type="hidden" id="ruta" name="ruta" value="' . $row['ruta'] . '">
                        <input type="hidden" id="identificador" name="identificador" value="' . $row['id'] . '">
                        <input type="hidden" id="tipo" name="tipo" value="fianza">
                        <button class="btn btn-sm btn-outline-info" type="submit"><img src="../../lib/img/DELETE.png" width="18" height="18"></button> 
                        </form>
                    </td>
                </tr>';
            }
            echo '                        
                </tbody>
            </table>';
        } else {
            echo '<div class="alert alert-warning text-center" role="alert"> No hay documentos de fianza para mostrar</div>';
        }
    } else {
        $log = new Log();
        $log->writeLine("[Error al consultar las imagenes de fianza][QUERY: $query]");
        echo '<div class="alert alert-danger text-center" role="alert">Error al consultar documentos de fianza</div>';
    }
    echo'
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="Aceptar" data-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>';

    /* MODAL PARA MOSTRAR LOS DOCUMENTOS DE LEASING */

    echo '
        <div class="modal" id="mdImgLeasing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">DOCUMENTOS DE LEASING</h4>
                    </div>
                    <div class="modal-body">';
    $query = "SELECT * FROM imagenesLeasing WHERE " . $gtia['id_leasing'] . " = idLeasing";
    $resultLeasing = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    if ($resultLeasing) {

        if (sqlsrv_has_rows($resultLeasing)) {
            echo '
            <table class="table table-sm  table-bordered table-hover">
                <thead style="background-color:#739cc7;">
                <tr> 
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Ver</th>
                    <th>Eliminar</th>
                 </tr>
                </thead>
                <tbody style="background-color: white;">';
            while ($row = sqlsrv_fetch_array($resultLeasing, SQLSRV_FETCH_ASSOC)) {
                $path = explode("\\", $row['ruta']);
                $size = count($path);
                echo '
                <tr>
                    <td>' . $row['tipo'] . '</td>
                    <td>' . $path[$size - 1] . '</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-info">
                            <a href="procesarDescargaPDF.php?path=' . $row['ruta'] . '" target="_blank" > <img src="../../lib/img/SHOW.png" width="18" height="18" > </a>
                        </button> 
                    </td>
                    <td class="text-center">
                    <form name="cualquiera" method="post" action="procesarBorrarPDF.php">
                        <input type="hidden" id="ruta" name="ruta" value="' . $row['ruta'] . '">
                        <input type="hidden" id="identificador" name="identificador" value="' . $row['id'] . '">
                        <input type="hidden" id="tipo" name="tipo" value="leasing">
                        <button class="btn btn-sm btn-outline-info" type="submit"><img src="../../lib/img/DELETE.png" width="18" height="18"></button> 
                        </form>
                    </td>
                </tr>';
            }
            echo '                        
                </tbody>
            </table>';
        } else {
            echo '<div class="alert alert-warning text-center" role="alert"> No hay documentos de leasing para mostrar</div>';
        }
    } else {
        $log = new Log();
        $log->writeLine("[Error al consultar las imagenes de leasing][QUERY: $query]");
        echo '<div class="alert alert-danger text-center" role="alert">Error al consultar documentos de leasing</div>';
    }
    echo'
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="Aceptar" data-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>';

    /* MODAL PARA MOSTRAR LOS DOCUMENTOS DE CARTERA */

    echo '
        <div class="modal" id="mdImgCartera" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">DOCUMENTOS DE COMPRA DE CARTERA</h4>
                    </div>
                    <div class="modal-body">';
    $query = "SELECT * FROM imagenesCartera WHERE " . $gtia['id_cartera'] . " = idCartera";
    $resultCartera = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    if ($resultCartera) {

        if (sqlsrv_has_rows($resultCartera)) {
            echo '
            <table class="table table-sm  table-bordered table-hover">
                <thead style="background-color:#739cc7;">
                <tr> 
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Ver</th>
                    <th>Eliminar</th>
                 </tr>
                </thead>
                <tbody style="background-color: white;">';
            while ($row = sqlsrv_fetch_array($resultCartera, SQLSRV_FETCH_ASSOC)) {
                $path = explode("\\", $row['ruta']);
                $size = count($path);
                echo '
                <tr>
                    <td>' . $row['tipo'] . '</td>
                    <td>' . $path[$size - 1] . '</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-info">
                            <a href="procesarDescargaPDF.php?path=' . $row['ruta'] . '" target="_blank" > <img src="../../lib/img/SHOW.png" width="18" height="18" > </a>
                        </button> 
                    </td>
                    <td class="text-center">
                    <form name="cualquiera" method="post" action="procesarBorrarPDF.php">
                        <input type="hidden" id="ruta" name="ruta" value="' . $row['ruta'] . '">
                        <input type="hidden" id="identificador" name="identificador" value="' . $row['id'] . '">
                        <input type="hidden" id="tipo" name="tipo" value="cartera">
                        <button class="btn btn-sm btn-outline-info" type="submit"><img src="../../lib/img/DELETE.png" width="18" height="18"></button> 
                        </form>
                    </td>
                </tr>';
            }
            echo '                        
                </tbody>
            </table>';
        } else {
            echo '<div class="alert alert-warning text-center" role="alert"> No hay documentos de cartera para mostrar</div>';
        }
    } else {
        $log = new Log();
        $log->writeLine("[Error al consultar las imagenes de cartera][QUERY: $query]");
        echo '<div class="alert alert-danger text-center" role="alert">Error al consultar documentos de compra de cartera</div>';
    }
    echo'
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="Aceptar" data-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>';
    ?>
    <script type="text/javascript" charset="utf8" src="../../lib/JQuery/ModificarGarantia.js"></script>
</div>
</body>
</html>
