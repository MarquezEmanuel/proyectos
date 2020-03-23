<?php
include_once '../conf/BDConexion.php';
require_once '../../lib/PHPExcel/Classes/PHPExcel.php';


/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>SWIFT</u></h3>
        <div id="centro" class="container">
            <form action="swiftprocesar.php" method="post" enctype="multipart/form-data">
			<br><hr /><br>
                <div class="row">
                    <label for="swift" class="col-sm-4 col-form-label" title="Documentos de tasaci&oacute;n">Ingresar Archivo Con Formato Requerido:</label>
                        <div class="col">
                            <input type="file" id="archivoSwift" name="archivoSwift[]" class="file" data-show-upload="true" data-show-caption="true">
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
                            <a href="swift.php"><input type="button" class="btn btn-dark" id="" name="" value="Canceeeelar"></a>
                             &nbsp;
                             <a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2">

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
</html>

