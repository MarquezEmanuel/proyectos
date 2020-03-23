<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$fechaInicio = $_POST['desde'];
$fechaFin = $_POST['hasta'];

if (isset($fechaInicio) && $fechaInicio != null) {
    $fechaInicio = date("d/m/Y", strtotime($fechaInicio));
    $fechaInicio = $fechaInicio . " 00:00:00";
}
if (isset($fechaFin) && $fechaFin != null) {
    $fechaFin = date("d/m/Y", strtotime($fechaFin));
    $fechaFin = $fechaFin . " 23:59:00";
}

switch($_SESSION['sucursal']){
		case "1":
			$cajeros = "cajero IN ('2788','3560','3591','3592','6280','6281','6282','6283','6284','9356','9360','9374','3582','3583','3584',
'3585','6290','6302','6303','2753','2755','2756','2772','2794','2795','3595','3596','3599','6276','6288','6309','9378','9390','9391','9392','9393',
'9394','9397','9398')";
			$nombreSucursal = "Rio Gallegos";
			break;
		case "5":
			$cajeros = "cajero IN ('9376','9377','3598')";
			$nombreSucursal = "Buenos Aires";
			break;
		case "10":
			$cajeros = "cajero IN ('2754','2783','3586','3587','3589','3594','6269','6293','6307','9361','9375','2775','2780','3564','9396','9399')";
			$nombreSucursal = "Caleta Olivia";
			break;
		case "15":
			$cajeros = "cajero IN ('2766','6291','9365','9366')";
			$nombreSucursal = "Rio Turbio";
			break;
		case "20":
			$cajeros = "cajero IN ('2774','3566','6274')";
			$nombreSucursal = "Piedra Buena";
			break;
		case "25":
			$cajeros = "cajero IN ('2752','3567','3568','3569','6278','9364')";
			$nombreSucursal = "Calafate";
			break;
		case "30":
			$cajeros = "cajero IN ('2767','3565','6279','9369')";
			$nombreSucursal = "Gobernador Gregores";
			break;
		case "40":
			$cajeros = "cajero IN ('2773','3570','6270','9379','9380')";
			$nombreSucursal = "Perito Moreno";
			break;
		case "41":
			$cajeros = "cajero IN ('2790','3597','6275')";
			$nombreSucursal = "Los Antiguos";
			break;
		case "45":
			$cajeros = "cajero IN ('3576','3577','3578','3579','3580','3581','9363')";
			$nombreSucursal = "Las Heras";
			break;
		case "50":
			$cajeros = "cajero IN ('3572','3573','3574','6292','6308','9362')";
			$nombreSucursal = "Pico Truncado";
			break;
		case "55":
			$cajeros = "cajero IN ('2759','3562','3563','6306','9370')";
			$nombreSucursal = "Puerto Deseado";
			break;
		case "60":
			$cajeros = "cajero IN ('2765','3571','6271','9381')";
			$nombreSucursal = "San Julian";
			break;
		case "70":
			$cajeros = "cajero IN ('2769','6268','9367','9368')";
			$nombreSucursal = "Puerto Santa Cruz";
			break;
		case "80":
			$cajeros = "cajero IN ('2784','6289')";
			$nombreSucursal = "Comodoro Rivadavia";
			break;
		case "85":
			$cajeros = "cajero IN ('3588','6272','6299')";
			$nombreSucursal = "28 de Noviembre";
			break;
	}
// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select * from [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$fechaInicio}' AND '{$fechaFin}' AND " . $cajeros;

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$_SESSION['buscar'] = $query;

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_incorrecta' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Cajero</th>
                                            <th>Neutral</th>
                                            <th style='display:none;'>Medicion</th>
											<th>UTP</th>
											<th>Dispens</th>
											<th style='display:none;'>HWCASS</th>
											<th>Dinero</th>
											<th>Insumos</th>
											<th>Comunicacion</th>
											<th style='display:none;'>OtrosHW</th>
											<th>Deposito</th>
											<th>Superv</th>
											<th>OpenST</th>
											<th style='display:none;'>PresHOP1</th>
											<th style='display:none;'>PresHOP2</th>
											<th style='display:none;'>PresHOP3</th>
											<th style='display:none;'>PresHOP4</th>
											<th>Tiempo Operativo</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $print = $print . "
            <tr>
							<td>{$row['cajero']}</td>
							<td>{$row['neutral']}</td>
							<td style='display:none;'>{$row['fueraMedicion']}</td>
							<td>{$row['UPT']}</td>
							<td>{$row['dispens']}</td>
							<td style='display:none;'>{$row['HWCASS']}</td>
							<td>{$row['dinero']}</td>
							<td>{$row['insumos']}</td>
							<td>{$row['comunic']}</td>
							<td style='display:none;'>{$row['otrosHW']}</td>
							<td>{$row['deposito']}</td>
							<td>{$row['superv']}</td>
							<td>{$row['openST']}</td>
							<td style='display:none;'>{$row['presHOP1']}</td>
							<td style='display:none;'>{$row['presHOP2']}</td>
							<td style='display:none;'>{$row['presHOP3']}</td>
							<td style='display:none;'>{$row['presHOP4']}</td>
							<td>{$row['tiempoOperativo']}</td>
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

