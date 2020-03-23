<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
session_start();
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Inventario de pagos a agencias externas</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCobro = $_POST['seleccionado'];
            $query = "select *, convert(varchar,cast(SDO_CAP as money),1) AS SDO_CAP2, convert(varchar,cast(DEUDA_TOTAL as money),1) AS DEUDA_TOTAL2 from openquery(M4000SF,'SELECT MAP.GLB_DTIME ID,
									   AEE.PNUENTEXT AS ALTA_ESTUDIO,
									   AEE.PCU_OFICI AS SUC,
									   AEE.PCUNUMCUE AS CUENTA,
									   AEE.PCU_PRODU AS PROD,
									   AEE.PCU_MONED AS MON,
									   MPR.ANO_PRODU AS NOMBRE_PROD,
									   AEE.PCOENTEXT AS ESTUDIO,
									   MCL.SNO_CLIEN AS NOMBRE,
									   ADO.SNU_DOCUM AS CUIL,
									   MAP.PSACAPREA AS SDO_CAP,
									   MAP.PSA_REAL AS DEUDA_TOTAL,
									   AEE.PNUENTEXT AS FECHA_ETAPA
								FROM SFB_PPAEE AEE
								INNER JOIN SFB_PPMAP MAP ON AEE.PCUNUMCUE = MAP.PCUNUMCUE AND 
															AEE.PCU_OFICI = MAP.PCU_OFICI AND
															MAP.PCOESTCUE = 1
								INNER JOIN SFB_BSADO ADO ON MAP.SCO_IDENT = ADO.SCO_IDENT AND
															ADO.SCOTIPDOC IN (34,35)
								INNER JOIN SFB_BSMCL MCL ON MAP.SCO_IDENT = MCL.SCO_IDENT
								INNER JOIN SFB_AAMPR MPR ON AEE.PCU_PRODU = MPR.ACO_PRODU AND
															AEE.PCU_MONED = MPR.DCO_MONED AND
															MPR.ACO_CONCE = 6
								WHERE AEE.PCOENTEXT IN (18, 19, 20, 22, 23, 24, 107, 108, 109, 112, 113, 114, 115, 116, 117)')
			WHERE ID =" . $idCobro;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCobro || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
                $cuen = sqlsrv_fetch_array($result);
				$nombreProd = utf8_encode($cuen['NOMBRE_PROD']);
				$nombre = utf8_encode($cuen['NOMBRE']);
                ?>
                <div class="container">
                    <br><br>
                    <div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Fecha de alta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['ALTA_ESTUDIO']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['SUC']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['CUENTA']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['PROD']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Moneda:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['MON']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Nombre de Producto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombreProd;?>" readonly>
                        </div>    
						<div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Estudio:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['ESTUDIO']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombre;?>" readonly>
                        </div> 
						<div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">CUIL:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['CUIL']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Saldo Capital:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['SDO_CAP2'];?>" readonly>
                        </div> 
						<div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Deuda total:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['DEUDA_TOTAL2']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Fecha etapa:</label>
                        <div class="col">
							<input type="text" class="form-control mb-2" value="<?= $cuen['FECHA_ETAPA'];}?>" readonly>
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


