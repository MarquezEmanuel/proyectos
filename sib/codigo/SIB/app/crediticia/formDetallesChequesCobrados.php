<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Cheques cobrados por morosos</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCobranzasTC = $_POST['seleccionado'];
            $query = "SELECT *, convert(varchar,cast(monto as money),1) AS monto2, convert(varchar,cast(deuda as money),1) AS deuda2 FROM [5chequesCobradosMorosos] WHERE id = ". $idCobranzasTC;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if (!$idCobranzasTC || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
                $cuen = sqlsrv_fetch_array($result);
                $fecha = isset($cuen['fecha']) ? $cuen['fecha']->format('d/m/Y') : "";
                ?>
                <div class="container">
                    <br><br>
                    <div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['sucursal']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Digito:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['digito']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Nombre de la Cuenta:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['nombreCuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">CUIL Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['cuilCuenta']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Producto de la Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['productoCuenta'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Depositante:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['depositante']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Ordenante:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['ordenante']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Documento del Cobrador:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['documentoCobrador']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Monto:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['monto2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Fecha:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $fecha; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Codigo Usuario:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['codigoUsuario'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Sucursal de Pago:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['sucursalPago']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">CUIL de el Deudor:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuilDeudor']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Dias de Atraso:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['diasAtraso']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Deuda:</label>
                        <div class="col" >
							<input type="text" class="form-control mb-2" value="<?= $cuen['deuda2']; }?>" readonly>
                        </div>
                </div>                    
                <br>
                &nbsp;
                <a href="<?= $_SERVER["HTTP_REFERER"] ?>"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>


