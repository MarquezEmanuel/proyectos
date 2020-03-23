<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Cuentas por cerrar saldo deudor</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(saldo as money),1) AS saldo2 FROM [3ACMOL]
                                    WHERE id =" . $idCuenta;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fechaUltimoMovimiento =  "";
                $fechaUltimoMovimiento = isset($cuen['fechaUltimoMovimiento']) ? $cuen['fechaUltimoMovimiento']->format('d/m/Y') : "";
                $nombreCliente = utf8_encode($cuen['nombreCliente']);
                ?>
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                        <input type="hidden" id="idCuenta" name="idCuenta" value="<?= $cuen['id'] ?>">
                        <label for="numeroClietne" class="col-sm-2 col-form-label">N&uacute;mero de Cliente:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['numeroCliente']; ?>" readonly>
                        </div>
                        <label for="numeroCuenta" class="col-sm-2 col-form-label">N&uacute;mero de Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="cliente" class="col-sm-2 col-form-label">Nombre de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombreCliente; ?>" readonly>
                        </div>
                        <label for="producto" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col" >
                            <input type="number" class="form-control mb-2" value="<?= $cuen['producto']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="estado" class="col-sm-2 col-form-label">Estado:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2"  value="<?= $cuen['estado']; ?>" readonly>
                        </div>
                        <label for="definicionEstado" class="col-sm-2 col-form-label">Definicion de Estado:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['definicionEstado']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="saldo" class="col-sm-2 col-form-label">Saldo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['saldo2']; ?>" readonly>
                        </div>
                        <label for="fecha" class="col-sm-2 col-form-label">Fecha de ultimo movimiento:</label>
                        <div class="col">
							<input type="text" class="form-control mb-2" value="<?= $fechaUltimoMovimiento; }?>" readonly>
                        </div>
                    </div>                    
                    <br>
                        &nbsp;
                        <a href="<?=$_SERVER["HTTP_REFERER"]?>"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>



