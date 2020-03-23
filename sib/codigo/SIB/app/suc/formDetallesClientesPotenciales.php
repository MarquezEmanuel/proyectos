<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Clientes potenciales</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
            $query = "SELECT * FROM [3clientesPotenciales]
                                    WHERE id =" . $idCuenta;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fecha = "";
                $fecha = isset($cuen['fechaActualizacion']) ? $cuen['fechaActualizacion']->format('d/m/Y') : "";
				$nombreCliente = utf8_encode($cuen['nombreCliente']);
                ?>
            <form action="guardarClientesPotenciales.php" method="post">
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                        <input type="hidden" id="idCuenta" name="idCuenta" value="<?= $cuen['id'] ?>">
                        <label for="causal" class="col-sm-2 col-form-label">Usuario:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['usuario']; ?>" readonly>
                        </div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Fecha Alta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fecha; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="producto" class="col-sm-2 col-form-label">Numero de Cliente:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['nroCliente']; ?>" readonly>
                        </div>
                        <label for="sucursal" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col" >
                            <input type="number" class="form-control mb-2" value="<?= $cuen['sucursal']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="cuenta" class="col-sm-2 col-form-label">Nombre de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $nombreCliente; ?>" readonly>
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