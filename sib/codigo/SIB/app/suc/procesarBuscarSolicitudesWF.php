<?php

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';
session_start();
$_SESSION['buscar'] = null;
$procesos = $_POST['procesos'];
$estados = $_POST['estados'];
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];


$querySolicitudes = "SELECT * FROM solicitudesWF WHERE SUCURSAL = {$_SESSION['sucursal']}";
    if ($procesos != NULL) {
		$querySolicitudes = $querySolicitudes . "AND PROCESO IN(";
        for ($i = 0; $i < count($procesos); $i++) {
            $i = $i +1;
            if($i == count($procesos)){
                $i = $i -1;
                $querySolicitudes = $querySolicitudes . "'$procesos[$i]')";
            }else{
                $i = $i -1;
                $querySolicitudes = $querySolicitudes . "'$procesos[$i]',";
            }
        }
		if($estados != NULL){
		$querySolicitudes = $querySolicitudes . "AND DESCRIPCION IN(";
        for ($i = 0; $i < count($estados); $i++) {
            $i = $i +1;
            if($i == count($estados)){
                $i = $i -1;
                $querySolicitudes = $querySolicitudes . "'$estados[$i]')";
            }else{
                $i = $i -1;
                $querySolicitudes = $querySolicitudes . "'$estados[$i]',";
            }
        }	
        if ($fechaInicio != NULL && $fechaFin != NULL) {
            $querySolicitudes .= "AND CAST(FECHAESTADO AS DATE) >= CAST('{$fechaInicio}' AS DATE) AND CAST(FECHAESTADO AS DATE) <= CAST('{$fechaFin}' AS DATE)";
        }
		}
    } else {
        if($estados != NULL){
		$querySolicitudes = $querySolicitudes . "AND DESCRIPCION IN(";
        for ($i = 0; $i < count($estados); $i++) {
            $i = $i +1;
            if($i == count($estados)){
                $i = $i -1;
                $querySolicitudes = $querySolicitudes . "'$estados[$i]')";
            }else{
                $i = $i -1;
                $querySolicitudes = $querySolicitudes . "'$estados[$i]',";
            }
        }	
        if ($fechaInicio != NULL && $fechaFin != NULL) {
            $querySolicitudes .= "AND CAST(FECHAESTADO AS DATE) >= CAST('{$fechaInicio}' AS DATE) AND CAST(FECHAESTADO AS DATE) <= CAST('{$fechaFin}' AS DATE)";
        }
		} else{
			if ($fechaInicio != NULL && $fechaFin != NULL) {
            $querySolicitudes .= "AND CAST(FECHAESTADO AS DATE) >= CAST('{$fechaInicio}' AS DATE) AND CAST(FECHAESTADO AS DATE) <= CAST('{$fechaFin}' AS DATE)";
        }
		}
    }
	
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitudes);

$_SESSION['buscar'] = $querySolicitudes;

if ($result) {
    if (sqlsrv_has_rows($result)) {
        $resultado = '<br>
            <div class="table-responsive">
                <table id="tb_buscar_solicitudes" class="table table-striped table-bordered" border="3" style="width: 100%">
                    <thead style="background-color:#024d85; color:white;">
                        <tr>
                            <th>Proceso</th>
                            <th>Sucursal</th>
                            <th>Fecha alta</th>
                            <th>Cliente</th>
                            <th>Fecha cambio</th>
                            <th>Descripción</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>';
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fechaAlta = isset($row['FECHAALTA']) ? $row['FECHAALTA']->format('d/m/Y') : "";
            $fechaEstado = isset($row['FECHAESTADO']) ? $row['FECHAESTADO']->format('d/m/Y') : "";
            $resultado .= "
                        <tr> 
                            <td>{$row['PROCESO']}</td>
                            <td>{$row['SUCURSAL']}</td>
                            <td>{$fechaAlta}</td>
                            <td>{$row['CLIENTE']}</td>
                            <td>{$fechaEstado}</td>
                            <td>{$row['DESCRIPCION']}</td>
                            <td class='text-center' title='Ir a ver detalles de solicitud'>
                                <button class='btn btn-sm btn-outline-info detallesSolicitudWF' name='{$row['ID']}'> 
                                    <img src='/lib/img/SHOW.png' width='18' height='18' > 
                                </button>
                            </td>
                        </tr>";
        }
        $resultado .= '            
                    </tbody>
            </div>';
    } else {
        $resultado = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
} else {
    Log::escribirError("[Error al realizar la busqueda avanzada de solicitudes workflow][QUERY: $querySolicitudes]");
    $resultado = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
}

echo $resultado;
