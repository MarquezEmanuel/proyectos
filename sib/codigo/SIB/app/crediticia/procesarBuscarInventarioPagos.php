<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$sucursal = $_POST['sucursal'];
$producto = $_POST['producto'];
$estudio = $_POST['estudio'];
$deuda = $_POST['plazo'];
$signoDeuda = $_POST['signoPlazo'];


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select *, convert(varchar,cast(SDO_CAP as money),1) AS SDO_CAP2, convert(varchar,cast(DEUDA_TOTAL as money),1) AS DEUDA_TOTAL2 from openquery(M4000SF,'SELECT MAP.GLB_DTIME ID,
									   AEE.PNUENTEXT AS ALTA_ESTUDIO,
									   AEE.PCU_OFICI AS SUC,
									   AEE.PCUNUMCUE AS CUENTA,
									   AEE.PCU_PRODU AS PROD,
									   AEE.PCU_MONED AS MON,
									   MPR.ANO_PRODU AS NOMBRE_PROD,
									   AEE.PCOENTEXT AS ESTUDIO,
									   MCL.SNO_CLIEN AS NOMBRE,
									   ADO.SNU_DOCUM AS CUIL,
									   MAP.PSACAPREA AS SDO_CAP,
									   MAP.PSA_REAL AS DEUDA_TOTAL,
									   AEE.PNUENTEXT AS FECHA_ETAPA
								FROM SFB_PPAEE AEE
								INNER JOIN SFB_PPMAP MAP ON AEE.PCUNUMCUE = MAP.PCUNUMCUE AND 
															AEE.PCU_OFICI = MAP.PCU_OFICI AND
															MAP.PCOESTCUE = 1
								INNER JOIN SFB_BSADO ADO ON MAP.SCO_IDENT = ADO.SCO_IDENT AND
															ADO.SCOTIPDOC IN (34,35)
								INNER JOIN SFB_BSMCL MCL ON MAP.SCO_IDENT = MCL.SCO_IDENT
								INNER JOIN SFB_AAMPR MPR ON AEE.PCU_PRODU = MPR.ACO_PRODU AND
															AEE.PCU_MONED = MPR.DCO_MONED AND
															MPR.ACO_CONCE = 6
								WHERE AEE.PCOENTEXT IN (18, 19, 20, 22, 23, 24, 107, 108, 109, 112, 113, 114, 115, 116, 117)')
 ";

if (isset($sucursal) && $sucursal != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE SUC = " . $sucursal;
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " AND PROD = " . $producto;
				if (isset($estudio) && $estudio != null) {
				//si tiene sucursal y tipo debito y saldo y minimo agrega en and
				$query = $query . " AND ESTUDIO = " . $estudio;
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DEUDA_TOTAL $signoDeuda " . $deuda;
					}
				} else{
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DEUDA_TOTAL $signoDeuda " . $deuda;
					}
				}
            } else{
				if (isset($estudio) && $estudio != null) {
				//si tiene sucursal y tipo debito y saldo y minimo agrega en and
				$query = $query . " AND ESTUDIO = " . $estudio;
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DEUDA_TOTAL $signoDeuda " . $deuda;
					}
				} else{
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DEUDA_TOTAL $signoDeuda " . $deuda;
					}
				}
			}
}else{
	if (isset($producto) && $producto != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " WHERE PROD = " . $producto;
				if (isset($estudio) && $estudio != null) {
				//si tiene sucursal y tipo debito y saldo y minimo agrega en and
				$query = $query . " AND ESTUDIO = " . $estudio;
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DEUDA_TOTAL $signoDeuda " . $deuda;
					}
				} else{
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DEUDA_TOTAL $signoDeuda " . $deuda;
					}
				}
            } else{
				if (isset($estudio) && $estudio != null) {
				//si tiene sucursal y tipo debito y saldo y minimo agrega en and
				$query = $query . " WHERE ESTUDIO = " . $estudio;
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DEUDA_TOTAL $signoDeuda " . $deuda;
					}
				} else{
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " WHERE DEUDA_TOTAL $signoDeuda " . $deuda;
					}
				}
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
                                    <colgroup>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th>Fecha de Alta</th>
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th>Producto</th>
                                            <th style='display:none;'>Moneda</th>
                                            <th style='display:none;'>Nombre de Producto</th>
                                            <th>Estudio</th>
                                            <th style='display:none;'>Nombre</th>
                                            <th style='display:none;'>CUIL</th>
                                            <th>Saldo Capital</th>
                                            <th>Deuda Total</th>
                                            <th>Fecha Etapa</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombreProd = utf8_encode($row['NOMBRE_PROD']);
			$nombre = utf8_encode($row['NOMBRE']);
            $print = $print . "
            <tr>
                <td>{$row['ALTA_ESTUDIO']}</td>
                <td style='display:none;'>{$row['SUC']}</td>
                <td style='display:none;'>{$row['CUENTA']}</td>
                <td>{$row['PROD']}</td>
                <td style='display:none;'>{$row['MON']}</td>
                <td style='display:none;'>{$nombreProd}</td>
                <td>{$row['ESTUDIO']}</td>
                <td style='display:none;'>{$nombre}</td>
                <td style='display:none;'>{$row['CUIL']}</td>
                <td>{$row['SDO_CAP2']}</td>
                <td>{$row['DEUDA_TOTAL2']}</td>
                <td>{$row['FECHA_ETAPA']}</td>
                <td class='text-center' title='Ver detalles de la cobranza'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesCobranzasTC' name='{$row['ID']}' width='18' height='18' > 
                    </button>
                </td>
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


