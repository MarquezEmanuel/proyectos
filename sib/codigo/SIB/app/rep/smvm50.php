<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();
//Cobro no aplicado


	date_default_timezone_set('America/Argentina/Buenos_Aires');
	$month = date('m', strtotime('-1 month'));
    $day = date("d", mktime(0,0,0, $month+1, 0, date('Y')));
	$ultimo = date('d-m-y', mktime(0,0,0, $month, $day, date('Y')));
	$primero = date('d-m-y', mktime(0,0,0, $month, 1, date('Y')));
	
	//FALA PONER MES
	
	$sql = "SELECT UNO.*, DOS.nombre, convert(varchar,cast(UNO.consolidado as money),1) AS consolidado2 FROM (SELECT SUM (SI.consolidado) consolidado,SI.documento FROM (SELECT *
  FROM [bd_sib].[dbo].[7regimenConsolidadoMaster]
  union all
  SELECT * from [bd_sib].[dbo].[7regimenConsolidadoVisa]) SI
  where SI.consolidado >= (select saldo*50 FROM [bd_sib].[dbo].[SMVM])
  group by SI.documento) UNO
  left join (select * from [bd_sib].[dbo].[7regimenConsolidadoMaster]
 union all
 select * from [bd_sib].[dbo].[7regimenConsolidadoVisa]) DOS ON UNO.documento = DOS.documento";
	$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
	
	if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = '<form method="POST" action="procesarGenerarConstanciaSaldos.php"> 
					<input type="submit" class="btn btn-dark" id="btnEnviarCorreo" name="btnEnviarCorreo" value="Generar" disabled></a>
            &nbsp;
            <a href="regimenTC.php"><input type="button" class="btn btn-dark" value="Volver"></a>
            <br><br>
					
                        <input type="hidden" name="reporte" id="reporte" value="EXTRACCIONES POR CAJA">
                        <input type="hidden" name="origen" id="origen" value="extraccionesMayores.php">
                        <div class="table-responsive">
                            <table id="diariosExtraccionesMayores" class="table table-striped table-bordered table-hover" style="width: 100%">
                                    <thead style="background-color:#1d6091;color:white;">
                                        <tr>
											<th class="text-center align-middle" class="text-center align-middle"><input type="checkbox" id="seleccionarTodos" name="seleccionarTodos"></th>
											<th class="text-center align-middle">Documento</th>
                                            <th class="text-center align-middle">Nombre</th>
											<th class="text-center align-middle">Consolidado</th>
											<th class="text-center align-middle">Desde/Hasta</th>
                                        </tr>
            </thead>
        <tbody>';
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['nombre']);
            $print = $print . "
            <tr>
				<td class='text-center align-middle'><input type='checkbox' id='transacciones' name='transacciones[]' value='{$row['documento']}'></td>
                <td class='text-center align-middle'>{$row['documento']}</td>
				<td class='text-center align-middle'>{$nombre}</td>
				<td class='text-center align-middle'>{$row['consolidado2']}</td>
				<td class='text-center align-middle'>{$primero}/{$ultimo}</td>
            </tr>";
        }
        $print = $print . " </tbody>
                            </table>
                        </div>
                    </form>";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados</div>';
    }
	}
	

require_once './menuReportes.php';
?>

    <div class="card-header">
	<div id="contenido">
        <div class="center">
            <h3 class="text-center"><u>SMVM Mayores a 50</u></h3>
        </div>
		<br>
            
	</div>
		<div id="contenido2" name="contenido2">
			<?= $print ?>
		</div>
	</div>

</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
	$('#diariosExtraccionesMayores').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'SMVMmayor50'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
	
	
	/* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */
	
	$("#contenido2").on("change", "#seleccionarTodos", function () {
        if ($(this).is(':checked')) {
            $("input[name='transacciones[]']").each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $("input[name='transacciones[]']").each(function () {
                $(this).prop('checked', false);
            });
        }
    });
	
    
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