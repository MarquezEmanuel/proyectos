<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();

function busca(){
	$consulta = $_SESSION['buscar'];
	if($consulta != null){
		$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
		
		if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cuotas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 8%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th style='display:none;'>Transaccion</th>
                                            <th style='display:none;'>Causal</th>
                                            <th style='display:none;'>Nombre transaccion</th>
                                            <th style='display:none;'>Tipo cuenta</th>
                                            <th style='display:none;'>Producto cuenta</th>
                                            <th style='display:none;'>Sucursal cuenta</th>
                                            <th>Numero de Cuenta</th>
                                            <th style='display:none;'>Digito cuenta</th>
                                            <th>Nombre de la Cuenta</th>
                                            <th style='display:none;'>Producto prestamo</th>
                                            <th style='display:none;'>Sucursal Prestamo</th>
                                            <th style='display:none;'>Prestamo</th>
                                            <th>Cliente</th>
                                            <th style='display:none;'>Sucursal operacion</th>
                                            <th style='display:none;'>Usuario transaccion</th>
                                            <th>Usuario</th>
                                            <th style='display:none;'>Cliente prestamo</th>
                                            <th style='display:none;'>Cliente cuenta</th>
                                            <th style='display:none;'>Fecha transaccion</th>
                                            <th style='display:none;'>Monto</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fechaTransaccion']) ? $row['fechaTransaccion']->format('d/m/Y') : "";
            $nombreTransaccion = utf8_encode($row['nombreTransaccion']);
            $nombreCuenta = utf8_encode($row['nombreCuenta']);
            $cliente = utf8_encode($row['cliente']);
            $nombreUsuario = utf8_encode($row['nombreUsuario']);
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['transaccion']}</td>
                <td style='display:none;'>{$row['causal']}</td>
                <td style='display:none;'>{$nombreTransaccion}</td>
                <td style='display:none;'>{$row['tipoCuenta']}</td>
                <td style='display:none;'>{$row['productoCuenta']}</td>
                <td style='display:none;'>{$row['sucursalCuenta']}</td>
                <td>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['digitoCuenta']}</td>
                <td>{$nombreCuenta}</td>
                <td style='display:none;'>{$row['productoPrestamo']}</td>
                <td style='display:none;'>{$row['sucursalPrestamo']}</td>
                <td style='display:none;'>{$row['prestamo']}</td>
                <td>{$cliente}</td>
                <td style='display:none;'>{$row['sucursalOperacion']}</td>
                <td style='display:none;'>{$row['usuarioTransaccion']}</td>
                <td>{$nombreUsuario}</td>
                <td style='display:none;'>{$row['clientePrestamo']}</td>
                <td style='display:none;'>{$row['clienteCuenta']}</td>
                <td style='display:none;'>{$fecha}</td>
                <td style='display:none;'>{$row['monto2']}</td>
                <td class='text-center' title='Ir a ver detalles de la Cuotas'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesCuotas' name='{$row['id']}' width='18' height='18' > 
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

/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Prestamos con cuenta asociada</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarCuotas" name="formBuscarCuotas" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Numero de Cuenta:</label> 
                        <input type="number" class="form-control" 
                               id="cuenta" name="cuenta"
                               placeholder="Numero de Cuenta">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Cliente:</label> 
                        <input type="text" class="form-control" 
                               id="cliente" name="cliente" 
                               pattern="[A-Za-zÁÉÍÚÓáéíúó ]{0,100}"
                               placeholder="Cliente"
                               title="Cliente">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio" 
                               placeholder="DD/MM/AAAA" title="Fecha reporte">
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
                            <input type="submit" class="btn btn-dark" id="btnBuscarCuota" name="btnBuscarCuota" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="buscarCobroCuotas.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                             &nbsp;
                             <a href="cobroCuotas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
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
	
	$('#tb_buscar_cuotas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Prestamos con cuenta asociada'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarCuota", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarCuotas.php",
            data: $("#formBuscarCuotas").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_cuotas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Prestamos con cuenta asociada'
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
    
    $("#contenido2").on("click", "img.detallesCuotas", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCuotas.php",
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
    
    $("#contenido").on("click", "img.detallesCuotas2", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCuotas.php",
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

