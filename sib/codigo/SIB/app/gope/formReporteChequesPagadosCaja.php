<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './menuOperaciones.php';

$resultado = $modal = $script = "";
$queryCheques = "SELECT * FROM [dbo].[5chequesPagadosCaja]";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCheques);
if ($result) {
    if (sqlsrv_has_rows($result)) {
        $resultado = "
            <div class='table-responsive mb-4'>
            <table id='tbRepChequesPagadosCaja' class='table table-striped'>
                <thead style='background-color:#024d85; color:white;'> 
                    <tr>
                        <th>Sucursal</th>
                        <th>Cuenta</th>
                        <th>Digito</th>
                        <th style='display:none;'>Causal</th>
                        <th>Depositante</th>
                        <th>Ordenante</th>
                        <th>Monto</th>
                        <th>Cheque</th>
                        <th style='display:none;'>Sucursal pago</th>
                        <th style='display:none;'>Codigo usuario</th>
                        <th style='display:none;'>Nombre usuario</th>
                        <th style='display:none;'>Fecha</th>
                        <th style='display:none;'>Numero de cliente</th>
                        <th style='display:none;'>Cuil</th>
                        <th style='display:none;'>Nombre</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $resultado .= "
                <tr style='background-color:#cfcffa;' id='{$row['id']}'>
                    <td class='align-middle'>{$row['sucursal']}</td>
                    <td class='align-middle'>{$row['cuenta']}</td>
                    <td class='align-middle'>{$row['digito']}</td>
                    <td style='display:none;'>{$row['causal']}</td>
                    <td class='align-middle'>" . utf8_encode($row['depositante']) . "</td>
                    <td class='align-middle'>" . utf8_encode($row['ordenante']) . "</td>
                    <td class='align-middle'>{$row['monto']}</td>
                    <td class='align-middle'>{$row['cheque']}</td>
                    <td style='display:none;'>{$row['sucursalPago']}</td>
                    <td style='display:none;'>{$row['codigoUsuario']}</td>
                    <td style='display:none;'>{$row['nombreUsuario']}</td>
                    <td style='display:none;'>{$row['fecha']}</td>
                    <td style='display:none;'>{$row['numeroCliente']}</td>
                    <td style='display:none;'>{$row['cuil']}</td>
                    <td style='display:none;'>{$row['nombreCuenta']}</td>
                    <td class='text-center' title='Ver detalles'>
                        <button class='btn btn-sm btn-outline-info detalleChequePagado' name='{$row['id']}'> 
                            <img src='../../lib/img/SHOW.png' name='' width='18' height='18' > 
                        </button>
                    </td>
                </tr>";
        }
        $resultado .= "
                </tbody>
            </table>
        </div>";

        $modal = '
            <div class="modal fade" id="mdDetalleChequePagado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-center" id="myModalLabel">INFORMACIÓN DETALLADA</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Número de sucursal:</label> 
                                <div class="col">
                                    <input type="text" class="form-control" id="sucursal" name="sucursal" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Número de cuenta: </label> 
                                <div class="col">
                                    <input class="form-control" id="cuenta" name="cuenta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Digito verificador: </label> 
                                <div class="col">
                                    <input class="form-control" id="digito" name="digito" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Causal: </label> 
                                <div class="col">
                                    <input class="form-control" id="causal" name="causal" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre depositante: </label> 
                                <div class="col">
                                    <input class="form-control" id="depositante" name="depositante" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre ordenante: </label> 
                                <div class="col">
                                    <input class="form-control" id="ordenante" name="ordenante" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Monto: </label> 
                                <div class="col">
                                    <input class="form-control" id="monto" name="monto" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Número de cheque: </label> 
                                <div class="col">
                                    <input class="form-control" id="cheque" name="cheque" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sucursal de pago: </label> 
                                <div class="col">
                                    <input class="form-control" id="sucursalPago" name="sucursalPago" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Codigo de usuario: </label> 
                                <div class="col">
                                    <input class="form-control" id="codigoUsuario" name="codigoUsuario" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre de usuario: </label> 
                                <div class="col">
                                    <input class="form-control" id="nombreUsuario" name="nombreUsuario" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Fecha: </label> 
                                <div class="col">
                                    <input class="form-control" id="fecha" name="fecha" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Número cliente: </label> 
                                <div class="col">
                                    <input class="form-control" id="numeroCliente" name="numeroCliente" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">CUIL: </label> 
                                <div class="col">
                                    <input class="form-control" id="cuil" name="cuil" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre: </label> 
                                <div class="col">
                                    <input class="form-control" id="nombre" name="nombre" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-outline-secondary" data-dismiss="modal" value="Aceptar">
                        </div>
                    </div>
                </div>
            </div>';

        $script = "
            <script>
                $(document).ready(function () {
                
                    $(document).ready(function () {
                        $('#tbRepChequesPagadosCaja').DataTable({
                            dom: 'Bfrtip',
                            responsive: true,
                            pageLength: 20,
                            buttons: ['excel'],
                            language: {url: '../../lib/js/Spanish.json'}
                        });
                    });
                    
                    $('.detalleChequePagado').click(function () {
                        var fila = $(this).attr('name');
                        var columnas = $('tr#' + fila).find('td');
                        $('#sucursal').val(columnas.eq(0).text());
                        $('#cuenta').val(columnas.eq(1).text());
                        $('#digito').val(columnas.eq(2).text());
                        $('#causal').val(columnas.eq(3).text());
                        $('#depositante').val(columnas.eq(4).text());
                        $('#ordenante').val(columnas.eq(5).text());
                        $('#monto').val(columnas.eq(6).text());
                        $('#cheque').val(columnas.eq(7).text());
                        $('#sucursalPago').val(columnas.eq(8).text());
                        $('#codigoUsuario').val(columnas.eq(9).text());
                        $('#nombreUsuario').val(columnas.eq(10).text());
                        $('#fecha').val(columnas.eq(11).text());
                        $('#numeroCliente').val(columnas.eq(12).text());
                        $('#cuil').val(columnas.eq(13).text());
                        $('#nombre').val(columnas.eq(14).text());
                        $('#mdDetalleChequePagado').modal({});
                        return false;
                    });
                });
            </script>";
    } else {
        $resultado = '<div class="alert alert-warning text-center" role="alert"> No se encontraron cheques pagados por caja</div>';
    }
} else {
    Log::escribirError("[Error al realizar la consulta de cheques pagados por caja][QUERY: $queryCheques]");
    $resultado = '<div class="alert alert-danger text-center" role="alert"> Error al realizar consulta de cheques pagados por caja</div>';
}
?>

<div class="container mt-4">
    <div id="superior">
        <h4 class="text-center mb-4 mt-4">CHEQUES PAGADOS POR CAJA</h4>
        <div class="form-row mb-4">
            <div class="col">
                <a href="formReportesTablas.php"><button class="btn btn-dark">Volver</button></a>
            </div>
        </div>
        <?php echo $resultado; ?>
    </div>
    <div id="inferior">
        <?php echo $modal; ?>
    </div>
</div>
<?php
echo $script;
