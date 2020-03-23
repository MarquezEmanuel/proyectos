<?php
/* INICIALIZA LA SESION */
session_start();

require_once './menuReportes.php';

$query = "SELECT * FROM rte_operacion";
$selectOperacion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
?>

<div class="card-header" id="FormBuscarRTE">

    <div id="contenido">
        <h4 class="text-center p-4">BUSCAR RTE - PLAZO FIJO</h4>
        <?php
        if ($selectOperacion) {
            if (sqlsrv_has_rows($selectOperacion)) {
                echo "
                <br>
                <input type='hidden' id='seleccionado' name='seleccionado' value=''>
                <div class='table-responsive'>
                    <table id='tablaRTE' class='table table-bordered table-hover' >
                        <thead style='background-color:#024d85; color:white;'>
                            <tr>
                                <th class='text-center'>Cuenta</th>
                                <th class='text-center'>Fecha</th>
                                <th class='text-center'>Tipo</th>
                                <th class='text-center'>Moneda</th>
                                <th class='text-center'>Monto</th>
                                <th class='text-center'>Importe</th>
                                <th class='text-center'>Personas</th>
                                <th class='text-center'>Borrar</th>
                                <th class='text-center'>Modificar</th>
                                <th class='text-center'>XML</th>
                            </tr>
                        </thead>
                        <tbody style='background-color: white;'>";
                while ($row = sqlsrv_fetch_array($selectOperacion, SQLSRV_FETCH_ASSOC)) {
                    echo"
                        <tr>
                            <td>{$row['cuenta']}</td>
                            <td>{$row['fecha']->format('d/m/Y')}</td>
                            <td>" . utf8_encode($row['tipo']) . "</td>
                            <td>" . utf8_encode($row['moneda']) . "</td>
                            <td>{$row['montoMo']}</td>
                            <td>{$row['montoPesos']}</td>    
                            <td>{$row['numeroPersonas']}</td>
                            <td class='text-center' title='Borrar RTE'>
                                 <button class='btn btn-sm btn-outline-danger'> 
                                    <img src='../../lib/img/DELETE.png' class='borrarRTE' name='{$row['idOperacion']}' width='18' height='18' > 
                                </button>
                            </td>
                            <td class='text-center' title='Modificar RTE'>
                                <button class='btn btn-sm btn-outline-warning'> 
                                    <img src='../../lib/img/EDIT.png' class='modificarRTE' name='{$row['idOperacion']}' width='18' height='18' > 
                                </button>
                            </td>
                            <td class='text-center' title='Generar archivo XML'>
                                <form action='procesarGenerarRTEPF.php' method='POST'>
                                    <input type='hidden' name='idOperacion' value='{$row['idOperacion']}'>
                                    <button class='btn btn-sm btn-outline-info'>
                                        <img src='../../lib/img/SETTING.png' class='generarRTE' name='{$row['idOperacion']}' width='18' height='18'>
                                    </button>
                                </form>
                            </td>
                        </tr>";
                }
                echo'   </tbody>
                    </table>
                </div>';
            } else {
                echo '<div class="alert alert-warning text-center" role="alert"> No se encontraron resultados </div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert"> Error al realizar búsqueda </div>';
        }
        ?>
    </div>
    <div id="contenido2" name="contenido2"></div>
    <?php include_once '../modalBorrar.php'; ?>
    <script type="text/javascript" charset="utf8" src="../../lib/JQuery/BuscarRTEPF.js"></script>
</div>
</body>

</html>

