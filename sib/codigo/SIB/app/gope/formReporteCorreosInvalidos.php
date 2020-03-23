<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './menuOperaciones.php';

$resultado = $script = "";
$queryCorreos = "SELECT * FROM [dbo].[correosElectronicosInvalidos]";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCorreos);
if ($result) {
    if (sqlsrv_has_rows($result)) {
        $resultado = "
        <div class='table-responsive mb-4'>
            <table id='tbRepCorreosInvalidos' class='table table-striped'>
                <thead style='background-color:#024d85; color:white;'> 
                    <tr>
                        <th title='Código de cliente'>Código</th>
                        <th title='Nombre de cliente'>Nombre</th>
                        <th title='Correo electrónico'>Correo electrónico</th>
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
                    <td class='align-middle'>{$row['CORREO']}</td>
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
                    $('#tbRepCorreosInvalidos').DataTable({
                        dom: 'Bfrtip',
                        responsive: true,
                        pageLength: 20,
                        buttons: ['excel'],
                        language: {url: '../../lib/js/Spanish.json'}
                    });
                });
            </script>";
    } else {
       $resultado = '<div class="alert alert-warning text-center" role="alert"> No se encontraron correos electrónicos inválidos</div>';
    }
} else {
    Log::escribirError("[Error al realizar la consulta de correos electronicos invalidos][QUERY: $queryCorreos]");
    $resultado = '<div class="alert alert-danger text-center" role="alert"> Error al realizar consulta de correos electrónicos inválidos</div>';
}
?>
<div class="container mt-4">
    <div id="superior">
        <h4 class="text-center mb-4 mt-4">CLIENTES CON CORREOS ELECTRÓNICOS INVÁLIDOS</h4>
        <div class="form-row mb-4">
            <div class="col text-left">
                <a href="formReportesTablas.php"><button class="btn btn-dark">Volver</button></a>
            </div>
        </div>
        <?php echo $resultado; ?>
    </div>
</div>
<?php
echo $script;
