<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();
//Cobro no aplicado

$_SESSION['buscar'] = null;
$print = '';
$usuario = trim($_SESSION['legajo']);
$directorio = opendir(URL_ConstanciaSaldo); //ruta actual
$print = '<form method="POST" action="procesarGenerarPDF.php"> 
			<input type="submit" class="btn btn-dark" id="btnEnviarCorreo" name="btnEnviarCorreo" value="Descargar"></a>
            &nbsp;
            <a href="buscarConstanciaSaldos.php"><input type="button" class="btn btn-dark" value="Volver"></a>
            <br><br>
					
                        <input type="hidden" name="reporte" id="reporte" value="EXTRACCIONES POR CAJA">
                        <input type="hidden" name="origen" id="origen" value="extraccionesMayores.php">
                        <div class="table-responsive">
                            <table id="diariosExtraccionesMayores" class="table table-striped table-bordered table-hover">
                                    <thead style="background-color:#1d6091;color:white;">
                                        <tr>
											<th class="text-center align-middle"><input type="checkbox" id="seleccionarTodos" name="seleccionarTodos"></th>
                                            <th>Nombre</th>
                                        </tr>
            </thead>
        <tbody>';
while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
{
    if (!is_dir($archivo))//verificamos si es o no un directorio
    {
		$print = $print . "
            <tr>
				<td><input type='checkbox' value='".$archivo."' id='cbCorreos' name='cbCorreos[]'></td>
                <td>".$archivo."</td>
            </tr>";
    }
}
$print = $print . " </tbody>
                            </table>
                        </div>
                    </form>";


require_once './header.php';
?>

    <div class="card-header">
	<div id="contenido">
        <div class="center">
            <h3 class="text-center"><u>Constancia de saldos</u></h3>
        </div>
		<br>
            <?= $print ?>
	</div>
		<div id="contenido2" name="contenido2">
		
		</div>
	</div>

</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
$("#seleccionarTodos").change(function () {
        if ($(this).is(':checked')) {
            $("input[name='cbCorreos[]']").each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $("input[name='cbCorreos[]']").each(function () {
                $(this).prop('checked', false);
            });
        }
    });
	
	/* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */
	
	
    
    $("#centro").on("click", "img.detallesCobranzasTC", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "procesarBaja.php",
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
	
	/*MODIFICAR USUARIO*/
	
	
	$("#centro").on("click", "img.modificarUsuario", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "modificacion.php",
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