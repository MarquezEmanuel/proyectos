<?php
/* INICIALIZA LA SESION */
session_start();

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

echo "<div class='container'>";

$cuenta = $_POST['producto'];
$sucursal = $_POST['sucursal'];
$nombre = $_POST['nombre'];


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select *,convert(varchar,cast(SALDO as money),1) AS SALDO2,convert(varchar,cast(MONTOBLOQUEO as money),1) AS MONTOBLOQUEO2
,convert(varchar,cast(SALDOPROTEGIDO as money),1) AS SALDOPROTEGIDO2
 from openquery (M4000SF, 'SELECT DISTINCT MOL.HCNCLIREL CLIRELACIONADOS,
                                                                     MOL.HCU_PRODU PRODUCTO, 
                                                                     MOL.HCU_OFICI SUCURSAL, 
                                                                     MOL.HCUNUMCUE CUENTA, 
                                                                     MOL.HCUDIGVER DIGITO, 
                                                                     MOL.HNO_CUENT NOMCUENTA, 
                                                                     MOL.HSAEFEHOY SALDO,
                                                                     MOL.SCO_IDENT CODCLIENTE,
                                                                     MCL.SNO_CLIEN NOMCLIENTE,
                                                                     MCL.SFEFALLEC FALLECIMIENTO,
                                                                     MCL.SFENOVFAL NOVEDAD,
                                                                     ABL.ACO_BLOQU TIPOBLOQUEO,
																	 TB.ANO_BLOQU DESCBLOQUEO,
                                                                     ABL.TVA_MOVIM MONTOBLOQUEO,
																	 MOL.HSA_PROTE SALDOPROTEGIDO,
																	 MOL.HCORESDEB RESTRICCIONDEBITO,
																	 MOL.HCORESCRE RESTRICCIONCREDITO
                                                            FROM SFB_AHMOL MOL
                                                            INNER JOIN SFB_BSMCL MCL ON MCL.SCO_IDENT = MOL.SCO_IDENT AND MCL.SFEFALLEC <> 0 AND MOL.HSAEFEHOY <> 0.00
                                                            INNER JOIN SFB_AHABL ABL ON ABL.HCU_OFICI = MOL.HCU_OFICI AND ABL.HCUNUMCUE = MOL.HCUNUMCUE AND ABL.HCUDIGVER = MOL.HCUDIGVER
															INNER JOIN SFB_AAMTB TB ON TB.ACO_BLOQU = ABL.ACO_BLOQU
                                                            WHERE MOL.HCOESTCUE = 1 AND MOL.HCU_PRODU IN (215, 237, 248, 249, 246, 269)')
";

if (isset($cuenta) && $cuenta != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE PRODUCTO = " . $cuenta;
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND SUCURSAL = " . $sucursal;
        if (isset($nombre) && $nombre != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND NOMCLIENTE LIKE '%" . $nombre . "%'";
        }
    } else {
        //no tiene sucursal
        if (isset($nombre) && $nombre != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND NOMCLIENTE LIKE '%" . $nombre . "%'";
        }
    }
} else {				
    //no tiene cuenta
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " WHERE SUCURSAL = " . $sucursal;
        if (isset($nombre) && $nombre != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND NOMCLIENTE LIKE '%" . $nombre . "%'";
        }
    } else {
        //no tiene sucursal
        if (isset($nombre) && $nombre != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " WHERE NOMCLIENTE LIKE '%" . $nombre . "%'";
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
                                <th style='display:none;'>Clientes Relacionados</th>
                                            <th>Producto</th>
                                            <th>Sucursal</th>
                                            <th>Cuenta</th>
                                            <th>Digito</th>
                                            <th style='display:none;'>Nombre de Cuenta</th>
                                            <th style='display:none;'>Saldo</th>
                                            <th style='display:none;'>Codigo de Cliente</th>
                                            <th>Nombre de Cliente</th>
                                            <th>Fallecimiento</th>
                                            <th style='display:none;'>Novedad</th>
                                            <th style='display:none;'>Tipo de Bloqueo</th>
											<th>Descipcion de Bloqueo</th>
                                            <th style='display:none;'>Monto de Bloqueo</th>
											<th style='display:none;'>Saldo Protegido</th>
											<th style='display:none;'>Restriccion Debito</th>
											<th style='display:none;'>Restriccion Credito</th>
                            </tr>
                        </thead>
                        <tbody style='background-color: white;'>";
            while ($row = sqlsrv_fetch_array($selectTransaccion, SQLSRV_FETCH_ASSOC)) {
				$cuenta = utf8_encode($row['NOMCUENTA']);
				$cliente = utf8_encode($row['NOMCLIENTE']);
                echo "
                        <tr title='RTE: {$row['CUENTA']} con un total de vinculados igual a '>
                            <td class='text-center align-middle'><input type='checkbox' id='transacciones' name='transacciones[]' value='{$row['CUENTA']}'></td>
                            <td style='display:none;'>{$row['CLIRELACIONADOS']}</td>
                <td>{$row['PRODUCTO']}</td>
                <td>{$row['SUCURSAL']}</td>
                <td>{$row['CUENTA']}</td>
                <td>{$row['DIGITO']}</td>
                <td style='display:none;'>{$nombre}</td>
                <td style='display:none;'>{$row['SALDO2']}</td>
                <td style='display:none;'>{$row['CODCLIENTE']}</td>
                <td>{$cliente}</td>
                <td>{$row['FALLECIMIENTO']}</td>
                <td style='display:none;'>{$row['NOVEDAD']}</td>
                <td style='display:none;'>{$row['TIPOBLOQUEO']}</td>
				<td>{$row['DESCBLOQUEO']}</td>
                <td style='display:none;'>{$row['MONTOBLOQUEO2']}</td>
				<td style='display:none;'>{$row['SALDOPROTEGIDO2']}</td>
				<td style='display:none;'>{$row['RESTRICCIONDEBITO']}</td>
				<td style='display:none;'>{$row['RESTRICCIONCREDITO']}</td>
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
