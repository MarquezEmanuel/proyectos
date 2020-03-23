<?php
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;

function incorrectaIdentificacion() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d-m-Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT * FROM [3transaccionIncorrecta] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $depositante = utf8_encode($row['depositante']);
                $html = $html . "
                    <tr>
                    <td>{$row['nombreTransaccion']}</td>
                    <td>{$depositante}</td>    
                    <td>{$row['documentoDepositante']}</td>
                    <td>{$row['usuario']}</td>
                    <td class='text-center' title='Ir a ver detalles del alta'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesIncorrecta2' name='{$row['id']}' width='18' height='18' > 
                    </button>
                    </td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=5>No hay incorrecta identificacion de clientes en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=5>No hay incorrecta identificacion de clientes en la fecha</td></tr>";
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
                            <h3 class="text-center"><u>Incorrecta identificacion de clientes</u></h3>
                        </div>
                        <br>
                        <a href="buscarIncorrectaIdentificacion.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        <input type="button" class="btn btn-dark" id="btnGraficoIncorrecta" name="btnGraficoIncorrecta" value="Gráfico" title="Cantidad de identificaciones incorrectas por usuario (Mas de 5)">
                        &nbsp;
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosIncorrectaIdentificacion' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 23%'/>
                                    <col style='width: 23%'/>
                                    <col style='width: 23%'/>
                                    <col style='width: 23%'/>
                                    <col style='width: 8%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Transaccion</th>
                                        <th>Depositante</th>
                                        <th>CUIL Depositante</th>
                                        <th>Usuario</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo incorrectaIdentificacion(); ?>
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
<div class="modal fade" id="modalIncorrectaIdentificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">INCORRECTA IDENTIFICACIÓN DE CLIENTES</h4>
            </div>
            <div class="modal-body">
                <div class="container" id="formulario">
                    <form id="formGIncorrectaIdentificacion" name="formGIncorrectaIdentificacion" method="POST">
                        <div class="form-row">
                            <div class="col">
                                <input type="date" class="form-control" name="fechaInicioInforme" id="fechaInicioInforme" title="Fecha de inicio">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" name="fechaFinInforme" id="fechaFinInforme" title="Fecha de fin">
                            </div>
                            <input type="hidden" id="opcion" name="opcion" value="4">
                            <button type="submit" class="btn btn-outline-success" title="Generear gráfico estadístico">Generar</button>
                        </div>
                    </form>
                </div>
                <div id="grafico" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/buscarIncorrectaIdentificacion.js"></script>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/diarios.js"></script>
</html>



