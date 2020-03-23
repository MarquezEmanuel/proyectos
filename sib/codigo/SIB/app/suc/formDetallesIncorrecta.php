<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Incorrecta identificacion de clientes</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(monto as money),1) AS monto2 FROM [3transaccionIncorrecta]
                                    WHERE id =" . $idCuenta;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fecha = "";
                $fecha = isset($cuen['fecha']) ? $cuen['fecha']->format('d/m/Y') : "";
				$depositante = utf8_encode($cuen['depositante']);
                $ordenante = utf8_encode($cuen['ordenante']);
                $nombreUsuario = utf8_encode($cuen['nombreUsuario']);
                ?>
            <form action="guardarIncorrecta.php" method="post">
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                        <input type="hidden" id="idCuenta" name="idCuenta" value="<?= $cuen['id'] ?>">
                        <label for="causal" class="col-sm-2 col-form-label">Causal:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['causal']; ?>" readonly>
                        </div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Transaccion:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['transaccion']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="producto" class="col-sm-2 col-form-label">Nombre Transaccion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['nombreTransaccion']; ?>" readonly>
                        </div>
                        <label for="sucursal" class="col-sm-2 col-form-label">Concepto:</label>
                        <div class="col" >
                            <input type="number" class="form-control mb-2" value="<?= $cuen['concepto']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="cuenta" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2"  value="<?= $cuen['producto']; ?>" readonly>
                        </div>
                        <label for="digito" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['sucursal']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fecha" class="col-sm-2 col-form-label">Cuenta:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['cuenta']; ?>" readonly>
                        </div>
                        <label for="monto" class="col-sm-2 col-form-label">Digito:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['digito']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="usuario" class="col-sm-2 col-form-label">Depositante:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $depositante; ?>" readonly>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">Ordenante:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $ordenante; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursal" class="col-sm-2 col-form-label">CUIL depositante:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['documentoDepositante']; ?>" readonly>
                        </div>
                        <label for="tarjetaSAV" class="col-sm-2 col-form-label">CUIL ordenante:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['documentoOrdenante']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalOrigen" class="col-sm-2 col-form-label">Sucursal Operacion:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['sucursalOperacion']; ?>" readonly>
                        </div>
                        <label for="titular" class="col-sm-2 col-form-label">Usuario:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['usuario']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalOrigen" class="col-sm-2 col-form-label">Nombre Usuario:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombreUsuario; ?>" readonly>
                        </div>
                        <label for="titular" class="col-sm-2 col-form-label">Fecha:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fecha; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalOrigen" class="col-sm-2 col-form-label">Numero Operacion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['numeroOperacion']; ?>" readonly>
                        </div>
                        <label for="titular" class="col-sm-2 col-form-label">Monto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['monto2']; ?>" readonly>
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
                        <a href="<?=$_SERVER["HTTP_REFERER"]?>"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
            </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>