<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
session_start();
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Refinanciaciones</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
			$desde = $_SESSION['desde'];
			$hasta = $_SESSION['hasta'];
            $idCobro = $_POST['seleccionado'];
            $query = "select *,convert(varchar,cast(importe as money),1) AS importe2 from openquery(M4000SF,'
					select 
					a.GLB_DTIME ID,
					a.sco_ident NROCLI, 
					b.snu_docum CUIL, 
					c.snu_docum DOC, 
					d.sno_clien DENOMINACION, 
					a.pcu_produ PRODUCTO,
					a.pcu_moned MONEDA,
					a.pcu_ofici SUC,
					a.pcunumcue CTA,
					a.pfe_liqui FEC_LIQ,
					a.pva_credi IMPORTE,
					a.pcn_cuota PLAZO,
					a.ppo_tna TNA,
					case e.acu_produ
					when 2 then ''VISA''
					when 3 then ''MC''
					else ''N/A'' end MARCA,
					e.acu_ofici SUC_TC,
					e.tnucuenta CTA_TC ,
					e.tnu_tarje NRO_TC
					from sfb_ppmap a 
					left join (select sco_ident, snu_docum from sfb_bsado where scotipdoc in (30,34,35))b on a.sco_ident = b.sco_ident
					left join (select sco_ident, snu_docum from sfb_bsado where scotipdoc not in (30,34,35))c on a.sco_ident = c.sco_ident
					left join (select sco_ident, sno_clien from sfb_bsmcl)d on a.sco_ident = d.sco_ident 
					left join (select sco_ident, acu_ofici,tnu_tarje, tnucuenta, acu_produ from sfb_bsmot where aco_conce=25)e on a.sco_ident = e.sco_ident
					where 
					a.pcu_produ in (692, 929, 930, 931, 932, 933, 978, 979) 
					and a.pcu_moned=80
					and a.pre_liqui between 
					(to_date(lpad(''".$desde."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and (to_date(lpad(''".$hasta."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
					')
			WHERE ID =" . $idCobro;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idCobro || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
                $cuen = sqlsrv_fetch_array($result);
                ?>
                <div class="container">
                    <br><br>
                    <div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Numero de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['NROCLI']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">CUIL:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['CUIL']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Documento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['DOC']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Denominacion:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['DENOMINACION']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['PRODUCTO']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Moneda:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['MONEDA'];?>" readonly>
                        </div>    
						<div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['SUC']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['CTA'];?>" readonly>
                        </div> 
						<div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Fecha de Liquidacion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['FEC_LIQ']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Importe:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['importe2'];?>" readonly>
                        </div> 
						<div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Plazo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['PLAZO']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">TNA:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['TNA'];?>" readonly>
                        </div> 
						<div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Marca:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['MARCA']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Sucursal de Tarjeta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['SUC_TC'];?>" readonly>
                        </div> 
						<div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Cuenta de Tarjeta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['CTA_TC']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Numero de Tarjeta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['NRO_TC'];}?>" readonly>
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


