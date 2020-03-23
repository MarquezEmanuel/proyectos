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
                        <h4>BUSCAR CUENTAS COMITENTE</h4>
                    </div>
                </div>
            </div>
            <br>
            <div id="centro" class="container">
                <form id="formBuscarCuentaComitente" name="formBuscarCuentaComitente" method="POST">
                    <div class="row">
                        <div class="col">
                            <label class="mr-sm-2">Numero de Cuenta Depositante:</label> 
                            <input type="number" class="form-control" id="depositante" name="depositante" placeholder="Numero de cuenta depositante">
                        </div>
                        <div class="col">
                            <label class="mr-sm-2">Numero de Cuenta Comitente:</label> 
                            <input type="number" class="form-control" id="comitente" name="comitente" placeholder="Numero de cuenta comitente">
                        </div>
                        <div class="col">
                            <label class="mr-sm-2">Estado de la Cuenta:</label> 
                            <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado de la cuenta">
                        </div>
                        <div class="col">
                            <label class="mr-sm-2">Tipo de Accion:</label> 
                            <input type="text" class="form-control" id="accion" name="accion" placeholder="Tipo de accion">
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <input type="submit" class="btn btn-success" id="btnBuscarCuentaComitente" name="btnBuscarCuentaComitente" value="Buscar" class="btn btn-bsc mt-4">
                                <a href="formBuscarCuentaComitente.php"><input type="button" class="btn btn-outline-secondary" id="" name="" value="Cancelar"></a>
                                <a href="cargarCuentaComitente.php"><input type="button" class="btn btn-outline-secondary" id="" name="" value="Volver"></a>
                            </div>
                        </div>
                    </div><br>
                </form>
            </div>
        </div>


        <div id="contenido2" name="contenido2"></div>

    </div>
</body>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/BuscarCuentaComitente.js"></script>
</html>