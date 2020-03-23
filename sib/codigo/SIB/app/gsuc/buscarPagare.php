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
        <table id='tb_buscar_pagare' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 8%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th style='display:none;'>PCU sucursal origen</th>
                                            <th style='display:none;'>PCU numero de cuenta</th>
                                            <th style='display:none;'>PCU producto</th>
                                            <th style='display:none;'>Estado prestamo</th>
                                            <th>Numero de Cuenta</th>
                                            <th>Cliente</th>
                                            <th>Fecha liquidacion</th>
                                            <th>Fecha Vencimiento</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {


            $fechaLiquidacion = isset($row['fechaLiquidacion']) ? $row['fechaLiquidacion']->format('d/m/Y') : "";
            $fechaVencimiento = isset($row['fechaVencimiento']) ? $row['fechaVencimiento']->format('d/m/Y') : "";
            $nombre = utf8_encode($row['snoCliente']);
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['pcuOfici']}</td>
                <td style='display:none;'>{$row['pcuNumeroCuenta']}</td>
                <td style='display:none;'>{$row['pcuProducto']}</td>
                <td style='display:none;'>{$row['estadoPrestamo']}</td>
                <td>{$row['scoIdent']}</td>
                <td>{$nombre}</td>
                <td>{$fechaLiquidacion}</td>
                <td>{$fechaVencimiento}</td>

                <td class='text-center' title='Ir a ver detalles del Pagare'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesPagare' name='{$row['id']}' width='18' height='18' > 
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
        <h3 class="text-center"><u>Pagare no cargados en SAV</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarPagare" name="formBuscarPagare" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Numero de cuenta:</label> 
                        <input type="number" class="form-control" 
                               id="cuenta" name="cuenta"
                               placeholder="cuenta" 
                               title="cuenta">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Numero de Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="Numero de sucursal" 
                               title="sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio"
                               placeholder="DD/MM/AAAA" title="Fecha Inicio">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Fin:</label> 
                        <input type="date" class="form-control" 
                               id="fechaFin" name="fechaFin" 
                               placeholder="DD/MM/AAAA" title="Fecha Fin">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarPagare" name="btnBuscarPagare" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="buscarPagare.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                            &nbsp;
                            <a href="noSAV.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
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
	
	$('#tb_buscar_pagare').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Pagare no cargados en SAV'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarPagare", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarPagare.php",
            data: $("#formBuscarPagare").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_pagare').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Pagare no cargados en SAV'
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
    
    $("#contenido2").on("click", "img.detallesPagare", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesPagare.php",
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
    
    $("#contenido").on("click", "img.detallesPagare2", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesPagare.php",
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
