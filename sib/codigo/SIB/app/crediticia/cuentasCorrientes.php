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
        <table id='tb_buscar_MoraPrestamos' class='table table-striped table-bordered' border='3' style='width: 100%'>
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
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th style='display:none;'>Digito</th>
                                            <th>Numero de Cliente</th>
                                            <th style='display:none;'>Nombre</th>
                                            <th style='display:none;'>Producto</th>
                                            <th style='display:none;'>Moneda</th>
                                            <th>Saldo</th>
                                            <th style='display:none;'>Acuerdo</th>
                                            <th style='display:none;'>Exceso</th>
                                            <th style='display:none;'>Rechazo</th>
                                            <th>Dias de Sobregiro</th>
                                            <th>Dias Saldo Deudor</th>
                                            <th style='display:none;'>Primer Vencimiento</th>
                                            <th>Promedio de Mes</th>
                                            <th>Promedio semestral</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombreCliente = utf8_encode($row['nombreCliente']);
			$primerVencimiento = isset($row['primerVencimiento']) ? $row['primerVencimiento']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['digito']}</td>
                <td>{$row['numeroCliente']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td style='display:none;'>{$row['moneda']}</td>
                <td>{$row['saldo2']}</td>
                <td style='display:none;'>{$row['acuerdo2']}</td>
                <td style='display:none;'>{$row['exceso2']}</td>
                <td style='display:none;'>{$row['rechazo2']}</td>
                <td>{$row['nroDiasSobregiro']}</td>
                <td>{$row['nroDiasSaldoDeudor']}</td>
                <td style='display:none;'>{$primerVencimiento}</td>
                <td>{$row['promedioMes2']}</td>
                <td>{$row['promedio1802']}</td>
                <td class='text-center' title='Ver detalles cuenta corriente'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMoraPrestamos' name='{$row['id']}' width='18' height='18' > 
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
}
echo $print;
	}
}

/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Cuentas Corrientes con Sobregiro</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarMoraPrestamos" name="formBuscarMoraPrestamos" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Cuenta:</label> 
                        <input type="number" class="form-control" 
                               id="cuenta" name="cuenta"
                               placeholder="Numero de Cuenta">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="Numero de Sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Producto:</label> 
                        <input type="number" class="form-control" 
                               id="producto" name="producto"
                               placeholder="Numero de Producto">
                    </div>
                </div>
				<hr />
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Importe Saldo:</label> 
                        <input type="number" class="form-control" 
                               id="cuota" name="cuota"
                               placeholder="Importe de la Saldo">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Importe Saldo:</label> <br>
                        <input type="radio" name="signoCuota" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoCuota" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoCuota" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Dias de Sobregiro:</label> 
                        <input type="number" class="form-control" 
                               id="dias" name="dias"
                               placeholder="Dias de Sobregiro">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Dias de Sobregiro:</label> <br>
                        <input type="radio" name="signoDias" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoDias" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoDias" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                </div>
				<hr />
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarMoraPrestamos" name="btnBuscarMoraPrestamos" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="cuentasCorrientes.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
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
	
	$('#tb_buscar_MoraPrestamos').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Cuentas Corrientes con Sobregiro'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarMoraPrestamos", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarCuentasCorrientes.php",
            data: $("#formBuscarMoraPrestamos").serialize(),
			beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_MoraPrestamos').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Cuentas Corrientes con Sobregiro'
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
    
    $("#contenido2").on("click", "img.detallesMoraPrestamos", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCuentasCorrientes.php",
            data: "seleccionado="+idcuotas,
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

