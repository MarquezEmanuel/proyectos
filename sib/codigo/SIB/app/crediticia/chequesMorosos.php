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
        <table id='tb_buscar_cheques' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th style='display:none;'>Digito</th>
                                            <th style='display:none;'>Nombre Cuenta</th>
                                            <th style='display:none;'>CUIL</th>
                                            <th>Producto</th>
                                            <th>Depositante</th>
                                            <th style='display:none;'>Ordenante</th>
                                            <th style='display:none;'>Documento del Cobrador</th>
                                            <th>Monto</th>
                                            <th style='display:none;'>Fecha</th>
                                            <th style='display:none;'>Codigo Usuario</th>
                                            <th>Nombre Usuario</th>
                                            <th style='display:none;'>Sucursal de Pago</th>
                                            <th style='display:none;'>CUIL deudor</th>
                                            <th>Dias de Atraso</th>
                                            <th>Deuda</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['digito']}</td>
                <td style='display:none;'>{$row['nombreCuenta']}</td>
                <td style='display:none;'>{$row['cuilCuenta']}</td>
                <td>{$row['productoCuenta']}</td>
                <td>{$row['depositante']}</td>
                <td style='display:none;'>{$row['ordenante']}</td>
                <td style='display:none;'>{$row['documentoCobrador']}</td>
                <td>{$row['monto2']}</td>
                <td style='display:none;'>{$fecha}</td>
                <td style='display:none;'>{$row['codigoUsuario']}</td>
                <td>{$row['nombreUsuario']}</td>
                <td style='display:none;'>{$row['sucursalPago']}</td>
                <td style='display:none;'>{$row['cuilDeudor']}</td>
                <td>{$row['diasAtraso']}</td>
                <td>{$row['deuda2']}</td>
                <td class='text-center' title='Ver detalles de la cobranza'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesChequesCobrados' name='{$row['id']}' width='18' height='18' > 
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
return $print;
	}
}

/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Cheques cobrados por morosos</u></h3>
        <div id="centro" class="container">
            <form id="formBuscarChequesCobrados" name="formBuscarChequesCobrados" method="POST">
			<br>
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Cuenta:</label> 
                        <input type="number" class="form-control" 
                               id="cuenta" name="cuenta"
                               placeholder="Numero de Cuenta">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="Numero de Sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Producto:</label> 
                        <input type="text" class="form-control" 
                               id="producto" name="producto"
                               placeholder="Producto">
                    </div>
                </div>
				<hr />
                <br>
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Monto:</label> 
                        <input type="number" class="form-control" 
                               id="monto" name="monto"
                               placeholder="Monto en pesos">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Monto:</label> <br>
                        <input type="radio" name="signoSaldo" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoSaldo" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoSaldo" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Dias de Atraso:</label> 
                        <input type="number" class="form-control" 
                               id="dias" name="dias"
                               placeholder="Dias de Atraso">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Dias de Atraso:</label> <br>
                        <input type="radio" name="signoMinimo" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoMinimo" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoMinimo" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                </div>
				<hr />
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarChequesCobrados" name="btnBuscarChequesCobrados" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="chequesMorosos.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
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
</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
	$('#tb_buscar_cheques').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Cheques cobrados por morosos'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarChequesCobrados", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarChequesMorosos.php",
            data: $("#formBuscarChequesCobrados").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_cheques').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Cheques cobrados por morosos'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
    
    /* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */
    
    $("#contenido2").on("click", "img.detallesChequesCobrados", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesChequesCobrados.php",
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

