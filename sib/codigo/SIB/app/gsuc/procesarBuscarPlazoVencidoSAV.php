<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX

$sucursal = $_POST['sucursal'];
$dias = $_POST['dias'];
$signoDias = $_POST['signoDias'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT * FROM plazoVencidoSAV";

if (isset($sucursal) && $sucursal != null) {
    $query = $query . " WHERE SUCURSAL = ".$sucursal ;
	if (isset($dias) && $dias != null) {
    $query = $query . " AND PLAZODIAS $signoDias " . $dias;
	} 
} else {
	if (isset($dias) && $dias != null) {
    $query = $query . " WHERE PLAZODIAS $signoDias " . $dias;
	} 
}
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
                                            <th>Sucursal</th>
											<th>Titular</th>
                                            <th>Tipo</th>
                                            <th>Numero Inicial</th>
											<th>Numero Final</th>
                                            <th>Fecha Ingreso</th>
                                            <th>Fecha Destruccion</th>
                                            <th>Dias de Atraso</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$tipo = utf8_encode($row['TIPO']);
			$titular = utf8_encode($row['TITULAR']);
            $print = $print . "
                <tr>
                    <td>{$row['SUCURSAL']}</td>
					<td>{$titular}</td>
                    <td>{$tipo}</td>
                    <td>{$row['NROINICIAL']}</td>
					<td>{$row['NROFINAL']}</td>
                    <td>{$row['FECHAINGRESO']}</td>
                    <td>{$row['FECHADESTRUCCION']}</td>
                    <td>{$row['PLAZODIAS']}</td>
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


