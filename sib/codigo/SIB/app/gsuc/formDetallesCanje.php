<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Cheques canje interno pendientes</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCanje = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(importe as money),1) AS importe2 FROM [3canjeInterno]
                                    WHERE id =" . $idCanje;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCanje || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fechaDeposito = "";
                $fechaDeposito = isset($cuen['fechaDeposito']) ? $cuen['fechaDeposito']->format('d/m/Y') : "";
                ?>
            <form action="guardarCanje.php" method="post">
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                        <input type="hidden" id="idCanje" name="idCanje" value="<?= $cuen['id'] ?>">
                        <label for="fechaDeposito" class="col-sm-2 col-form-label">Fecha Deposito:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fechaDeposito; ?>" readonly>
                        </div>
                        <label for="numeroCheque" class="col-sm-2 col-form-label">N&uacute;mero de Cheque:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['numeroCheque']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="concepto" class="col-sm-2 col-form-label">Concepto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['concepto']; ?>" readonly>
                        </div>
                        <label for="sucursal" class="col-sm-2 col-form-label">Suc. Cta. Deposito:</label>
                        <div class="col" >
                            <input type="number" class="form-control mb-2" value="<?= $cuen['sucursalCuentaDeposito']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="cuenta" class="col-sm-2 col-form-label">Cuenta Beneficiario:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['cuentaBeneficiario']; ?>" readonly>
                        </div>
                        <label for="sucursal" class="col-sm-2 col-form-label">Sucursal Girada:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['sucursalGirada']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="libra" class="col-sm-2 col-form-label">Cuenta Libra:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuentaLibra']; ?>" readonly>
                        </div>
                        <label for="importe" class="col-sm-2 col-form-label">Importe:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['importe2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="hora" class="col-sm-2 col-form-label">Hora Acreditacion:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['horaAcreditacion']; ?>" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label">Estado:</label>
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

