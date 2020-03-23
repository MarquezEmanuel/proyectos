<?php
/* AGREGA LA CABECERA CON EL MENU */
require_once './menuSucursal.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha = Date("Y-m-d");

?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Solicitudes de workflow</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarSolicitudesWF" name="formBuscarSolicitudesWF" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Descripción:</label> 
                        <input type="text" class="form-control" 
                               id="descripcion" name="descripcion"
                               placeholder="Descripción de solicitud" 
                               title="Descripción del estado para la solicitud">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Cliente:</label> 
                        <input type="number" class="form-control" 
                               id="cliente" name="cliente" 
                               placeholder="Número/CUIL de cliente"
                               title="Número o CUIL de cliente">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio" max="<?= $fecha; ?>"
                               placeholder="DD/MM/AAAA" title="Fecha inicio para cambio de estado">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Fin:</label> 
                        <input type="date" class="form-control" 
                               id="fechaFin" name="fechaFin" max="<?= $fecha; ?>"
                               placeholder="DD/MM/AAAA" title="Fecha fin para cambio de estado">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarSolicitudes" name="btnBuscarSolicitudes" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="formBuscarSolicitudesWF.php"><input type="button" class="btn btn-dark" value="Cancelar"></a>
                            &nbsp;
                            <a href="formSolicitudesWF.php"><input type="button" class="btn btn-dark" value="Volver"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2"></div>
</div>
</body>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/buscarSolicitudesWF.js"></script>
</html>
