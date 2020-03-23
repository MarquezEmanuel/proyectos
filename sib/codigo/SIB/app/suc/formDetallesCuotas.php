<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Prestamos con cuenta asociada</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuota = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(monto as money),1) AS monto2 FROM [3prestamosConCuentaAsociada]
                                    WHERE id =" . $idCuota;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuota || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fechaTransaccion = "";
                $fechaTransaccion = isset($cuen['fechaTransaccion']) ? $cuen['fechaTransaccion']->format('d/m/Y') : "";
                $nombreTransaccion = utf8_encode($cuen['nombreTransaccion']);
                $nombreCuenta = utf8_encode($cuen['nombreCuenta']);
                $cliente = utf8_encode($cuen['cliente']);
                $nombreUsuario = utf8_encode($cuen['nombreUsuario']);
                ?>
            <form action="guardarCuotas.php" method="post">
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                        <input type="hidden" id="idCuota" name="idCuota" value="<?= $cuen['id'] ?>">
                        <label for="transaccion" class="col-sm-2 col-form-label">Transaccion:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['transaccion']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Causal:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['causal']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Nombre de Trans.:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombreTransaccion; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Tipo Cuenta:</label>
                        <div class="col" >
                            <input type="number" class="form-control mb-2" value="<?= $cuen['tipoCuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Prod. Cuenta:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2"  value="<?= $cuen['productoCuenta']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Sucursal Cuenta:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['sucursalCuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="cuenta" class="col-sm-2 col-form-label">Cuenta:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['cuenta']; ?>" readonly>
                        </div>
                        <label for="digitoCuenta" class="col-sm-2 col-form-label">Digito Cuenta:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['digitoCuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreCuenta" class="col-sm-2 col-form-label">Nombre Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombreCuenta; ?>" readonly>
                        </div>
                        <label for="productoPrestamo" class="col-sm-2 col-form-label">Prod. Prestamo:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['productoPrestamo']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalPrestamo" class="col-sm-2 col-form-label">Suc. Prestamo:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['sucursalPrestamo']; ?>" readonly>
                        </div>
                        <label for="prestamo" class="col-sm-2 col-form-label">Prestamo:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['prestamo']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="cliente" class="col-sm-2 col-form-label">Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cliente; ?>" readonly>
                        </div>
                        <label for="sucursalOperacion" class="col-sm-2 col-form-label">Suc. Operacion:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['sucursalOperacion']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="usuarioTransaccion" class="col-sm-2 col-form-label">Usuario Trans.:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['usuarioTransaccion']; ?>" readonly>
                        </div>
                        <label for="nombreUsuario" class="col-sm-2 col-form-label">Nombre Usuario:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombreUsuario; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="monto" class="col-sm-2 col-form-label">Monto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['monto2']; ?>" readonly>
                        </div>
                        <label for="clientePrestamo" class="col-sm-2 col-form-label">Cliente Prestamo:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['clientePrestamo']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="clienteCuenta" class="col-sm-2 col-form-label">Cliente Cuenta:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['clienteCuenta']; ?>" readonly>
                        </div>
                        <label for="fechaTransaccion" class="col-sm-2 col-form-label">Fecha Transaccion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fechaTransaccion; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="comentario" class="col-sm-2 col-form-label">Comentario:</label>
                        <div class="col" >
                            <textarea type="input" class="form-control mb-2" id="comentario" name="comentario"><?= $cuen['comentario']; }?></textarea>
                        </div>
                    </div>                    
                    <br>
                    <input type="submit" class="btn btn-dark" id="guardar" name="guardar" value="Guardar Comentario">
                        &nbsp;
                        <a href="formBuscarCobroCuotas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
            </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>


