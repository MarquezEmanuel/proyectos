<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$desde = $_POST['desde'];

$desde = date("d-m-Y", strtotime($desde));

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select ACO_TRANS TRANSACCION, ACO_CAUSA CAUSAL, ACU_OFICI SUCURSAL, ACUNUMCUE CUENTA, ACUDIGVER DIGITO,
AFE_TRANS FECHA, convert(varchar,cast(TVA_MOVIM as money),1) AS MONTO from openquery(M4000SF,'select * from SFB_AAAML WHERE ANO_PROCE = ''".$desde."-PMDEB-SIB.txt'' AND TCO_ERROR = ''OK''')";

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);


if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th>Transaccion</th>
                                            <th>Causal</th>
                                            <th>Sucursal</th>
                                            <th>Cuenta</th>
                                            <th>Digito</th>
                                            <th>Fecha Proceso</th>
                                            <th>Monto</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $print = $print . "
            <tr>
                <td>{$row['TRANSACCION']}</td>
                <td>{$row['CAUSAL']}</td>
                <td>{$row['SUCURSAL']}</td>
                <td>{$row['CUENTA']}</td>
                <td>{$row['DIGITO']}</td>
                <td>{$row['FECHA']}</td>
				<td>{$row['MONTO']}</td>
            </tr>";
        }
        $print = $print . "</tbody></table>
        ";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para la fecha ingresada</div>';
    }
} else {
    // OCURRIO UN ERROR 
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
    echo $query;
}

echo $print;


