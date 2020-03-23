<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$transaccion = $_POST['transaccion'];
$localidad = $_POST['localidad'];
$cuit = $_POST['cuit'];
$documento = $_POST['documento'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT * FROM transaccion t
            LEFT JOIN vinculado v ON v.idTransaccion = t.idTransaccion ";

if (isset($transaccion) && $transaccion != null) {
    $query = $query . " WHERE t.transaccion LIKE '%" . $transaccion . "%'";
    if (isset($localidad) && $localidad != null) {
        $query = $query . "AND t.localidad LIKE '%" . $localidad . "%'";
        if (isset($cuit) && $cuit != null) {
            $query = $query . " AND v.cuit = " . $cuit;
        }
        if (isset($documento) && $documento != null) {
            $query = $query . " AND v.numeroDocumento = " . $documento;
        }
    } else {
        if (isset($cuit) && $cuit != null) {
            $query = $query . " WHERE v.cuit = " . $cuit;
            if (isset($documento) && $documento != null) {
                $query = $query . " AND v.numeroDocumento = " . $documento;
            }
        } else {
            if (isset($documento) && $documento != null) {
                $query = $query . " WHERE v.numeroDocumento = " . $documento;
            }
        }
    }
} else {
    if (isset($localidad) && $localidad != null) {
        $query = $query . "WHERE t.localidad LIKE '%" . $localidad . "%'";
        if (isset($cuit) && $cuit != null) {
            $query = $query . " AND v.cuit = " . $cuit;
        }
        if (isset($documento) && $documento != null) {
            $query = $query . " AND v.numeroDocumento = " . $documento;
        }
    } else {
        if (isset($cuit) && $cuit != null) {
            $query = $query . " WHERE v.cuit = " . $cuit;
            if (isset($documento) && $documento != null) {
                $query = $query . " AND v.numeroDocumento = " . $documento;
            }
        } else {
            if (isset($documento) && $documento != null) {
                $query = $query . " WHERE v.numeroDocumento = " . $documento;
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
        <table id='tb_buscar_reporte' class='table table-bordered table-hover'>
        <thead style='background-color:#024d85; color:white;'>
            <tr>
                <th style='display:none;'>Fecha</th>
                <th style='display:none;'>Provincia</th>
                <th style='display:none;'>Localidad</th>
                <th style='display:none;'>Calle</th>
                <th style='display:none;'>Numero</th>
                <th title='Operacion' class='text-center'>Operacion</th>
                <th title='Transaccion' class='text-center'>Transaccion</th>
                <th title='Moneda' class='text-center'>Moneda</th>
                <th title='Monto' class='text-center'>Monto</th>
                <th style='display:none;'>Equivalente en Pesos Argentinos</th>


                <th style='display:none;'>Operador</th>
                <th style='display:none;'>Identificacion</th>
                <th title='Cuit' class='text-center'>Cuit-Cuil</th>
                <th title='Tipo de Persona' class='text-center'>Tipo de Persona</th>
                <th title='Apellido/Denominacion' class='text-center'>Apellido/Denominacion</th>
                <th style='display:none;'>Nombre</th>
                <th style='display:none;'>Tipo de Documento</th>
                <th style='display:none;'>Numero de Documento</th>

                
                <th>Modificar</th>
				<th>Eliminar</th>
                <th>Generar XML</th>
            </tr>
        </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

            $fecha = utf8_encode($row['fecha']);
            $provincia = utf8_encode($row['provincia']);
            $localidad = utf8_encode($row['localidad']);
            $calle = utf8_encode($row['calle']);
            $numero = $row['numero'];
            $operacion = utf8_encode($row['operacion']);
            $transaccion = utf8_encode($row['transaccion']);
            $moneda = utf8_encode($row['moneda']);
            $monto = $row['monto'];
            $equivalente = $row['equivalente'];


            $operador = utf8_encode($row['operador']);
            $identificacion = utf8_encode($row['identificacion']);
            $cuit = $row['cuit'];
            $persona = utf8_encode($row['tipo']);
            $apellido = utf8_encode($row['apellidoDenominacion']);
            $nombre = utf8_encode($row['nombre']);
            $tipo = utf8_encode($row['tipoDocumento']);
            $documento = $row['numeroDocumento'];

            $print = $print . "
            <tr>
                <td style='display:none;'>{$fecha}</td>
                <td style='display:none;'>{$provincia}</td>
                <td style='display:none;'>{$localidad}</td>
                <td style='display:none;'>{$calle}</td>
                <td style='display:none;'>{$numero}</td>
                <td title='Operacion' class='text-center'>{$operacion}</td>
                <td title='Transaccion' class='text-center'>{$transaccion}</td>
                <td title='Moneda' class='text-center'>{$moneda}</td>
                <td title='Monto' class='text-center'>{$monto}</td>
                <td style='display:none;'>{$equivalente}</td>


                <td style='display:none;'>{$operador}</td>
                <td style='display:none;'>{$identificacion}</td>
                <td title='Cuit' class='text-center'>{$cuit}</td>
                <td title='Tipo de Persona' class='text-center'>{$persona}</td>
                <td title='Apellido/Denominacion' class='text-center'>{$apellido}</td>
                <td style='display:none;'>{$nombre}</td>
                <td style='display:none;'>{$tipo}</td>
                <td style='display:none;'>{$documento}</td>
                    

                <td class='text-center' title='Ir a la modificación de reporte'>
                    <button class='btn btn-sm btn-outline-warning'> ";
            if (isset($row['idTransaccion'])) {
                $print = $print . "<img src='../../lib/img/EDIT.png' class='modificarReporte' name='{$row['idTransaccion']}' width='18' height='18' > ";
				$print = $print . "        </button>
                </td>
				<td class='text-center' title='Eliminar Reporte'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/DELETE.png' class='eliminarReporte' name='{$row['idTransaccion']}' width='18' height='18' > 
                    </button>
                </td>
                <td class='text-center' title='Generar XML'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/xml.png' class='generarXML' name='{$row['idTransaccion']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
            } else {
                $fecha = utf8_encode($row['fecha']);
                $provincia = utf8_encode($row['provincia']);
                $localidad = utf8_encode($row['localidad']);
                $calle = utf8_encode($row['calle']);
                $operacion = utf8_encode($row['operacion']);
                $transaccion = utf8_encode($row['transaccion']);
                $sql = "SELECT * FROM transaccion WHERE fecha LIKE '{$fecha}' AND provincia LIKE '{$provincia}' AND localidad LIKE '{$localidad}' AND calle LIKE '{$calle}'"
                        . "AND numero = {$numero} AND operacion LIKE '{$operacion}' AND transaccion LIKE '{$transaccion}' AND monto = {$monto} AND equivalente = {$equivalente}";
                
                $esta = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                if ($esta) {
                    $dale = sqlsrv_has_rows($esta);
                    if ($dale){
                        while ($row = sqlsrv_fetch_array($esta, SQLSRV_FETCH_ASSOC)) {
                            $idTransaccion = $row['idTransaccion'];
                        }
                    } else {
                        $idTransaccion = 'nulloooooooooo';
                    }
                } else {
                    $idTransaccion = 'nullaaaaa';
                }
                $print = $print . "<img src='../../lib/img/EDIT.png' class='modificarReporte' name='{$idTransaccion}' width='18' height='18' > ";
            
            $print = $print . "        </button>
                </td>
				<td class='text-center' title='Eliminar Reporte'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/DELETE.png' class='eliminarReporte' name='{$idTransaccion}' width='18' height='18' > 
                    </button>
                </td>
                <td class='text-center' title='Generar XML'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/xml.png' class='generarXML' name='{$idTransaccion}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
			}
			
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
    $log->writeLine("[Error al buscar RTEOC en la BD][QUERY: $query]");
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
}

echo $print;
