<?php

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (isset($_POST['mes'])) {
    $mes = $_POST['mes'];
    $marca = ($_POST['marca'] == "TODAS") ? "" : $_POST['marca'];
    $documento = isset($_POST['documento']) ? $_POST['documento'] : "";
    $cuenta = $_POST['cuenta'];
    $nroMes = (int) substr($mes, 5, 2) . substr($mes, 0, 4);

    $consulta = "SELECT * FROM [regimenCTTCTranasacciones] "
            . "WHERE mes = {$nroMes} AND usuarioDocNro LIKE '%{$documento}%' "
            . "AND cuenta LIKE '%{$cuenta}%' AND marca LIKE '%{$marca}%' AND relacion = 'Corporativa' ";
    $transacciones = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
    if ($transacciones) {
        if (sqlsrv_has_rows($transacciones)) {
            $filas = "";
            while ($row = sqlsrv_fetch_array($transacciones, SQLSRV_FETCH_ASSOC)) {
                $montoTotal = $row['pesos'] + $row['dolarPeso'];
                $filas .= "
                    <tr>
                        <td class='text-center align-middle'>
                            <input type='checkbox' id='transacciones' name='transacciones[]' value='{$row['id']}'>
                        </td>
                        <td class='align-middle' style='display: none;'>{$row['mes']}</td>
                        <td class='align-middle'>{$row['usuarioDocNro']}</td>
                        <td class='align-middle'>{$row['cuenta']}</td>
                        <td class='align-middle'>{$row['marca']}</td>
                        <td class='align-middle' style='display: none;'>{$row['entidad']}</td>
                        <td class='align-middle' style='display: none;'>{$row['tarjeta']}</td>
                        <td class='align-middle'>{$row['pesos']}</td>
                        <td class='align-middle'>{$row['dolarPeso']}</td>
                        <td class='align-middle'>{$montoTotal}</td>
                        <td class='align-middle'>{$row['relacion']}</td>
                    </tr>";
            }
            $resultado = "
                <div class='row mt-2 mb-4'>
                    <div id='resultado' name='resultado' class='col-10'></div>
                    <div class='col-2 text-right'>
                        <button class='btn btn-outline-danger' id='btnBorrarCTTC' name='btnBorrarCTTC' 
                                title='Borrar transacciones seleccionadas'> 
                            <img src='../../lib/img/DELETE.png' width='32' height='32'>
                        </button>
                        <button class='btn btn-outline-info' id='btnGenerarXML' name='btnGenerarXML' disabled 
                                title='Generar XML para las transacciones seleccionadas'> 
                            <img src='../../lib/img/SETTING.png' width='32' height='32'> 
                        </button>
                    </div>
                </div>
                <form name='formProcesarBuscarCTTC' id='formProcesarBuscarCTTC' method='POST'>
                    <div class='table-responsive'>
                        <table id='tbCTTC' class='table table-striped table-bordered' style='width: 100%'> 
                            <thead style='background-color:#024d85; color:white;'>
                                <tr>
                                    <th>Seleccionar</th>
                                    <th style='display: none;'>Mes</th>
                                    <th>Nro documento</th>
                                    <th>Cuenta</th>
                                    <th>Marca</th>
                                    <th style='display: none;'>Entidad</th>
                                    <th style='display: none;'>Tarjeta</th>
                                    <th>Monto pesos</th>
                                    <th title='Monto total de dolares pesificado'>Monto dolar</th>
                                    <th>Monto total</th>
                                    <th>Relación</th>
                                </tr>
                            </thead>
                            <tbody>{$filas}</tbody>
                        </table>
                    </div>
                </form>";
        } else {
            $mensaje = "No se encontraron resultados";
            $resultado = '<div class="alert alert-warning text-center mt-2" role="alert">' . $mensaje . '</div>';
        }
    } else {
        Log::escribirError("[Error al realizar consulta CTTC][{$consulta}]");
        $mensaje = "No se pudo realizar la consulta";
        $resultado = '<div class="alert alert-danger text-center mt-2" role="alert">' . $mensaje . '</div>';
    }
} else {
    $mensaje = "No se recibieron los datos del formulario de búsqueda";
    $resultado = '<div class="alert alert-danger text-center mt-2" role="alert">' . $mensaje . '</div>';
}

echo $resultado;