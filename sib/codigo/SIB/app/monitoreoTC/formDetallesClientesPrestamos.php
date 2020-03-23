<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Clientes con prestamos y tarjetas asociadas</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idMora = $_POST['seleccionado'];
            $query = "SELECT *, convert(varchar,cast(CAPITALREAL as money),1) AS CAPITALREAL2, convert(varchar,cast(SALDOREAL as money),1) AS SALDOREAL2,
			convert(varchar,cast(SOLICITADO as money),1) AS SOLICITADO2, convert(varchar,cast(MSALANT as money),1) AS MSALANT2 ,
			convert(varchar,cast(MSALACT as money),1) AS MSALACT2, convert(varchar,cast(MIMPORTE as money),1) AS MIMPORTE2,
			convert(varchar,cast(VSALANT as money),1) AS VSALANT2, convert(varchar,cast(VSALACT as money),1) AS VSALACT2,
			convert(varchar,cast(VIMPORTE as money),1) AS VIMPORTE2, convert(varchar,cast(MDEUDA as money),1) AS MDEUDA2,
			convert(varchar,cast(VDEUDA as money),1) AS VDEUDA2
				FROM [7prestamosTC] WHERE id = ". $idMora;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idMora || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
                $cuen = sqlsrv_fetch_array($result);
                $nombre = utf8_encode($cuen['NOMBRE']);
				$vencimiento = isset($cuen['VENCIMIENTO']) ? $cuen['VENCIMIENTO']->format('d/m/Y') : "";
				$fallecido = isset($cuen['FALLECIDO']) ? $cuen['FALLECIDO']->format('d/m/Y') : "";
				$fechaMaster = isset($cuen['MFECHA']) ? $cuen['MFECHA']->format('d/m/Y') : "";
				$fechaVisa = isset($cuen['VFECHA']) ? $cuen['VFECHA']->format('d/m/Y') : "";
                ?>
                <div class="container">
                    <br><br>
                    <div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Codigo de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['IDCLIENTE']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">CUIT:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['CUIT'];; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">DNI:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['DNI']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Nombre y Apellido:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $nombre; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['PRODUCTO']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Numero de Prestamo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['NROPRESTAMO'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Vencimiento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $vencimiento; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Capital:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['CAPITALREAL2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Saldo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['SALDOREAL2']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Monto Solicitado:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['SOLICITADO2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Fecha de Fallecimiento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $fallecido; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Cuenta Master:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['MCUENTA'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Relacion Mater:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['MRELACION']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Estado Master:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['MESTADO']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">MTU Master:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['MMTU']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Saldo Anterior Master:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['MSALANT2']; ?>" readonly>
                        </div>
						<div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Saldo Actual Master:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['MSALACT2']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Ultima Fecha de Ajuste Master:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fechaMaster; ?>" readonly>
                        </div>
						<div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Importe de Ajuste Master:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['MIMPORTE2']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Importe de Deuda Master:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['MDEUDA2']; ?>" readonly>
                        </div>
						<div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Cuenta Visa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['VCUENTA']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Relacion Visa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['VRELACION']; ?>" readonly>
                        </div>
						<div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Estado Visa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['VESTADO']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">MTU Visa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['VMTU']; ?>" readonly>
                        </div>
						<div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Saldo Anterior Visa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['VSALANT2']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Saldo Actual Visa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['VSALACT2']; ?>" readonly>
                        </div>
						<div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Ultima Fecha de Ajuste Visa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $fechaVisa; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Importe de Ajuste Visa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['VIMPORTE2']; ?>" readonly>
                        </div>
						<div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Importe de Deuda Visa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['VDEUDA2']; }?>" readonly>
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


