<?php
include_once '../conf/BDConexion.php';

session_start();

function busca(){
	$consulta = $_SESSION['buscar'];
	if($consulta != null){
		$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
		
		if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_moras' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Sucursal</th>
                                            <th style='display:none;'>Modulo</th>
                                            <th style='display:none;'>Numero de Caja</th>
                                            <th>Codigo Contrato</th>
                                            <th>Importe Cuotas</th>
                                            <th style='display:none;'>Cantidad de Cuotas</th>
                                            <th style='display:none;'>Cuenta DA</th>
                                            <th style='display:none;'>Digito DA</th>
                                            <th style='display:none;'>Fecha Alta</th>
                                            <th style='display:none;'>Nombre</th>
                                            <th style='display:none;'>Producto</th>
                                            <th style='display:none;'>Sucursal Cuenta DA</th>
                                            <th style='display:none;'>Tipo Cuenta DA</th>
                                            <th>Numero Cliente</th>
                                            <th style='display:none;'>Numero Documento</th>
                                            <th style='display:none;'>Nombre Cuenta</th>
                                            <th>Estado</th>
                                            <th>Saldo</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fechaAlta = isset($row['fechaAlta']) ? $row['fechaAlta']->format('d/m/Y') : "";
            $nombre = utf8_encode($row['nombre']);
            $estado = utf8_encode($row['estado']);
            $print = $print . "
            <tr>
                <td>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['modulo']}</td>
                <td style='display:none;'>{$row['numeroCaja']}</td>
                <td>{$row['codigoContrato']}</td>
                <td>{$row['importeCuota2']}</td>
                <td style='display:none;'>{$row['cantidadCuotas']}</td>
                <td style='display:none;'>{$row['cuentaDA']}</td>
                <td style='display:none;'>{$row['digitoDA']}</td>
                <td style='display:none;'>{$fechaAlta}</td>
                <td style='display:none;'>{$nombre}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td style='display:none;'>{$row['sucursalCuentaDA']}</td>
                <td style='display:none;'>{$row['tipoCuentaDA']}</td>
                <td>{$row['numeroCliente']}</td>
                <td style='display:none;'>{$row['numeroDocumento']}</td>
                <td style='display:none;'>{$row['nombreCuenta']}</td>
                <td>{$estado}</td>
                <td>{$row['saldo2']}</td>
                <td class='text-center' title='Ir a ver detalles de Mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMorasCajaSeguridad' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
        }
        $print = $print . "</tbody></table>
        ";
    }  else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
}
echo $print;
	}
}

require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Moras en cajas de seguridad</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarMorasCajaSeguridad" name="formBuscarMorasCajaSeguridad" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Estado:</label> 
                        <select class="form-control" 
                               id="tratado" name="tratado">
                            <option value="SIN TRATAR">SIN TRATAR</option>
                            <option value="TRATADO">TRATADO</option>
                        </select>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Numero de Caja:</label> 
                        <input type="number" class="form-control" 
                               id="numeroCaja" name="numeroCaja" 
                               placeholder="Numero Caja"
                               title="Cliente">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal" 
                               placeholder="Numero sucursal"
                               title="Sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio"
                               placeholder="DD/MM/AAAA" title="Fecha alta">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Fin:</label> 
                        <input type="date" class="form-control" 
                                   id="fechaFin" name="fechaFin" 
                               placeholder="DD/MM/AAAA" title="Fecha reporte">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarMorasCajaSeguridad" name="btnBuscarMorasCajaSeguridad" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="buscarMorasCajaSeguridad.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                             &nbsp;
                             <a href="morasCajaSeguridad.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
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
<div class="modal fade" id="mdCargando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/cargandoGSUC.gif" class="img-fluid" alt="Responsive image" background="" width="250" height="250">
                </div>
        </div>
</div>
</body>
<script>
$(document).ready(function () {
	
	$('#tb_buscar_moras').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Moras Caja Seguridad'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarMorasCajaSeguridad", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarMorasCajaSeguridad.php",
            data: $("#formBuscarMorasCajaSeguridad").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_moras').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Moras Caja Seguridad'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
			complete: function() {
					setTimeout(function(){
						$('#mdCargando').modal('hide');
					},1000)		
				},
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
    
    /* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */
    
    $("#contenido2").on("click", "img.detallesMorasCajaSeguridad", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesMorasCajaSeguridad.php",
            data: "seleccionado="+idcanje,
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
    
    /* CARGA EL FORMULARIO DE DETALLES DE GARANTIA EN EL DIV CONTENIDO */
    
    $("#contenido").on("click", "img.detallesMorasCajaSeguridad2", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesMorasCajaSeguridad.php",
            data: "seleccionado="+idcanje,
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





