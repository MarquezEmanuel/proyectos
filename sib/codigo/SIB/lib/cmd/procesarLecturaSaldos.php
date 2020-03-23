<?php
$fecha = date("Y-m-d H:i", time());
echo "\n[$fecha][Inicia la lectura del archivo B27A]";
$rutaB27A ="D:\\Aplica\\SIB\\documents\\B27A.txt";
if (file_exists($rutaB27A)) {
	$file = fopen($rutaB27A, "r");
	if($file) {
		$server = "192.168.250.144";
		$db = "bd_sib";
		$uid = "sa";
		$pwd = "Rytdba086+";
		$connectionInfo = array("Database"=>$db, "UID"=>$uid, "PWD"=>$pwd);
		$con = sqlsrv_connect($server, $connectionInfo) or die(date("Y-m-d H:i", time()) . " ERROR!! No se pudo conectar a MySQL.\r\n");
		if($con) {
			/* LISTADO DE CUENTAS QUE SE VAN A EXTRAER DEL ARCHIVO */
			$cuentas = array("1110.01.911.2.80", "1150.01.101.1.02", "1150.01.704.2.20", "1150.01.102.9.11", "1150.01.103.7.02", "1150.01.201.9.20");
			$sucursal = "";
			$fechaControl = "";
			$values = "";
			while (!feof($file)) {
				$linea = fgets($file);
				$linea = trim($linea);
				$cuenta = substr($linea, 0, 16);
				$separada = explode(" ", $cuenta);
				if (strlen($separada[0]) == 3 || strlen($separada[0]) == 4) {
					$sucursal = $separada[0];
					$fechaControl = substr(trim(fgets($file)), 50, 8);
					fgets($file);
					fgets($file);
					fgets($file);
					fgets($file);
					fgets($file);
				} else {
					if (in_array($cuenta, $cuentas)) {
						$saldoSFB = trim(substr($linea, 16, 21));
						$saldoSCB = trim(substr($linea, 40, 22));
						$diferencia = trim(substr($linea, 65, 22));
						$fechaActualizacion = substr($fechaControl, 0, 2) ."/". substr($fechaControl, 3, 2). "/20".substr($fechaControl, 6, 2);
						$values = $values . "(" . trim($sucursal) . ",'" . $cuenta . "','" . $saldoSFB . "','" . $saldoSCB . "', '" . $diferencia . "','$fechaActualizacion', GETDATE()),";
					}
				}
			}
			fclose($file);
			
			$sqlControl = "select TOP 1 id from [dbo].[3saldosSucursales] WHERE fechaControl = '$fechaActualizacion'";
			$result = sqlsrv_query($con, $sqlControl);
			if($result) {
				if (!sqlsrv_has_rows($result)) {
					$values = substr($values, 0, -1);
					$sql = "INSERT INTO [3saldosSucursales] (numeroSucursal, cuenta, saldoSFB, saldoSCB, diferencias, fechaControl, fechaActualizacion) VALUES $values";
					$result = sqlsrv_query($con, $sql);
					if(!$result) {
						echo "\n[$fecha][No se realizo el insert para procesar B27A de $fechaActualizacion - $sql]";
					} else {
						echo "\n[$fecha][Se realizo el insert para procesar B27A de $fechaActualizacion]";
					}
				} else {
					echo "\n[$fecha][Ya se proceso el actual archivo - $sqlControl]";
				}
			} else {
				echo "\n[$fecha][No se pudo realizar la consulta de control - $sqlControl]";
			}
		} else {
			echo "\n[$fecha][No se pudo establecer conexion a la base de datos]";
		}
	} else {
		echo "\n[$fecha][No se pudo abrir el archivo B27A en $rutaB27A]";
	}
} else {
	echo "\n[$fecha][No se encontro el archivo B27A en $rutaB27A]";
}