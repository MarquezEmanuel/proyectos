<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');

function PMCRED() {
	$hoy = date("y-m-d");
	$hoy=strtotime('-5 days',strtotime($hoy));
	$hoy = date("d-m-y", $hoy);
	$ultimo = date("d-m-y");
    $sql = "SELECT *,convert(varchar,cast(importe as money),1) AS importe2 FROM [7ajusteSinReintegro] where fecha between '".$hoy."' and '".$ultimo."'";
	echo $sql;
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $html = "<br>
        <table id='tb_buscar_MoraTarjetas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>Marca</th>
                                            <th>Cuenta</th>
                                            <th>Concepto</th>
                                            <th>Fecha</th>
                                            <th>Importe</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
            $html = $html . "
            <tr>
                <td>{$row['marca']}</td>
                <td>{$row['cuenta']}</td>
                <td>{$row['concepto']}</td>
                <td>{$fecha}</td>
                <td>{$row['importe2']}</td>
            </tr>";
        }
        $html = $html . "</tbody></table>";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $html = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
}  else {
        $html = $html . '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron ajustes sin reintegro</div>';
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
                            <h3 class="text-center"><u>Ajustes sin reintegro</u></h3>
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
                            title: 'Ajustes sin reintegro'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });


});

</script>
</html>

