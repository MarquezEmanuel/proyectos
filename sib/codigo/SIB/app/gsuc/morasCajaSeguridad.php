<?php

include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;

function morasCajaSeguridad() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT *,convert(varchar,cast(importeCuota as money),1) AS importeCuota2,convert(varchar,cast(saldo as money),1) AS saldo2 FROM [3morasCajaSeguridad] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
         if ($filas) {
        $html = "<br>
        <table id='diariosMorasCajaSeguridad' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Sucursal</th>
                                            <th>Modulo</th>
                                            <th>Numero de Caja</th>
                                            <th style='display:none;'>Codigo Contrato</th>
                                            <th>Importe Cuotas</th>
                                            <th>Cuotas</th>
                                            <th style='display:none;'>Cuenta DA</th>
                                            <th style='display:none;'>Digito DA</th>
                                            <th style='display:none;'>Fecha Alta</th>
                                            <th>Nombre</th>
                                            <th style='display:none;'>Producto</th>
                                            <th style='display:none;'>Sucursal Cuenta DA</th>
                                            <th>Tipo Cuenta</th>
                                            <th>Numero de Cuenta</th>
                                            <th style='display:none;'>Numero Documento</th>
                                            <th style='display:none;'>Nombre Cuenta</th>
                                            <th style='display:none;'>Estado</th>
                                            <th>Saldo</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fechaAlta = isset($row['fechaAlta']) ? $row['fechaAlta']->format('d/m/Y') : "";
            $nombre = utf8_encode($row['nombre']);
            $estado = utf8_encode($row['estado']);
            $html = $html . "
            <tr>
                <td>{$row['sucursal']}</td>
                <td>{$row['modulo']}</td>
                <td>{$row['numeroCaja']}</td>
                <td style='display:none;'>{$row['codigoContrato']}</td>
                <td>{$row['importeCuota2']}</td>
                <td>{$row['cantidadCuotas']}</td>
                <td style='display:none;'>{$row['cuentaDA']}</td>
                <td style='display:none;'>{$row['digitoDA']}</td>
                <td style='display:none;'>{$fechaAlta}</td>
                <td>{$nombre}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td style='display:none;'>{$row['sucursalCuentaDA']}</td>
                <td>{$row['tipoCuentaDA']}</td>
                <td>{$row['numeroCliente']}</td>
                <td style='display:none;'>{$row['numeroDocumento']}</td>
                <td style='display:none;'>{$row['nombreCuenta']}</td>
                <td style='display:none;'>{$estado}</td>
                <td>{$row['saldo2']}</td>
                <td class='text-center' title='Ir a ver detalles de Mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMorasCajaSeguridad' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
        }
        $html = $html . "</tbody></table>
        ";
    }else {
            $html = $html . "<tr> <td COLSPAN=6>No hay moras en caja de seguridad en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=6>No hay moras en caja de seguridad en la fecha</td></tr>";
    }
    return $html;
}

require_once './header.php';
?>
<div class="container">
        <div id="centro" class="container">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Moras en cajas de seguridad</u></h3>
                        </div>
                        <br>
                        <a href="buscarMorasCajaSeguridad.php"><input type="button" class="btn btn-dark" value="Busqueda Avanzada"></a>
                        <a href="formCorreoMorasCajaSeguridad.php"><input type="button" class="btn btn-dark" value="Enviar correo"></a>
                        &nbsp;
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br>
                                    <?php
                                    echo morasCajaSeguridad();
                                    ?>
                        <br>
                    </div>
                </div>
    </div>
</div>
</body>
<script>
$(document).ready(function () {
                $('#diariosMorasCajaSeguridad').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 500,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Moras Caja Seguridad'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
   
	});
</script>
</html>

