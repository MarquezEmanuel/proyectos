<?php

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$depositante = $_POST['depositante'];
$comitente = $_POST['comitente'];
$estado = $_POST['estado'];
$accion = $_POST['accion'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT * FROM cuentasComitentes ";

if (isset($estado) && $estado != null) {
    $query = $query . " WHERE estadoDepositante LIKE '%" . $estado . "%'";
    if (isset($accion) && $accion != null) {
        $query = $query . "AND tipoAccion LIKE '%" . $accion . "%'";
        if (isset($depositante) && $depositante != null) {
            $query = $query . " AND cuentaDepositante = " . $depositante;
        }
        if (isset($comitente) && $comitente != null) {
            $query = $query . " AND cuentaComitente = " . $comitente;
        }
    } else {
        if (isset($depositante) && $depositante != null) {
            $query = $query . " WHERE cuentaDepositante = " . $depositante;
            if (isset($comitente) && $comitente != null) {
                $query = $query . " AND cuentaComitente = " . $comitente;
            }
        } else {
            if (isset($comitente) && $comitente != null) {
                $query = $query . " WHERE cuentaComitente = " . $comitente;
            }
        }
    }
} else {
    if (isset($accion) && $accion != null) {
        $query = $query . "WHERE tipoAccion LIKE '%" . $accion . "%'";
        if (isset($depositante) && $depositante != null) {
            $query = $query . " AND cuentaDepositante = " . $depositante;
        }
        if (isset($comitente) && $comitente != null) {
            $query = $query . " AND cuentaComitente = " . $comitente;
        }
    } else {
        if (isset($depositante) && $depositante != null) {
            $query = $query . " WHERE cuentaDepositante = " . $depositante;
            if (isset($comitente) && $comitente != null) {
                $query = $query . " AND cuentaComitente = " . $comitente;
            }
        } else {
            if (isset($comitente) && $comitente != null) {
                $query = $query . " WHERE cuentaComitente = " . $comitente;
            }
        }
    }
}

// SE EJECUTA LA CONSULTA 

$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_comitente' class='table table-bordered table-hover'>
        <thead style='background-color:#024d85; color:white;'>
            <tr>
                <th style='display:none;'>Fecha Accion</th>
                <th>Estado de cuenta</th>
                <th>Numero cuenta depositante</th>
                <th>Numero cuenta comitente</th>
                <th>Cantidad vinculados</th>
                <th>Tipo de accion</th>
                
                <th>Modificar</th>
		<th>Eliminar</th>
                <th>Generar XML</th>
            </tr>
        </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

            $fecha = utf8_encode($row['fechaAccion']);
            $estado = utf8_encode($row['estadoDepositante']);
            $cuentaDepositante = $row['cuentaDepositante'];
            $cuentaComitente = $row['cuentaComitente'];
            $cantidad = $row['cantidadCliente'];
            $tipo = utf8_encode($row['tipoAccion']);

            $print = $print . "
            <tr>
                <td style='display:none;'>{$fecha}</td>
                <td>{$estado}</td>
                <td>{$cuentaDepositante}</td>
                <td>{$cuentaComitente}</td>
                <td>{$cantidad}</td>
                <td>{$tipo}</td>
                    
                <td class='text-center' title='Ir a la modificación de reporte'>
                    <button class='btn btn-sm btn-outline-warning'> 
                <img src='../../lib/img/EDIT.png' class='modificarCuentaComitente' name='{$row['idCuentaComitente']}' width='18' height='18' > 
                    </button>
                </td>
				<td class='text-center' title='Eliminar Reporte'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/DELETE.png' class='eliminarCuentaComitente' name='{$row['idCuentaComitente']}' width='18' height='18' > 
                    </button>
                </td>
                <td class='text-center' title='Generar XML'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/xml.png' class='generarXML' name='{$row['idCuentaComitente']}' width='18' height='18' > 
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
    $log = new Log();
    $log->writeLine("[Error al buscar CuentaComitente en la BD][QUERY: $query]");
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
}

echo $print;
