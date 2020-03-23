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
    
    //Rio Gallegos
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2788',
'3560',
'3591',
'3592',
'6280',
'6281',
'6282',
'6283',
'6284',
'9356',
'9360',
'9374',
'3582',
'3583',
'3584',
'3585',
'6290',
'6302',
'6303',
'2753',
'2755',
'2756',
'2772',
'2794',
'2795',
'3595',
'3596',
'3599',
'6276',
'6288',
'6309',
'9378',
'9390',
'9391',
'9392',
'9393',
'9394',
'9397',
'9398'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Rio Gallegos";
				if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>1</td>
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
						<td>1</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>1</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Rio Gallegos</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Rio Gallegos</td></tr>";
    }
    
    //BS AS
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('9376',
'9377',
'3598'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Buenos Aires";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>5</td>
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
						<td>5</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>5</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Buenos Aires</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Buenos Aires</td></tr>";
    }
    
    //Caleta
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2754',
'2783',
'3586',
'3587',
'3589',
'3594',
'6269',
'6293',
'6307',
'9361',
'9375',
'2775',
'2780',
'3564',
'9396',
'9399'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Caleta Olivia";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>10</td>
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
						<td>10</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>10</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Caleta Olivia</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Caleta Olivia</td></tr>";
    }
    
    //Rio Turbio
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2766',
'6291',
'9365',
'9366')";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Rio Turbio";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>15</td>
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
						<td>15</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>15</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Rio Turbio</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Rio Turbio</td></tr>";
    }
    
    //Piedra Buena
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2774',
'3566',
'6274'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Piedra Buena";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>20</td>
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
						<td>20</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>20</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Piedra Buena</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Piedra Buena</td></tr>";
    }
    
    //Calafate
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2752',
'3567',
'3568',
'3569',
'6278',
'9364'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Calafate";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>25</td>
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
						<td>25</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>25</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Calafate</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Calafate</td></tr>";
    }
    
    //Gobernador Gregores
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2767',
'3565',
'6279',
'9369'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Gobernador Gregores";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>30</td>
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
						<td>30</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>30</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Gobernador Gregores</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Gobernador Gregores</td></tr>";
    }
    
    //Perito Moreno
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2773',
'3570',
'6270',
'9379',
'9380'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Perito Moreno";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>40</td>
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
						<td>40</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>40</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Perito Moreno</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Perito Moreno</td></tr>";
    }
    
    //Los Antiguos
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2790',
'3597',
'6275'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Los Antiguos";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>41</td>
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
						<td>41</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>41</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Los Antiguos</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Los Antiguos</td></tr>";
    }
    
    //Las Heras
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('3576',
'3577',
'3578',
'3579',
'3580',
'3581',
'9363'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Las Heras";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>45</td>
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
						<td>45</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>45</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Las Heras</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Las Heras</td></tr>";
    }
    
    //Pico Truncado
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('3572',
'3573',
'3574',
'6292',
'6308',
'9362'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Pico Truncado";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>50</td>
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
						<td>50</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>50</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Pico Truncado</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Pico Truncado</td></tr>";
    }
    
    //Puerto Deseado
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2759',
'3562',
'3563',
'6306',
'9370'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Puerto Deseado";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>55</td>
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
						<td>55</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>55</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Puerto Deseado</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Puerto Deseado</td></tr>";
    }
    
    //San Julian
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2765','3571','6271','9381')";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "San Julian";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>60</td>
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
						<td>60</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>60</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en San Julian</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en San Julian</td></tr>";
    }
    
    //Puerto Santa Cruz
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2769',
'6268',
'9367',
'9368')";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Puerto Santa Cruz";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>70</td>
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
						<td>70</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>70</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Puerto Santa Cruz</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Puerto Santa Cruz</td></tr>";
    }
    
    //Comodoro Rivadavia
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2784',
'6289'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Comodoro Rivadavia";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>80</td>
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
						<td>80</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>80</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Comodoro Rivadavia</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en Comodoro Rivadavia</td></tr>";
    }
    
    //28 de Noviembre
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('3588',
'6272',
'6299'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "28 de Noviembre";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>85</td>
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
						<td>85</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>85</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en 28 de Noviembre</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en 28 de Noviembre</td></tr>";
    }
	
	//95 tesoreria general
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2753','2755','2756','2772','2794','3595',
  '3596','3599','6276','6288','6304','6309','9378','9390','9391','9392','9393','9394'
)";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "95 tesoreria";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>95</td>
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
						<td>95</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>95</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en suc 95</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en suc 95</td></tr>";
    }
	
	//95 prosegur sur
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('3590','2795','9371','9398','9397')";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "95 prosegur sur";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>95</td>
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
						<td>95</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>95</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en suc 95</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en suc 95</td></tr>";
    }
	
	//95 prosegur norte
    
    $sql = "SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2780','3564','2775','9396','9399','3898')";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "95 prosegur norte";
                if($row['promedio'] > 95){
					$html = $html. "
                    <tr>
                    <td>95</td>
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
						<td>95</td>
						<td>{$nombreSucursal}</td>    
						<td>{$row['promedio']}</td>
						<td class='text-center' title='Ver detalles de sucursal'>
							<img src='/lib/img/rojo.png' class='tiempo' name='{$nombreSucursal}' width='30' height='30'>
						</td>
						</tr>";
					} else {
						$html = $html. "
						<tr>
						<td>95</td>
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
            $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en suc 95</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=4>No hay cajeros procesados en la fecha en suc 95</td></tr>";
    }
    
    return $html;
}
require_once './header.php';
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
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                                <table id='diariosPagare' class='table table-striped table-bordered' border="3" style="width: 100%">
                                    <colgroup>
                                    <col style='width: 20%'/>
                                    <col style='width: 60%'/>
                                    <col style='width: 20%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Numero de Sucursal</th>
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

