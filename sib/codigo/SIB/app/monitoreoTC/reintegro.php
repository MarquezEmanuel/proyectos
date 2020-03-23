<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');

function PMCRED() {
	$hoy = date("y-m-d");
	$hoy=strtotime('-5 days',strtotime($hoy));
	$hoy = date("Y-m-d", $hoy);
	$ultimo = date("Y-m-d");
    $sql = "SELECT *,convert(varchar,cast(monto as money),1) AS monto2 FROM [7reintegroSinAjuste] where fecha between '".$hoy."' and '".$ultimo."'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $html = "<br>
        <table id='tb_buscar_MoraTarjetas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>Causal</th>
                                            <th>Sucursal</th>
                                            <th>Cuenta</th>
                                            <th>Digito</th>
                                            <th>Codigo Cliente</th>
                                            <th>Cuenta Tarjeta</th>
                                            <th>Fecha</th>
                                            <th>Monto</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $html = $html . "
            <tr>
                <td>{$row['causal']}</td>
                <td>{$row['sucursal']}</td>
                <td>{$row['cuenta']}</td>
                <td>{$row['digito']}</td>
                <td>{$row['codigoCliente']}</td>
                <td>{$row['cuentaTarjeta']}</td>
                <td>{$row['fecha']}</td>
                <td>{$row['monto2']}</td>
            </tr>";
        }
        $html = $html . "</tbody></table>";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $html = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
}  else {
        $html = $html . '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron reintegros sin ajustes</div>';
    }
    return $html;
}



/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Reintegros sin ajuste</u></h3>
                        </div>
                        <a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                                    <?php
                                    echo PMCRED();
                                    ?>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div id="contenido2" name="contenido2">
	</div>
</div>

			
</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
	$('#tb_buscar_MoraTarjetas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 100,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Reintegros sin ajustes'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });


});

</script>
</html>

