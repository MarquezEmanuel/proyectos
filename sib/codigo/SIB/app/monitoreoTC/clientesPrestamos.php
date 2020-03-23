<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();

function busca(){
	$consulta = $_SESSION['buscar'];
	if($consulta != null){
		$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
		
		if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_MoraTarjetas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>Codigo Cliente</th>
                                            <th>CUIT</th>
                                            <th style='display:none;'>DNI</th>
                                            <th>Nombre y Apellido</th>
                                            <th style='display:none;'>Producto</th>
                                            <th>Numero de Prestamo</th>
                                            <th style='display:none;'>Vencimiento</th>
                                            <th style='display:none;'>Capital</th>
                                            <th style='display:none;'>Saldo</th>
                                            <th style='display:none;'>Monto Solicitado</th>
                                            <th style='display:none;'>Fecha de Fallecimiento</th>
                                            <th style='display:none;'>Cuenta Master</th>
                                            <th style='display:none;'>Relacion Master</th>
                                            <th>Estado Master</th>
                                            <th>MTU Master</th>
                                            <th style='display:none;'>Saldo Anterior Master</th>
											<th>Saldo Actual Master</th>
											<th style='display:none;'>Ultima Fecha de Ajuste Master</th>
											<th style='display:none;'>Importe de Ajuste Master</th>
											<th style='display:none;'>Importe de Deuda Master</th>
											<th style='display:none;'>Cuenta Visa</th>
                                            <th style='display:none;'>Relacion Visa</th>
                                            <th>Estado Visa</th>
                                            <th>MTU Visa</th>
                                            <th style='display:none;'>Saldo Anterior Visa</th>
											<th>Saldo Actual Visa</th>
											<th style='display:none;'>Ultima Fecha de Ajuste Visa</th>
											<th style='display:none;'>Importe de Ajuste Visa</th>
											<th style='display:none;'>Importe de Deuda Visa</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($row['NOMBRE']);
			$vencimiento = isset($row['VENCIMIENTO']) ? $row['VENCIMIENTO']->format('d/m/Y') : "";
			$fallecido = isset($row['FALLECIDO']) ? $row['FALLECIDO']->format('d/m/Y') : "";
			$fechaMaster = isset($row['MFECHA']) ? $row['MFECHA']->format('d/m/Y') : "";
			$fechaVisa = isset($row['VFECHA']) ? $row['VFECHA']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['IDCLIENTE']}</td>
                <td>{$row['CUIT']}</td>
                <td style='display:none;'>{$row['DNI']}</td>
                <td>{$nombre}</td>
                <td style='display:none;'>{$row['PRODUCTO']}</td>
                <td>{$row['NROPRESTAMO']}</td>
                <td style='display:none;'>{$vencimiento}</td>
                <td style='display:none;'>{$row['CAPITALREAL2']}</td>
                <td style='display:none;'>{$row['SALDOREAL2']}</td>
                <td style='display:none;'>{$row['SOLICITADO2']}</td>
                <td style='display:none;'>{$fallecido}</td>
                <td style='display:none;'>{$row['MCUENTA']}</td>
                <td style='display:none;'>{$row['MRELACION']}</td>
                <td>{$row['MESTADO']}</td>
                <td>{$row['MMUT']}</td>
                <td style='display:none;'>{$row['MSALANT2']}</td>
				<td>{$row['MSALACT2']}</td>
				<td style='display:none;'>{$fechaMaster}</td>
				<td style='display:none;'>{$row['MIMPORTE2']}</td>
				<td style='display:none;'>{$row['MDEUDA2']}</td>
				<td style='display:none;'>{$row['VCUENTA']}</td>
				<td style='display:none;'>{$row['VRELACION']}</td>
				<td>{$row['VESTADO']}</td>
				<td>{$row['VMTU']}</td>
				<td style='display:none;'>{$row['VSALANT2']}</td>
				<td>{$row['VSALACT2']}</td>
				<td style='display:none;'>{$fechaVisa}</td>
				<td style='display:none;'>{$row['VIMPORTE2']}</td>
				<td style='display:none;'>{$row['VDEUDA2']}</td>
                <td class='text-center' title='Ver detalles de la tarjeta en mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesClientesPrestamos' name='{$row['ID']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
        }
        $print = $print . "</tbody></table>
        ";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
} 
echo $print;
	}
}




/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Clientes con prestamos y tarjetas asociadas</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarMoraTarjetas" name="formBuscarMoraTarjetas" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">CUIT:</label> 
                        <input type="number" class="form-control" 
                               id="CUIT" name="CUIT"
                               placeholder="Numero de CUIT">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Producto:</label> 
                        <input type="number" class="form-control" 
                               id="producto" name="producto"
                               placeholder="Numero de Producto">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fallecido:</label> <br>
                        <input type="radio" name="fallecidos" value="IS NOT NULL"> <label class="mr-sm-2">Clientes fallecidos</label>
                        <input type="radio" name="fallecidos" value="IS NULL"> <label class="mr-sm-2">Clientes activos</label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Cuenta Visa:</label> 
                        <input type="number" class="form-control" 
                               id="visa" name="visa"
                               placeholder="Numero de cuenta Visa">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Cuenta Master:</label> 
                        <input type="number" class="form-control" 
                               id="master" name="master"
                               placeholder="Numero de cuenta Master">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarMoraTarjetas" name="btnBuscarMoraTarjetas" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="clientesPrestamos.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                             &nbsp;
                             <a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2">
	<?php
        echo busca();
	?>
	</div>
</div>
<div class="modal fade" id="mdProcesando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/espera.gif" class="img-fluid" alt="Responsive image" background="" width="400" height="400">
                </div>
        </div>
</div>
</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
	$('#tb_buscar_MoraTarjetas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Prestamos TC'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarMoraTarjetas", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarClientesPrestamos.php",
            data: $("#formBuscarMoraTarjetas").serialize(),
			beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_MoraTarjetas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Prestamos TC'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
			complete: function() {
					setTimeout(function(){
						$('#mdProcesando').modal('hide');
					},1000)		
				},
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
    
    /* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */
    
    $("#contenido2").on("click", "img.detallesClientesPrestamos", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesClientesPrestamos.php",
            data: "seleccionado="+idcuotas,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
});

</script>
</html>

