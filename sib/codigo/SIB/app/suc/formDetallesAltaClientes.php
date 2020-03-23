<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Alta de clientes</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
            $query = "SELECT * FROM [3altaCliente]
                                    WHERE id =" . $idCuenta;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                $fechaAlta = $fechaNacimiento = "";
                $fechaAlta = isset($cuen['fechaAlta']) ? $cuen['fechaAlta']->format('d/m/Y') : "";
                $fechaNacimiento = isset($cuen['fechaNacimiento']) ? $cuen['fechaNacimiento']->format('d/m/Y') : "";
				$nombreCliente = utf8_encode($cuen['nombreCliente']);
                $nombreUsuario = utf8_encode($cuen['nombreUsuario']);
                ?>
            <form action="guardarAltaClientes.php" method="post">
                <div class="container">
                        <br><br>
                    <div class="form-group row">
                        <input type="hidden" id="idCuenta" name="idCuenta" value="<?= $cuen['id'] ?>">
                        <label for="numeroCliente" class="col-sm-2 col-form-label">N&uacute;mero Cliente:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['numeroCliente']; ?>" readonly>
                        </div>
                        <label for="nombreCliente" class="col-sm-2 col-form-label">Nombre Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombreCliente; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="altaUsuario" class="col-sm-2 col-form-label">Alta Usuario:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['usuarioAlta']; ?>" readonly>
                        </div>
                        <label for="nombreUsuario" class="col-sm-2 col-form-label">Nombre Usuario:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $nombreUsuario; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaAlta" class="col-sm-2 col-form-label">Fecha de Alta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $fechaAlta; ?>" readonly>
                        </div>
                        <label for="fechaNacimiento" class="col-sm-2 col-form-label">Fecha de Nacimiento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fechaNacimiento; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="edad" class="col-sm-2 col-form-label">Edad:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cuen['edad']; ?>" readonly>
                        </div>
                        <label for="comentario" class="col-sm-2 col-form-label">Comentario:</label>
                        <div class="col" >
                            <textarea type="input" class="form-control mb-2" id="comentario" name="comentario"><?= $cuen['comentario']; }?></textarea>
                        </div>
                    </div>                    
                    <br>
                    <input type="submit" class="btn btn-dark" id="guardar" name="guardar" value="Guardar Comentario">
                        &nbsp;
                        <a href="formBuscarAltaClientes.php"><input type="button" class="btn btn-dark" value="Volver"></a>
            </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

