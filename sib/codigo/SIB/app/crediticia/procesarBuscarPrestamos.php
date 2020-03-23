<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$sucursal = $_POST['sucursal'];
$prestamos = $_POST['prestamos'];
$signoPrestamos = $_POST['signoPrestamos'];
$tarjeta = $_POST['tarjeta'];

$desde = date("d/m/y", strtotime($desde));
$desde = str_replace("/","",$desde);
$hasta = date("d/m/y", strtotime($hasta));
$hasta = str_replace("/","",$hasta);

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select *, convert(varchar,cast(CAPITAL as money),1) AS CAPITAL2, convert(varchar,cast(SALDO_ACTUAL as money),1) AS SALDO_ACTUAL2,
convert(varchar,cast(CAPITAL_SOLICITADO as money),1) AS CAPITAL_SOLICITADO2, convert(varchar,cast(CAPITAL_A_PAGAR as money),1) AS CAPITAL_A_PAGAR2,
convert(varchar,cast(SALDO_MINIMO as money),1) AS SALDO_MINIMO2
 from openquery(M4000SF,'SELECT DISTINCT
CASE MOT.ACU_PRODU
WHEN 2 THEN ''VISA''
WHEN 3 THEN ''MASTER''
END TIPO,
MOT.TNUCUENTA,     
MOT.TNU_TARJE,
MOT.SCO_IDENT,
MOT.SSAOTRCU1 SALDO_ACTUAL,
MOT.SSAOTRCU2 SALDO_MINIMO,
MAP.PCU_OFICI SUCURSAL,
MAP.CAPITAL,
MAP.PRESTAMOS,
MAP.CAPITAL_A_PAGAR,
MAP.CAPITAL_SOLICITADO
FROM SFB_BSMOT MOT
INNER JOIN (
select count(SCO_IDENT) PRESTAMOS,
	SCO_IDENT,
	sum(PSUCAREAL) CAPITAL,
   sum(psacaprea) CAPITAL_A_PAGAR,
   sum(pva_solic) CAPITAL_SOLICITADO,
   max(PCU_OFICI) PCU_OFICI
   from SFB_PPMAP
   where PCU_PRODU NOT IN (590,935,936)
   group by SCO_IDENT
) MAP ON MOT.SCO_IDENT = MAP.SCO_IDENT
WHERE MOT.ACO_CONCE = 25 AND MOT.ACU_PRODU IN (2, 3) AND MOT.TNUCUENTA <> 0') 
 ";

if (isset($sucursal) && $sucursal != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE SUCURSAL = " . $sucursal;
        if (isset($prestamos) && $prestamos != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " AND PRESTAMOS $signoPrestamos" . $prestamos;
			if (isset($tarjeta) && $tarjeta != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " AND TIPO LIKE '%" . $tarjeta ."%'";
            } 
            } else{
				if (isset($tarjeta) && $tarjeta != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " AND TIPO LIKE '%" . $tarjeta ."%'";
            }
			}
}else{
	if (isset($prestamos) && $prestamos != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " WHERE PRESTAMOS $signoPrestamos" . $prestamos;
			if (isset($tarjeta) && $tarjeta != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " AND TIPO LIKE '%" . $tarjeta ."%'";
            }
            } 
		else{
				if (isset($tarjeta) && $tarjeta != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " WHERE TIPO LIKE '%" . $tarjeta ."%'";
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
                                            <th>Tipo</th>
                                            <th>Numero Cuenta</th>
                                            <th>Numero de Tarjeta</th>
                                            <th>Codigo de Cliente</th>
                                            <th>Saldo Actual</th>
                                            <th>Saldo Minimo</th>
											<th style='display:none;'>Capital</th>
											<th style='display:none;'>Prestamos</th>
                                            <th style='display:none;'>Capital a Pagar</th>
                                            <th style='display:none;'>Capital Solicitado</th>
											<th style='display:none;'>Sucursal</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
		$fila = 0;
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $print = $print . "
            <tr id='{$fila}'>
                <td>{$row['TIPO']}</td>
                <td>{$row['TNUCUENTA']}</td>
                <td>{$row['TNU_TARJE']}</td>
                <td>{$row['SCO_IDENT']}</td>
                <td>{$row['SALDO_ACTUAL2']}</td>
                <td>{$row['SALDO_MINIMO2']}</td>
                <td style='display:none;'>{$row['CAPITAL2']}</td>
                <td style='display:none;'>{$row['PRESTAMOS']}</td>
                <td style='display:none;'>{$row['CAPITAL_A_PAGAR2']}</td>
                <td style='display:none;'>{$row['CAPITAL_SOLICITADO2']}</td>
				<td style='display:none;'>{$row['SUCURSAL']}</td>
                <td class='text-center' title='Ver detalles de la cobranza'>
                    <button class='btn btn-sm btn-outline-info detalleChequePagado' name='{$fila}'> 
                        <img src='/lib/img/SHOW.png' class='detallesCobranzasTC' name='' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
			$fila++;
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


