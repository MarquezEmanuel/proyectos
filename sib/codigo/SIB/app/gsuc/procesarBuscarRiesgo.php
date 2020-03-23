<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$sucursal = $_POST['sucursal'];
$cuil = $_POST['cuil'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];

$desde = date("d/m/y", strtotime($desde));
$desde = str_replace("/","",$desde);
$hasta = date("d/m/y", strtotime($hasta));
$hasta = str_replace("/","",$hasta);

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select * from openquery(M4000SF,'SELECT MCL.SCO_IDENT CODCLIENTE,
                                                                   MCL.SNO_CLIEN NOMCLIENTE,
                                                                   ADO.SNU_DOCUM CUIL,
                                                                   SUBSTR(ADO.SNU_DOCUM, 3, 8) DOCUMENTO,
                                                                   MCL.CCOEJECUE OFICIAL,
                                                                   MTG.ANO_LARGA ESTADO,
                                                                   ''NO INFORMADO'' RIESGO,
                                                                   TO_CHAR ( TO_DATE ( LPAD(MCL.SFE_ALTA, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHAALTA,
																   MCL.SCOOFIORI SUCURSAL
                                                      FROM SFB_BSMCL MCL
                                                      INNER JOIN SFB_BSADO ADO ON ADO.SCO_IDENT = MCL.SCO_IDENT AND ADO.SCOTIPDOC IN (34, 35)
                                                      INNER JOIN SFB_BSMTG MTG ON MTG.ACO_CODIG = LPAD(MCL.SCOESTPER, 2, 0) AND ACO_TABLA = ''ESTCLIEN'' AND ACO_CODIG <> '' ''
                                                      WHERE MCL.SSERIESGO = ''9'' AND
													  (to_date(lpad(MCL.SFE_ALTA, 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) between (to_date(lpad(''".$desde."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
													  and (to_date(lpad(''".$hasta."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
													  ')";

if (isset($sucursal) && $sucursal != null) {
    $query = $query . " WHERE SUCURSAL = " . $sucursal;
    if (isset($cuil) && $cuil != null) {
        $query = $query . " AND CUIL = " . $cuil;
    }
} else {
     if (isset($cuil) && $cuil != null) {
        $query = $query . " WHERE CUIL = " . $cuil;
    }
}
// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$_SESSION['buscar'] = $query;

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_incorrecta' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Codigo de Cliente</th>
											<th>Nombre de Cliente</th>
											<th>CUIT-CUIL</th>
											<th>Documento</th>
											<th>Oficial</th>
											<th>Estado</th>
											<th>Riesgo</th>
											<th>Fecha de Alta</th>
											<th>Sucursal</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($row['NOMCLIENTE']);
                $print = $print . "
                    <tr>
                    <td>{$row['CODCLIENTE']}</td>
                    <td>{$nombre}</td>    
                    <td>{$row['CUIL']}</td>
                    <td>{$row['DOCUMENTO']}</td>
                    <td>{$row['OFICIAL']}</td>
					<td>{$row['ESTADO']}</td>
					<td>{$row['RIESGO']}</td>
					<td>{$row['FECHAALTA']}</td>
					<td>{$row['SUCURSAL']}</td>
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

