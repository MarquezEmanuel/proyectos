<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Mora En Tarjetas</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idMora = $_POST['seleccionado'];
            $query = "SELECT *, convert(varchar,cast(total as money),1) AS total2, convert(varchar,cast(minimo as money),1) AS minimo2,"
        . "convert(varchar,cast(mora as money),1) AS mora2, convert(varchar,cast(saldo as money),1) AS saldo2 FROM [4moraTarjetas] WHERE id = ". $idMora;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idMora || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
                $cuen = sqlsrv_fetch_array($result);
                $nombreCliente = utf8_encode($cuen['nombreCliente']);
                ?>
                <div class="container">
                    <br><br>
                    <div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Marca:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['marca']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['sucursal'];; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Cuenta de Tarjeta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuentaTarjeta']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Total:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['total2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Minimo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['minimo2']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Mora:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['mora2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Dias de Atraso:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['diasAtraso']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Nombre de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombreCliente; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Documento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['documento'];; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Tipo de Cuenta:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['tipoCuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Sucursal de la Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['sucursalCuenta']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuenta'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Digito:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['digito']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Saldo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['saldo2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Codigo de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['codigoCliente']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['producto'];} ?>" readonly>
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


