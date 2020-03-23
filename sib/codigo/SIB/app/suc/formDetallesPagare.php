<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Pagare no cargados en SAV</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
            $query = "SELECT * FROM [3crucePPMAPySAV]
                                    WHERE id =" . $idCuenta;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fechaLiquidacion = $fechaVencimiento = "";
                $fechaLiquidacion = isset($cuen['fechaLiquidacion']) ? $cuen['fechaLiquidacion']->format('d/m/Y') : "";
                $fechaVencimiento = isset($cuen['fechaVencimiento']) ? $cuen['fechaVencimiento']->format('d/m/Y') : "";
				$nombreCliente = utf8_encode($cuen['snoCliente']);
                ?>
            <form action="guardarPagare.php" method="post">
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                        <input type="hidden" id="idCuenta" name="idCuenta" value="<?= $cuen['id'] ?>">
                        <label for="pcu" class="col-sm-2 col-form-label">PCU Sucursal Origen:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['pcuOfici']; ?>" readonly>
                        </div>
                        <label for="numeroCuenta" class="col-sm-2 col-form-label">PCU numero de Cuenta:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['pcuNumeroCuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="numeroCliente" class="col-sm-2 col-form-label">N&uacute;mero de Cliente:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['scoIdent']; ?>" readonly>
                        </div>
                        <label for="cliente" class="col-sm-2 col-form-label">Cliente:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $nombreCliente; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="producto" class="col-sm-2 col-form-label">PCU Producto:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2"  value="<?= $cuen['pcuProducto']; ?>" readonly>
                        </div>
                        <label for="liquidacion" class="col-sm-2 col-form-label">Fecha liquidacion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fechaLiquidacion; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="vencimiento" class="col-sm-2 col-form-label">Fecha Vencimiento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fechaVencimiento; ?>" readonly>
                        </div>
                        <label for="estado" class="col-sm-2 col-form-label">Estado Prestamo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['estadoPrestamo']; ?>" readonly>
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


