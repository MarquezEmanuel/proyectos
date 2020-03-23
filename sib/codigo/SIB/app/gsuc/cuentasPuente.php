<?php

//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

session_start();

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function cuentaCorrentista() {
	date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "select cuenta,convert(varchar,cast(suc01 as money),1) AS s01,convert(varchar,cast(suc10 as money),1) AS s10,
	convert(varchar,cast(suc20 as money),1) AS s20,convert(varchar,cast(suc25 as money),1) AS s25,convert(varchar,cast(suc30 as money),1) AS s30,
	convert(varchar,cast(suc41 as money),1) AS s41,convert(varchar,cast(suc50 as money),1) AS s50,convert(varchar,cast(suc55 as money),1) AS s55,
	convert(varchar,cast(suc60 as money),1) AS s60,convert(varchar,cast(suc80 as money),1) AS s80
	from [bd_sib].[dbo].[3cuentasPuente] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {	
				switch($row['cuenta']){
					case 351003010380:
						$nombre = "CONTROL VARIOS CAJA";
						break;
					case 351003070780:
						$nombre = "PUENTE CTA.CTE. PESOS";
						break;
					case 351003080680:
						$nombre = "PUENTE CAJA AHORRO PESOS";
						break;
					case 351003101080:
						$nombre = "CONTROL CTAS. CTES.";
						break;
					case 351003201880:
						$nombre = "CTROL. CAJA DE AHORRO";
						break;
					case 351003401480:
						$nombre = "CTROL.PLAZO FIJO";
						break;
					case 351003931080:
						$nombre = "CTROL CANJE 42 VAL.ALCOBRO";
						break;
				}
                $html = $html . "
                    <tr>
                    <td>{$row['cuenta']}</td>
					<td>{$nombre}</td>
                    <td>{$row['s01']}</td>    
                    <td>{$row['s10']}</td>
                    <td>{$row['s20']}</td>
                    <td>{$row['s25']}</td>
					<td>{$row['s30']}</td>
					<td>{$row['s41']}</td>
					<td>{$row['s50']}</td>
					<td>{$row['s55']}</td>
					<td>{$row['s60']}</td>
					<td>{$row['s80']}</td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=11>No hay cuentas puentes con diferencias en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=11>No hay cuentas puentes con diferencias en la fecha</td></tr>";
    }
    return $html;
}

$_SESSION['buscar'] = null;

require_once './header.php';
?>
<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Cuentas Puentes</u></h3>
                        </div>
                        <br>
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosCentralCuentaCorrentista' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Cuenta</th>
										<th>Nombre</th>
										<th>Suc01</th>
                                        <th>Suc10</th>
                                        <th>Suc20</th>
                                        <th>Suc25</th>
                                        <th>Suc30</th>
										<th>Suc41</th>
                                        <th>Suc50</th>
										<th>Suc55</th>
										<th>Suc60</th>
										<th>Suc80</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo cuentaCorrentista();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" charset="utf8" src="/lib/JQuery/diarios.js"></script>
</html>

