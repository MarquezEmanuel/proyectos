<?php
include_once '../conf/BDConexion.php';

function noSAV() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual." 00:00:00";
    $actualfinal = $actualfinal." 23:59:59";
    
    //Rio Gallegos
    
    $sql = "SELECT count(*) cantidad
  FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 1";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Rio Gallegos";
				if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>1</td>
                    <td>{$nombreSucursal}</td> 
					<td>{$row['cantidad']}</td>					
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='1' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>1</td>
					<td>{$nombreSucursal}</td> 
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='1' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad
  FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 5";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Buenos Aires";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>5</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='5' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>5</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='5' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad
  FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 10";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Caleta Olivia";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>10</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='10' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>10</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='10' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad
  FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 15";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Rio Turbio";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>15</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='15' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>15</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='15' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 20";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Piedra Buena";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>20</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='20' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>20</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='20' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 25";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Calafate";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>25</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='25' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>25</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='25' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 30";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Gobernador Gregores";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>30</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='30' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>30</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='30' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 40";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Perito Moreno";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>40</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='40' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>40</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='40' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 41";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Los Antiguos";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>41</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='41' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>41</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='41' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 45";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Las Heras";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>45</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='45' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>45</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='45' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 50";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Pico Truncado";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>50</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='50' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>50</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='50' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 55";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Puerto Deseado";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>55</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='55' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>55</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='55' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 60";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "San Julian";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>60</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='60' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>60</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='60' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 70";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Puerto Santa Cruz";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>70</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='70' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>70</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='70' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 80";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Comodoro Rivadavia";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>80</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='80' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>80</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='80' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 85";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "28 de Noviembre";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>85</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='85' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>85</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='85' width='30' height='30'>
					</td>
					</tr>";
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
    
    $sql = "SELECT count(*) cantidad FROM [bd_sib].[dbo].[3archivosConta] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = 95";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Casa Central";
                if($row['cantidad'] > 6){
					$html = $html. "
                    <tr>
                    <td>95</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/verde.png' class='tiempo' name='95' width='30' height='30'>
                    </td>
                    </tr>";
				} else{
					$html = $html. "
					<tr>
					<td>95</td>
					<td>{$nombreSucursal}</td>    
					<td>{$row['cantidad']}</td>
					<td class='text-center' title='Ver detalles de sucursal'>
						<img src='/lib/img/rojo.png' class='tiempo' name='95' width='30' height='30'>
					</td>
					</tr>";
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
                            <h3 class="text-center"><u>Archivos Para Conta - Sucursales</u></h3>
                        </div>
                        <br>
                        <a href="conta.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                                <table id='diariosPagare' class='table table-striped table-bordered' border="3" style="width: 100%">
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Numero de Sucursal</th>
                                            <th>Nombre de Sucursal</th>
                                            <th>Cantidad de Archivos</th>
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
            url: "formDetallesArchivosConta.php",
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

