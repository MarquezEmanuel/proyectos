<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './header.php';


$form = $modal = $resultado = "";

        $queryExtracciones = "select rec.nombreCliente, rec.marca, convert(varchar,cast(rec.mtoTotalMoraTC as money),1) AS deuda, cor.correo
from [bd_sib].[dbo].[recuperacionCrediticia] rec
inner join (select DISTINCT codigoCliente, correo 
                    from [bd_sib].[dbo].[correosElectronicos]) cor on cor.codigoCliente = RIGHT('000000000000' + rec.numeroCliente, 13)
where rec.marca is not null";
        $resultExtraciones = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryExtracciones);
		$unica = 0;
        if ($resultExtraciones) {
            if (sqlsrv_has_rows($resultExtraciones)) {
                $tabla = '
                    <form method="POST" action="procesarEnvioCorreo.php"> 
					<input type="submit" class="btn btn-dark" id="btnEnviarCorreo" name="btnEnviarCorreo" value="Enviar"></a>
            &nbsp;
            <a href="inicio.php"><input type="button" class="btn btn-dark" value="Volver"></a>
            <br><br>
					
                        <input type="hidden" name="reporte" id="reporte" value="EXTRACCIONES POR CAJA">
                        <input type="hidden" name="origen" id="origen" value="extraccionesMayores.php">
                        <div class="table-responsive">
                            <table id="diariosExtraccionesMayores" class="table table-striped table-bordered table-hover">
                                <thead style="background-color:#07385c;color:white;">
                                    <tr>
                                        <th class="text-center align-middle"><input type="checkbox" id="seleccionarTodos" name="seleccionarTodos"></th>
                                        <th>Nombre Cliente</th>
                                        <th>Marca</th>
                                        <th>Deuda</th>
                                        <th>Correo electrónico</th>
                                    </tr>
                                </thead>
                                <tbody>';
                while ($row = sqlsrv_fetch_array($resultExtraciones, SQLSRV_FETCH_ASSOC)) {
					if($unica == 0){
						 $tabla = $tabla . "
                                    <tr>
                                        <td><input type='checkbox' value='malcom38794@gmail.com' id='cbCorreos' name='cbCorreos[]'></td>
                                        <td>Malcom</td>
                                        <td>Visa</td>
                                        <td>10</td>
                                        <td>malcom38794@gmail.com</td>
                                    </tr>
									<tr>
                                        <td><input type='checkbox' value='e.m.a-13@hotmail.com' id='cbCorreos' name='cbCorreos[]'></td>
                                        <td>Emanuel</td>
                                        <td>Master</td>
                                        <td>9999999</td>
                                        <td>e.m.a-13@hotmail.com</td>
                                    </tr>
									<tr>
                                        <td><input type='checkbox' value='msalazar@bancosantacruz.com' id='cbCorreos' name='cbCorreos[]'></td>
                                        <td>banco</td>
                                        <td>Master</td>
                                        <td>99990</td>
                                        <td>msalazar@bancosantacruz.com</td>
                                    </tr>
									<tr>
                                        <td><input type='checkbox' value='emarquez@bancosantacruz.com' id='cbCorreos' name='cbCorreos[]'></td>
                                        <td>banco ema</td>
                                        <td>Master</td>
                                        <td>99990</td>
                                        <td>emarquez@bancosantacruz.com</td>
                                    </tr>
									";
						$unica = 1;
					}
					$nombre = utf8_encode($row['nombreCliente']);
                    $tabla = $tabla . "
                                    <tr>
                                        <td><input type='checkbox' value='{$row['correo']}' id='cbCorreos' name='cbCorreos[]'></td>
                                        <td>{$nombre}</td>
                                        <td>{$row['marca']}</td>
                                        <td>{$row['deuda']}</td>
                                        <td>{$row['correo']}</td>
                                    </tr>";
                }
                $tabla = $tabla . '            
                                </tbody>
                            </table>
                        </div>
                    </form>';
            } else {
                $tabla = '<div class="alert alert-warning text-center" role="alert">No se encontraron correos electrónicos asociados a las cuentas del reporte</div>';
            }
        } else {
            $log = new Log();
            $log->writeLine("[Error al consultar correos para extracciones][QUERY: $queryExtracciones]");
            $tabla = '<div class="alert alert-danger text-center" role="alert">Error al realizar la consulta sobre correos electronicos para extracciones</div>';
        }

        $form = $tabla;



?>

<div class="container">
    <div class="card-header">
        <div class="center">
            <h3 class="text-center"><u>Correo clientes en mora</u></h3>
        </div>
        <div class="mb-4 mt-4">
            <?= $form ?>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/CorreoExtracciones.js"></script>
