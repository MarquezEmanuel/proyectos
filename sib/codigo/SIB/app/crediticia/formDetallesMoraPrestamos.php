<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Mora En Prestamos</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idMoraPrestamos = $_POST['seleccionado'];
            $query = "SELECT *, convert(varchar,cast(importeCuota as money),1) AS importeCuota2, convert(varchar,cast(interesNormal as money),1) AS interesNormal2,"
        . "convert(varchar,cast(capital as money),1) AS capital2, convert(varchar,cast(punitorios as money),1) AS punitorios2, "
        . "convert(varchar,cast(gastos as money),1) AS gastos2, convert(varchar,cast(compensatorios as money),1) AS compensatorios2 FROM [4moraPrestamos] WHERE id = ". $idMoraPrestamos;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idMoraPrestamos || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
                $cuen = sqlsrv_fetch_array($result);
                $nombreCliente = utf8_encode($cuen['nombreCliente']);
                $vencimiento = isset($cuen['vencimiento']) ? $cuen['vencimiento']->format('d/m/Y') : "";
                ?>
                <div class="container">
                    <br><br>
                    <div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Numero de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['numeroCliente']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Nombre de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombreCliente; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['sucursal']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Cuenta:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['producto']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Moneda:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['moneda'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Atributo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['atributo']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Cuota:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuota']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Vencimiento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $vencimiento; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Importe de Cuota:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['importeCuota2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Interes Normal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['interesNormal2']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Capital:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['capital2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Punitorios:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['punitorios2']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Gastos:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['gastos2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Compensatorios:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['compensatorios2']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Dias de Mora:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['diasMora']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Legajo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['legajo']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Carpeta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['carpeta'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Tipo de Credito:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['tipoCredito'];}?>" readonly>
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


