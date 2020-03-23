<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Fallas de caja</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(montoTransaccion as money),1) AS monto2 FROM [3fallas]
                                    WHERE id =" . $idCuenta;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fecha = "";
                $fecha = isset($cuen['fechaTransaccion']) ? $cuen['fechaTransaccion']->format('d/m/Y') : "";
                ?>
                <form action="guardarFallas.php" method="post">
                    <div class="container">
                        <br><br>
                        <div class="form-group row">
                            <input type="hidden" id="idCuenta" name="idCuenta" value="<?= $cuen['id'] ?>">
                            <label for="causal" class="col-sm-2 col-form-label">Sucursal Cuenta:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" value="<?= $cuen['sucursalCuenta']; ?>" readonly>
                            </div>
                            <label for="transaccion" class="col-sm-2 col-form-label">Numero Cuenta:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2" value="<?= $cuen['numeroCuenta']; ?>" readonly>
                            </div>
                            <div class="w-100"></div>
                            <label for="producto" class="col-sm-2 col-form-label">Numero Sucursal Origen:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $cuen['sucursalOrigen']; ?>" readonly>
                            </div>
                            <label for="sucursal" class="col-sm-2 col-form-label">Numero Comprobante:</label>
                            <div class="col" >
                                <input type="number" class="form-control mb-2" value="<?= $cuen['numeroComprobante']; ?>" readonly>
                            </div>
                            <div class="w-100"></div>
                            <label for="cuenta" class="col-sm-2 col-form-label">Moneda:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"  value="<?= $cuen['moneda']; ?>" readonly>
                            </div>
                            <label for="digito" class="col-sm-2 col-form-label">Usuario:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $cuen['usuario']; ?>" readonly>
                            </div>
                            <div class="w-100"></div>
                            <label for="fecha" class="col-sm-2 col-form-label">Supervisor:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $cuen['supervisor']; ?>" readonly>
                            </div>
                            <label for="titular" class="col-sm-2 col-form-label">Hora Sistema:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $cuen['horaSistema']; ?>" readonly>
                            </div>
                            <div class="w-100"></div>
                            <label for="usuario" class="col-sm-2 col-form-label">Numero Secuencia:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $cuen['numeroSecuencia']; ?>" readonly>
                            </div>
                            <label for="nombre" class="col-sm-2 col-form-label">Categoria Transaccion:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $cuen['categoriaTransaccion']; ?>" readonly>
                            </div>
                            <div class="w-100"></div>
                            <label for="sucursal" class="col-sm-2 col-form-label">Estado Transaccion:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $cuen['estadoTransaccion']; ?>" readonly>
                            </div>
                            <label for="tarjetaSAV" class="col-sm-2 col-form-label">Tipo Transaccion:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $cuen['tipoTransaccion']; ?>" readonly>
                            </div>
                            <div class="w-100"></div>
                            <label for="sucursalOrigen" class="col-sm-2 col-form-label">Fecha Transaccion:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $fecha; ?>" readonly>
                            </div>
                            <label for="sucursalOrigen" class="col-sm-2 col-form-label">Nombre Transaccion:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $cuen['nombreTransaccion']; ?>" readonly>
                            </div>
                            <div class="w-100"></div>
                            <label for="sucursalOrigen" class="col-sm-2 col-form-label">Monto Transaccion:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="<?= $cuen['monto2']; ?>" readonly>
                            </div>
                            <label for="comentario" class="col-sm-2 col-form-label">Comentario:</label>
                            <div class="col" >
                                <textarea type="input" class="form-control mb-2" id="comentario" name="comentario"><?= $cuen['comentario'];
        } ?></textarea>
                        </div>
                    </div>                    
                    <br>
                    <input type="submit" class="btn btn-dark" id="guardar" name="guardar" value="Guardar Comentario">
                    &nbsp;
                    <a href="<?= $_SERVER["HTTP_REFERER"] ?>"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>