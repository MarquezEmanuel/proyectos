<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function cuentaCorrentista() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "select * from cuentaCorrentistasInhabilitados";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                //$audFechaInicio = isset($row['FECHAALTA']) ? $row['FECHAALTA']->format('d/m/Y') : "";
                //$audFechaFin = isset($row['FECHAHASTA']) ? $row['FECHAHASTA']->format('d/m/Y') : "";
                $audFechaInicio = $row['FECHAALTA'];
                $audFechaFin = $row['FECHAHASTA'];
                $nombreCliente = utf8_encode($row['NOMBRECLIENTE']);
                $cuenta = $row['SUCURSAL']."-".$row['NUMEROCUENTA'] ."/".$row['DIGITO'];
                $html = $html . "
                    <tr>
                    <td>{$nombreCliente}</td>
                    <td>{$row['CUIT']}</td>    
                    <td>{$audFechaInicio}</td>
                    <td>{$audFechaFin}</td>
                    <td>{$cuenta}</td>
					<td>{$row['NOMBRERELACION']}</td>
                    <td class='text-center' title='Ir a ver detalles de la Cuenta'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesCuenta2' name='{$row['ID']}' width='18' height='18' > 
                    </button>
                    </td>
					<td><input type='button' class='btn btn-dark btnTratar' id='{$row['ID']}' name='{$row['ID']}' value='Tratar'></td>
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

require_once './header.php';
?>
<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Central de cuentacorrentistas inhabilitados</u></h3>
                        </div>
                        <br>
                        &nbsp;
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosCentralCuentaCorrentista' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 20%'/>
                                    <col style='width: 15%'/>
                                    <col style='width: 13%'/>
                                    <col style='width: 13%'/>
                                    <col style='width: 15%'/>
									<col style='width: 14%'/>
                                    <col style='width: 10%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Nombre de Cliente</th>
                                        <th>CUIT-CUIL</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Cuenta</th>
										<th>Relacion</th>
                                        <th>Detalles</th>
										<th>Tratar</th>
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
<script>
$(document).ready(function () {
    /* CARGA EL FORMULARIO DE DETALLES DE GARANTIA EN EL DIV CONTENIDO */
    
    $("#contenido").on("click", "img.detallesCuenta2", function () {
         var idcuenta = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCuenta.php",
            data: "seleccionado="+idcuenta,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
	
	$('.btnTratar').click(function () {
        var idcuenta = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formComentarioCuentacorrentista.php",
            data: "seleccionado="+idcuenta,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
});
</script>
<script type="text/javascript" charset="utf8" src="/lib/JQuery/diarios.js"></script>
</html>

