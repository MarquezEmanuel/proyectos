<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$estado = $_POST['estado'];
$cuenta = $_POST['cuenta'];
$tipo = $_POST['tipo'];
$tarjeta = $_POST['tarjeta'];
$denominacion = $_POST['denominacion'];

//CUENTA MASTER
if($tipo[0] == 'MC'){
	if($estado[0] == 'activa'){
		$esta = "ope_esta = 1";
	}else{
		$esta = "ope_esta = 9";
	}
	$query = "SELECT SucurCodi sucursal,
	   cuenta_nume cuenta,
	   tarje_nume tarjeta,
	   plasti_nombre nombre,
	   loca localidad,
	   titu_identi tipo,
	   docu_tipo tipoDocumento,
	   docu_nume documento,
	   hasta_vigen_fecha fecha,
	   convert(varchar,cast(credi_limi as money),1) AS limite
  FROM [192.168.250.133].[Smartopen].[dbo].[CredenTarje] where $esta";
  
  if (isset($tarjeta) && $tarjeta != null) {
    $query = $query . " AND tarje_nume = '" . $tarjeta ."'";
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND Cuenta_Nume = " . $cuenta;
		if (isset($denominacion) && $denominacion != null) {
        $query = $query . " AND plasti_nombre LIKE '%" . $denominacion ."%'";
		}
	} else {
		if (isset($denominacion) && $denominacion != null) {
        $query = $query . " AND plasti_nombre LIKE '%" . $denominacion ."%'";
		}
	}
} else {
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND Cuenta_Nume = " . $cuenta;
		if (isset($denominacion) && $denominacion != null) {
        $query = $query . " AND plasti_nombre LIKE '%" . $denominacion ."%'";
		}
	} else{
		if (isset($denominacion) && $denominacion != null) {
        $query = $query . " AND plasti_nombre LIKE '%" . $denominacion ."%'";
		}
	}
}
//VISA CONSULTA
}else{
	if($estado[0] == 'activa'){
		$esta = "TarjeEsta IN (20,25) AND TarjeCate = '0'";
	}else{
		$esta = "TarjeEsta IN (22,29)";
	}
	$query = "SELECT Cuenta,
	   TarjeNume tarjeta,
	   DocuTipo tipoDocumento,
	   DocuNume documento,
	   TarjeDeno nombre,
	   Nacio nacionalidad,
	   TarjeVigenHastaFecha fecha
  FROM [192.168.250.133].[Smartopen].[dbo].[VisaTarje] where $esta";
  
  if (isset($tarjeta) && $tarjeta != null) {
    $query = $query . " AND TarjeNume = '" . $tarjeta ."'";
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND Cuenta = " . $cuenta;
		if (isset($denominacion) && $denominacion != null) {
        $query = $query . " AND TarjeDeno LIKE '%" . $denominacion ."%'";
		}
	} else {
		if (isset($denominacion) && $denominacion != null) {
        $query = $query . " AND TarjeDeno LIKE '%" . $denominacion ."%'";
		}
	}
} else {
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND Cuenta = " . $cuenta;
		if (isset($denominacion) && $denominacion != null) {
        $query = $query . " AND TarjeDeno LIKE '%" . $denominacion ."%'";
		}
	} else{
		if (isset($denominacion) && $denominacion != null) {
        $query = $query . " AND TarjeDeno LIKE '%" . $denominacion ."%'";
		}
	}
}
}


// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);


if($tipo[0] == 'MC'){
	if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_MoraTarjetas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>Cuenta</th>
											<th>Sucursal</th>
											<th>Tarjeta</th>
                                            <th>Nombre</th>
                                            <th>Localidad</th>
                                            <th>Documento Tipo</th>
											<th>Documento</th>
											<th>Fecha Vigencia</th>
											<th>Limite</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['nombre']);
			$localidad = utf8_encode($row['localidad']);
			$fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['cuenta']}</td>
				<td>{$row['sucursal']}</td>
				<td>{$row['tarjeta']}</td>
                <td>{$nombre}</td>
                <td>{$localidad}</td>
                <td>{$row['tipoDocumento']}</td>
				<td>{$row['documento']}</td>
				<td>{$fecha}</td>
				<td>{$row['limite']}</td>
            </tr>";
        }
        $print = $print . "</tbody></table>
        ";
    } else {
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
} else {
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
    echo $query;
}
}else{
	//TABLA DE VISA
	if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_MoraTarjetas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>Cuenta</th>
                                            <th>Tarjeta</th>
                                            <th>Tipo Documento</th>
											<th>Documento</th>
											<th>Nombre</th>
											<th>Nacionalidad</th>
											<th>Vigencia</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['nombre']);
			$fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['Cuenta']}</td>
                <td>{$row['tarjeta']}</td>
                <td>{$row['tipoDocumento']}</td>
                <td>{$row['documento']}</td>
				<td>{$nombre}</td>
				<td>{$row['nacionalidad']}</td>
				<td>{$fecha}</td>
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
    echo $query;
}
}


echo $print;


