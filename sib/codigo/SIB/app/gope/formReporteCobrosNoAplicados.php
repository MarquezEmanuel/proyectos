<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './menuOperaciones.php';

/* OBTIENE LOS PRIMEROS 50 REGISTROS PARA MOSTRAR AL INICIAR */

$resultado = "";
$queryCobros = "select TOP 50 * from [dbo].[4cobroNoAplicado] ORDER BY saldoTerceros DESC";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCobros);
if ($result) {
    if (sqlsrv_has_rows($result)) {
        $resultado = "
        <div class='table-responsive mb-4'>
            <table id='tbRepCobrosNoAplicados' class='table table-striped'>
                <thead style='background-color:#024d85; color:white;'> 
                    <tr>
                        <th title='Producto'>Producto</th>
                        <th title='Número de cliente'>Número</th>
                        <th title='Nombre de cliente'>Nombre</th>
                        <th title='Sucursal'>Sucursal</th>
                        <th title='Cuenta'>Cuenta</th>
                        <th style='display:none;' title='Digito'>Digito</th>
                        <th style='display:none;' title='Moneda'>Moneda</th>
                        <th style='display:none;' title='Sucursal del crédito'>Sucursal crédito</th>
                        <th title='Cuenta del crédito'>Cuenta crédito</th>
                        <th title='Saldo terceros'>Saldo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $resultado .= "
                <tr style='background-color: #cfcffa;' id='{$row['id']}'>
                    <td class='align-middle'>" . $row['producto'] . "</td>
                    <td class='align-middle'>" . $row['numeroCliente'] . "</td>
                    <td class='align-middle'>" . utf8_encode($row['nombreCliente']) . "</td>
                    <td class='align-middle'>{$row['sucursal']}</td>
                    <td class='align-middle'>{$row['cuenta']}</td>
                    <td style='display:none;' class='align-middle'>{$row['digito']}</td>
                    <td style='display:none;' class='align-middle'>{$row['moneda']}</td>
                    <td style='display:none;' class='align-middle'>{$row['sucursalCredito']}</td>
                    <td class='align-middle'>{$row['cuentaCredito']}</td>
                    <td class='align-middle'>{$row['saldoTerceros']}</td>
                    <td class='text-center' title='Ver detalles'>
                        <button class='btn btn-sm btn-outline-info detalleCobroNoAplicado' name='{$row['id']}'> 
                            <img src='../../lib/img/SHOW.png' name='' width='18' height='18' > 
                        </button>
                    </td>
                </tr>";
        }
        $resultado .= "
                </tbody>
            </table>
        </div>";
    }
} else {
    Log::escribirError("[Error al realizar la consulta de cobros no aplicados][QUERY: $queryCobros]");
    $resultado = '<div class="alert alert-danger text-center" role="alert"> Error al realizar consulta de cobros no aplicados</div>';
}
?>

<div class="container mt-4">
    <div id="superior">
        <h4 class="text-center mb-4 mt-4">COBROS NO APLICADOS</h4>
        <div class="form-row mb-4">
            <div class="col">
                <a href="formReportesTablas.php"><button class="btn btn-dark">Volver</button></a>
            </div>
        </div>

        <div class="card text-center mb-4">
            <div class="card-header text-left" style='background-color:#024d85; color:white;'>
                COMPLETE EL FORMULARIO CON EL FILTRO DESEADO
            </div>
            <div class="card-body" style='background-color: #cfcffa;'>
                <form id="formCobrosNoAplicados" name="formCobrosNoAplicados" method="POST">
                    <div class="form-row ">
                        <div class="col">
                            <select id="campo" name="campo" class="form-control">
                                <option value="producto">Por producto</option>
                                <option value="sucursal">Por sucursal</option>
                                <option value="cuenta">Por cuenta</option>
                            </select>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" 
                                   id="valor" name="valor" min="1" 
                                   placeholder="Valor a buscar"
                                   required>
                        </div>
                        <div class="col text-right">
                            <input type="submit" class="btn btn-success" name="btnBuscarCobros" id="btnBuscarCobros" value="Buscar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <div id="inferior" class="mt-4">
        <?php echo $resultado; ?>
    </div>
    <div class="modal fade" id="mdDetalleCobroNoAplicado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="myModalLabel">INFORMACIÓN DETALLADA</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Producto:</label> 
                        <div class="col">
                            <input type="text" class="form-control" id="producto" name="producto" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Número de cliente: </label> 
                        <div class="col">
                            <input class="form-control" id="numeroCliente" name="numeroCliente" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre de cliente: </label> 
                        <div class="col">
                            <input class="form-control" id="nombreCliente" name="nombreCliente" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Sucursal: </label> 
                        <div class="col">
                            <input class="form-control" id="sucursal" name="sucursal" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Cuenta: </label> 
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
                        <label class="col-sm-3 col-form-label">Moneda: </label> 
                        <div class="col">
                            <input class="form-control" id="moneda" name="moneda" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Sucursal crédito: </label> 
                        <div class="col">
                            <input class="form-control" id="sucursalCredito" name="sucursalCredito" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Cuenta crédito: </label> 
                        <div class="col">
                            <input class="form-control" id="cuentaCredito" name="cuentaCredito" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Saldo terceros: </label> 
                        <div class="col">
                            <input class="form-control" id="saldoTerceros" name="saldoTerceros" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-outline-secondary" data-dismiss="modal" value="Aceptar">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        cargarTabla();
        cargarDetalle();

        function cargarTabla() {
            $('#tbRepCobrosNoAplicados').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                pageLength: 20,
                buttons: ['excel'],
                language: {url: '../../lib/js/Spanish.json'}
            });
        }

        $('#formCobrosNoAplicados').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "procesarBuscarCobrosNoAplicados.php",
                data: $("#formCobrosNoAplicados").serialize(),
                success: function (data) {
                    $("#inferior").html(data);
                    cargarTabla();
                    cargarDetalle();
                },
                error: function () {
                    $("#inferior").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
        });

        function cargarDetalle() {
            $('.detalleCobroNoAplicado').click(function () {
                var fila = $(this).attr('name');
                var columnas = $('tr#' + fila).find('td');
                $('#producto').val(columnas.eq(0).text());
                $('#numeroCliente').val(columnas.eq(1).text());
                $('#nombreCliente').val(columnas.eq(2).text());
                $('#sucursal').val(columnas.eq(3).text());
                $('#cuenta').val(columnas.eq(4).text());
                $('#digito').val(columnas.eq(5).text());
                $('#moneda').val(columnas.eq(6).text());
                $('#sucursalCredito').val(columnas.eq(7).text());
                $('#cuentaCredito').val(columnas.eq(8).text());
                $('#saldoTerceros').val(columnas.eq(9).text());
                $('#mdDetalleCobroNoAplicado').modal({});
                return false;
            });
        }

    });
</script>