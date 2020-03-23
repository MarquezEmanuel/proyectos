<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './menuOperaciones.php';

$resultado = $script = "";
$queryPersonas = "select * from [dbo].[codigoPostalInconsistente]";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryPersonas);
if ($result) {
    if (sqlsrv_has_rows($result)) {
        $resultado = "
        <div class='table-responsive mb-4'>
            <table id='tbRepCodigoPostal' class='table table-striped'>
                <thead style='background-color:#024d85; color:white;'> 
                    <tr>
                        <th title='Código de cliente'>Código</th>
                        <th title='Nombre de cliente'>Nombre</th>
                        <th title='Nombre de cliente'>Código postal</th>
                        <th title='Código postal CPA'>CPA</th>
                        <th title='Usuario de creación'>Creación</th>
                        <th title='Usuario de edición'>Edición</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $resultado .= "
                <tr style='background-color: #cfcffa;' id='{$row['ID']}'>
                    <td class='align-middle'>" . $row['NROCLIENTE'] . "</td>
                    <td class='align-middle'>" . utf8_encode($row['NOMCLIENTE']) . "</td>
                    <td class='align-middle'>{$row['CODPOSTAL']}</td>
                    <td class='align-middle'>{$row['CODCPA']}</td>
                    <td class='align-middle'>{$row['CODUSUCRE']}</td>
                    <td class='align-middle'>{$row['CODUSUMOD']}</td>
                </tr>";
        }
        $resultado .= "
                </tbody>
            </table>
        </div>";
        $script = "
            <script>
                $(document).ready(function () {
                    $('#tbRepCodigoPostal').DataTable({
                        dom: 'Bfrtip',
                        responsive: true,
                        pageLength: 20,
                        buttons: ['excel'],
                        language: {url: '../../lib/js/Spanish.json'}
                    });
                });
            </script>";
    } else {
        $resultado = '<div class="alert alert-warning text-center" role="alert"> No se encontraron códigos postales inconsistentes</div>';
    }
} else {
    Log::escribirError("[Error al realizar la consulta de personas fisicas duplicadas][QUERY: $queryPersonas]");
    $resultado = '<div class="alert alert-danger text-center" role="alert"> Error al realizar consulta de códigos postales inconsistentes</div>';
}
?>
<div class="container mt-4">
    <div id="superior">
        <h4 class="text-center mb-4 mt-4">CÓDIGO POSTAL INCONSISTENTE</h4>
        <div class="form-row mb-4">
            <div class="col text-left">
                <a href="formReportesTablas.php"><button class="btn btn-dark">Volver</button></a>
            </div>
        </div>
        <?php echo $resultado; ?>        
    </div>
</div>
<?php echo $script;