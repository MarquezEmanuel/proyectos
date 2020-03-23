<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$estado = $_POST['estado'];
$cuenta = $_POST['cuenta'];
$tipo = $_POST['tipo'];
$sucursal = $_POST['sucursal'];
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
	   docu_tipo tipoDocumento,
	   docu_nume documento,
	   alta_fecha fechaAlta,
	   naci_fecha nacimiento
  FROM [192.168.250.133].[Smartopen].[dbo].[CredenSocios] where SucurCodi != 0 AND $esta";
  
  if (isset($sucursal) && $sucursal != null) {
    $query = $query . " AND SucurCodi = " . $sucursal;
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
		$esta = "cuentaEsta = 10";
	}else{
		$esta = "cuentaEsta = 19";
	}
	$query = "SELECT Cuenta2nume cuenta,
	   SucurCodi sucursal,
	   Veri2Nume digito,
	   LocaNombre localidad,
	   BancaCuentaTipo tipoCuenta,
	   CuentaDeno nombre,
	   AltaFecha alta,
	   CuitNume cuit
  FROM [192.168.250.133].[Smartopen].[dbo].[VisaSocios] where $esta";
  
  if (isset($sucursal) && $sucursal != null) {
    $query = $query . " AND SucurCodi = " . $sucursal;
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND Cuenta2nume = " . $cuenta;
		if (isset($denominacion) && $denominacion != null) {
        $query = $query . " AND CuentaDeno LIKE '%" . $denominacion ."%'";
		}
	} else {
		if (isset($denominacion) && $denominacion != null) {
        $query = $query . " AND CuentaDeno LIKE '%" . $denominacion ."%'";
		}
	}
} else {
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND Cuenta2nume = " . $cuenta;
		if (isset($denominacion) && $denominacion != null) {
        $query = $query . " AND CuentaDeno LIKE '%" . $denominacion ."%'";
		}
	} else{
		if (isset($denominacion) && $denominacion != null) {
        $query = $query . " AND CuentaDeno LIKE '%" . $denominacion ."%'";
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
											<th>Fecha Alta</th>
											<th>Fecha Nacimiento</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['nombre']);
			$localidad = utf8_encode($row['localidad']);
			$fecha = isset($row['fechaAlta']) ? $row['fechaAlta']->format('d/m/Y') : "";
			$nacimiento = isset($row['nacimiento']) ? $row['nacimiento']->format('d/m/Y') : "";
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
				<td>{$nacimiento}</td>
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
                                            <th>Sucursal</th>
                                            <th>Cuenta</th>
                                            <th>Digito</th>
                                            <th>Localidad</th>
											<th>Tipo Cuenta</th>
											<th>Nombre</th>
											<th>Fecha Alta</th>
											<th>CUIT</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['nombre']);
			$alta = isset($row['alta']) ? $row['alta']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['sucursal']}</td>
                <td>{$row['cuenta']}</td>
                <td>{$row['digito']}</td>
                <td>{$row['localidad']}</td>
				<td>{$row['tipoCuenta']}</td>
				<td>{$nombre}</td>
				<td>{$alta}</td>
				<td>{$row['cuit']}</td>
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


