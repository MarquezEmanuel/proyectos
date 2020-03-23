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
        <table id='tb_buscar_telefonos' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 10%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 17%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Numero de sucursal</th>
                                            <th style='display:none;'>Numero de Documento</th>
                                            <th>Descripcion</th>
                                            <th style='display:none;'>Fecha Gra</th>
                                            <th style='display:none;'>Fecha Ingreso</th>
                                            <th style='display:none;'>Numero de Cliente</th>
                                            <th>Nombre de Cliente</th>
                                            <th>Correo de Cliente</th>
                                            <th>Telefono SFB</th>
                                            <th>Telefono Engage</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $descripcion = utf8_encode($row['descripcion']);
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $correoCliente = utf8_encode($row['correoCliente']);
            $fechaGra = isset($row['fechaGra']) ? $row['fechaGra']->format('d/m/Y') : "";
            $fechaIngreso = isset($row['fechaIngreso']) ? $row['fechaIngreso']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['numeroDocumento']}</td>
                <td>{$descripcion}</td>
                <td style='display:none;'>{$fechaGra}</td>
                <td style='display:none;'>{$fechaIngreso}</td>
                <td style='display:none;'>{$row['numeroCliente']}</td>
                <td>{$nombreCliente}</td>
                <td>{$correoCliente}</td>
                <td>{$row['telefonoSFB']}</td>
                <td>{$row['telefonoEngage']}</td>

                <td class='text-center' title='Ir a ver detalles de Telefonos'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesTelefonos' name='{$row['id']}' width='18' height='18' > 
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

require_once './menuSucursal.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Datos de Clientes con tarjetas en el tesoro</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarTelefonos" name="formBuscarTelefonos" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Numero de Cliente:</label> 
                        <input type="number" class="form-control" 
                               id="cliente" name="cliente" 
                               placeholder="Numero de cliente"
                               title="Numero de cliente">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">DNI:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal" 
                               placeholder="Numero de DNI"
                               title="Numero de DNI">
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
                            <input type="submit" class="btn btn-dark" id="btnBuscarTelefonos" name="btnBuscarTelefonos" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="formBuscarTelefonosTarjetas.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                             &nbsp;
                             <a href="formTelefonosTarjetas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
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
	
	$('#tb_buscar_telefonos').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Telefonos Tarjetas'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarTelefonos", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarTelefonos.php",
            data: $("#formBuscarTelefonos").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_telefonos').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Telefonos Tarjetas'
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
    
    $("#contenido2").on("click", "img.detallesTelefonos", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesTelefonos.php",
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
    
    $("#contenido").on("click", "img.detallesTelefonos2", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesTelefonos.php",
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


