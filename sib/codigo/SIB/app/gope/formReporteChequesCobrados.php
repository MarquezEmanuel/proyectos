<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './menuOperaciones.php';

$resultado = $modal = $script = "";
$queryCheques = "SELECT * FROM [5chequesCobradosMorosos]";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCheques);
if ($result) {
    if (sqlsrv_has_rows($result)) {
        $resultado = "
            <div class='table-responsive mb-4'>
                <table id='tbRepChequesCobradosMorosos' class='table table-striped'>
                    <thead style='background-color:#024d85; color:white;'> 
                        <tr>
                            <th>Sucursal</th>
                            <th>Cuenta</th>
                            <th>Digito</th>
                            <th>Nombre cuenta</th>
                            <th style='display:none;'>Cuil cuenta</th>
                            <th>Producto</th>
                            <th style='display:none;'>Depositante</th>
                            <th style='display:none;'>Ordenante</th>
                            <th style='display:none;'>Cobrador</th>
                            <th>Monto</th>
                            <th style='display:none;'>Fecha</th>
                            <th style='display:none;'>Código usuario</th>
                            <th style='display:none;'>Nombre usuario</th>
                            <th style='display:none;'>Sucursal pago</th>
                            <th style='display:none;'>CUIL deudor</th>
                            <th style='display:none;'>Días atraso</th>
                            <th>Deuda</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
            $resultado .= "
                <tr style='background-color:#cfcffa;' id='{$row['id']}'>
                    <td>{$row['sucursal']}</td>
                    <td>{$row['cuenta']}</td>
                    <td>{$row['digito']}</td>
                    <td>{$row['nombreCuenta']}</td>
                    <td style='display:none;'>{$row['cuilCuenta']}</td>
                    <td>{$row['productoCuenta']}</td>   
                    <td style='display:none;'>" . utf8_encode($row['depositante']) . "</td>
                    <td style='display:none;'>" . utf8_encode($row['ordenante']) . "</td>
                    <td style='display:none;'>{$row['documentoCobrador']}</td>
                    <td>{$row['monto']}</td>
                    <td style='display:none;'>{$fecha}</td>
                    <td style='display:none;'>{$row['codigoUsuario']}</td>
                    <td style='display:none;'>{$row['nombreUsuario']}</td>
                    <td style='display:none;'>{$row['sucursalPago']}</td>
                    <td style='display:none;'>{$row['cuilDeudor']}</td>
                    <td style='display:none;'>{$row['diasAtraso']}</td>
                    <td>{$row['deuda']}</td>
                    <td class='text-center' title='Ver detalles'>
                        <button class='btn btn-sm btn-outline-info detalleChequeCobrado' name='{$row['id']}'> 
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
            <div class="modal fade" id="mdDetalleChequeCobrado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                <label class="col-sm-3 col-form-label">Nombre cuenta: </label> 
                                <div class="col">
                                    <input class="form-control" id="nombreCuenta" name="nombreCuenta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">CUIL cuenta: </label> 
                                <div class="col">
                                    <input class="form-control" id="cuilCuenta" name="cuilCuenta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Producto cuenta: </label> 
                                <div class="col">
                                    <input class="form-control" id="productoCuenta" name="productoCuenta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Depositante: </label> 
                                <div class="col">
                                    <input class="form-control" id="depositante" name="depositante" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Ordenante: </label> 
                                <div class="col">
                                    <input class="form-control" id="ordenante" name="ordenante" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Documento cobrador: </label> 
                                <div class="col">
                                    <input class="form-control" id="documentoCobrador" name="documentoCobrador" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Monto: </label> 
                                <div class="col">
                                    <input class="form-control" id="monto" name="monto" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Fecha: </label> 
                                <div class="col">
                                    <input class="form-control" id="fecha" name="fecha" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Código usuario: </label> 
                                <div class="col">
                                    <input class="form-control" id="codigoUsuario" name="codigoUsuario" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre usuario: </label> 
                                <div class="col">
                                    <input class="form-control" id="nombreUsuario" name="nombreUsuario" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sucursal pago: </label> 
                                <div class="col">
                                    <input class="form-control" id="sucursalPago" name="sucursalPago" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">CUIL deudor: </label> 
                                <div class="col">
                                    <input class="form-control" id="cuilDeudor" name="cuilDeudor" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Días atraso: </label> 
                                <div class="col">
                                    <input class="form-control" id="diasAtraso" name="diasAtraso" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Deuda: </label> 
                                <div class="col">
                                    <input class="form-control" id="deuda" name="deuda" readonly>
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
                        $('#tbRepChequesCobradosMorosos').DataTable({
                            dom: 'Bfrtip',
                            responsive: true,
                            pageLength: 20,
                            buttons: ['excel'],
                            language: {url: '../../lib/js/Spanish.json'}
                        });
                    });

                    $('.detalleChequeCobrado').click(function () {
                        var fila = $(this).attr('name');
                        var columnas = $('tr#' + fila).find('td');
                        $('#sucursal').val(columnas.eq(0).text());
                        $('#cuenta').val(columnas.eq(1).text());
                        $('#digito').val(columnas.eq(2).text());
                        $('#nombreCuenta').val(columnas.eq(3).text());
                        $('#cuilCuenta').val(columnas.eq(4).text());
                        $('#productoCuenta').val(columnas.eq(5).text());
                        $('#depositante').val(columnas.eq(6).text());
                        $('#ordenante').val(columnas.eq(7).text());
                        $('#documentoCobrador').val(columnas.eq(8).text());
                        $('#monto').val(columnas.eq(9).text());
                        $('#fecha').val(columnas.eq(10).text());
                        $('#codigoUsuario').val(columnas.eq(11).text());
                        $('#nombreUsuario').val(columnas.eq(12).text());
                        $('#sucursalPago').val(columnas.eq(13).text());
                        $('#cuilDeudor').val(columnas.eq(14).text());
                        $('#diasAtraso').val(columnas.eq(15).text());
                        $('#deuda').val(columnas.eq(16).text());
                        $('#mdDetalleChequeCobrado').modal({});
                        return false;
                    });
                });
            </script>";
    } else {
        $resultado = '<div class="alert alert-warning text-center" role="alert"> No se encontraron cheques cobrados por morosos</div>';
    }
} else {
    Log::escribirError("[Error al realizar la consulta de cheques cobrados por morosos][QUERY: $queryCheques]");
    $resultado = '<div class="alert alert-danger text-center" role="alert"> Error al realizar consulta de cheques cobrados por morosos </div>';
}
?>

<div class="container mt-4">
    <div id="superior">
        <h4 class="text-center mb-4 mt-4">CHEQUES COBRADOS POR MOROSOS</h4>
        <div class="form-row mb-4">
            <div class="col">
                <a href="formReportesTablas.php"><button class="btn btn-dark">Volver</button></a>
            </div>
        </div>
        <?php echo $resultado; ?>
    </div>
</div>
<div id="inferior"></div>
<?php echo $modal; ?>
</div>
<?php
echo $script;
