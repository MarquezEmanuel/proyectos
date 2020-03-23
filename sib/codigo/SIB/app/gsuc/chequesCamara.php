<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function saldos() {
    $sql = "SELECT * FROM [bd_sib].[dbo].[autorizacionChequesEnCamara]";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$titular = utf8_encode($row['TITULAR']);
				$cuenta = $row['SUCURSAL'] ."-". $row['CUENTA'] ."/". $row['DIGITO'];
                $html = $html . "<tr>
                    <td>{$titular}</td>
                    <td>{$cuenta}</td> 
                    <td>{$row['CHEQUE']}</td>
                    <td>{$row['IMPORTE']}</td>
                    <td>{$row['SALDO']}</td>
                    <td>{$row['BLOQUEO']}</td>
					<td>{$row['ACUERDO']}</td>
					<td>{$row['SALDOCAL']}</td>
                     </tr>";

            }
        } else {
            $html = $html . "<tr> <td COLSPAN=8>No hay cheques pendientes en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=8>No hay cheques pendientes en la fecha</td></tr>";
    }
    return $html;
}

require_once './header.php';
?>

<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Autorizacion de cheques en camara</u></h3>
                        </div>
                        <br>
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosSaldos' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 25%'/>
                                    <col style='width: 15%'/>
                                    <col style='width: 10%'/>
                                    <col style='width: 10%'/>
                                    <col style='width: 12%'/>
                                    <col style='width: 10%'/>
                                    <col style='width: 10%'/>
                                    <col style='width: 8%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Titular</th>
                                        <th>Cuenta</th>
                                        <th>Cheque</th>
                                        <th>Importe</th>
                                        <th>Saldo</th>
                                        <th>Bloqueo</th>
                                        <th>Acuerdo</th>
                                        <th>Saldo Calculado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo saldos();
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



