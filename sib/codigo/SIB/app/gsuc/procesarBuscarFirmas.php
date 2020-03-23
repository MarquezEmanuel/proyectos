<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];

$desde = date("d/m/Y", strtotime($desde));
$desde = str_replace("/","-",$desde);
$hasta = date("d/m/Y", strtotime($hasta));
$hasta = str_replace("/","-",$hasta);

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT  [nombreTramite] ,count(nombreTramite) cantidad FROM (select * from[bd_sib].[dbo].[3tramitesFirmaGrafometrica] WHERE fechaAlta between '".$desde."' and '".$hasta."') DOS
    GROUP BY nombreTramite ORDER BY cantidad desc";

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 75%'/>
                                        <col style='width: 25%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th>Nombre de Tramite</th>
                                            <th>Cantidad</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['nombreTramite']);
            $print = $print . "
            <tr>
                <td>{$nombre}</td>
                <td>{$row['cantidad']}</td>
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


