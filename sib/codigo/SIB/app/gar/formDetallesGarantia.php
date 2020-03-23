<?php
/* CONSTANTES PARA LAS RUTAS - LOG PARA REGISTRAR Y CONEXION A BASE DE DATOS */
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';
?>
<div class="container">
    <div id="contenido">
        <h4 class="text-center p-4">DETALLES DE GARANTIA</h4>
        <div id="centro" class="container">
            <?php
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

            $queryEstados = "SELECT * FROM estado";
            $estados = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryEstados);

            if (!$idGarantia || !$result || !$estados) {
                $log = new Log();
                $log->writeLine("[Error al consultar garantia o estados][QUERY: $query][QUERY: $queryEstados]");
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la garantia </div>';
            } else {
                $gtia = sqlsrv_fetch_array($result);

                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */

                $fecAltaOpe = isset($gtia['fecAltaOpe']) ? $gtia['fecAltaOpe']->format('Y-m-d') : "";
                $fecVtoOpe = isset($gtia['fecVtoOpe']) ? $gtia['fecVtoOpe']->format('Y-m-d') : "";
                ?>
                <div class="container">
                    <div class="row"> <div class="col"> <h5>DATOS COMUNES</h5> <hr/></div> </div>
                    <div class="form-group row">
                        <input type="hidden" id="id_garantia" name="id_garantia" value="<?= $gtia['id_garantia'] ?>">
                        <div class="w-100"></div>
                        <label for="sucursal" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" placeholder="Sucursal" value="<?= $gtia['sucursal']; ?>" readonly>
                        </div>
                        <label for="moneda" class="col-sm-2 col-form-label">Moneda:</label>
                        <div class="col" >
                            <input type="number" class="form-control mb-2" placeholder="Moneda" value="<?= $gtia['moneda']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fecAltaOpe" class="col-sm-2 col-form-label">Fecha Alta OP:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2"  value="<?= $fecAltaOpe; ?>" readonly>
                        </div>
                        <label for="fecVtoOpe" class="col-sm-2 col-form-label">Fecha Vto. OP:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" title="Fecha Vencimiento Operacion" value="<?= $fecVtoOpe; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nroCli" class="col-sm-2 col-form-label">N&uacute;mero Cliente:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" placeholder="Numero Cliente" value="<?= $gtia['nroCli']; ?>" readonly>
                        </div>
                        <label for="nomCli" class="col-sm-2 col-form-label">Nombre Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" placeholder="Nombre Cliente" value="<?= $gtia['nomCli']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="descProd" class="col-sm-2 col-form-label">Desc. Producto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" placeholder="Descripcion del Producto" value="<?= $gtia['descProd']; ?>" readonly>
                        </div>
                        <label for="opeRela" class="col-sm-2 col-form-label">Operaci&oacute;n/Relaci&oacute;n:</label>
                        <div class="col" >
                            <input type="number" class="form-control mb-2" placeholder="Operacion/Relacion" value="<?= $gtia['opeRela']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sav" class="col-sm-2 col-form-label">SAV:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" placeholder="N&uacute;mero Valor no Dinerario" title="N&uacute;mero Valor no Dinerario" value="<?= $gtia['sav']; ?>" readonly>
                        </div>
                        <label for="prodCred" class="col-sm-2 col-form-label">Producto Cred:</label>
                        <div class="col">
                            <input type="int" class="form-control mb-2" placeholder="Producto del Credito" value="<?= $gtia['prodCred']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="entGtia" class="col-sm-2 col-form-label">Entrega Gtia:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" placeholder="Entrega de Garantia" value="<?= $gtia['entGtia']; ?>" readonly>
                        </div>
                        <label for="gesCan" class="col-sm-2 col-form-label">Gesti&oacute;n de Canc:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" placeholder="Gestion de Cancelacion" value="<?= $gtia['gesCan']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="oriGtia" class="col-sm-2 col-form-label">Original:</label>
                        <div class="col">
                            <select class="form-control mb-2" readonly>
                                <?php
                                if ($gtia['oriGtia'] == "SI") {
                                    echo "<option value='SI' selected>SI</option> ";
                                } else {
                                    echo "<option value='NO' selected>NO</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <label for="estado" class="col-sm-2 col-form-label">Estado:</label>
                        <div class="col" class="col-sm-2 col-form-label">
                            <select class="form-control mb-2" readonly>
                                <?php
                                while ($row = sqlsrv_fetch_array($estados, SQLSRV_FETCH_ASSOC)) {
                                    if ($gtia['estado'] == $row['id_estado']) {
                                        echo "<option value='{$row['id_estado']}' selected>{$row['nombre']}</option>";
                                    } else {
                                        echo "<option value='{$row['id_estado']}'>{$row['nombre']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="w-100"></div>
                        <label for="valNomi" class="col-sm-2 col-form-label">Valor Nominal:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" placeholder="Valor Nominal" value="<?= $gtia['valNomi']; ?>" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col"></div>
                        <div class="w-100"></div>
                        <label for="observacion" class="col-sm-2 col-form-label">Observaci&oacute;n:</label>
                        <div class="col">
                            <textarea class="form-control mb-2" placeholder="Observaciones" readonly><?= $gtia['observacion']; ?></textarea>
                        </div>
                    </div>
                    <hr/>
                </div>
                <div class="container">
                    <div class="row"> 
                        <div class="col"> <h5>HIPOTECA</h5> </div>
                        <div class="col text-right"> 
                            <button id="btnShowHipoteca" class="btn btn-outline-danger" title="Ocultar tabla de hipoteca">
                                <img src='../../lib/img/EYE.png' width="15" height="15">
                            </button>
                        </div>
                    </div>
                    <hr/>
                    <?php
                    $query = "SELECT * FROM imagenesHipoteca WHERE idHipoteca=" . $gtia['id_hipoteca'] . " ORDER BY tipo";
                    $resultHipoteca = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

                    if ($resultHipoteca) {
                        if (sqlsrv_has_rows($resultHipoteca)) {
                            $cantidad = 1;
                            echo '
                            <div class="form-group row" id="camposHipoteca">
                                <label class="col-sm-2 col-form-label">Imagenes:</label>
                                <div class="col">
                                    <table class="table table-sm  table-bordered table-hover">
                                        <thead style="background-color:#739cc7;">
                                        <tr> 
                                            <th>Tipo</th>
                                            <th>Nombre</th>
                                            <th>Ver</th>
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
                                        </tr>';
                            }
                            echo '                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>';
                        } else {
                            echo '
                            <div class="form-group row" id="camposHipoteca"> 
                                <label for="entGtia" class="col-sm-2 col-form-label">Imagenes:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" value="No posee" readonly>
                                </div>
                            </div>';
                        }
                    } else {
                        echo '
                        <div class="form-group row" id="camposHipoteca"> 
                            <label for="entGtia" class="col-sm-2 col-form-label">Imagenes:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="No se pudo consultar sobre imagenes de hipoteca" readonly>
                            </div>
                        </div>';
                    }
                    ?>
                    <hr/>
                </div>
                <div class="container">
                    <div class="row"> 
                        <div class="col"> <h5>PRENDA</h5> </div>
                        <div class="col text-right"> 
                            <button id="btnShowPrenda" class="btn btn-outline-danger" title="Ocultar campos de prenda">
                                <img src='../../lib/img/EYE.png' width="15" height="15">
                            </button>
                        </div>
                    </div>
                    <hr/>
                    <?php
                    $query = "SELECT * FROM imagenesPrenda WHERE idPrenda=" . $gtia['id_prenda'] . " ORDER BY tipo";
                    $resultPrenda = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

                    if ($resultPrenda) {
                        if (sqlsrv_has_rows($resultPrenda)) {
                            $cantidad = 1;
                            echo '
                            <div class="form-group row" id="camposPrenda">
                                <label class="col-sm-2 col-form-label">Imagenes:</label>
                                <div class="col">
                                    <table class="table table-sm  table-bordered table-hover">
                                        <thead style="background-color:#739cc7;">
                                        <tr> 
                                            <th>Tipo</th>
                                            <th>Nombre</th>
                                            <th>Ver</th>
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
                                        </tr>';
                            }
                            echo '                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>';
                        } else {
                            echo '
                            <div class="form-group row" id="camposPrenda"> 
                                <label for="entGtia" class="col-sm-2 col-form-label">Imagenes:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" value="No posee" readonly>
                                </div>
                            </div>';
                        }
                    } else {
                        echo '
                        <div class="form-group row" id="camposPrenda"> 
                            <label for="entGtia" class="col-sm-2 col-form-label">Imagenes:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="No se pudo consultar sobre imagenes de prenda" readonly>
                            </div>
                        </div>';
                    }
                    ?>
                    <hr/>
                </div>
                <div class="container">
                    <div class="row"> 
                        <div class="col"> <h5>FIANZA</h5> </div>
                        <div class="col text-right"> 
                            <button id="btnShowFianza" class="btn btn-outline-danger" title="Ocultar campos de fianza">
                                <img src='../../lib/img/EYE.png' width="15" height="15">
                            </button>
                        </div>
                    </div>
                    <hr/>
                    <?php
                    $query = "SELECT * FROM imagenesFianza WHERE idFianza=" . $gtia['id_fianza'] . " ORDER BY tipo";
                    $resultFianza = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

                    if ($resultFianza) {
                        if (sqlsrv_has_rows($resultFianza)) {
                            $cantidad = 1;
                            echo '
                            <div class="form-group row" id="camposFianza">
                                <label class="col-sm-2 col-form-label">Imagenes:</label>
                                <div class="col">
                                    <table class="table table-sm  table-bordered table-hover">
                                        <thead style="background-color:#739cc7;">
                                        <tr> 
                                            <th>Tipo</th>
                                            <th>Nombre</th>
                                            <th>Ver</th>
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
                                        </tr>';
                            }
                            echo '                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>';
                        } else {
                            echo '
                            <div class="form-group row" id="camposFianza">     
                                <label for="entGtia" class="col-sm-2 col-form-label">Imagenes:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" value="No posee" readonly>
                                </div>
                            </div>';
                        }
                    } else {
                        echo '
                        <div class="form-group row" id="camposFianza"> 
                            <label for="entGtia" class="col-sm-2 col-form-label">Imagenes:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="No se pudo consultar sobre imagenes de fianza" readonly>
                            </div>
                        </div>';
                    }
                    ?>
                    <hr/>
                </div>
                <div class="container">
                    <div class="row"> 
                        <div class="col"> <h5>LEASING</h5> </div>
                        <div class="col text-right"> 
                            <button id="btnShowLeasing" class="btn btn-outline-danger" title="Ocultar campos de leasing">
                                <img src='../../lib/img/EYE.png' width="15" height="15">
                            </button>
                        </div>
                    </div>
                    <hr/>
                    <?php
                    $query = "SELECT * FROM imagenesLeasing WHERE idLeasing=" . $gtia['id_leasing'] . " ORDER BY tipo";
                    $resultLeasing = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

                    if ($resultLeasing) {
                        if (sqlsrv_has_rows($resultLeasing)) {
                            $cantidad = 1;
                            echo '
                            <div class="form-group row" id="camposLeasing">
                                <label class="col-sm-2 col-form-label">Imagenes:</label>
                                <div class="col">
                                    <table class="table table-sm  table-bordered table-hover">
                                        <thead style="background-color:#739cc7;">
                                        <tr> 
                                            <th>Tipo</th>
                                            <th>Nombre</th>
                                            <th>Ver</th>
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
                                        </tr>';
                            }
                            echo '                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>';
                        } else {
                            echo '
                            <div class="form-group row" id="camposLeasing">     
                                <label for="entGtia" class="col-sm-2 col-form-label">Imagenes:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" value="No posee" readonly>
                                </div>
                            </div>';
                        }
                    } else {
                        echo '
                        <div class="form-group row" id="camposLeasing"> 
                            <label for="entGtia" class="col-sm-2 col-form-label">Imagenes:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="No se pudo consultar sobre imagenes de leasing" readonly>
                            </div>
                        </div>';
                    }
                    ?>
                    <hr/>
                </div>
                <div class="container">
                    <div class="row"> 
                        <div class="col"> <h5>COMPRA DE CARTERA</h5> </div>
                        <div class="col text-right"> 
                            <button id="btnShowCartera" class="btn btn-outline-danger" title="Ocultar campos compra de cartera">
                                <img src='../../lib/img/EYE.png' width="15" height="15">
                            </button>
                        </div>
                    </div>
                    <hr/>
                    <?php
                    $query = "SELECT * FROM imagenesCartera WHERE idCartera=" . $gtia['id_cartera'] . " ORDER BY tipo";
                    $resultCartera = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

                    if ($resultCartera) {
                        if (sqlsrv_has_rows($resultCartera)) {
                            $cantidad = 1;
                            echo '
                            <div class="form-group row" id="camposCartera">
                                <label class="col-sm-2 col-form-label">Imagenes:</label>
                                <div class="col">
                                    <table class="table table-sm  table-bordered table-hover">
                                        <thead style="background-color:#739cc7;">
                                        <tr> 
                                            <th>Tipo</th>
                                            <th>Nombre</th>
                                            <th>Ver</th>
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
                                        </tr>';
                            }
                            echo '                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>';
                        } else {
                            echo '
                            <div class="form-group row" id="camposCartera">     
                                <label for="entGtia" class="col-sm-2 col-form-label">Imagenes:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" value="No posee" readonly>
                                </div>
                            </div>';
                        }
                    } else {
                        echo '
                        <div class="form-group row" id="camposCartera"> 
                            <label for="entGtia" class="col-sm-2 col-form-label">Imagenes:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="No se pudo consultar sobre imagenes de compra de cartera" readonly>
                            </div>
                        </div>';
                    }
                    ?>
                    <hr/>
                </div>
            <?php } ?>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <a href="formBuscarGarantia.php"><input type="button" class="btn btn-outline-secondary" id="" name="" value="Cancelar"></a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/DetalleGarantia.js"></script>
</html>
