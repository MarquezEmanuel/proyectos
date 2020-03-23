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
        <table id='tb_buscar_MoraTarjetas' class='table table-striped table-bordered' border='3' style='width: 100%'>
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
                                            <th>Marca</th>
                                            <th>Sucursal</th>
                                            <th>Cuenta Tarjeta</th>
                                            <th style='display:none;'>Total</th>
                                            <th style='display:none;'>Minimo</th>
                                            <th>Mora</th>
                                            <th>Dias de Atraso</th>
                                            <th style='display:none;'>Nombre de Cliente</th>
                                            <th>Documento</th>
                                            <th style='display:none;'>Tipo de cuenta</th>
                                            <th style='display:none;'>Sucursal Cuenta</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th style='display:none;'>Digito</th>
                                            <th style='display:none;'>Saldo</th>
                                            <th style='display:none;'>Codigo de Cliente</th>
                                            <th style='display:none;'>Producto</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $print = $print . "
            <tr>
                <td>{$row['marca']}</td>
                <td>{$row['sucursal']}</td>
                <td>{$row['cuentaTarjeta']}</td>
                <td style='display:none;'>{$row['total2']}</td>
                <td style='display:none;'>{$row['minimo2']}</td>
                <td>{$row['mora2']}</td>
                <td>{$row['diasAtraso']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td>{$row['documento']}</td>
                <td style='display:none;'>{$row['tipoCuenta']}</td>
                <td style='display:none;'>{$row['sucursalCuenta']}</td>
                <td style='display:none;'>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['digito']}</td>
                <td style='display:none;'>{$row['saldo2']}</td>
                <td style='display:none;'>{$row['codigoCliente']}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td class='text-center' title='Ver detalles de la tarjeta en mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMoraTarjetas' name='{$row['id']}' width='18' height='18' > 
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


function segmento() {
    $sql = "SELECT DISTINCT tipoCuenta FROM [bd_sib].[dbo].[4moraTarjetas]";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $html = $html . "<option value='{$row['tipoCuenta']}'>{$row['tipoCuenta']}</option>";
            }
        } else {
            $html = $html . "<option>No hay segmentos disponibles</option>";
        }
    } else {
        $html = $html . "<option>No hay segmentos disponibles</option>";
    }
    return $html;
}


/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Mora En Tarjetas</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarMoraTarjetas" name="formBuscarMoraTarjetas" method="POST">
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
                        <label class="mr-sm-2">Importe Mora:</label> 
                        <input type="number" class="form-control" 
                               id="mora" name="mora"
                               placeholder="Importe de la Mora">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Importe Mora:</label> <br>
                        <input type="radio" name="signoMora" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoMora" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoMora" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2" title="Seleccione pulsando Ctrl para elegir mas de un segmento">Tipo de Cuenta:</label> 
                        <select multiple id="elegido" class="form-control" name="elegido[]" style="width: 300; height:100" title="Seleccione pulsando Ctrl para elegir mas de un segmento">
                            <?php
                            echo segmento();
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Dias de Atraso:</label> 
                        <input type="number" class="form-control" 
                               id="dias" name="dias"
                               placeholder="Dias de Atraso">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Dias de Atraso:</label> <br>
                        <input type="radio" name="signoDias" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoDias" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoDias" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarMoraTarjetas" name="btnBuscarMoraTarjetas" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="moraTarjetas.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
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
	
	$('#tb_buscar_MoraTarjetas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Mora en Tarjetas'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarMoraTarjetas", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarMoraTarjetas.php",
            data: $("#formBuscarMoraTarjetas").serialize(),
			beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_MoraTarjetas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Mora en Tarjetas'
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
    
    $("#contenido2").on("click", "img.detallesMoraTarjetas", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesMoraTarjetas.php",
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

