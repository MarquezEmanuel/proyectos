<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Reversas</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(montoTransaccion as money),1) AS montoTransaccion2 FROM [3reversas]
                                    WHERE id =" . $idCuenta;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fechaTransaccion = "";
                $fechaTransaccion = isset($cuen['fechaTransaccion']) ? $cuen['fechaTransaccion']->format('d/m/Y') : "";
                ?>
            <form action="guardarReversas.php" method="post">
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                        <input type="hidden" id="idCuenta" name="idCuenta" value="<?= $cuen['id'] ?>">
                        <label for="sucursal" class="col-sm-2 col-form-label">Sucursal Cuenta:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['sucursalCuenta']; ?>" readonly>
                        </div>
                        <label for="numeroCuenta" class="col-sm-2 col-form-label">N&uacute;mero de Cuenta:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['numeroCuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalOrigen" class="col-sm-2 col-form-label">N&uacute;mero sucursal de origen:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['numeroSucursalOrigen']; ?>" readonly>
                        </div>
                        <label for="comprobante" class="col-sm-2 col-form-label">N&uacute;mero Comprobante:</label>
                        <div class="col" >
                            <input type="number" class="form-control mb-2" value="<?= $cuen['numeroComprobante']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="moneda" class="col-sm-2 col-form-label">Moneda:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['moneda']; ?>" readonly>
                        </div>
                        <label for="usuario" class="col-sm-2 col-form-label">Usuario:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['usuario']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="supervisor" class="col-sm-2 col-form-label">Supervisor:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['supervisor']; ?>" readonly>
                        </div>
                        <label for="concepto" class="col-sm-2 col-form-label">Concepto:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['concepto']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="secuencia" class="col-sm-2 col-form-label">N&uacute;mero Secuencia:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['numeroSecuencia']; ?>" readonly>
                        </div>
                        <label for="categoria" class="col-sm-2 col-form-label">Cateogria Transaccion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['categoriaTransaccion']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="estado" class="col-sm-2 col-form-label">Estado Transaccion:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['estadoTransaccion']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Tipo Transaccion:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['tipoTransaccion']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaTransaccion" class="col-sm-2 col-form-label">Fecha Transaccion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fechaTransaccion; ?>" readonly>
                        </div>
                        <label for="monto" class="col-sm-2 col-form-label">Monto Transaccion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['montoTransaccion2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Nombre Transaccion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['nombreTransaccion']; ?>" readonly>
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

