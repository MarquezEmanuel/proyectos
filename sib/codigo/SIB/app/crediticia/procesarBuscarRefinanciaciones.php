<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$cuil = $_POST['CUIL'];
$plazo = $_POST['plazo'];
$signoPlazo = $_POST['signoPlazo'];

$desde = date("d/m/y", strtotime($desde));
$desde = str_replace("/","",$desde);
$hasta = date("d/m/y", strtotime($hasta));
$hasta = str_replace("/","",$hasta);


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select *,convert(varchar,cast(importe as money),1) AS importe2 from openquery(M4000SF,'
select 
a.GLB_DTIME ID,
a.sco_ident NROCLI, 
b.snu_docum CUIL, 
c.snu_docum DOC, 
d.sno_clien DENOMINACION, 
a.pcu_produ PRODUCTO,
a.pcu_moned MONEDA,
a.pcu_ofici SUC,
a.pcunumcue CTA,
a.pfe_liqui FEC_LIQ,
a.pva_credi IMPORTE,
a.pcn_cuota PLAZO,
a.ppo_tna TNA,
case e.acu_produ
when 2 then ''VISA''
when 3 then ''MC''
else ''N/A'' end MARCA,
e.acu_ofici SUC_TC,
e.tnucuenta CTA_TC ,
e.tnu_tarje NRO_TC
from sfb_ppmap a 
left join (select sco_ident, snu_docum from sfb_bsado where scotipdoc in (30,34,35))b on a.sco_ident = b.sco_ident
left join (select sco_ident, snu_docum from sfb_bsado where scotipdoc not in (30,34,35))c on a.sco_ident = c.sco_ident
left join (select sco_ident, sno_clien from sfb_bsmcl)d on a.sco_ident = d.sco_ident 
left join (select sco_ident, acu_ofici,tnu_tarje, tnucuenta, acu_produ from sfb_bsmot where aco_conce=25)e on a.sco_ident = e.sco_ident
where 
a.pcu_produ in (692, 929, 930, 931, 932, 933, 978, 979) 
and a.pcu_moned=80
and a.pre_liqui between 
 (to_date(lpad(''".$desde."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and (to_date(lpad(''".$hasta."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
')
 ";

if (isset($cuil) && $cuil != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE CUIL = " . $cuil;
        if (isset($plazo) && $plazo != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " AND PLAZO $signoPlazo " . $plazo;
            }
}else{
	if (isset($plazo) && $plazo != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " WHERE PLAZO $signoPlazo " . $plazo;
            }
}

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$_SESSION['buscar'] = $query;
$_SESSION['desde'] = $desde;
$_SESSION['hasta'] = $hasta;


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
                                            <th style='display:none;'>Numero de Cliente</th>
                                            <th style='display:none;'>CUIL</th>
                                            <th style='display:none;'>Documento</th>
                                            <th style='display:none;'>Denominacion</th>
                                            <th>Producto</th>
                                            <th style='display:none;'>Moneda</th>
                                            <th>Sucursal</th>
                                            <th>Numero de Cuenta</th>
                                            <th style='display:none;'>Fecha de Liquidacion</th>
                                            <th>Importe</th>
                                            <th>Plazo</th>
                                            <th>TNA</th>
                                            <th style='display:none;'>Marca</th>
                                            <th style='display:none;'>Sucursal de Tarjeta</th>
                                            <th style='display:none;'>Cuenta de Tarjeta</th>
                                            <th style='display:none;'>Numero de Tarjeta</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['NROCLI']}</td>
                <td style='display:none;'>{$row['CUIL']}</td>
                <td style='display:none;'>{$row['DOC']}</td>
                <td style='display:none;'>{$row['DENOMINACION']}</td>
                <td>{$row['PRODUCTO']}</td>
                <td style='display:none;'>{$row['MONEDA']}</td>
                <td>{$row['SUC']}</td>
                <td>{$row['CTA']}</td>
                <td style='display:none;'>{$row['FEC_LIQ']}</td>
                <td>{$row['importe2']}</td>
                <td>{$row['PLAZO']}</td>
                <td>{$row['TNA']}</td>
                <td style='display:none;'>{$row['MARCA']}</td>
                <td style='display:none;'>{$row['SUC_TC']}</td>
                <td style='display:none;'>{$row['CTA_TC']}</td>
                <td style='display:none;'>{$row['NRO_TC']}</td>
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


