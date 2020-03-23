<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();

function PMCRED() {
    $sql = "select *, convert(varchar,cast(importe as money),1) AS importe2 from openquery([BSCBASES3], 'SELECT ''CREDENCIAL'' marca,
                                                                          AJU.CredenAjusNume nroAjuste,
                                                                          AJU.Cuenta cuenta, 
                                                                           SOC.plasti_nombre nombre,
                                                                          SOC.CUIT cuit,
                                                                          AJU.ConcepCodi codigo, 
                                                                           AJU.Impor importe,
                                                                          AJU.AjusFecha fecha,
																		  US.User_ID legajo,
																		  US.User_Name usuario,
																		  US.User_Lastname apellido
                                                              FROM [SmartOpen].[dbo].[CredenHistoAjus] AJU
                                                              INNER JOIN (SELECT Cuenta, 
                                                                                              ConcepCodi, 
                                                                                              Impor,
                                                                                              ROW_NUMBER() over (partition by Cuenta, ConcepCodi, Impor order by AjusFecha desc) orden
                                                                                 FROM [SmartOpen].[dbo].[CredenHistoAjus]
                                                                                 WHERE AjusFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)) AND AjusFecha <=  DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))) REP 
                                                                                 ON REP.Cuenta = AJU.Cuenta AND
                                                                                    REP.ConcepCodi = AJU.ConcepCodi AND
                                                                                    REP.Impor = AJU.Impor AND
                                                                                    REP.orden >= 2
                                                              INNER JOIN [SmartOpen].[dbo].[CredenSocios] SOC ON SOC.cuenta_nume = AJU.Cuenta
															  INNER JOIN [Smartopen].[dbo].[SecurityUsers] US ON AJU.IngreUID = US.User_Num
                                                              WHERE AjusFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)) AND AjusFecha <=  DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))
                                                              UNION ALL
                                                              SELECT ''VISA'' marca,
                                                                          AJU.VisaAjusNume nroAjuste,
                                                                          AJU.Cuenta cuenta,
                                                                          SOC.CuentaDeno nombre,
                                                                          REPLACE(LTRIM(REPLACE(REPLACE(SOC.CuitNume,''-'',''''),''0'','' '')),'' '',''0'') cuit,
                                                                          AJU.ConcepCodi codigo,
                                                                          AJU.Impor importe,
                                                                          AJU.AjusFecha fecha,
																		  US.User_ID legajo,
																		  US.User_Name usuario,
																		  US.User_Lastname apellido 
                                                              FROM [SmartOpen].[dbo].[VisaHistoAjus] AJU
                                                              INNER JOIN (SELECT Cuenta,
                                                                                              ConcepCodi,
                                                                                              Impor,
                                                                                              ROW_NUMBER() over (partition by Cuenta, ConcepCodi, Impor order by AjusFecha desc) orden
                                                                                   FROM [SmartOpen].[dbo].[VisaHistoAjus]
                                                                                   WHERE AjusFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)) AND AjusFecha <=  DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))) REP
                                                                                   ON REP.Cuenta = AJU.Cuenta AND
                                                                                    REP.ConcepCodi = AJU.ConcepCodi AND
                                                                                    REP.Impor = AJU.Impor AND
                                                                                    REP.orden >= 2
                                                              INNER JOIN [SmartOpen].[dbo].[VisaSocios] SOC ON SOC.Cuenta = AJU.Cuenta
															  INNER JOIN [Smartopen].[dbo].[SecurityUsers] US ON AJU.IngreUID = US.User_Num
                                                              WHERE AjusFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)) AND AjusFecha <=  DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))')
";
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
                                            <th>Nro Ajuste</th>
                                            <th>Cuenta</th>
                                            <th>Nombre</th>
                                            <th>CUIT</th>
                                            <th>Codigo</th>
                                            <th>Importe</th>
                                            <th>Fecha</th>
											<th>Usuario</th>
											<th>Legajo</th>
                                        </tr>
            </thead>
        <tbody>";
		$fila = 0;
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($row['nombre']);
			$usuario = utf8_encode($row['usuario']);
			$apellido = utf8_encode($row['apellido']);
			$fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
            $html = $html . "
            <tr>
                <td>{$row['marca']}</td>
                <td>{$row['nroAjuste']}</td>
                <td>{$row['cuenta']}</td>
                <td>{$nombre}</td>
                <td>{$row['cuit']}</td>
                <td>{$row['codigo']}</td>
                <td>{$row['importe2']}</td>
                <td>{$fecha}</td>
				<td>{$usuario} {$apellido}</td>
				<td>{$row['legajo']}</td>
            </tr>";
			$fila++;
        }
        $html = $html . "</tbody></table>
        ";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $html = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
}  else {
        $html = $html . "<tr> <td COLSPAN=6>No hay Ajustes duplicados en la fecha</td></tr>";
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
                            <h3 class="text-center"><u>Ajustes Duplicados</u></h3>
                        </div>
                        <a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br>
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
                            title: 'Ajustes Duplicados'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });


});

</script>
</html>

