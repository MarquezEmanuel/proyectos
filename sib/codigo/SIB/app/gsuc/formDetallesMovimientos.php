<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Movimientos Sin Depositantes</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(montoOrigen as money),1) AS montoOrigen2, convert(varchar,cast(montoPesos as money),1) AS montoPesos2 FROM [3movimientoSinDepositantes]
                                    WHERE id =" . $idCuenta;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fechaValor = "";
                $fechaValor = isset($cuen['fechaValor']) ? $cuen['fechaValor']->format('d/m/Y') : "";
                ?>
            <form action="guardarMovimientos.php" method="post">
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                        <input type="hidden" id="idCuenta" name="idCuenta" value="<?= $cuen['id'] ?>">
                        <label for="sucursal" class="col-sm-2 col-form-label">Concepto:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['concepto']; ?>" readonly>
                        </div>
                        <label for="numeroCuenta" class="col-sm-2 col-form-label">Tipo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['tipo']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalOrigen" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['codigoSucursal']; ?>" readonly>
                        </div>
                        <label for="comprobante" class="col-sm-2 col-form-label">N&uacute;mero de Cuenta:</label>
                        <div class="col" >
                            <input type="number" class="form-control mb-2" value="<?= $cuen['numeroCuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="moneda" class="col-sm-2 col-form-label">Digito Verificador:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2"  value="<?= $cuen['digitoVerificador']; ?>" readonly>
                        </div>
                        <label for="usuario" class="col-sm-2 col-form-label">Codigo de Moneda:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['codigoMoneda']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="supervisor" class="col-sm-2 col-form-label">Codigo de Usuario:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['codigoUsuario']; ?>" readonly>
                        </div>
                        <label for="concepto" class="col-sm-2 col-form-label">Nombre de Usuario:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['nombreUsuario']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="categoria" class="col-sm-2 col-form-label">Fecha Valor:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fechaValor; ?>" readonly>
                        </div>
                        <label for="estado" class="col-sm-2 col-form-label">Monto Origen:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['montoOrigen2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="tipo" class="col-sm-2 col-form-label">Monto en Pesos:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['montoPesos2']; ?>" readonly>
                        </div>
                        <label for="comentario" class="col-sm-2 col-form-label">Comentario:</label>
                        <div class="col" >
                            <textarea type="input" class="form-control mb-2" id="comentario" name="comentario"><?= $cuen['comentario']; }?></textarea>
                        </div>
                    </div>                    
                    <br>
                    <input type="submit" class="btn btn-dark" id="guardar" name="guardar" value="Guardar Comentario">
                        &nbsp;
                        <a href="<?=$_SERVER["HTTP_REFERER"]?>"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
            </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

