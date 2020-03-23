<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

date_default_timezone_set('America/Argentina/Buenos_Aires');
$month = date('m', strtotime('-1 month'));
$day = date("d", mktime(0,0,0, $month+1, 0, date('Y')));
$ultimo = date('d-m-y', mktime(0,0,0, $month, $day, date('Y')));
$primero = date('d-m-y', mktime(0,0,0, $month, 1, date('Y')));
	
// RECIBE LOS DATOS ENVIADOS POR AJAX
$tarjeta = $_POST['tarjeta'];
$control = $_POST['control'];



if($tarjeta[0] == 'MC'){
	if($control[0] == '0'){
		$query = "SELECT *, convert(varchar,cast(consumos as money),1) AS consumos2, convert(varchar,cast(ajustes as money),1) AS ajustes2
  , convert(varchar,cast(consolidado as money),1) AS consolidado2 FROM [bd_sib].[dbo].[7regimenConsolidadoMaster]";
	}else{
		if($control[0] == '13'){
			$query = "SELECT *, convert(varchar,cast(consumos as money),1) AS consumos2, convert(varchar,cast(ajustes as money),1) AS ajustes2
  , convert(varchar,cast(consolidado as money),1) AS consolidado2 FROM [bd_sib].[dbo].[7regimenConsolidadoMaster] WHERE consolidado >= (select saldo*13 FROM [bd_sib].[dbo].[SMVM])";
		} else {
			$query = "SELECT *, convert(varchar,cast(consumos as money),1) AS consumos2, convert(varchar,cast(ajustes as money),1) AS ajustes2
  , convert(varchar,cast(consolidado as money),1) AS consolidado2 FROM [bd_sib].[dbo].[7regimenConsolidadoMaster] WHERE consolidado >= (select saldo*50 FROM [bd_sib].[dbo].[SMVM])";			
		}
	}
	
		$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
		
//VISA CONSULTA
}else{
	if($control[0] == '0'){
		$query = "SELECT *, convert(varchar,cast(consumos as money),1) AS consumos2, convert(varchar,cast(ajustes as money),1) AS ajustes2
  , convert(varchar,cast(consolidado as money),1) AS consolidado2 FROM [bd_sib].[dbo].[7regimenConsolidadoVisa]";
	}else{
		if($control[0] == '13'){
			$query = "SELECT *, convert(varchar,cast(consumos as money),1) AS consumos2, convert(varchar,cast(ajustes as money),1) AS ajustes2
  , convert(varchar,cast(consolidado as money),1) AS consolidado2 FROM [bd_sib].[dbo].[7regimenConsolidadoVisa] WHERE consolidado >= (select saldo*13 FROM [bd_sib].[dbo].[SMVM])";
		} else {
			$query = "SELECT *, convert(varchar,cast(consumos as money),1) AS consumos2, convert(varchar,cast(ajustes as money),1) AS ajustes2
  , convert(varchar,cast(consolidado as money),1) AS consolidado2 FROM [bd_sib].[dbo].[7regimenConsolidadoVisa] WHERE consolidado >= (select saldo*50 FROM [bd_sib].[dbo].[SMVM])";		
		}
	}
	$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
  
}


if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_MoraTarjetas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>Documento</th>
                                            <th>Nombre</th>
											<th>Consumos</th>
                                            <th>Ajustes</th>
											<th>Consolidado</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['nombre']);
            $print = $print . "
            <tr>
                <td>{$row['documento']}</td>
				<td>{$nombre}</td>
                <td>{$row['consumos2']}</td>
				<td>{$row['ajustes2']}</td>
				<td>{$row['consolidado2']}</td>
            </tr>";
        }
        $print = $print . "</tbody></table>
        ";
    } else {
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
} else {
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
}


echo $print;


