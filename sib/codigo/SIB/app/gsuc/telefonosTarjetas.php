<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;
//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function telefonosTarjetas() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT * FROM [3telefonosTarjetas] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$descripcion = utf8_encode($row['descripcion']);
                $html = $html . "
                    <tr>
                    <td>{$row['numeroDocumento']}</td>
                    <td>{$row['numeroCliente']}</td>    
                    <td>{$row['correoCliente']}</td>
                    <td>{$row['telefonoSFB']}</td>
                    <td>{$row['telefonoEngage']}</td>
					<td>{$descripcion}</td>
                    <td class='text-center' title='Ir a ver detalles de los telefonos'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesTelefonos2' name='{$row['id']}' width='18' height='18' > 
                    </button>
                    </td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=7>No hay datos de clientes con tarjeta en el tesoro en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=7>No hay datos de clientes con tarjeta en el tesoro en la fecha</td></tr>";
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
                            <h3 class="text-center"><u>Datos de Clientes con tarjetas en el tesoro</u></h3>
                        </div>
                        <br>
                        <a href="buscarTelefonosTarjetas.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosTelefonos' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Documento</th>
                                        <th>Numero de Cliente</th>
                                        <th>Correo</th>
                                        <th>Telefono SFB</th>
                                        <th>Telefono Engage</th>
										<th>Tipo</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo telefonosTarjetas();
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
<script type="text/javascript" charset="utf8" src="/lib/JQuery/buscarTelefonos.js"></script>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
	$('#diariosTelefonos').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Datos de clientes con tarjetas en el tesoro'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
	});

</script>
<script type="text/javascript" charset="utf8" src="/lib/JQuery/diarios.js"></script>
</html>

