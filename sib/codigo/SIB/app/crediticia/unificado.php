<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();

function segmento() {
    $sql = "SELECT DISTINCT segmento FROM [bd_sib].[dbo].[recuperacionCrediticia]";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $html = $html . "<option value='{$row['segmento']}'>{$row['segmento']}</option>";
            }
        } else {
            $html = $html . "<option>No hay segmentos disponibles</option>";
        }
    } else {
        $html = $html . "<option>No hay segmentos disponibles</option>";
    }
    return $html;
}

function busca(){
$consulta = $_SESSION['buscar'];
if($consulta != null){
	$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
	
	if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_unificado' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                        <col style='width: 10%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
										<col style='width: 10%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th>Numero de CUIT</th>
                                            <th style='display:none;'>Numero de Cliente</th>
											<th style='display:none;'>Saldo de Cuentas</th>
                                            <th style='display:none;'>Nombre de Cliente</th>
                                            <th style='display:none;'>Cartera</th>
                                            <th>Sucursal</th>
											<th>Mayor dia de atraso</th>
                                            <th style='display:none;'>Deuda Total Consolidada</th>
                                            <th>Deuda Total Vencida</th>
                                            <th>Deuda Total MME</th>
                                            <th>Segmento</th>
                                            <th>Dias de Atraso en Prestamo</th>
											<th style='display:none;'>Producto Prestamo</th>
                                            <th style='display:none;'>Saldo Total Pendiente Prestamo</th>
                                            <th style='display:none;'>Monto Total Mora Prestamo</th>
                                            <th style='display:none;'>MME Prestamo</th>
											<th style='display:none;'>Saldo de Terceros</th>
											<th style='display:none;'>Carpeta</th>
											<th style='display:none;'>Forma de Pago</th>
											<th style='display:none;'>Organismo</th>
                                            <th style='display:none;'>Dias Atraso TC</th>
											<th style='display:none;'>Marca</th>
											<th style='display:none;'>Cuenta Tarjeta</th>
                                            <th style='display:none;'>Saldo Total Pendiente TC</th>
                                            <th style='display:none;'>Monto Total Mora TC</th>
                                            <th style='display:none;'>MME TC</th>
											<th style='display:none;'>Cobranzas Tanques SFB</th> 
                                            <th style='display:none;'>Dias de Atraso en GYM</th>
                                            <th style='display:none;'>Saldo Total Pendiente GYM</th>
                                            <th style='display:none;'>Monto Total Mora GYM</th>
                                            <th style='display:none;'>MME GYM</th>
                                            <th style='display:none;'>Capital GYM</th>
                                            <th style='display:none;'>Saldo contable GYM</th>
                                            <th style='display:none;'>Dias de Atraso CC</th>                                            
                                            <th style='display:none;'>Saldo Total Pendiente CC</th>
                                            <th style='display:none;'>Monto Total Mora CC</th>
                                            <th style='display:none;'>MME CC</th>
                                            <th style='display:none;'>Fallecido</th>
                                            <th style='display:none;'>Quiebra</th>
                                            <th style='display:none;'>Agencia</th>
                                            <th style='display:none;'>Etapa</th>
                                            <th style='display:none;'>Situacion BCRA</th>
                                            <th style='display:none;'>Proyeccion</th>                                           
                                            <th style='display:none;'>Datos Empleador</th>
                                            <th style='display:none;'>Conyuge</th>
                                            <th style='display:none;'>Tipo de Gestion</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $conyuge = utf8_encode($row['conyuge']);
			$total= 0;
			$diasTC = $row['diasAtrasoTC'];
			$diasPrestamo = $row['diasAtrasoPrestamo'];
			$diasCC = $row['diasAtrasoCC'];
			$diasGYM = $row['diasAtrasoGYM'];
			if ($diasTC != null){
				if($total < $diasTC){
					$total = $diasTC;
					if($diasPrestamo != null){
						if($total < $diasPrestamo){
							$total = $diasPrestamo;
							if($diasCC != null){
								if($total < $diasCC){
									$total = $diasCC;
									if($diasGYM != null){
										if($total < $diasGYM){
											$total = $diasGYM;
										}
									}
								}
							}
						}
					}
				}
			}else{
				if($diasPrestamo != null){
						if($total < $diasPrestamo){
							$total = $diasPrestamo;
							if($diasCC != null){
								if($total < $diasCC){
									$total = $diasCC;
									if($diasGYM != null){
										if($total < $diasGYM){
											$total = $diasGYM;
										}
									}
								}
							}
						}
					}else{
						if($diasCC != null){
								if($total < $diasCC){
									$total = $diasCC;
									if($diasGYM != null){
										if($total < $diasGYM){
											$total = $diasGYM;
										}
									}
								}
							}else{
								if($diasGYM != null){
										if($total < $diasGYM){
											$total = $diasGYM;
										}
									}
							}
					}
			}
			
			
		if (isset($atraso) && $atraso != null){	
		if($signoAtraso == '>'){
				if($total > $atraso){
					$print = $print . "
            <tr>
                <td>{$row['numeroCuit']}</td>
                <td style='display:none;'>{$row['numeroCliente']}</td>
				<td style='display:none;'>{$row['saldoCuentas2']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td style='display:none;'>{$row['cartera']}</td>
                <td>{$row['sucursal']}</td>
				<td>{$total}</td>
                <td style='display:none;'>{$row['deudaTotalConsolidada2']}</td>
                <td>{$row['deudaTotalVencida2']}</td>
                <td>{$row['deudaTotalMME2']}</td>
                <td>{$row['segmento']}</td>
                <td>{$row['diasAtrasoPrestamo']}</td>
				<td style='display:none;'>{$row['productoPrestamo']}</td>
                <td style='display:none;'>{$row['sdoTotPendientePrestamo2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraPrestamo2']}</td>
                <td style='display:none;'>{$row['mmePrestamo2']}</td>
				<td style='display:none;'>{$row['saldoTerceros2']}</td>
				<td style='display:none;'>{$row['carpeta']}</td>
				<td style='display:none;'>{$row['formaPago']}</td>
				<td style='display:none;'>{$row['organismo']}</td>
                <td style='display:none;'>{$row['diasAtrasoTC']}</td>
				<td style='display:none;'>{$row['marca']}</td>
				<td style='display:none;'>{$row['cuentaTarjeta']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteTC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraTC2']}</td>
                <td style='display:none;'>{$row['mmeTC2']}</td>
				<td style='display:none;'>{$row['cobranzasTanqueSFB2']}</td>
                <td style='display:none;'>{$row['diasAtrasoGYM']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteGYM2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraGYM2']}</td>
                <td style='display:none;'>{$row['mmeGYM2']}</td>
                <td style='display:none;'>{$row['capitalGYM2']}</td>
                <td style='display:none;'>{$row['saldoContableGYM2']}</td>
                <td style='display:none;'>{$row['diasAtrasoCC']}</td>
                <td style='display:none;'>{$row['sdoTotPendienteCC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraCC2']}</td>
                <td style='display:none;'>{$row['mmeCC2']}</td>
                <td style='display:none;'>{$row['fallecido']}</td>
                <td style='display:none;'>{$row['quiebra']}</td>
                <td style='display:none;'>{$row['agencia']}</td>
                <td style='display:none;'>{$row['etapa']}</td>
                <td style='display:none;'>{$row['situacionBCRA']}</td>
                <td style='display:none;'>{$row['proyeccion']}</td>
                <td style='display:none;'>{$row['datosEmpleador']}</td>
                <td style='display:none;'>{$conyuge}</td>
                <td style='display:none;'>{$row['tipoGestion']}</td>
                <td class='text-center' title='Ver detalles de el unificado'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesUnificado' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
				}
			} else{
				if($signoAtraso == '<'){
				if($total < $atraso){
					$print = $print . "
            <tr>
                <td>{$row['numeroCuit']}</td>
                <td style='display:none;'>{$row['numeroCliente']}</td>
				<td style='display:none;'>{$row['saldoCuentas2']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td style='display:none;'>{$row['cartera']}</td>
                <td>{$row['sucursal']}</td>
				<td>{$total}</td>
                <td style='display:none;'>{$row['deudaTotalConsolidada2']}</td>
                <td>{$row['deudaTotalVencida2']}</td>
                <td>{$row['deudaTotalMME2']}</td>
                <td>{$row['segmento']}</td>
                <td>{$row['diasAtrasoPrestamo']}</td>
				<td style='display:none;'>{$row['productoPrestamo']}</td>
                <td style='display:none;'>{$row['sdoTotPendientePrestamo2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraPrestamo2']}</td>
                <td style='display:none;'>{$row['mmePrestamo2']}</td>
				<td style='display:none;'>{$row['saldoTerceros2']}</td>
				<td style='display:none;'>{$row['carpeta']}</td>
				<td style='display:none;'>{$row['formaPago']}</td>
				<td style='display:none;'>{$row['organismo']}</td>
                <td style='display:none;'>{$row['diasAtrasoTC']}</td>
				<td style='display:none;'>{$row['marca']}</td>
				<td style='display:none;'>{$row['cuentaTarjeta']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteTC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraTC2']}</td>
                <td style='display:none;'>{$row['mmeTC2']}</td>
				<td style='display:none;'>{$row['cobranzasTanqueSFB2']}</td>
                <td style='display:none;'>{$row['diasAtrasoGYM']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteGYM2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraGYM2']}</td>
                <td style='display:none;'>{$row['mmeGYM2']}</td>
                <td style='display:none;'>{$row['capitalGYM2']}</td>
                <td style='display:none;'>{$row['saldoContableGYM2']}</td>
                <td style='display:none;'>{$row['diasAtrasoCC']}</td>
                <td style='display:none;'>{$row['sdoTotPendienteCC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraCC2']}</td>
                <td style='display:none;'>{$row['mmeCC2']}</td>
                <td style='display:none;'>{$row['fallecido']}</td>
                <td style='display:none;'>{$row['quiebra']}</td>
                <td style='display:none;'>{$row['agencia']}</td>
                <td style='display:none;'>{$row['etapa']}</td>
                <td style='display:none;'>{$row['situacionBCRA']}</td>
                <td style='display:none;'>{$row['proyeccion']}</td>
                <td style='display:none;'>{$row['datosEmpleador']}</td>
                <td style='display:none;'>{$conyuge}</td>
                <td style='display:none;'>{$row['tipoGestion']}</td>
                <td class='text-center' title='Ver detalles de el unificado'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesUnificado' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
				}
			} else{
				if($signoAtraso == '='){
				if($total == $atraso){
					$print = $print . "
            <tr>
                <td>{$row['numeroCuit']}</td>
                <td style='display:none;'>{$row['numeroCliente']}</td>
				<td style='display:none;'>{$row['saldoCuentas2']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td style='display:none;'>{$row['cartera']}</td>
                <td>{$row['sucursal']}</td>
				<td>{$total}</td>
                <td style='display:none;'>{$row['deudaTotalConsolidada2']}</td>
                <td>{$row['deudaTotalVencida2']}</td>
                <td>{$row['deudaTotalMME2']}</td>
                <td>{$row['segmento']}</td>
                <td>{$row['diasAtrasoPrestamo']}</td>
				<td style='display:none;'>{$row['productoPrestamo']}</td>
                <td style='display:none;'>{$row['sdoTotPendientePrestamo2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraPrestamo2']}</td>
                <td style='display:none;'>{$row['mmePrestamo2']}</td>
				<td style='display:none;'>{$row['saldoTerceros2']}</td>
				<td style='display:none;'>{$row['carpeta']}</td>
				<td style='display:none;'>{$row['formaPago']}</td>
				<td style='display:none;'>{$row['organismo']}</td>
                <td style='display:none;'>{$row['diasAtrasoTC']}</td>
				<td style='display:none;'>{$row['marca']}</td>
				<td style='display:none;'>{$row['cuentaTarjeta']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteTC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraTC2']}</td>
                <td style='display:none;'>{$row['mmeTC2']}</td>
				<td style='display:none;'>{$row['cobranzasTanqueSFB2']}</td>
                <td style='display:none;'>{$row['diasAtrasoGYM']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteGYM2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraGYM2']}</td>
                <td style='display:none;'>{$row['mmeGYM2']}</td>
                <td style='display:none;'>{$row['capitalGYM2']}</td>
                <td style='display:none;'>{$row['saldoContableGYM2']}</td>
                <td style='display:none;'>{$row['diasAtrasoCC']}</td>
                <td style='display:none;'>{$row['sdoTotPendienteCC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraCC2']}</td>
                <td style='display:none;'>{$row['mmeCC2']}</td>
                <td style='display:none;'>{$row['fallecido']}</td>
                <td style='display:none;'>{$row['quiebra']}</td>
                <td style='display:none;'>{$row['agencia']}</td>
                <td style='display:none;'>{$row['etapa']}</td>
                <td style='display:none;'>{$row['situacionBCRA']}</td>
                <td style='display:none;'>{$row['proyeccion']}</td>
                <td style='display:none;'>{$row['datosEmpleador']}</td>
                <td style='display:none;'>{$conyuge}</td>
                <td style='display:none;'>{$row['tipoGestion']}</td>
                <td class='text-center' title='Ver detalles de el unificado'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesUnificado' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
				}
			}
			}
			}
		}else{
			$print = $print . "
            <tr>
                <td>{$row['numeroCuit']}</td>
                <td style='display:none;'>{$row['numeroCliente']}</td>
				<td style='display:none;'>{$row['saldoCuentas2']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td style='display:none;'>{$row['cartera']}</td>
                <td>{$row['sucursal']}</td>
				<td>{$total}</td>
                <td style='display:none;'>{$row['deudaTotalConsolidada2']}</td>
                <td>{$row['deudaTotalVencida2']}</td>
                <td>{$row['deudaTotalMME2']}</td>
                <td>{$row['segmento']}</td>
                <td>{$row['diasAtrasoPrestamo']}</td>
				<td style='display:none;'>{$row['productoPrestamo']}</td>
                <td style='display:none;'>{$row['sdoTotPendientePrestamo2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraPrestamo2']}</td>
                <td style='display:none;'>{$row['mmePrestamo2']}</td>
				<td style='display:none;'>{$row['saldoTerceros2']}</td>
				<td style='display:none;'>{$row['carpeta']}</td>
				<td style='display:none;'>{$row['formaPago']}</td>
				<td style='display:none;'>{$row['organismo']}</td>
                <td style='display:none;'>{$row['diasAtrasoTC']}</td>
				<td style='display:none;'>{$row['marca']}</td>
				<td style='display:none;'>{$row['cuentaTarjeta']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteTC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraTC2']}</td>
                <td style='display:none;'>{$row['mmeTC2']}</td>
				<td style='display:none;'>{$row['cobranzasTanqueSFB2']}</td>
                <td style='display:none;'>{$row['diasAtrasoGYM']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteGYM2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraGYM2']}</td>
                <td style='display:none;'>{$row['mmeGYM2']}</td>
                <td style='display:none;'>{$row['capitalGYM2']}</td>
                <td style='display:none;'>{$row['saldoContableGYM2']}</td>
                <td style='display:none;'>{$row['diasAtrasoCC']}</td>
                <td style='display:none;'>{$row['sdoTotPendienteCC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraCC2']}</td>
                <td style='display:none;'>{$row['mmeCC2']}</td>
                <td style='display:none;'>{$row['fallecido']}</td>
                <td style='display:none;'>{$row['quiebra']}</td>
                <td style='display:none;'>{$row['agencia']}</td>
                <td style='display:none;'>{$row['etapa']}</td>
                <td style='display:none;'>{$row['situacionBCRA']}</td>
                <td style='display:none;'>{$row['proyeccion']}</td>
                <td style='display:none;'>{$row['datosEmpleador']}</td>
                <td style='display:none;'>{$conyuge}</td>
                <td style='display:none;'>{$row['tipoGestion']}</td>
                <td class='text-center' title='Ver detalles de el unificado'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesUnificado' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
		}
        }
        $print = $print . "</tbody></table>
        ";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
}
return $print;
}
}

/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Integrador de Recuperacion Crediticia</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarUnificado" name="formBuscarUnificado" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">CUIT:</label> 
                        <input type="number" class="form-control" 
                               id="cuit" name="cuit"
                               placeholder="Numero de CUIT">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="Numero de Sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Tipo de Gestion:</label> 
                        <input type="text" class="form-control" 
                               id="tipoGestion" name="tipoGestion"
                               placeholder="Tipo de Gestion">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Mayor Dia de Atraso:</label> 
                        <input type="number" class="form-control" 
                               id="atraso" name="atraso"
                               placeholder="Dias de Atraso">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Mayor Dia de Atraso:</label> <br>
                        <input type="radio" name="signoAtraso" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoAtraso" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoAtraso" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Monto Total:</label> 
                        <input type="number" class="form-control" 
                               id="monto" name="monto"
                               placeholder="Monto">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Monto Total:</label> <br>
                        <input type="radio" name="signoMonto" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoMonto" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoMonto" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2" title="Seleccione pulsando Ctrl para elegir mas de un segmento">Lista de Segmentos:</label> 
                        <select multiple id="elegido" class="form-control" name="elegido[]" style="width: 400; height:250" title="Seleccione pulsando Ctrl para elegir mas de un segmento">
                            <?php
                            echo segmento();
                            ?>
                        </select>
                    </div>
					<div class="col">
                        <label class="mr-sm-2">Saldo en Cuentas:</label> 
                        <input type="number" class="form-control" 
                               id="saldo" name="saldo"
                               placeholder="Saldo en cuentas">
                    </div>
                    <div class="col">
						<label class="mr-sm-2">Saldo en Cuentas:</label> <br>
							<input type="radio" name="signoSaldo" value="<"> <label class="mr-sm-2">Menor</label>
							<input type="radio" name="signoSaldo" value=">"> <label class="mr-sm-2">Mayor</label>
							<input type="radio" name="signoSaldo" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarUnificado" name="btnBuscarUnificado" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="unificado.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                            &nbsp;
                            <a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2">
	<?php
        echo busca();
	?>
	</div>
</div>
<div class="modal fade" id="mdProcesando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/ajax-loader.gif" class="img-fluid" alt="Responsive image" background="" width="250" height="250">
                </div>
        </div>
</div>
</body>
<script type="text/javascript" charset="utf8">
    $(document).ready(function () {
		
		$('#tb_buscar_unificado').DataTable({
                        dom: 'Brtip',
                        responsive: true,
                        scrollX: true,
                        pageLength: 15,
                        buttons: [
                            {extend: 'excelHtml5',
                                title: 'Informe Integrador de Recuperacion Crediticia'
                            },
                        ],
                        language: {url: "/lib/js/Spanish.json"
                        }
                    });
        /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */

        $("#contenido").on("click", "#btnBuscarUnificado", function () {
            $.ajax({
                type: "POST",
                url: "procesarBuscarUnificado.php",
                data: $("#formBuscarUnificado").serialize(),
				beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
				},
                success: function (data) {
                    $("#contenido2").html(data);
                    $('#tb_buscar_unificado').DataTable({
                        dom: 'Brtip',
                        responsive: true,
                        scrollX: true,
                        pageLength: 15,
                        buttons: [
                            {extend: 'excelHtml5',
                                title: 'Informe Integrador de Recuperacion Crediticia'
                            },
                        ],
                        language: {url: "/lib/js/Spanish.json"
                        }
                    });
                },
				complete: function() {
					setTimeout(function(){
						$('#mdProcesando').modal('hide');
					},1000)		
				},
                error: function () {
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
            return false;
        });

        /* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */

        $("#contenido2").on("click", "img.detallesUnificado", function () {
            var idcuotas = $(this).attr('name');
            $.ajax({
                type: "POST",
                url: "formDetallesUnificado.php",
                data: "seleccionado=" + idcuotas,
                success: function (data) {
                    $("#contenido").empty();
                    $("#contenido2").empty();
                    $("#contenido").html(data);
                },
                error: function () {
                    $("#contenido").empty();
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
        });
    });

</script>
</html>

