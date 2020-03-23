<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './header.php';

$queryCorreo = "SELECT * FROM [3correoMensaje] WHERE reporte='MORAS EN CAJAS DE SEGURIDAD' ";
$resultCorreo = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCorreo);

$form = $modal = $resultado = "";
if ($resultCorreo) {
    $id = $mensaje = "";
    if (sqlsrv_has_rows($resultCorreo)) {
        $correo = sqlsrv_fetch_array($resultCorreo, SQLSRV_FETCH_ASSOC);
        $id = $correo['id'];
        $nombre = utf8_encode($correo['nombre']);
        $asunto = utf8_encode($correo['asunto']);
        $mensaje = utf8_encode($correo['mensaje']);
        $tabla = "";
        $queryMorasCajas = "SELECT DISTINCT right('00' + CONVERT(NVARCHAR, M.sucursalCuentaDA), 2) + '-' + right('00000' + CONVERT(NVARCHAR, M.cuentaDA), 6) + '/' + CONVERT(NVARCHAR, M.digitoDA) cuenta, M.cantidadCuotas, C.codigoCliente, M.nombre, C.correo
                            FROM [3morasCajaSeguridad] M
                            INNER JOIN (SELECT codigoCliente, correo, ROW_NUMBER() over (partition by codigoCliente order by codigoCliente desc) orden FROM correosElectronicos) C ON C.codigoCliente = right('000000000000' + CONVERT(NVARCHAR, M.numeroCliente ), 13) AND C.orden = 1
                            WHERE CAST(fechaActualizacion AS DATE) = CAST(GETDATE() AS DATE)";
        $resultMorasCajas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryMorasCajas);
        if ($resultMorasCajas) {
            if (sqlsrv_has_rows($resultMorasCajas)) {
                $tabla = '
                    <form method="POST" action="procesarEnvioCorreo.php"> 
                        <input type="hidden" name="reporte" id="reporte" value="MORAS EN CAJAS DE SEGURIDAD">
                        <input type="hidden" name="origen" id="origen" value="morasCajaSeguridad.php">
                        <div class="table-responsive">
                            <table id="diariosMorasCajasSeguridad" class="table table-striped table-bordered table-hover">
                                <thead style="background-color:#024d85;color:white;">
                                    <tr>
                                        <th class="text-center align-middle"><input type="checkbox" id="seleccionarTodos" name="seleccionarTodos"></th>
                                        <th>Cuenta</th>
                                        <th>Cuotas</th>
                                        <th>Código cliente</th>
                                        <th>Nombre cliente</th>
                                        <th>Correo electrónico</th>
                                    </tr>
                                </thead>
                                <tbody>';
                while ($row = sqlsrv_fetch_array($resultMorasCajas, SQLSRV_FETCH_ASSOC)) {
                    $tabla = $tabla . "
                                    <tr>
                                        <td><input type='checkbox' value='{$row['correo']}' id='cbCorreos' name='cbCorreos[]'></td>
                                        <td>{$row['cuenta']}</td>
                                        <td>{$row['cantidadCuotas']}</td>
                                        <td>{$row['codigoCliente']}</td>
                                        <td>" . utf8_encode($row['nombre']) . "</td>
                            <td>{$row['correo']}</td>
                            </tr>";
                }
                $tabla = $tabla . '            
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <input type="submit" class="btn btn-success" id="btnEnviarCorreo" name="btnEnviarCorreo" value="Enviar">
                                </div>
                            </div>
                        </div>
                    </form>';
            } else {
                $tabla = '<div class="alert alert-warning text-center" role="alert">No se encontraron correos electrónicos asociados a los clientes del reporte</div>';
            }
        } else {
            $log = new Log();
            $log->writeLine("[Error al consultar correos para moras en cajas de seguridad][QUERY: $queryMorasCajas]");
            $tabla = '<div class="alert alert-danger text-center" role="alert">Error al realizar la consulta sobre correos electronicos para moras en cajas de seguridad</div>';
        }
        $form = '
            <input type="button" class="btn btn-dark" id="btnEditarMsjMoras" name="btnEditarMsjMoras" value="Modificar mensaje predeterminado"></a>
            &nbsp;
            <a href="morasCajaSeguridad.php"><input type="button" class="btn btn-dark" value="Volver"></a>
            <br><br>' . $tabla;
    } else {
        $form = '
            <input type="button" class="btn btn-dark" id="btnCrearMsjMoras" name="btnCrearMsjMoras" value="Crear mensaje predeterminado"></a>
            &nbsp;
            <a href="morasCajaSeguridad.php"><input type="button" class="btn btn-dark" value="Volver"></a>
            <br><br>
            <div class="alert alert-warning text-center" role="alert"> Configure el mensaje predeterminado presionando el botón "Crear mensaje predeterminado"</div>';
    }

    $modal = '
        <div class="modal fade" id="mdCorreoMoraCajas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">CONFIGURACIÓN DE CORREO ELECTRÓNICO</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" id="contenidoMdCorreoMoras" name="contenidoMdCorreoMoras">
                                <form id="formCorreoMoras" name="formCorreoMoras" method="POST">
                                    <input type="hidden" name="metodo" id="metodo" value="modificar">
                                    <input type="hidden" name="id" id="id" value="' . $id . '">
                                    <input type="hidden" name="reporte" id="reporte" value="MORAS EN CAJAS DE SEGURIDAD">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nombre:</label> 
                                        <div class="col">
                                            <input type="text" class="form-control mb-2" 
                                                   id="nombre" name="nombre" value="' . $nombre . '"
                                                   minlength="10" maxlength="50" 
                                                   placeholder="Nombre para mostrar" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Asunto:</label> 
                                        <div class="col">
                                            <input type="text" class="form-control mb-2" 
                                                   id="asunto" name="asunto" value="' . $asunto . '"
                                                   minlength="10" maxlength="50"
                                                   placeholder="Asunto" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Mensaje:</label> 
                                        <div class="col">
                                            <textarea class="form-control mb-2" 
                                                      minlength="30" maxlength="500" 
                                                      rows="10" cols="40"
                                                      id="mensaje" name="mensaje" 
                                                      placeholder="Mensaje predeterminado" required>' . $mensaje . '</textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="footerMdCorreoMoras" name="footerMdCorreoMoras">
                        <input type="submit" class="btn btn-success" style="display:none" id="btnAceptar" name="btnAceptar" value="Aceptar">
                        <input type="submit" class="btn btn-success" id="btnFormCorreoMoras" name="btnFormCorreoMoras" value="Confirmar">
                        <input type="submit" class="btn btn-outline-secondary" id="btnCancelar" name="btnCancelar" data-dismiss="modal" value="Cancelar">
                    </div>
                </div>
            </div>
        </div>';
} else {
    $form = $modal = "";
    $resultado = '<div class="alert alert-danger text-center" role="alert">Error al realizar la consulta sobre mensaje predeterminado</div>';
}
?>

<div class="container">
    <div class="card-header">
        <div class="center">
            <h3 class="text-center"><u>Moras en cajas de seguridad</u></h3>
        </div>
        <div class="mb-4 mt-4" id="resultado"><?= $resultado; ?></div>
        <div class="mb-4 mt-4">
            <?= $form ?>
        </div>
    </div>
</div>
<?= $modal ?>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/CorreoMorasCajasSeguridad.js"></script>