<?php

include_once '/conf/BDConexion.php';

$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$fecha = $_POST['fecha'];


$fecha = date("d/m/y", strtotime($fecha));
$fecha = str_replace("/","",$fecha);


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select *, (SALDO_HOY-CREDITO + DEBITO) CAL1, (SALDO_HOY - DEBITO + CREDITO) CAL2
from openquery(M4000SF,'SELECT (CCU_OFICI||''-''||CCUNUMCUE||''/''||CCUDIGVER) CUENTA, 
                                               MOL.CSATOTAYE SALDO_AYER, 
                                               MOL.CSATOTHOY SALDO_HOY, 
                                               (CASE WHEN DEB.DEBITO IS NULL THEN 0 ELSE DEB.DEBITO END) DEBITO,
                                               (CASE WHEN CRE.CREDITO IS NULL THEN 0 ELSE CRE.CREDITO END) CREDITO
                                        FROM SFB_ACMOL MOL
                                        LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) debito
                                                      FROM SFB_ACAHI 
                                                      WHERE ARE_VALOR > (to_date(lpad(''".$fecha."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 1 AND (ACU_OFICI||ACUNUMCUE||ACUDIGVER) IN 
                                                      (17232078, 12094286, 12094293, 12761283, 12761290, 12925667, 12925674, 13047876,
                                                            13214427, 13214434, 13338510, 13338534, 13493914, 13493921, 13493938, 13493945, 
                                                            13493952, 12978234)
                                                      GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) DEB ON DEB.cuenta = (CCU_OFICI||CCUNUMCUE||CCUDIGVER)
                                        LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) credito
                                                      FROM SFB_ACAHI 
                                                      WHERE ARE_VALOR > (to_date(lpad(''".$fecha."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 2 AND (ACU_OFICI||ACUNUMCUE||ACUDIGVER) IN 
                                                      (17232078, 12094286, 12094293, 12761283, 12761290, 12925667, 12925674, 13047876,
                                                            13214427, 13214434, 13338510, 13338534, 13493914, 13493921, 13493938, 13493945, 
                                                            13493952, 12978234)
                                                      GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) CRE ON CRE.CUENTA = (CCU_OFICI||CCUNUMCUE||CCUDIGVER)
                                        WHERE (CCU_OFICI||CCUNUMCUE||CCUDIGVER) IN 
                                        (17232078, 12094286, 12094293, 12761283, 12761290, 12925667, 12925674, 13047876,
                                        13214427, 13214434, 13338510, 13338534, 13493914, 13493921, 13493938, 13493945, 
                                        13493952, 12978234) ')
 ";


// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);



if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th>Cuenta</th>
                                            <th>Saldo Ayer</th>
                                            <th>Saldo Hoy</th>
                                            <th>Debito</th>
                                            <th>Credito</th>
                                            <th>CAL1</th>
                                            <th>CAL2</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $print = $print . "
            <tr>
                <td>{$row['CUENTA']}</td>
                <td>{$row['SALDO_AYER']}</td>
                <td>{$row['SALDO_HOY']}</td>
                <td>{$row['DEBITO']}</td>
                <td>{$row['CREDITO']}</td>
                <td>{$row['CAL1']}</td>
                <td>{$row['CAL2']}</td>
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


