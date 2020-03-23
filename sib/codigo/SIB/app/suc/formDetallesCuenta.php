<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Detalles de cuentacorrentista inhabilitado</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
            $query = "SELECT * FROM cuentaCorrentistasInhabilitados
                                    WHERE ID LIKE '" . $idCuenta ."'";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $nombreCuenta = utf8_encode($cuen['NOMBRECUENTA']);
                $nombreCliente = utf8_encode($cuen['NOMBRECLIENTE']);
                ?>
            <form action="guardarCuenta.php" method="post">
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                            <input type="hidden" id="idCuenta" name="idCuenta" value="<?= $cuen['ID'] ?>">
                            <label for="sucursal" class="col-sm-2 col-form-label">Sucursal:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $cuen['SUCURSAL']; ?>" readonly>
                            </div>
                            <label for="numeroCuenta" class="col-sm-2 col-form-label">N&uacute;mero de Cuenta:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" value="<?= $cuen['NUMEROCUENTA']; ?>" readonly>
                            </div>
                            <div class="w-100"></div>
                            <label for="digito" class="col-sm-2 col-form-label">Digito Verificador:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" value="<?= $cuen['DIGITO']; ?>" readonly>
                            </div>
                            <label for="codigo" class="col-sm-2 col-form-label">Codigo Usuario:</label>
                            <div class="col" >
                                <input type="number" class="form-control mb-2" value="<?= $cuen['NUMEROCLIENTE']; ?>" readonly>
                            </div>
                            <div class="w-100"></div>
                            <label for="cuenta" class="col-sm-2 col-form-label">Nombre Cuenta:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"  value="<?= $nombreCuenta; ?>" readonly>
                            </div>
                            <label for="cuit" class="col-sm-2 col-form-label">CUIT - CUIL:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" value="<?= $cuen['CUIT']; ?>" readonly>
                            </div>
                            <div class="w-100"></div>
                            <label for="cliente" class="col-sm-2 col-form-label">Nombre Cliente:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $nombreCliente; ?>" readonly>
                            </div>
                            <label for="producto" class="col-sm-2 col-form-label">Codigo de Producto:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" value="<?= $cuen['PRODUCTO']; ?>" readonly>
                            </div>
                            <div class="w-100"></div>
                            <label for="ccoEst" class="col-sm-2 col-form-label">Tipo de relacion:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" value="<?= $cuen['TIPORELACION']; ?>" readonly>
                            </div>
                            <label for="fechaInicio" class="col-sm-2 col-form-label">Fecha Alta:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $cuen['FECHAALTA']; ?>" readonly>
                            </div>
                            <div class="w-100"></div>
                            <label for="fechaFin" class="col-sm-2 col-form-label">Fecha Fin:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?=$cuen['FECHAHASTA'];}?>" readonly>
                        </div>
                    </div>                     
                    <br>
                        &nbsp;
                        <a href="<?=$_SERVER["HTTP_REFERER"]?>"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
            </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

