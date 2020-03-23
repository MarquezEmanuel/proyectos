<?php
/* INICIALIZA LA SESION */
session_start();

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

echo "<div class='container'>";

$fecha = $_POST['fecha'];
$operacion = $_POST['operacion'];
$cuenta = $_POST['cuenta'];

if (isset($fecha) && $fecha != null) {
    $fecha = date("d/m/Y", strtotime($fecha));
    $fechaInicio = $fecha . " 00:00:00";
	$fechaFin = $fecha . " 23:59:00";
}

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select * from [10pmcred]";

if (isset($cuenta) && $cuenta != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE numeroCuenta = " . $cuenta;
    if (isset($operacion) && $operacion != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND tipo LIKE '" . $operacion . "'";
        if (isset($fecha) && $fecha != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND fecha between '" . $fechaInicio . "' and '" . $fechaFin . "'";
        }
    } else {
        //no tiene sucursal
        if (isset($fecha) && $fecha != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND fecha between '" . $fechaInicio . "' and '" . $fechaFin . "'";
        }
    }
} else {				
    //no tiene cuenta
    if (isset($operacion) && $operacion != null) {
        //si tiene sucursal agrega en and
        $query = $query . " WHERE tipo LIKE '" . $operacion. "'";
        if (isset($fecha) && $fecha != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND fecha between '" . $fechaInicio . "' and '" . $fechaFin . "'";
        }
    } else {
        //no tiene sucursal
        if (isset($fecha) && $fecha != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " WHERE fecha between '" . $fechaInicio . "' and '" . $fechaFin . "'";
        }
    }
}

if ($query) {
    /* HACE LA CONSULTA A PARTIR DE LAS FECHAS INGRESADAS */

    $selectTransaccion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

    if ($selectTransaccion) {
        if (sqlsrv_has_rows($selectTransaccion)) {
            echo "
            <div class='alert text-right'>
                <input type='submit' class='btn btn-dark' id='btnGenerarXML' name='btnGenerarXML' value='TXT'>
            </div>
            <form method='POST' id='formProcesarBuscarRTE' name='formProcesarBuscarRTE'>
                <div class='table-responsive'>
                    <table id='tablaRTE' class='table table-bordered table-hover' >
                        <thead style='background-color:#024d85; color:white;'>
                            <tr>
                                <th class='text-center align-middle'><input type='checkbox' id='seleccionarTodos' name='seleccionarTodos'></th>
                                <th>Fecha</th>
                                            <th>Moneda</th>
                                            <th>Tipo</th>
                                            <th>Causal</th>
                                            <th>Tipo de Cuenta</th>
                                            <th>Numero de Cuenta</th>
                                            <th>Sucursal</th>
                                            <th>Digito</th>
                                            <th>Importe</th>
                                            <th>Documento</th>
                            </tr>
                        </thead>
                        <tbody style='background-color: white;'>";
            while ($row = sqlsrv_fetch_array($selectTransaccion, SQLSRV_FETCH_ASSOC)) {
				$rubro = utf8_encode($row['rubro']);
				$razon = utf8_encode($row['razon']);
				$fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
				$importe = $row['importe'];
				$importe = number_format($importe / 100, 2, ',', ''); 
                echo "
                        <tr title='Razon: {$razon} . Usuario: {$row['usuario']} . Legajo: {$row['legajo']}'>
                            <td class='text-center align-middle'><input type='checkbox' id='transacciones' name='transacciones[]' value='{$row['id']}'></td>
                            <td>{$fecha}</td>
                <td>{$row['moneda']}</td>
                <td>{$row['tipo']}</td>
                <td>{$row['causal']}</td>
                <td>{$row['tipoCuenta']}</td>
                <td>{$row['numeroCuenta']}</td>
                <td>{$row['sucursal']}</td>
                <td>{$row['digito']}</td>
                <td>{$importe}</td>
                <td>{$row['documento']}</td>
                        </tr>";
            }
            echo '      </tbody>
                    </table>
                </div>
            </form>';
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
