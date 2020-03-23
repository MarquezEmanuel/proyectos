<?php

//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

session_start();

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function cuentaCorrentista() {
    $sql = "select * from openquery(M4000SF,'SELECT MCL.SCO_IDENT CODCLIENTE,
                                                                   MCL.SNO_CLIEN NOMCLIENTE,
                                                                   ADO.SNU_DOCUM CUIL,
                                                                   SUBSTR(ADO.SNU_DOCUM, 3, 8) DOCUMENTO,
                                                                   MCL.CCOEJECUE OFICIAL,
                                                                   MTG.ANO_LARGA ESTADO,
                                                                   ''NO INFORMADO'' RIESGO,
                                                                   TO_CHAR ( TO_DATE ( LPAD(MCL.SFE_ALTA, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHAALTA,
																   MCL.SCOOFIORI SUCURSAL
                                                      FROM SFB_BSMCL MCL
                                                      INNER JOIN SFB_DAMCP MCP ON MCL.SFE_ALTA = DFE_DAN1 AND MCP.DCO_SUCUR4 = 9999
                                                      INNER JOIN SFB_BSADO ADO ON ADO.SCO_IDENT = MCL.SCO_IDENT AND ADO.SCOTIPDOC IN (34, 35)
                                                      INNER JOIN SFB_BSMTG MTG ON MTG.ACO_CODIG = LPAD(MCL.SCOESTPER, 2, 0) AND ACO_TABLA = ''ESTCLIEN'' AND ACO_CODIG <> '' ''
                                                      WHERE MCL.SSERIESGO = ''9'' AND MCL.SCOOFIORI = {$_SESSION['sucursal']}')";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$nombre = utf8_encode($row['NOMCLIENTE']);
                $html = $html . "
                    <tr>
                    <td>{$row['CODCLIENTE']}</td>
                    <td>{$nombre}</td>    
                    <td>{$row['CUIL']}</td>
                    <td>{$row['DOCUMENTO']}</td>
                    <td>{$row['OFICIAL']}</td>
					<td>{$row['ESTADO']}</td>
					<td>{$row['RIESGO']}</td>
					<td>{$row['FECHAALTA']}</td>
					<td>{$row['SUCURSAL']}</td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=5>No hay cuentas correntistas inhabilitados en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=5>No hay cuentas correntistas inhabilitados en la fecha</td></tr>";
    }
    return $html;
}

$_SESSION['buscar'] = null;

require_once './menuSucursal.php';
?>
<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Clientes dados de alta con riesgo no informado</u></h3>
                        </div>
                        <br>
						<a href="buscarRiesgo.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosCentralCuentaCorrentista' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Codigo de Cliente</th>
										<th>Nombre de Cliente</th>
                                        <th>CUIT-CUIL</th>
                                        <th>Documento</th>
                                        <th>Oficial</th>
                                        <th>Estado</th>
										<th>Riesgo</th>
                                        <th>Fecha de Alta</th>
										<th>Sucursal</th>
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

