<?php

/* INCLUYE LOS ARCHIVOS PARA ESCRIBIR EL LOG Y LA CONEXION A LA BASE DE DATOS */
include_once '../../app/conf/Constants.php';
include_once '../../app/conf/Log.php';
include_once '../../app/conf/BDConexion.php';

/* RECIBE LOS DATOS DESDE EL MODAL Y JS CORRESPONDIENTE PARA CADA REPORTE */
$inicio = $_POST['fechaInicioInforme'];
$fin = $_POST['fechaFinInforme'];
$opcion = $_POST['opcion'];

/* INICIALIZA LAS VARIABLES A USAR */
$data = NULL;
$log = new Log();

/*
 * CASO 1 : REPORTE DE ALTA DE CLIENTES POR CADA USUARIO
 * CASO 2 : REPORTE DE EXTRACCIONES POR CAJA
 * CASO 3 : REPORTE DE CANTIDAD DE REVERSAS POR USUARIO
 * CASO 4 : REPORTE DE CANTIDAD INCORRECTA IDENTIFICACIONES DE CLIENTES POR USUARIO
 * CASO 5 : REPORTE DE CANTIDAD DE FALLAS POR USUARIO
 * CASO 6 : REPORTE DE FIRMAS GRAFOMETRICAS
 */

switch ($opcion) {
    case 1:
        $sql = "SELECT TOP 5 usuarioAlta usuario, COUNT(*) cantidad 
                FROM [3altaCliente] 
                WHERE CAST(fechaActualizacion AS DATE) >= CAST('{$inicio}' as DATE) AND 
                      CAST(fechaActualizacion AS DATE) <= CAST('{$fin}' as DATE)
                GROUP BY usuarioAlta
                ORDER BY cantidad DESC";
        $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        if ($result) {
            if (sqlsrv_has_rows($result)) {
                $data[] = array('usuario', 'cantidad');
                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    $data[] = array("'" . $row['usuario'] . "'", $row['cantidad']);
                }
            }
        } else {
            $log->writeLine("[ERROR: No se pudo realizar la consulta de alta clientes][QUERY: {$sql}]");
        }
        break;
    case 2:
        break;
    case 3:
        $sql = "SELECT TOP 5 usuario, count(id) cantidad
                FROM [3reversas]
                WHERE CAST(fechaActualizacion AS DATE) >= CAST('{$inicio}' as DATE) AND
                      CAST(fechaActualizacion AS DATE) <= CAST('{$fin}' as DATE)
                GROUP BY usuario
                ORDER BY cantidad DESC";
        $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        if ($result) {
            if (sqlsrv_has_rows($result)) {
                $data[] = array('usuario', 'cantidad');
                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    $data[] = array("'" . $row['usuario'] . "'", $row['cantidad']);
                }
            }
        } else {
            $log->writeLine("[ERROR: No se pudo realizar la consulta de reversas][QUERY: {$sql}]");
        }
        break;
    case 4:
        $sql = "SELECT TOP 5 usuario, count(id) cantidad 
                FROM [dbo].[3transaccionIncorrecta] 
                WHERE CAST(fechaActualizacion AS DATE) >= CAST('{$inicio}' as DATE) AND 
                      CAST(fechaActualizacion AS DATE) <= CAST('{$fin}' as DATE)
                GROUP BY usuario 
                ORDER BY cantidad DESC";
        $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        if ($result) {
            if (sqlsrv_has_rows($result)) {
                $data[] = array('usuario', 'cantidad');
                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    $data[] = array("'" . $row['usuario'] . "'", $row['cantidad']);
                }
            }
        } else {
            $log->writeLine("[ERROR: No se pudo realizar la consulta de identificaciones incorrectas][QUERY: {$sql}]");
        }
        break;
    case 5:
        $sql = "SELECT TOP 5 usuario, count(id) cantidad
                FROM [3fallas]
                WHERE CAST(fechaActualizacion AS DATE) >= CAST('{$inicio}' as DATE) AND
                      CAST(fechaActualizacion AS DATE) <= CAST('{$fin}' as DATE)
                GROUP BY usuario
                ORDER BY cantidad DESC";
        $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        if ($result) {
            if (sqlsrv_has_rows($result)) {
                $data[] = array('usuario', 'cantidad');
                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    $data[] = array("'" . $row['usuario'] . "'", $row['cantidad']);
                }
            }
        } else {
            $log->writeLine("[ERROR: No se pudo realizar la consulta de fallas][QUERY: {$sql}]");
        }
        break;
	case 6:
		$sql = "SELECT  [nombreTramite] ,count(nombreTramite) cantidad FROM (select * from[bd_sib].[dbo].[3tramitesFirmaGrafometrica] WHERE fechaAlta between CAST('".$inicio."' as DATE) and CAST('".$fin."' as DATE)) DOS
    GROUP BY nombreTramite ORDER BY cantidad desc";
		$log->writeLine("[ERROR: No se pudo realizar la consulta de fallas][QUERY: {$sql}]");
        $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        if ($result) {
            if (sqlsrv_has_rows($result)) {
                $data[] = array('nombreTramite', 'cantidad');
                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    $data[] = array("'" . utf8_encode($row['nombreTramite']) . "'", $row['cantidad']);
                }
            }
        } else {
            $log->writeLine("[ERROR: No se pudo realizar la consulta de fallas][QUERY: {$sql}]");
        }
        break;
}

/* DEVUELVE LA INFORMACION EN FORMATO JSON PARA SER PROCESADA EN EL JAVASCRIPT */

echo json_encode($data);
