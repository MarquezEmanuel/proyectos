<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './menuOperaciones.php';

$resultado = $script = "";
$queryCorreos = "select  TOP 4000 * from [dbo].[telefonosParticularesInvalidos]";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCorreos);
if ($result) {
    if (sqlsrv_has_rows($result)) {
        $resultado = "
        <div class='table-responsive mb-4'>
            <table id='tbRepTelefonosInvalidos' class='table table-striped'>
                <thead style='background-color:#024d85; color:white;'> 
                    <tr>
                        <th title='Código de cliente'>Código</th>
                        <th title='Nombre de cliente'>Nombre</th>
                        <th title='Número de teléfono particular'>Telefono</th>
                        <th title='Usuario de creación'>Usuario</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $resultado .= "
                <tr style='background-color: #cfcffa;'>
                    <td class='align-middle'>" . $row['NROCLIENTE'] . "</td>
                    <td class='align-middle'>" . utf8_encode($row['NOMCLIENTE']) . "</td>
                    <td class='align-middle'>{$row['TELEFONO']}</td>
                    <td class='align-middle'>{$row['CODUSUCRE']}</td>
                </tr>";
        }
        $resultado .= "
                </tbody>
            </table>
        </div>";
        
        $script = "
            <script>
                $(document).ready(function () {
                    $('#tbRepTelefonosInvalidos').DataTable({
                        dom: 'Bfrtip',
                        responsive: true,
                        pageLength: 20,
                        buttons: ['excel'],
                        language: {url: '../../lib/js/Spanish.json'}
                    });
                });
            </script>";
    } else {
        $resultado = '<div class="alert alert-danger text-center" role="alert"> No se encontraron telefonos particulares inválidos </div>';
    }
} else {
    Log::escribirError("[Error al realizar la consulta de telefonos particulares invalidos][QUERY: $queryCorreos]");
    $resultado = '<div class="alert alert-danger text-center" role="alert"> Error al realizar consulta de telefonos particulares inválidos </div>';
}
?>
<div class="container mt-4">
    <div id="superior">
        <h4 class="text-center mb-4 mt-4">CLIENTES CON TELÉFONOS PARTICULARES INVÁLIDOS</h4>
        <div class="form-row mb-4">
            <div class="col text-left">
                <a href="formReportesTablas.php"><button class="btn btn-dark">Volver</button></a>
            </div>
        </div>
        <?php echo $resultado; ?>
    </div>
</div>
<?php echo $script;