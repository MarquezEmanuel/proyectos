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
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>Marca</th>
                                            <th>Cuenta</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $print = $print . "
            <tr>
                <td>{$row['marca']}</td>
                <td>{$row['cuenta']}</td>
                <td class='text-center' title='Ver detalles de la tarjeta en mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesClientesPrestamos' name='{$row['cuenta']}' width='18' height='18' > 
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
        <h3 class="text-center"><u>Saldos a Favor</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarMoraTarjetas" name="formBuscarMoraTarjetas" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Marca:</label> 
                        <select multiple name="marca[]" id="marca" class="form-control mb-2" title="Forma de pago" style="width: 520; height:75">
						<option value="= 'MC'">Master</option>
						<option value="= 'VISA'">Visa</option>
						</select>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Cuenta:</label> 
                        <input type="text" class="form-control" 
                               id="cuenta" name="cuenta"
                               placeholder="cuenta">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarMoraTarjetas" name="btnBuscarMoraTarjetas" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="saldos.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
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
					<img src="../../lib/img/espera.gif" class="img-fluid" alt="Responsive image" background="" width="400" height="400">
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
                            title: 'Saldos a Favor'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    
    $("#contenido").on("click", "#btnBuscarMoraTarjetas", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarSaldos.php",
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
                            title: 'Saldos a Favor'
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
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la peticiÃ³n </div>');
            }
        });
        return false;
    });
	
	
	$("#contenido2").on("click", "img.detallesClientesPrestamos", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesSaldos.php",
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

