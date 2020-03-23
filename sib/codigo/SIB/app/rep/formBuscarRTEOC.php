<?php
/* INICIALIZA LA SESION */
session_start();

require_once './menuReportes.php';
?>
    <div class="card-header">
        <div id="contenido">
            <br><div class="row">
                <div class="col">
                    <div class="text-center">
                        <h4>BUSCAR RTE - OPERACIÓN DE CAMBIO</h4>
                    </div>
                </div>
            </div>
            <br>
            <div id="centro" class="container">
                <form id="formBuscarReporte" name="formBuscarReporte" method="POST">
                    <div class="row">
                        <div class="col">
                            <label class="mr-sm-2">Transaccion:</label> 
                            <input type="text" class="form-control" id="transaccion" name="transaccion" placeholder="Transaccion">
                        </div>
                        <div class="col">
                            <label class="mr-sm-2">Localidad:</label> 
                            <input type="text" class="form-control" id="localidad" name="localidad" placeholder="Localidad">
                        </div>
                        <div class="col">
                            <label class="mr-sm-2">CUIT-CUIL:</label> 
                            <input type="number" class="form-control" id="cuit" name="cuit" placeholder="CUIT - CUIL">
                        </div>
                        <div class="col">
                            <label class="mr-sm-2">Numero de documento:</label> 
                            <input type="number" class="form-control" id="documento" name="documento" placeholder="Numero de documento">
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <input type="submit" class="btn btn-success" id="btnBuscarReporte" name="btnBuscarReporte" value="Buscar" class="btn btn-bsc mt-4">
                                <a href="formBuscarRTEOC.php"><input type="button" class="btn btn-outline-secondary" id="" name="" value="Cancelar"></a>
                                <a href="inicioRTEOC.php"><input type="button" class="btn btn-outline-secondary" id="" name="" value="Volver"></a>
                            </div>
                        </div>
                    </div><br>
                </form>
            </div>
        </div>


        <div id="contenido2" name="contenido2"></div>

    </div>
</body>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/BuscarRTEOC.js"></script>
</html>