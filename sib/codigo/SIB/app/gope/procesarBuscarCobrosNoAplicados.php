<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

$campo = $_POST['campo'];
$valor = $_POST['valor'];

$resultado = "";
$queryCobros = "select * from [dbo].[4cobroNoAplicado] WHERE {$campo} = {$valor}";
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
    } else {
        $resultado = '<div class="alert alert-warning text-center" role="alert">No se encontraron cobros no aplicados</div>';
    }
} else {
    Log::escribirError("[Error al realizar la consulta de cobros no aplicados][QUERY: $queryCobros]");
    $resultado = '<div class="alert alert-danger text-center" role="alert"> Error al realizar consulta de cobros no aplicados</div>';
}

echo $resultado;
