<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$numeroCaja = $_POST['numeroCaja'];
$sucursal = $_POST['sucursal'];
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
$tratado = $_POST['tratado'];
$numeroTratado;

if($tratado === "TRATADO"){
    $numeroTratado = 1;
}else{
    $numeroTratado = 0;
}

if (isset($fechaInicio) && $fechaInicio != null) {
    $fechaInicio = date("d/m/Y", strtotime($fechaInicio));
    $fechaInicio = $fechaInicio . " 00:00:00";
}
if (isset($fechaFin) && $fechaFin != null) {
    $fechaFin = date("d/m/Y", strtotime($fechaFin));
    $fechaFin = $fechaFin . " 23:59:00";
}

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *,convert(varchar,cast(importeCuota as money),1) AS importeCuota2,convert(varchar,cast(saldo as money),1) AS saldo2 FROM [3morasCajaSeguridad] WHERE sucursal = {$_SESSION['sucursal']}";

if (isset($numeroCaja) && $numeroCaja != null) {
    $query = $query . " AND numeroCaja = " . $numeroCaja;
    if (isset($sucursal) && $sucursal != null) {
        $query = $query . " AND numeroDocumento = '" . $sucursal . "'";
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
        if(isset($tratado) && $tratado != null){
                $query = $query . " AND tratado = " . $numeroTratado;
            }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
            if(isset($tratado) && $tratado != null){
                $query = $query . " AND tratado = " . $numeroTratado;
            }
        }else{
            if(isset($tratado) && $tratado != null){
                $query = $query . " AND tratado = " . $numeroTratado;
            }
        }
    }
} else {
    if (isset($sucursal) && $sucursal != null) {
        $query = $query . "AND numeroDocumento = '" . $sucursal . "'";
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
            if(isset($tratado) && $tratado != null){
                $query = $query . " AND tratado = " . $numeroTratado;
            }
        }else{
            if(isset($tratado) && $tratado != null){
                $query = $query . " AND tratado = " . $numeroTratado;
            }
        }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
            if(isset($tratado) && $tratado != null){
                $query = $query . " AND tratado = " . $numeroTratado;
            }
        }else{
            if(isset($tratado) && $tratado != null){
                $query = $query . " AND tratado = " . $numeroTratado;
            }
        }
    }
}
// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$_SESSION['buscar'] = $query;

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_moras' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Modulo</th>
                                            <th style='display:none;'>Numero de Caja</th>
                                            <th>Codigo Contrato</th>
                                            <th>Importe Cuotas</th>
                                            <th style='display:none;'>Cantidad de Cuotas</th>
                                            <th style='display:none;'>Cuenta DA</th>
                                            <th style='display:none;'>Digito DA</th>
                                            <th style='display:none;'>Fecha Alta</th>
                                            <th style='display:none;'>Nombre</th>
                                            <th style='display:none;'>Producto</th>
                                            <th style='display:none;'>Sucursal Cuenta DA</th>
                                            <th style='display:none;'>Tipo Cuenta DA</th>
                                            <th>Numero Cliente</th>
                                            <th>Numero Documento</th>
                                            <th style='display:none;'>Nombre Cuenta</th>
                                            <th>Estado</th>
                                            <th>Saldo</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fechaAlta = isset($row['fechaAlta']) ? $row['fechaAlta']->format('d/m/Y') : "";
            $nombre = utf8_encode($row['nombre']);
            $estado = utf8_encode($row['estado']);
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['modulo']}</td>
                <td style='display:none;'>{$row['numeroCaja']}</td>
                <td>{$row['codigoContrato']}</td>
                <td>{$row['importeCuota2']}</td>
                <td style='display:none;'>{$row['cantidadCuotas']}</td>
                <td style='display:none;'>{$row['cuentaDA']}</td>
                <td style='display:none;'>{$row['digitoDA']}</td>
                <td style='display:none;'>{$fechaAlta}</td>
                <td style='display:none;'>{$nombre}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td style='display:none;'>{$row['sucursalCuentaDA']}</td>
                <td style='display:none;'>{$row['tipoCuentaDA']}</td>
                <td>{$row['numeroCliente']}</td>
                <td>{$row['numeroDocumento']}</td>
                <td style='display:none;'>{$row['nombreCuenta']}</td>
                <td>{$estado}</td>
                <td>{$row['saldo2']}</td>
                <td class='text-center' title='Ir a ver detalles de Mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMorasCajaSeguridad' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
        }
        $print = $print . "</tbody></table>
        ";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
} else {
    // OCURRIO UN ERROR 
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
}

echo $print;

