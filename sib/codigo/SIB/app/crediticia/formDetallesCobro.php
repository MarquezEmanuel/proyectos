<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Cobros no aplicados en compra de cartera</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCobro = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(saldoTerceros as money),1) AS saldoTerceros2 FROM [4cobroNoAplicado]
                                    WHERE id =" . $idCobro;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCobro || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
                $cuen = sqlsrv_fetch_array($result);
                $nombreCliente = utf8_encode($cuen['nombreCliente']);
                ?>
                <div class="container">
                    <br><br>
                    <div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['producto']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['sucursal']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Cuenta prestamo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuentaCredito']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Saldo de terceros:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['saldoTerceros']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Numero de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['numeroCliente']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombreCliente;}?>" readonly>
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


