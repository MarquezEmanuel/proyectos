<?php
include_once '../conf/BDConexion.php';
require_once '../../lib/PHPExcel/Classes/PHPExcel.php';

/* INICIALIZA LA SESION */
session_start();


/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Generar Archivo PMDEB</u></h3>
        <div id="centro" class="container">
            <form action="procesarPmdeb.php" method="post" enctype="multipart/form-data">
			<br><hr /><br>
                <div class="row">
                    <label for="imagenTasPren" class="col-sm-4 col-form-label" title="Documentos de tasaci&oacute;n">Ingresar Archivo Con Formato Requerido:</label>
                        <div class="col">
                            <input type="file" id="imagenTasPren" name="imagenTasPren[]" class="file" data-show-upload="true" data-show-caption="true">
                        </div>
                </div>
				<br>
				<hr />
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="" name="" value="Generar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="pmdeb.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
							&nbsp;
                            <a href="pmdebResultados.php"><input type="button" class="btn btn-dark" id="" name="" value="Resultados"></a>
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
// $archivo = "tarjetass.xls";
// $inputFileType = PHPExcel_IOFactory::identify($archivo);
// $objReader = PHPExcel_IOFactory::createReader($inputFileType);
// $objPHPExcel = $objReader->load($archivo);
// $sheet = $objPHPExcel->getSheet(0); 
// $highestRow = $sheet->getHighestRow(); 
// $highestColumn = $sheet->getHighestColumn();

// for ($row = 2; $row <= $highestRow; $row++){ 
		// echo $sheet->getCell("A".$row)->getValue()." - ";
		// echo $sheet->getCell("B".$row)->getValue()." - ";
		// echo $sheet->getCell("C".$row)->getValue()." - ";
		// echo $sheet->getCell("D".$row)->getValue()." - ";
		// echo $sheet->getCell("E".$row)->getValue()." - ";
		// echo $sheet->getCell("F".$row)->getValue();
		// echo "<br>";
// }
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
    
    $("#contenido").on("click", "#btnBuscarCobranzasTC", function () {
        $.ajax({
            type: "POST",
            url: "procesarPmdeb.php",
            data: $("#formBuscarCobranzasTC").serialize(),
			beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
			},
            success: function (data) {
                $("#contenido2").html(data);
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
            url: "formDetallesCobranzasTC.php",
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

