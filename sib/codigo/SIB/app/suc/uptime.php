<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function noSAV() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual." 00:00:00";
    $actualfinal = $actualfinal." 23:59:59";
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
	FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN";
	switch($_SESSION['sucursal']){
		case "1":
			$sql = $sql . "('2788','3560','3591','3592','6280','6281','6282','6283','6284','9356','9360','9374','3582','3583','3584','3585','6290','6302',
			'6303','2753','2755','2756','2772','2794','2795','3595','3596','3599','6276','6288','6309','9378','9390','9391','9392','9393','9394','9397','9398')";
			$nombreSucursal = "Rio Gallegos";
			break;
		case "5":
			$sql = $sql . "('9376','9377','3598')";
			$nombreSucursal = "Buenos Aires";
			break;
		case "10":
			$sql = $sql . "('2754','2783','3586','3587','3589','3594','6269','6293','6307','9361','9375','2775','2780','3564','9396','9399')";
			$nombreSucursal = "Caleta Olivia";
			break;
		case "15":
			$sql = $sql . "('2766','6291','9365','9366')";
			$nombreSucursal = "Rio Turbio";
			break;
		case "20":
			$sql = $sql . "('2774','3566','6274')";
			$nombreSucursal = "Piedra Buena";
			break;
		case "25":
			$sql = $sql . "('2752','3567','3568','3569','6278','9364')";
			$nombreSucursal = "Calafate";
			break;
		case "30":
			$sql = $sql . "('2767','3565','6279','9369')";
			$nombreSucursal = "Gobernador Gregores";
			break;
		case "40":
			$sql = $sql . "('2773','3570','6270','9379','9380')";
			$nombreSucursal = "Perito Moreno";
			break;
		case "41":
			$sql = $sql . "('2790','3597','6275')";
			$nombreSucursal = "Los Antiguos";
			break;
		case "45":
			$sql = $sql . "('3576','3577','3578','3579','3580','3581','9363')";
			$nombreSucursal = "Las Heras";
			break;
		case "50":
			$sql = $sql . "('3572','3573','3574','6292','6308','9362')";
			$nombreSucursal = "Pico Truncado";
			break;
		case "55":
			$sql = $sql . "('2759','3562','3563','6306','9370')";
			$nombreSucursal = "Puerto Deseado";
			break;
		case "60":
			$sql = $sql . "('2765','3571','6271','9381')";
			$nombreSucursal = "San Julian";
			break;
		case "70":
			$sql = $sql . "('2769','6268','9367','9368')";
			$nombreSucursal = "Puerto Santa Cruz";
			break;
		case "80":
			$sql = $sql . "('2784','6289')";
			$nombreSucursal = "Comodoro Rivadavia";
			break;
		case "85":
			$sql = $sql . "('3588','6272','6299')";
			$nombreSucursal = "28 de Noviembre";
			break;
	}
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['promedio']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					if($row['promedio'] < 92){
						$html = $html. "
						<tr>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/amarillo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
						}
					}
				} 
        }
        else{
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha</td></tr>";
    }
    return $html;
}
require_once './menuSucursal.php';
?>

<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Tiempo de Actividad - Cajeros</u></h3>
                        </div>
                        <br>
                        <a href="buscarUptime.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                                <table id='diariosPagare' class='table table-striped table-bordered' border="3" style="width: 100%">
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Nombre de Sucursal</th>
                                            <th>Promedio Actividad</th>
											<th>Detalles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    echo noSAV();
                                    ?>
                                    </tbody>
                                </table>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>	
$("#contenido").on("click", "img.tiempo", function () {
        var id = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formDetallesUptime.php",
            data: "seleccionado=" + id,
            success: function (data) {
                $("#contenido").html(data);
                $("#contenido2").empty();
            },
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
</script>
<script type="text/javascript" charset="utf8" src="/lib/JQuery/diarios.js"></script>
</html>

