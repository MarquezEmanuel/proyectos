<?php
/* AGREGA LA CABECERA CON EL MENU */
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
        <table id='tb_buscar_cuentas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                        <th style='display:none;'>Cuenta</th>
                                        <th style='display:none;'>Producto</th>
                                        <th style='display:none;'>Definicion estado</th>
                                        <th style='display:none;'>Saldo</th>
                                        <th>Sucursal</th>
                                        <th>Numero de Cliente</th>
                                        <th>Nombre de Cliente</th>
                                        <th>Estado</th>
                                        <th>Ultimo Movimiento</th>
                                        <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

            $fechaUltimoMovimiento = isset($row['fechaUltimoMovimiento']) ? $row['fechaUltimoMovimiento']->format('d/m/Y') : "";
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td style='display:none;'>{$row['definicionEstado']}</td>
                <td style='display:none;'>{$row['saldo2']}</td>
                <td>{$row['sucursal']}</td>
                <td>{$row['numeroCliente']}</td>
                <td>{$nombreCliente}</td>
                <td>{$row['estado']}</td>
                <td>{$fechaUltimoMovimiento}</td>
                <td class='text-center' title='Ir a ver detalles de las Cuentas'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesCuentasPorCerrar' name='{$row['id']}' width='18' height='18' > 
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
        <h3 class="text-center"><u>Cuentas por cerrar saldo deudor</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarCuentasPorCerrar" name="formBuscarCuentasPorCerrar" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Numero de Cliente:</label> 
                        <input type="number" class="form-control" 
                               id="numeroCliente" name="numeroCliente"
                               placeholder="Numero de cliente" 
                               title="Numero de cliente">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Nombre de Cliente:</label> 
                        <input type="text" class="form-control" 
                               id="cliente" name="cliente" 
                               pattern="[A-Za-zÁÉÍÚÓáéíúó ]{0,100}"
                               placeholder="Nombre de cliente"
                               title="Nombre de cliente">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio"
                               placeholder="DD/MM/AAAA" title="Fecha inicio">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Fin:</label> 
                        <input type="date" class="form-control" 
                               id="fechaFin" name="fechaFin" 
                               placeholder="DD/MM/AAAA" title="Fecha fin">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarCuentasPorCerrar" name="btnBuscarCuentasPorCerrar" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                            &nbsp;
                            <a href="formCuentasPorCerrar.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
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
	
	$('#tb_buscar_cuentas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Cuentas por cerrar'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarCuentasPorCerrar", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarCuentasPorCerrar.php",
            data: $("#formBuscarCuentasPorCerrar").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_cuentas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Cuentas por cerrar'
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
    
    $("#contenido2").on("click", "img.detallesCuentasPorCerrar", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCuentasPorCerrar.php",
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
    
    $("#contenido").on("click", "img.detallesCuentasPorCerrar2", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCuentasPorCerrar.php",
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

