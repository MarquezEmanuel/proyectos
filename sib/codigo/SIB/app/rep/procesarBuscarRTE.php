<?php
/* INICIALIZA LA SESION */
session_start();

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

echo "<div class='container'>";
if (isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])) {
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $_SESSION['fechaInicioRTE'] = $fechaInicio;
    if (isset($_POST['apellido']) && $_POST['apellido'] != NULL) {
        $apellido = $_POST['apellido'];
        $query = "SELECT DISTINCT RTE.*, CAN.cantidad
                FROM rte_transaccion RTE
                INNER JOIN rte_vinculado VIN ON RTE.referencia = VIN.referencia AND VIN.apellido LIKE '%{$apellido}%'
                LEFT JOIN (select referencia, count(*) cantidad from rte_vinculado where relacionFondo = 'Vinculado al producto operado' OR (relacionFondo IN ('Operador/Titular','Titular','Operador') AND relacionProducto = 'SI') GROUP BY referencia) CAN ON CAN.referencia = RTE.referencia
                WHERE CAST(fecha AS DATE) >= CAST('{$fechaInicio}' as DATE) AND CAST(fecha AS DATE) <= CAST('{$fechaFin}' as DATE)";
    } else {
        $query = "SELECT RTE.*, CAN.cantidad
                FROM rte_transaccion RTE
                LEFT JOIN (select referencia, count(*) cantidad from rte_vinculado where relacionFondo = 'Vinculado al producto operado' OR (relacionFondo IN ('Operador/Titular','Titular','Operador') AND relacionProducto = 'SI') GROUP BY referencia) CAN ON CAN.referencia = RTE.referencia
                WHERE CAST(fecha AS DATE) >= CAST('{$fechaInicio}' as DATE) AND CAST(fecha AS DATE) <= CAST('{$fechaFin}' as DATE)";
    }

    /* HACE LA CONSULTA A PARTIR DE LAS FECHAS INGRESADAS */

    $selectTransaccion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

    if ($selectTransaccion) {
        if (sqlsrv_has_rows($selectTransaccion)) {
            echo "
            <div class='alert text-right' title='Panel de operaciones para las transacciones'>
                <button class='btn btn-outline-danger' id='btnBorrarRTE' name='btnBorrarRTE' title='Borrar transacciones seleccionadas'> 
                    <img src='../../lib/img/DELETE.png' width='24' height='24'>
                </button>
                <button class='btn btn-outline-warning' style='border-color: #634a00;' id='btnModificarRTE' name='btnModificarRTE' title='Modificar transaccion seleccionada'> 
                    <img src='../../lib/img/EDIT.png' width='24' height='24'> 
                </button>
                <button class='btn btn-outline-success' id='btnAgregarVinculado' name='btnAgregarVinculado' title='Agregar sujeto vinculado'> 
                    <img src='../../lib/img/ADD_USER.png' width='24' height='24'> 
                </button>
                <button class='btn btn-outline-primary' id='btnDetalleRTE' name='btnDetalleRTE' title='Ver transaccion seleccionada'> 
                    <img src='../../lib/img/SHOW.png' width='24' height='24'> 
                </button>
                <button class='btn btn-outline-info' id='btnGenerarXML' name='btnGenerarXML' title='Generar XML para las transacciones seleccionadas'> 
                    <img src='../../lib/img/SETTING.png' width='24' height='24'> 
                </button>
            </div>
            <form method='POST' id='formProcesarBuscarRTE' name='formProcesarBuscarRTE'>
                <div class='table-responsive'>
                    <table id='tablaRTE' class='table table-bordered table-hover' >
                        <thead style='background-color:#024d85; color:white;'>
                            <tr>
                                <th class='text-center align-middle'><input type='checkbox' id='seleccionarTodos' name='seleccionarTodos'></th>
                                <th class='text-center align-middle'>Referencia</th>
                                <th class='text-center align-middle'>Concepto</th>
                                <th class='text-center align-middle'>Número de Cuenta</th>
                                <th class='text-center align-middle'>Fecha</th>
                                <th class='text-center align-middle'>Tipo</th>
                                <th class='text-center align-middle'>Moneda</th>
                                <th class='text-center align-middle'>Monto Origen</th>
                                <th class='text-center align-middle'>Monto en Pesos</th>
                                <th class='text-center align-middle'>Sujetos</th>
                            </tr>
                        </thead>
                        <tbody style='background-color: white;'>";
            while ($row = sqlsrv_fetch_array($selectTransaccion, SQLSRV_FETCH_ASSOC)) {
                echo "
                        <tr title='RTE: {$row['referencia']} con un total de vinculados igual a {$row['cantidad']}'>
                            <td class='text-center align-middle'><input type='checkbox' id='transacciones' name='transacciones[]' value='{$row['referencia']}'></td>
                            <td class='align-middle'>{$row['referencia']}</td>
                            <td class='align-middle'>{$row['concepto']}</td>
                            <td class='align-middle'>{$row['cuenta']}</td>
                            <td class='align-middle'>{$row['fecha']->format('d/m/Y')}</td>
                            <td class='align-middle'>" . utf8_encode($row['tipo']) . "</td>
                            <td class='align-middle'>" . utf8_encode($row['moneda']) . "</td>
                            <td class='align-middle'>{$row['montoOrigen']}</td>
                            <td class='align-middle'>{$row['montoPesos']}</td>    
                            <td class='align-middle'>{$row['cantidad']}</td>
                        </tr>";
            }
            echo '      </tbody>
                    </table>
                </div>
            </form>
            <div class="alert text-right">
                <button class="btn btn-outline-info" id="btnTop" name="btnTop" title="Subir"> 
                    <img src="../../lib/img/TOP.png" width="25" height="25">
                </button>
            </div>';
        } else {
            echo '<div class="alert alert-warning text-center" role="alert"> No se encontraron resultados </div>';
        }
    } else {
        $log = new Log();
        $log->writeLine("[Error al realizar la consulta con la base de datos][QUERY: {$query}]");
        echo '<div class="alert alert-danger text-center" role="alert"> Error al realizar búsqueda </div>';
    }
} else {
    $log = new Log();
    $log->writeLine("[Error al recibir parametros por POST]");
    echo '<div class="alert alert-danger text-center" role="alert"> No se recibieron los datos del formulario de búsqueda </div>';
}
echo "</div>";
