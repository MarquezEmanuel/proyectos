<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './menuOperaciones.php';

$resultado = $script = "";
$queryDomicilios = "SELECT * FROM documentosInvalidos";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryDomicilios);
if ($result) {
    if (sqlsrv_has_rows($result)) {
        $resultado = "
        <div class='table-responsive mb-4'>
            <table id='tbRepDocumentosInvalidos' class='table table-striped'>
                <thead style='background-color:#024d85; color:white;'> 
                    <tr>
                        <th>Número de cliente</th>
                        <th>Nombre de cliente</th>
                        <th>Tipo de documento</th>
                        <th>Número de documento</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $resultado .= "
                <tr style='background-color:#cfcffa;' id='{$row['ID']}'>
                    <td class='align-middle'>" . $row['NROCLIENTE'] . "</td>
                    <td class='align-middle'>" . utf8_encode($row['NOMCLIENTE']) . "</td>
                    <td class='align-middle'>" . utf8_encode($row['TIPODOCUMENTO']) . "</td>
                    <td class='align-middle'>" . utf8_encode($row['NRODOCUMENTO']) . "</td>
                </tr>";
        }
        $resultado .= "
                </tbody>
            </table>
        </div>";
        $script = "
            <script>
                $(document).ready(function () {
                    $('#tbRepDocumentosInvalidos').DataTable({
                        dom: 'Bfrtip',
                        responsive: true,
                        pageLength: 20,
                        buttons: ['excel'],
                        language: {url: '../../lib/js/Spanish.json'}
                    });
                });
            </script>";
    } else {
        $resultado = '<div class="alert alert-warning text-center" role="alert"> No se encontraron documentos inválidos </div>';
    }
} else {
    Log::escribirError("[Error al realizar la consulta de documentos invalidos][QUERY: $queryDomicilios]");
    $resultado = '<div class="alert alert-danger text-center" role="alert"> Error al realizar consulta de documentos inválidos </div>';
}
?>
<div class="container mt-4">
    <div id="superior">
        <h4 class="text-center mb-4 mt-4">CLIENTES CON DOCUMENTO INVÁLIDO</h4>
        <div class="form-row mb-4">
            <div class="col text-left">
                <a href="formReportesTablas.php"><button class="btn btn-dark">Volver</button></a>
            </div>
        </div>
        <?php echo $resultado; ?>
    </div>
</div>
<?php echo $script;