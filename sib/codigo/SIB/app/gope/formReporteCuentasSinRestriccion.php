<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './menuOperaciones.php';

$resultado = $modal = $script = "";
$queryCuentas = "SELECT * FROM [dbo].[5cuentasSinRestriccion]";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCuentas);
if ($result) {
    if (sqlsrv_has_rows($result)) {
        $resultado = "
            <div class='table-responsive mb-4'>
                <table id='tbRepCuentasSinRestriccion' class='table table-striped'>
                    <thead style='background-color:#024d85; color:white;'> 
                        <tr>
                            <th>Sucursal</th>
                            <th>Cuenta</th>
                            <th>Digito</th>
                            <th style='display:none;'>Producto</th>
                            <th style='display:none;'>Codigo</th>
                            <th>Nombre de cliente</th>
                            <th>Nombre de cuenta</th>
                            <th style='display:none;'>Restricción</th>
                            <th style='display:none;'>Relacionados</th>
                            <th>Saldo</th>
                            <th style='display:none;'>Concepto</th>
                            <th>Fallecimiento</th>
                            <th style='display:none;'>Fecha novedad</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fechaFallecimiento = isset($row['fechaFallecimiento']) ? $row['fechaFallecimiento']->format('d/m/Y') : "";
            $fechaNovedad = isset($row['fechaNovedad']) ? $row['fechaNovedad']->format('d/m/Y') : "";
            $resultado = $resultado . "
                <tr style='background-color:#cfcffa;' id='{$row['id']}'>
                    <td class='align-middle'>{$row['sucursal']}</td>
                    <td class='align-middle'>{$row['cuenta']}</td>
                    <td class='align-middle'>{$row['digito']}</td>
                    <td style='display:none;'>{$row['producto']}</td>
                    <td style='display:none;'>{$row['numeroCliente']}</td>
                    <td class='align-middle'>" . utf8_encode($row['nombreCliente']) . "</td>
                    <td class='align-middle'>" . utf8_encode($row['nombreCuenta']) . "</td>
                    <td style='display:none;'>{$row['restriccionCredito']}</td>
                    <td style='display:none;'>{$row['clientesRelacionados']}</td>
                    <td class='align-middle'>{$row['saldoDisponible']}</td>
                    <td style='display:none;'>{$row['concepto']}</td>
                    <td class='align-middle'>{$fechaFallecimiento}</td>
                    <td style='display:none;'>{$fechaNovedad}</td>
                    <td class='text-center' title='Ver detalles'>
                        <button class='btn btn-sm btn-outline-info detalleCuentasSinRestriccion' name='{$row['id']}'> 
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
        <div class="modal fade" id="mdDetalleCuentasSinRestriccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                            <label class="col-sm-3 col-form-label">Producto: </label> 
                            <div class="col">
                                <input class="form-control" id="producto" name="producto" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Número cliente: </label> 
                            <div class="col">
                                <input class="form-control" id="numeroCliente" name="numeroCliente" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nombre cliente: </label> 
                            <div class="col">
                                <input class="form-control" id="nombreCliente" name="nombreCliente" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nombre cuenta: </label> 
                            <div class="col">
                                <input class="form-control" id="nombreCuenta" name="nombreCuenta" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Restricción crédito: </label> 
                            <div class="col">
                                <input class="form-control" id="restriccion" name="restriccion" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Clientes relacionados: </label> 
                            <div class="col">
                                <input class="form-control" id="cantidad" name="cantidad" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Saldo disponible: </label> 
                            <div class="col">
                                <input class="form-control" id="saldo" name="saldo" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Concepto: </label> 
                            <div class="col">
                                <input class="form-control" id="concepto" name="concepto" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Fallecimiento: </label> 
                            <div class="col">
                                <input class="form-control" id="fallecimiento" name="fallecimiento" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Novedad: </label> 
                            <div class="col">
                                <input class="form-control" id="novedad" name="novedad" readonly>
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
                        $('#tbRepCuentasSinRestriccion').DataTable({
                            dom: 'Bfrtip',
                            responsive: true,
                            pageLength: 20,
                            buttons: ['excel'],
                            language: {url: '../../lib/js/Spanish.json'}
                        });
                    });
                    
                    $('.detalleCuentasSinRestriccion').click(function () {
                        var fila = $(this).attr('name');
                        var columnas = $('tr#' + fila).find('td');
                        $('#sucursal').val(columnas.eq(0).text());
                        $('#cuenta').val(columnas.eq(1).text());
                        $('#digito').val(columnas.eq(2).text());
                        $('#producto').val(columnas.eq(3).text());
                        $('#numeroCliente').val(columnas.eq(4).text());
                        $('#nombreCliente').val(columnas.eq(5).text());
                        $('#nombreCuenta').val(columnas.eq(6).text());
                        $('#restriccion').val(columnas.eq(7).text());
                        $('#cantidad').val(columnas.eq(8).text());
                        $('#saldo').val(columnas.eq(9).text());
                        $('#concepto').val(columnas.eq(10).text());
                        $('#fallecimiento').val(columnas.eq(11).text());
                        $('#novedad').val(columnas.eq(12).text());
                        $('#mdDetalleCuentasSinRestriccion').modal({});
                        return false;
                    });
                });
            </script>";
    } else {
        $resultado = '<div class="alert alert-warning text-center" role="alert"> No se encontraron cuentas sin restricción a los débitos</div>';
    }
} else {
    Log::escribirError("[Error al realizar la consulta de cheques pagados por caja][QUERY: $queryCuentas]");
    $resultado = '<div class="alert alert-danger text-center" role="alert"> Error al realizar consulta de cuentas sin restricción a los débitos </div>';
}
?>

<div class="container mt-4">
    <div id="superior">
        <h4 class="text-center mb-4 mt-4">CUENTAS SIN RESTRICCIÓN A LOS DÉBITOS DE CLIENTES FALLECIDOS</h4>
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
