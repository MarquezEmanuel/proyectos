<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Moras CPD</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(deuda as money),1) AS deuda2,convert(varchar,cast(interes as money),1) AS interes2,convert(varchar,cast(monto as money),1) AS monto2 FROM [3MorasCPD]
                                    WHERE id =" . $idCuenta;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fecha = "";
                $fecha = isset($cuen['fechaVencimiento']) ? $cuen['fechaVencimiento']->format('d/m/Y') : "";
                $nombreCliente = utf8_encode($cuen['nombreCliente']);
                ?>
            <form action="guardarMorasCPD.php" method="post">
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                        <input type="hidden" id="idCuenta" name="idCuenta" value="<?= $cuen['id'] ?>">
                        <label for="numeroCliente" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['sucursal']; ?>" readonly>
                        </div>
                        <label for="nombreCliente" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['producto'];; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="altaUsuario" class="col-sm-2 col-form-label">Numero de Cuenta:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['numeroCuenta']; ?>" readonly>
                        </div>
                        <label for="nombreUsuario" class="col-sm-2 col-form-label">Numero de Cliente:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['numeroCliente'];; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaAlta" class="col-sm-2 col-form-label">Nombre de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $nombreCliente; ?>" readonly>
                        </div>
                        <label for="fechaNacimiento" class="col-sm-2 col-form-label">Deuda:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['deuda2'];; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaAlta" class="col-sm-2 col-form-label">Interes:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['interes2'];; ?>" readonly>
                        </div>
                        <label for="fechaNacimiento" class="col-sm-2 col-form-label">Fecha de Vencimiento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fecha; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="edad" class="col-sm-2 col-form-label">Cheque:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['cheque']; ?>" readonly>
                        </div>
                        <label for="edad" class="col-sm-2 col-form-label">Diferencia:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['diferencia']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
						<label for="fechaNacimiento" class="col-sm-2 col-form-label">Monto del Cheque:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['monto2']; ?>" readonly>
                        </div>
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

