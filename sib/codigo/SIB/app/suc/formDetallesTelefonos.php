<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Datos de Clientes con tarjetas en el tesoro</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
            $query = "SELECT * FROM [3telefonosTarjetas]
                                    WHERE id =" . $idCuenta;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fechaGra = $fechaIngreso = "";
                $fechaGra = isset($cuen['fechaGra']) ? $cuen['fechaGra']->format('d/m/Y') : "";
                $fechaIngreso = isset($cuen['fechaIngreso']) ? $cuen['fechaIngreso']->format('d/m/Y') : "";
                $descripcion = utf8_encode($cuen['descripcion']);
                $nombreCliente = utf8_encode($cuen['nombreCliente']);
                $correoCliente = utf8_encode($cuen['correoCliente']);
                ?>
            <form action="guardarTelefonos.php" method="post">
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                        <input type="hidden" id="idCuenta" name="idCuenta" value="<?= $cuen['id'] ?>">
                        <label for="causal" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['sucursal']; ?>" readonly>
                        </div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Numero de Documento:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['numeroDocumento']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="cuenta" class="col-sm-2 col-form-label">Descripcion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $descripcion; ?>" readonly>
                        </div>
                        <label for="digito" class="col-sm-2 col-form-label">Fecha Gra:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fechaGra; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="cuenta" class="col-sm-2 col-form-label">Fecha Ingreso:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $fechaIngreso; ?>" readonly>
                        </div>
                        <label for="digito" class="col-sm-2 col-form-label">Numero de Cliente:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['numeroCliente']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="cuenta" class="col-sm-2 col-form-label">Nombre de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $nombreCliente; ?>" readonly>
                        </div>
                        <label for="digito" class="col-sm-2 col-form-label">Correo de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $correoCliente; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="cuenta" class="col-sm-2 col-form-label">Telefono SFB:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2"  value="<?= $cuen['telefonoSFB']; ?>" readonly>
                        </div>
                        <label for="digito" class="col-sm-2 col-form-label">Telefono Engage:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['telefonoEngage']; ?>" readonly>
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