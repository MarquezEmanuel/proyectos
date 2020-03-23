<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Mora Comercial</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idMora = $_POST['seleccionado'];
            $query = "SELECT *, convert(varchar,cast(montoTotal as money),1) AS montoTotal2, convert(varchar,cast(montoExigible as money),1) AS montoExigible2,"
        . "convert(varchar,cast(MME as money),1) AS MME2 FROM [bd_sib].[dbo].[moraComercial] WHERE numeroCliente = '". $idMora ."'";
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
                        <label for="transaccion" class="col-sm-2 col-form-label">Numero de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['numeroCliente']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">CUIT - CUIL:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['numeroCuit'];; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Nombre de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombreCliente; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['sucursal']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Dias de Atraso:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['diasAtraso']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Monto Total:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['montoTotal2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Monto Exigible:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['montoExigible2']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">MME:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['MME2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['producto'];; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Cartera:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cartera']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Proyeccion:</label>
                        <div class="col">
			<input type="text" class="form-control mb-2"  value="<?= $cuen['proyeccion'];} ?>" readonly>
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


