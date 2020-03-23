<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Cobranzas Tarjeta de Credito</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idSaldosMora = $_POST['seleccionado'];
            $query = "SELECT *, convert(varchar,cast(montoTotal as money),1) AS montoTotal2, convert(varchar,cast(deudaVencidaTotal as money),1) AS deudaVencidaTotal2,"
        . "convert(varchar,cast(montoExigible as money),1) AS montoExigible2, convert(varchar,cast(mme as money),1) AS mme2, "
        . "convert(varchar,cast(saldoCuentas as money),1) AS saldoCuentas2 FROM [4saldosClientesMora] WHERE id =". $idSaldosMora;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idSaldosMora || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
                $cuen = sqlsrv_fetch_array($result);
                $nombre = utf8_encode($cuen['nombre']);
                $conyuge = utf8_encode($cuen['conyuge']);
                $fechaAltaEtapa = isset($cuen['fechaAltaEtapa']) ? $cuen['fechaAltaEtapa']->format('d/m/Y') : "";
                ?>
                <div class="container">
                    <br><br>
                    <div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Numero Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['numeroCliente']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">CUIT:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['numeroCuit']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Numero de Documento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['numeroDocumento']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Nombre:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $nombre; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['sucursal']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Cartera:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cartera'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Dias de Atraso:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['diasAtraso']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Producto con Mayor Atraso:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['productoMayorAtraso']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Monto Total:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['montoTotal2']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Deuda Total Vencida:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['deudaVencidaTotal2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Monto Exigible:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['montoExigible2']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">MME:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['mme2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Fallecido:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['fallecido']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Confidencial:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['confidencial']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Agencia:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['agencia']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Etapa:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['etapa']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Fecha Alta Etapa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $fechaAltaEtapa; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Situacion BCRA:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['situacionBCRA'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Conyuge:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $conyuge;?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Organismo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['organismo'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Empresa Haberes:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['empresaHaberes']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Tipo de Gestion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['tipoGestion'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Cantidad de Cuentas:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cantidadCuentas'];?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Saldo en Cuentas:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['saldoCuentas2'];}?>" readonly>
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


