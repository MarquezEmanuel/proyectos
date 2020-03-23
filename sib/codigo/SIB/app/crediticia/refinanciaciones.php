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
}
echo $print;
	}
}

date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y-m-d");
$primerDia = date('Y-m-d', mktime(0,0,0, date("m"), 1, date("Y")));
/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Refinanciaciones</u></h3>
		<br>
        <div id="centro" class="container">
            <form id="formBuscarCobranzasTC" name="formBuscarCobranzasTC" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Desde:</label> 
                        <input type="date" class="form-control" 
                               id="desde" name="desde" value="<?= $primerDia ?>"
                               placeholder="Fecha Desde">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Hasta:</label> 
                        <input type="date" class="form-control" 
                               id="hasta" name="hasta" value="<?= $actual ?>"
                               placeholder="Fecha Hasta">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">CUIL - CUIT:</label> 
                        <input type="number" class="form-control" 
                               id="CUIL" name="CUIL"
                               placeholder="Numero de CUIL - CUIT">
                    </div>
                </div>
				<hr />
                <br>
                <div class="row">
				<div class="col">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Plazo:</label> 
                        <input type="number" class="form-control" 
                               id="plazo" name="plazo"
                               placeholder="Plazo en dias">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Plazo:</label> <br>
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
                            <a href="refinanciaciones.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
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
                            title: 'Cobranzas Tarjeta de Credito'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscar", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarRefinanciaciones.php",
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
                            title: 'Cobranzas Tarjeta de Credito'
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
            url: "formDetallesRefinanciaciones.php",
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

