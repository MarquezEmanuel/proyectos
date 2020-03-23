<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$sucursal = $_POST['sucursal'];
$nombre = $_POST['nombre'];
$fecha = $_POST['fecha'];

if (isset($fecha) && $fecha != null) {
    $fechaInicio = date("d/m/Y", strtotime($fecha));
    $fechaInicio = $fechaInicio . " 00:00:00";
}
if (isset($fecha) && $fecha != null) {
    $fechaFin = date("d/m/Y", strtotime($fecha));
    $fechaFin = $fechaFin . " 23:59:00";
}

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select * from openquery([BSCBASES3], 'SELECT marcacodi,
                                                                          argencomernume,
                                                                        entinume,
                                                                          bancocodi,
                                                                          sucurcodi,
                                                                          argencomerfantanombre,
                                                                          argencomerestacentralnume,
                                                                          argencomerrazon,
                                                                          argencomercalle,
                                                                          argencomerpuertanume,
                                                                          argencomerpiso,
                                                                          argencomerpostalcodi,
                                                                          argencomerloca,
                                                                          provincodi,
                                                                          zonacodi,
                                                                          argencomertele,
                                                                          ramoscodi,
                                                                          ArgenComerPagoPlazo,
                                                                          argencomerdescuenporce,
                                                                          (CASE WHEN argencomercuotasplan = ''S'' THEN ''Opera con Plan Cuotas con cobro anticipado'' 
                                                                                    WHEN argencomercuotasplan = ''N'' THEN ''Opera con Plan Cuotas tradicional con financiacion del comercio'' 
                                                                                    ELSE ''''
                                                                          END) argencomercuotasplan,
                                                                          argencomersiccode,
                                                                          argencomerventalimi,
                                                                          argencomerbrutosingrenume,
                                                                          argencomercuitnume,
                                                                          brutosingrecondicodi,
                                                                          argencomeraltafecha,
                                                                          argencomerbajafecha,
                                                                          argencomerprocefecha,
                                                                          usuacodi,
                                                                          ArgenComerPagoPlazoNvo,
                                                                          ArgenComerPagoPlazoNvoVig,
                                                                          (CASE WHEN ArgenComerValeTipo = 0 THEN ''No opera con vales'' 
                                                                                    WHEN ArgenComerValeTipo IS NULL THEN ''''
                                                                                    ELSE CAST(ArgenComerValeTipo AS NVARCHAR)
                                                                          END) ArgenComerValeTipo,
                                                                          (CASE WHEN ArgenComerPagoPlazoTipo = ''H'' THEN ''Dias habiles'' 
                                                                                    WHEN ArgenComerPagoPlazoTipo = ''R'' THEN ''Dias corridos''
                                                                                    WHEN ArgenComerPagoPlazoTipo = ''C'' THEN ''Ciclos''
                                                                                    ELSE ''''
                                                                          END) ArgenComerPagoPlazoTipo,
                                                                          (CASE WHEN ArgenComerPagoPlazoTipoNvo = ''H'' THEN ''Dias habiles'' 
                                                                                    WHEN ArgenComerPagoPlazoTipoNvo = ''R'' THEN ''Dias corridos''
                                                                                    WHEN ArgenComerPagoPlazoTipoNvo = ''C'' THEN ''Ciclos''
                                                                                    ELSE CAST(ArgenComerPagoPlazoTipoNvo AS NVARCHAR)
                                                                          END) ArgenComerPagoPlazoTipoNvo,
                                                                          (CASE WHEN ArgenComerIVACate = 1 THEN ''Responsable inscripto''
                                                                                    WHEN ArgenComerIVACate = 2 THEN ''Sujeto no categorizado''
                                                                                    WHEN ArgenComerIVACate = 3 THEN ''Excento''
                                                                                    WHEN ArgenComerIVACate = 7 THEN ''No responsable''
                                                                                    WHEN ArgenComerIVACate = 8 THEN ''Monotributista''
                                                                                    WHEN ArgenComerIVACate = 9 THEN ''Responsable no inscripto''
                                                                                    ELSE CAST(ArgenComerIVACate AS NVARCHAR)
                                                                          END) ArgenComerIVACate,
                                                                          ArgenComerExcep,
                                                                          (CASE WHEN ArgenComerMaestroMarca = 0 THEN ''No esta adherido a tarjeta maestro''
                                                                                    WHEN ArgenComerMaestroMarca = 1 THEN ''Si esta adherido a tarjeta maestro pesos''
                                                                          END) ArgenComerMaestroMarca,
                                                                          (CASE WHEN ArgenComerPos = 0 THEN ''No opera con terminal de venta POS''
                                                                                    WHEN ArgenComerPos = 1 THEN ''Opera con terminal de venta POS''
                                                                                    ELSE CAST(ArgenComerPos AS NVARCHAR)
                                                                          END) ArgenComerPos
                                                              FROM [SmartOpen].[dbo].[ArgenComer]')
 ";

if (isset($sucursal) && $sucursal != null) {
    //si tiene documento empieza el where
    $query = $query . " WHERE sucurcodi = " . $sucursal;
    if (isset($nombre) && $nombre != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND argencomerrazon LIKE '%" . $nombre ."%'";
        if (isset($fecha) && $fecha != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . "AND argencomeraltafecha between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        } 
    } else {
        //no tiene sucursal
        if (isset($fecha) && $fecha != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . "AND argencomeraltafecha between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        } 
    }
} else {
    //no tiene documento
    if (isset($nombre) && $nombre != null) {
        //si tiene sucursal agrega en and
        $query = $query . " WHERE argencomerrazon LIKE '%" . $nombre ."%'";
        if (isset($fecha) && $fecha != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . "AND argencomeraltafecha between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        } 
    } else {
        //no tiene sucursal
        if (isset($fecha) && $fecha != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . "WHERE argencomeraltafecha between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
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
        <table id='tb_buscar_MoraTarjetas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th style='display:none;'>Entidad</th>
                                            <th>Sucursal</th>
                                            <th>Nro Comercio</th>
                                            <th style='display:none;'>Nro Establecimiento</th>
                                            <th style='display:none;'>Nombre</th>
                                            <th>Razon social</th>
                                            <th style='display:none;'>Domicilio</th>
                                            <th style='display:none;'>Nro</th>
                                            <th style='display:none;'>Piso</th>
                                            <th style='display:none;'>CP</th>
                                            <th>Localidad</th>
                                            <th style='display:none;'>Provincia</th>
                                            <th style='display:none;'>Codigo de zona</th>
                                            <th style='display:none;'>Telefono</th>
                                            <th style='display:none;'>Plazo pago</th>
											<th style='display:none;'>Liq Anticipada</th>
											<th style='display:none;'>Ramo</th>
											<th style='display:none;'>Ramo MWW</th>
											<th style='display:none;'>Limite Vta</th>
											<th style='display:none;'>Nro Insc IIBB</th>
											<th>CUIT</th>
											<th style='display:none;'>MCA EXPC IIBB</th>
											<th>Fec alta COM</th>
											<th style='display:none;'>Fec baja COM</th>
											<th style='display:none;'>Tipo Plazo</th>
											<th style='display:none;'>Categ IVA</th>
											<th style='display:none;'>EXCP Gana</th>
											<th style='display:none;'>MCA Maestro</th>
											<th style='display:none;'>Terminal Pos</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$razon = utf8_encode($row['argencomerrazon']);
			$fantasia = utf8_encode($row['argencomerfantanombre']);
			$alta = isset($row['argencomeraltafecha']) ? $row['argencomeraltafecha']->format('d/m/Y') : "";
			$baja = isset($row['argencomerbajafecha']) ? $row['argencomerbajafecha']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['entinume']}</td>
                <td>{$row['sucurcodi']}</td>
                <td>{$row['argencomernume']}</td>
                <td style='display:none;'>{$row['argencomerestacentralnume']}</td>
                <td style='display:none;'>{$fantasia}</td>
                <td>{$razon}</td>
                <td style='display:none;'>{$row['argencomercalle']}</td>
                <td style='display:none;'>{$row['argencomerpuertanume']}</td>
                <td style='display:none;'>{$row['argencomerpiso']}</td>
                <td style='display:none;'>{$row['argencomerpostalcodi']}</td>
                <td>{$row['argencomerloca']}</td>
                <td style='display:none;'>{$row['provincodi']}</td>
                <td style='display:none;'>{$row['zonacodi']}</td>
                <td style='display:none;'>{$row['argencomertele']}</td>
                <td style='display:none;'>{$row['ArgenComerPagoPlazo']}</td>
                <td style='display:none;'>{$row['argencomercuotasplan']}</td>
				<td style='display:none;'>{$row['ramoscodi']}</td>
				<td style='display:none;'>{$row['argencomersiccode']}</td>
				<td style='display:none;'>{$row['argencomerventalimi']}</td>
				<td style='display:none;'>{$row['argencomerbrutosingrenume']}</td>
				<td>{$row['argencomercuitnume']}</td>
				<td style='display:none;'>{$row['brutosingrecondicodi']}</td>
				<td>{$alta}</td>
				<td style='display:none;'>{$baja}</td>
				<td style='display:none;'>{$row['ArgenComerPagoPlazoTipo']}</td>
				<td style='display:none;'>{$row['ArgenComerIVACate']}</td>
				<td style='display:none;'>{$row['ArgenComerExcep']}</td>
				<td style='display:none;'>{$row['ArgenComerMaestroMarca']}</td>
				<td style='display:none;'>{$row['ArgenComerPos']}</td>
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


