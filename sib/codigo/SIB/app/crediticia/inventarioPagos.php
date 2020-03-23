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
                                            <th>Fecha de Alta</th>
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th>Producto</th>
                                            <th style='display:none;'>Moneda</th>
                                            <th style='display:none;'>Nombre de Producto</th>
                                            <th>Estudio</th>
                                            <th style='display:none;'>Nombre</th>
                                            <th style='display:none;'>CUIL</th>
                                            <th>Saldo Capital</th>
                                            <th>Deuda Total</th>
                                            <th>Fecha Etapa</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombreProd = utf8_encode($row['NOMBRE_PROD']);
			$nombre = utf8_encode($row['NOMBRE']);
            $print = $print . "
            <tr>
                <td>{$row['ALTA_ESTUDIO']}</td>
                <td style='display:none;'>{$row['SUC']}</td>
                <td style='display:none;'>{$row['CUENTA']}</td>
                <td>{$row['PROD']}</td>
                <td style='display:none;'>{$row['MON']}</td>
                <td style='display:none;'>{$nombreProd}</td>
                <td>{$row['ESTUDIO']}</td>
                <td style='display:none;'>{$nombre}</td>
                <td style='display:none;'>{$row['CUIL']}</td>
                <td>{$row['SDO_CAP2']}</td>
                <td>{$row['DEUDA_TOTAL2']}</td>
                <td>{$row['FECHA_ETAPA']}</td>
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
}
echo $print;
	}
}

date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y-m-d");
/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Inventario de operaciones a agencias externas</u></h3>
		<br>
        <div id="centro" class="container">
            <form id="formBuscarCobranzasTC" name="formBuscarCobranzasTC" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="Sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Producto:</label> 
                        <input type="number" class="form-control" 
                               id="producto" name="producto"
                               placeholder="Producto">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Estudio:</label> 
                        <input type="number" class="form-control" 
                               id="estudio" name="estudio"
                               placeholder="Estudio">
                    </div>
                </div>
				<hr />
                <br>
                <div class="row">
				<div class="col">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Deuda Total:</label> 
                        <input type="number" class="form-control" 
                               id="plazo" name="plazo"
                               placeholder="Plazo en dias">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Deuda Total:</label> <br>
                        <input type="radio" name="signoPlazo" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoPlazo" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoPlazo" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
					<div class="col">
                    </div>
                </div>
				<hr />
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscar" name="btnBuscar" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="inventarioPagos.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
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
	
	$('#tb_buscar_cobranzasTC').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Inventario de Operaciones'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscar", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarInventarioPagos.php",
            data: $("#formBuscarCobranzasTC").serialize(),
			beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
			},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_cobranzasTC').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Inventario de Operaciones'
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
    
    $("#contenido2").on("click", "img.detallesCobranzasTC", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesInventarioPagos.php",
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

