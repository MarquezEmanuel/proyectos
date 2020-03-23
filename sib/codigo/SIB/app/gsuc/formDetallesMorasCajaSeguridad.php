<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Moras en cajas de seguridad</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(importeCuota as money),1) AS importeCuota2,convert(varchar,cast(saldo as money),1) AS saldo2 FROM [3morasCajaSeguridad]
                                    WHERE id =" . $idCuenta;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fechaAlta = isset($cuen['fechaAlta']) ? $cuen['fechaAlta']->format('d/m/Y') : "";
                $nombre = utf8_encode($cuen['nombre']);
                $estado = utf8_encode($cuen['estado']);
                ?>
            <form action="guardarMorasCajaSeguridad.php" method="post">
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                        <input type="hidden" id="idCuenta" name="idCuenta" value="<?= $cuen['id'] ?>">
                        <label for="numeroCliente" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['sucursal']; ?>" readonly>
                        </div>
                        <label for="nombreCliente" class="col-sm-2 col-form-label">Modulo:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['modulo']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="altaUsuario" class="col-sm-2 col-form-label">Numero Caja:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['numeroCaja']; ?>" readonly>
                        </div>
                        <label for="nombreUsuario" class="col-sm-2 col-form-label">Codigo Contrato:</label>
                        <div class="col" >
                            <input type="number" class="form-control mb-2" value="<?= $cuen['codigoContrato']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaAlta" class="col-sm-2 col-form-label">Importe Cuota:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['importeCuota2']; ?>" readonly>
                        </div>
                        <label for="fechaNacimiento" class="col-sm-2 col-form-label">Cantidad de Cuotas:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['cantidadCuotas']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaAlta" class="col-sm-2 col-form-label">Cuenta DA:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2"  value="<?= $cuen['cuentaDA']; ?>" readonly>
                        </div>
                        <label for="fechaNacimiento" class="col-sm-2 col-form-label">Digito DA:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['digitoDA']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaAlta" class="col-sm-2 col-form-label">Fecha Alta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $fechaAlta; ?>" readonly>
                        </div>
                        <label for="fechaNacimiento" class="col-sm-2 col-form-label">Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombre; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaAlta" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2"  value="<?= $cuen['producto']; ?>" readonly>
                        </div>
                        <label for="fechaNacimiento" class="col-sm-2 col-form-label">Sucursal Cuenta DA:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['sucursalCuentaDA']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaAlta" class="col-sm-2 col-form-label">Tipo de Cuenta DA:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['tipoCuentaDA']; ?>" readonly>
                        </div>
                        <label for="fechaNacimiento" class="col-sm-2 col-form-label">Numero de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['numeroCliente']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaAlta" class="col-sm-2 col-form-label">Numero de Documento:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2"  value="<?= $cuen['numeroDocumento']; ?>" readonly>
                        </div>
                        <label for="fechaNacimiento" class="col-sm-2 col-form-label">Nombre de Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['nombreCuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaAlta" class="col-sm-2 col-form-label">Estado:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $estado; ?>" readonly>
                        </div>
                        <label for="fechaNacimiento" class="col-sm-2 col-form-label">Saldo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['saldo2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="comentario" class="col-sm-2 col-form-label">Comentario:</label>
                        <div class="col" >
                            <textarea type="input" class="form-control mb-2" id="comentario" name="comentario"><?= $cuen['comentario']; }?></textarea>
                        </div>
                        <label for="tratado" class="col-sm-2 col-form-label">Estado:</label>
                        <div class="col">
                                    <?php
                                    if ($cuen['tratado'] == 0 || $cuen['tratado'] == 'null') {
                                        echo '<select style="background-color: red;" class="form-control mb-2" id="tratado" name="tratado" title="Original">'
                                        . '<option style="background-color: red;" value="SIN TRATAR" selected>SIN TRATAR</option> <option style="background-color: white;" value="TRATADO">TRATADO</option>'
                                        . '</select>';
                                    } else {
                                        echo '<select style="background-color: white;" class="form-control mb-2" id="oriGtia" name="oriGtia" title="Original">'
                                        . '<option style="background-color: white;" value="TRATADO" selected>TRATADO</option> <option style="background-color: red;" value="SIN TRATAR">SIN TRATAR</option>'
                                        . '</select>';
                                    }
                                    ?>
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