<?php

/* AGREGA LA CABECERA CON EL MENU */
require_once './menuSucursal.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Central de cuentacorrentistas inhabilitados</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarCuenta" name="formBuscarCuenta" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Cliente:</label> 
                        <input type="text" class="form-control" 
                               id="cliente" name="cliente" 
                               pattern="[A-Za-zÁÉÍÚÓáéíúó ]{0,100}"
                               placeholder="Nombre y Apellido"
                               title="Cliente">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">CUIT-CUIL:</label> 
                        <input type="number" class="form-control" 
                               id="cuil" name="cuil"
                               placeholder="CUIT-CUIL" 
                               title="CUIT-CUIL">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio"
                               placeholder="DD/MM/AAAA" title="Fecha inicio">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Fin:</label> 
                        <input type="date" class="form-control" 
                               id="fechaFin" name="fechaFin"
                               placeholder="DD/MM/AAAA" title="Fecha fin">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarCuenta" name="btnBuscarCuenta" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                            &nbsp;
                            <a href="formCentralCuentacorrentista.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2"></div>
</div>
</body>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/buscarCuentacorrentista.js"></script>
</html>
