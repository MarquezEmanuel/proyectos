<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";
$cuis = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cuil = $_POST['cuil'];
$nombre = $_POST['nombre'];


$clientes = "select cuit from [8empleadosBanco]";
$cuits = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $clientes);
 while ($row = sqlsrv_fetch_array($cuits, SQLSRV_FETCH_ASSOC)) {
            $cuis = $cuis . "{$row['cuit']},";
        }
$cuis = trim($cuis, ',');

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select TIPODOC,
          CUIT2,
		  CUIT,
          CODCLIENTE,
          NOMCLIENTE,
          TIPO,
          PRODUCTO,
          MONEDA,
          SUCURSAL,
          CUENTA,
          DIGITO
from openquery(M4000SF, 'SELECT ADO.SCOTIPDOC TIPODOC,
                                                      ADO.SNU_DOCUM CUIT,
                                                      SUBSTR(ADO.SNU_DOCUM, 1, 2) ||''-''|| SUBSTR(ADO.SNU_DOCUM, 3,8)||''-''||SUBSTR(ADO.SNU_DOCUM, 11, 1) CUIT2,
                                                      ADO.SCO_IDENT CODCLIENTE,
                                                      MCL.SNO_CLIEN NOMCLIENTE,
                                                      MCL.ASE_PRIVA TIPO,
                                                      MOL.HCU_PRODU PRODUCTO,
                                                      MOL.HCU_MONED MONEDA,
                                                      MOL.HCU_OFICI SUCURSAL,
                                                      MOL.HCUNUMCUE CUENTA,
                                                      MOL.HCUDIGVER DIGITO
                                        FROM SFB_BSADO ADO
                                        INNER JOIN SFB_BSMCL MCL ON MCL.SCO_IDENT = ADO.SCO_IDENT
                                        INNER JOIN SFB_AHMOL MOL ON MOL.SCO_IDENT = ADO.SCO_IDENT AND MOL.HCOESTCUE = 1
                                        WHERE ADO.SCOTIPDOC IN (34, 35) AND
										ADO.SNU_DOCUM in(".$cuis.")
										')";


if (isset($cuil) && $cuil != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE CUIT = " . $cuil . "";
    if (isset($nombre) && $nombre != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND NOMCLIENTE LIKE '%" . $nombre . "%'";
    } 
} else {				
    //no tiene cuenta
    if (isset($nombre) && $nombre != null) {
        //si tiene sucursal agrega en and
        $query = $query . " WHERE NOMCLIENTE LIKE '%" . $nombre . "%'";
    } 
}

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$_SESSION['buscar'] = $query;


if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>CUIL</th>
											<th>Cod Cliente</th>
                                            <th>Nombre y Apellido</th>
                                            <th>Tipo</th>
											<th>Producto</th>
											<th>Moneda</th>
											<th>Sucursal</th>
											<th>Cuenta</th>
											<th>Digito</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['NOMCLIENTE']);
            $print = $print . "
            <tr>
                <td>{$row['CUIT2']}</td>
				<td>{$row['CODCLIENTE']}</td>
                <td>{$nombre}</td>
				<td>{$row['TIPO']}</td>
				<td>{$row['PRODUCTO']}</td>
				<td>{$row['MONEDA']}</td>
				<td>{$row['SUCURSAL']}</td>
				<td>{$row['CUENTA']}</td>
				<td>{$row['DIGITO']}</td>
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

echo $print;


