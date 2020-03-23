<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX

$cliente = $_POST['cliente'];
$cuit = $_POST['cuit'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS

$query = "select * from openquery(M4000SF,'SELECT DISTINCT REC.RCO_SERVI ENTE,
										MEN.RNO_ENTE NOMBRE,
										MEN.RCOSUBENT SUBE,
										MEN.RNOSUBENT NOMBRECOMPLETO,
										REC.RNU_COMPO NROABONADO,
										REC.RCU_OFICI SUCURSAL,
										REC.RCUNUMCUE CUENTA,
										REC.RCUDIGVER DIGITO,
										MTG.ANO_LARGA ESTADO
		FROM SFB_REREC REC
		LEFT JOIN SFB_BSADO ADO ON ADO.SCO_IDENT = REC.SCO_IDENT
		LEFT JOIN SFB_REMEN MEN ON MEN.RCO_SERVI = REC.RCO_SERVI
		LEFT JOIN SFB_BSMTG MTG ON MTG.ACO_CODIG = LPAD(REC.RCOESTSER,2,0) AND MTG.ACO_TABLA = ''CODESTSERV''";	

if (isset($cliente) && $cliente != null) {
    $query .= " WHERE ADO.SCO_IDENT = {$cliente}";
	if (isset($cuit) && $cuit != null) {
		$query .= " AND ADO.SNU_DOCUM = {$cuit}";
	}
} else {
	if (isset($cuit) && $cuit != null) {
		$query .= " WHERE ADO.SNU_DOCUM = {$cuit}";
	} else {
		$query = "select TOP 200 * from openquery(M4000SF,'SELECT REC.RCO_SERVI ENTE,
										MEN.RNO_ENTE NOMBRE,
										MEN.RCOSUBENT SUBE,
										MEN.RNOSUBENT NOMBRECOMPLETO,
										REC.RNU_COMPO NROABONADO,
										REC.RCU_OFICI SUCURSAL,
										REC.RCUNUMCUE CUENTA,
										REC.RCUDIGVER DIGITO,
										MTG.ANO_LARGA ESTADO
				FROM SFB_REREC REC
				LEFT JOIN SFB_BSADO ADO ON ADO.SCO_IDENT = REC.SCO_IDENT
				LEFT JOIN SFB_REMEN MEN ON MEN.RCO_SERVI = REC.RCO_SERVI
				LEFT JOIN SFB_BSMTG MTG ON MTG.ACO_CODIG = LPAD(REC.RCOESTSER,2,0) AND MTG.ACO_TABLA = ''CODESTSERV''";
	}
} 

$query .= "')";

// SE EJECUTA LA CONSULTA

$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$_SESSION['buscar'] = $query;

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_canje' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Ente</th>
											<th>Nombre</th>
											<th>Sub-E</th>
											<th>Nombre Completo</th>
											<th>Nro Abonado</th>
											<th>Sucursal</th>
											<th>Cuenta</th>
											<th>Digito</th>
											<th>Estado</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['NOMBRE']);
			$nombreCompleto = utf8_encode($row['NOMBRECOMPLETO']);
            $print = $print . "
                <tr>
                <td>{$row['ENTE']}</td>
                <td>{$nombre}</td>    
                <td>{$row['SUBE']}</td>
                <td>{$nombreCompleto}</td>
				<td>{$row['NROABONADO']}</td>
				<td>{$row['SUCURSAL']}</td>
				<td>{$row['CUENTA']}</td>
				<td>{$row['DIGITO']}</td>
				<td>{$row['ESTADO']}</td>
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


