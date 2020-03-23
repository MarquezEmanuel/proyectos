<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './header.php';

$queryCorreo = "SELECT * FROM [3correoMensaje] WHERE reporte='EXTRACCIONES POR CAJA' ";
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
        $queryExtracciones = "SELECT right('00' + CONVERT(NVARCHAR, E.sucursal), 2) + '-' + right('00000' + CONVERT(NVARCHAR, E.cuenta), 6) + '/' + CONVERT(NVARCHAR, E.digito) cuenta, CONVERT(NVARCHAR,CAST(E.monto as money), 1) monto, C.codigoCliente, C.nombreCliente, C.correo 
                              FROM [3mayores15] E
                              INNER JOIN correosElectronicos C ON C.sucursal = E.sucursal AND C.cuenta = E.cuenta AND C.digito = E.digito
                              WHERE CAST(fechaActualizacion AS DATE) = CAST(GETDATE() AS DATE)";
        $resultExtraciones = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryExtracciones);

        if ($resultExtraciones) {
            if (sqlsrv_has_rows($resultExtraciones)) {
                $tabla = '
                    <form method="POST" action="procesarEnvioCorreo.php"> 
                        <input type="hidden" name="reporte" id="reporte" value="EXTRACCIONES POR CAJA">
                        <input type="hidden" name="origen" id="origen" value="extraccionesMayores.php">
                        <div class="table-responsive">
                            <table id="diariosExtraccionesMayores" class="table table-striped table-bordered table-hover">
                                <thead style="background-color:#024d85;color:white;">
                                    <tr>
                                        <th class="text-center align-middle"><input type="checkbox" id="seleccionarTodos" name="seleccionarTodos"></th>
                                        <th>Cuenta</th>
                                        <th>Monto</th>
                                        <th>Código cliente</th>
                                        <th>Nombre cliente</th>
                                        <th>Correo electrónico</th>
                                    </tr>
                                </thead>
                                <tbody>';
                while ($row = sqlsrv_fetch_array($resultExtraciones, SQLSRV_FETCH_ASSOC)) {
                    $tabla = $tabla . "
                                    <tr>
                                        <td><input type='checkbox' value='{$row['correo']}' id='cbCorreos' name='cbCorreos[]'></td>
                                        <td>{$row['cuenta']}</td>
                                        <td>{$row['monto']}</td>
                                        <td>{$row['codigoCliente']}</td>
                                        <td>" . utf8_encode($row['nombreCliente']) . "</td>
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
                $tabla = '<div class="alert alert-warning text-center" role="alert">No se encontraron correos electrónicos asociados a las cuentas del reporte</div>';
            }
        } else {
            $log = new Log();
            $log->writeLine("[Error al consultar correos para extracciones][QUERY: $queryExtracciones]");
            $tabla = '<div class="alert alert-danger text-center" role="alert">Error al realizar la consulta sobre correos electronicos para extracciones</div>';
        }

        $form = '
            <input type="button" class="btn btn-dark" id="btnEditarMsjExtracciones" name="btnEditarMsjExtracciones" value="Modificar mensaje predeterminado"></a>
            &nbsp;
            <a href="extraccionesMayores.php"><input type="button" class="btn btn-dark" value="Volver"></a>
            <br><br>' . $tabla;
    } else {
        $form = '
            <input type="button" class="btn btn-dark" id="btnCrearMsjExtracciones" name="btnCrearMsjExtracciones" value="Crear mensaje predeterminado"></a>
            &nbsp;
            <a href="extraccionesMayores.php"><input type="button" class="btn btn-dark" value="Volver"></a>
            <br><br>
            <div class="alert alert-warning text-center" role="alert"> Configure el mensaje predeterminado presionando el botón "Crear mensaje predeterminado"</div>';
    }

    $modal = '
        <div class="modal fade" id="mdCorreoExtracciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">CONFIGURACIÓN DE CORREO ELECTRÓNICO</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" id="contenidoMdCorreoExtracciones" name="contenidoCorreoExtracciones">
                                <form id="formCorreoExtracciones" name="formCorreoExtracciones" method="POST">
                                    <input type="hidden" name="metodo" id="metodo" value="modificar">
                                    <input type="hidden" name="id" id="id" value="' . $id . '">
                                    <input type="hidden" name="reporte" id="reporte" value="EXTRACCIONES POR CAJA">
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
                                                      id="mensaje" name="mensaje" 
                                                      rows="10" cols="40"
                                                      placeholder="Mensaje predeterminado" required>' . $mensaje . '</textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="footerMdCorreoExtracciones" name="footerMdCorreoExtracciones">
                        <input type="submit" class="btn btn-success" style="display:none" id="btnAceptar" name="btnAceptar" value="Aceptar">
                        <input type="submit" class="btn btn-success" id="btnFormCorreoExtracciones" name="btnFormCorreoExtracciones" value="Confirmar">
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
            <h3 class="text-center"><u>Extracciones por caja</u></h3>
        </div>
        <div class="mb-4 mt-4" id="resultado"><?= $resultado; ?></div>
        <div class="mb-4 mt-4">
            <?= $form ?>
        </div>
    </div>
</div>
<?= $modal ?>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/CorreoExtracciones.js"></script>
