<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './menuOperaciones.php';

$resultado = $modal = $script = "";
$queryTarjetas = "SELECT * FROM [dbo].[5tarjetasMalVinculadas]";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryTarjetas);
if ($result) {
    if (sqlsrv_has_rows($result)) {
        $resultado = "
            <div class='table-responsive mb-4'>
                <table id='tbRepTarjetasMalVinculadas' class='table table-striped'>
                    <thead style='background-color:#024d85; color:white;'> 
                        <tr>
                            <th>Código</th>
                            <th>Nombre de cliente</th>
                            <th>Nro de tarjeta</th>
                            <th style='display:none;'>Tipo de cuenta</th>
                            <th>Cuenta</th>
                            <th style='display:none;'>Numero de documento</th>
                            <th style='display:none;'>Estado</th>
                            <th>Nombre de cuenta</th>
                            <th style='display:none;'>Tipo de tarjeta</th>
                            <th style='display:none;'>Fecha</th>
                            <th style='display:none;'>Tipo de cliente</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fechaEmisionPlastico']) ? $row['fechaEmisionPlastico']->format('d/m/Y') : "";
            $tipoCliente = ($row['tipoCliente'] == 'Z') ? "NORMAL" : "CONFIDENCIAL";
            $resultado .= "
                <tr style='background-color:#cfcffa;' id='{$row['id']}'>
                    <td class='align-middle'>{$row['numeroCliente']}</td>
                    <td class='align-middle'>" . utf8_encode($row['nombreCliente']) . "</td>
                    <td class='align-middle'>{$row['numeroTarjeta']}</td>
                    <td style='display:none;'>{$row['tipoCuenta']}</td>
                    <td class='align-middle'>{$row['numeroCuenta']}</td>
                    <td style='display:none;'>{$row['numeroDocumento']}</td>
                    <td style='display:none;'>{$row['estado']}</td>
                    <td class='align-middle'>" . utf8_encode($row['nombreCuenta']) . "</td>
                    <td style='display:none;'>{$row['tipoTarjeta']}</td>
                    <td style='display:none;'>{$fecha}</td>
                    <td style='display:none;'>{$tipoCliente}</td>
                    <td class='text-center' title='Ver detalles'>
                        <button class='btn btn-sm btn-outline-info detalleTarjetaMalVinculada' name='{$row['id']}'> 
                            <img src='../../lib/img/SHOW.png' name='' width='18' height='18' > 
                        </button>
                    </td>
                </tr>";
        }
        $resultado .= "
                    </tbody>
                </table>
            </div>";
        $modal = '<div class="modal fade" id="mdDetalleTarjetaMalVinculada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-center" id="myModalLabel">INFORMACIÓN DETALLADA</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre de cliente:</label> 
                                <div class="col">
                                    <input type="text" class="form-control" id="nombreCliente" name="nombreCliente" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Número de cliente: </label> 
                                <div class="col">
                                    <input class="form-control" id="numeroCliente" name="numeroCliente" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Número de tarjeta: </label> 
                                <div class="col">
                                    <input class="form-control" id="numeroTarjeta" name="numeroTarjeta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tipo de cuenta: </label> 
                                <div class="col">
                                    <input class="form-control" id="tipoCuenta" name="tipoCuenta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Número de cuenta: </label> 
                                <div class="col">
                                    <input class="form-control" id="numeroCuenta" name="numeroCuenta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Número documento: </label> 
                                <div class="col">
                                    <input class="form-control" id="numeroDocumento" name="numeroDocumento" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Estado: </label> 
                                <div class="col">
                                    <input class="form-control" id="estado" name="estado" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre de cuenta: </label> 
                                <div class="col">
                                    <input class="form-control" id="nombreCuenta" name="nombreCuenta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tipo de tarjeta: </label> 
                                <div class="col">
                                    <input class="form-control" id="tipoTarjeta" name="tipoTarjeta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Fecha: </label> 
                                <div class="col">
                                    <input class="form-control" id="fecha" name="fecha" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tipo de cliente: </label> 
                                <div class="col">
                                    <input class="form-control" id="tipoCliente" name="tipoCliente" readonly>
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
                        $('#tbRepTarjetasMalVinculadas').DataTable({
                            dom: 'Bfrtip',
                            responsive: true,
                            pageLength: 20,
                            buttons: ['excel'],
                            language: {url: '../../lib/js/Spanish.json'}
                        });
                    });

                    $('.detalleTarjetaMalVinculada').click(function () {
                        var fila = $(this).attr('name');
                        var columnas = $('tr#' + fila).find('td');
                        $('#nombreCliente').val(columnas.eq(0).text());
                        $('#numeroCliente').val(columnas.eq(1).text());
                        $('#numeroTarjeta').val(columnas.eq(2).text());
                        $('#tipoCuenta').val(columnas.eq(3).text());
                        $('#numeroCuenta').val(columnas.eq(4).text());
                        $('#numeroDocumento').val(columnas.eq(5).text());
                        $('#estado').val(columnas.eq(6).text());
                        $('#nombreCuenta').val(columnas.eq(7).text());
                        $('#tipoTarjeta').val(columnas.eq(8).text());
                        $('#fecha').val(columnas.eq(9).text());
                        $('#tipoCliente').val(columnas.eq(10).text());
                        $('#mdDetalleTarjetaMalVinculada').modal({});
                        return false;
                    });
                });
            </script>";
    } else {
        $resultado = '<div class="alert alert-warning text-center" role="alert"> No se encontraron tarjetas mal vinculadas</div>';
    }
} else {
    Log::escribirError("[Error al realizar la consulta de cheques pagados por caja][QUERY: $queryTarjetas]");
    $resultado = '<div class="alert alert-danger text-center" role="alert"> Error al realizar consulta de tarjetas mal vinculadas</div>';
}
?>

<div class="container mt-4">
    <div id="superior">
        <h4 class="text-center mb-4 mt-4">TARJETAS DE DÉBITO MAL VINCULADAS</h4>
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
