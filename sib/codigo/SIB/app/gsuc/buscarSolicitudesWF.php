<?php
/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha = Date("Y-m-d");

session_start();

function procesos(){
	$query = "select DISTINCT proceso FROM solicitudesWF";
	$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $html = $html . "<option value='{$row['proceso']}'>{$row['proceso']}</option>";
            }
        } else {
            $html = $html . "<option>No hay procesos disponibles</option>";
        }
    } else {
        $html = $html . "<option>No hay procesos disponibles</option>";
    }
    return $html;
}

function estados(){
	$query = "select DISTINCT descripcion FROM solicitudesWF";
	$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $html = $html . "<option value='{$row['descripcion']}'>{$row['descripcion']}</option>";
            }
        } else {
            $html = $html . "<option>No hay estados disponibles</option>";
        }
    } else {
        $html = $html . "<option>No hay estados disponibles</option>";
    }
    return $html;
}

function busca(){
	$consulta = $_SESSION['buscar'];
	if($consulta != null){
		$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
		
		if ($result) {
    if (sqlsrv_has_rows($result)) {
        $resultado = '<br>
            <div class="table-responsive">
                <table id="tb_buscar_solicitudes" class="table table-striped table-bordered" border="3" style="width: 100%">
                    <thead style="background-color:#024d85; color:white;">
                        <tr>
                            <th>Proceso</th>
                            <th>Sucursal</th>
                            <th>Fecha alta</th>
                            <th>Cliente</th>
                            <th>Fecha cambio</th>
                            <th>Descripción</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>';
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fechaAlta = isset($row['FECHAALTA']) ? $row['FECHAALTA']->format('d/m/Y') : "";
            $fechaEstado = isset($row['FECHAESTADO']) ? $row['FECHAESTADO']->format('d/m/Y') : "";
            $resultado .= "
                        <tr> 
                            <td>{$row['PROCESO']}</td>
                            <td>{$row['SUCURSAL']}</td>
                            <td>{$fechaAlta}</td>
                            <td>{$row['CLIENTE']}</td>
                            <td>{$fechaEstado}</td>
                            <td>{$row['DESCRIPCION']}</td>
                            <td class='text-center' title='Ir a ver detalles de solicitud'>
                                <button class='btn btn-sm btn-outline-info detallesSolicitudWF' name='{$row['ID']}'> 
                                    <img src='/lib/img/SHOW.png' width='18' height='18' > 
                                </button>
                            </td>
                        </tr>";
        }
        $resultado .= '            
                    </tbody>
            </div>';
    }  else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $resultado = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
}
echo $resultado;
	}
}

?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Solicitudes de workflow</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarSolicitudesWF" name="formBuscarSolicitudesWF" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="Número de sucursal" 
                               title="Número de sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio" max="<?= $fecha; ?>"
                               placeholder="DD/MM/AAAA" title="Fecha inicio para cambio de estado">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Fin:</label> 
                        <input type="date" class="form-control" 
                               id="fechaFin" name="fechaFin" max="<?= $fecha; ?>"
                               placeholder="DD/MM/AAAA" title="Fecha fin para cambio de estado">
                    </div>
                </div>
                <br>
				<hr>
				<div class="row">
                    <div class="col">
                        <label class="mr-sm-2" title="Seleccione pulsando Ctrl para elegir mas de un segmento">Lista de Procesos:</label> 
                        <select multiple id="procesos" class="form-control" name="procesos[]" style="width: 400; height:250" title="Seleccione pulsando Ctrl para elegir mas de un proceso">
                            <?php
                            echo procesos();
                            ?>
                        </select>
                    </div>
					<div class="col">
                        <label class="mr-sm-2" title="Seleccione pulsando Ctrl para elegir mas de un segmento">Lista de Estados:</label> 
                        <select multiple id="estados" class="form-control" name="estados[]" style="width: 400; height:250" title="Seleccione pulsando Ctrl para elegir mas de un estado">
                            <?php
                            echo estados();
                            ?>
                        </select>
                    </div>
                </div>
				<br>
				<hr>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarSolicitudes" name="btnBuscarSolicitudes" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="buscarSolicitudesWF.php"><input type="button" class="btn btn-dark" value="Cancelar"></a>
                            &nbsp;
                            <a href="reportesTablas.php"><input type="button" class="btn btn-dark" value="Volver"></a>
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
<div class="modal fade" id="mdCargando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/cargandoGSUC.gif" class="img-fluid" alt="Responsive image" background="" width="250" height="250">
                </div>
        </div>
</div>
</body>
<script>
$(document).ready(function () {
	
	$('#tb_buscar_solicitudes').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Solicitudes de workflow'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarSolicitudes", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarSolicitudesWF.php",
            data: $("#formBuscarSolicitudesWF").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_solicitudes').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Solicitudes de workflow'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
			complete: function() {
					setTimeout(function(){
						$('#mdCargando').modal('hide');
					},1000)		
				},
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
    
    /* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */
    
    $("#contenido2").on("click", "button.detallesSolicitudWF", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesSolicitudesWF.php",
            data: "seleccionado="+idcanje,
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
    
    /* CARGA EL FORMULARIO DE DETALLES DE GARANTIA EN EL DIV CONTENIDO */
    
    $("#contenido").on("click", "button.detallesSolicitudWF", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesSolicitudesWF.php",
            data: "seleccionado="+idcanje,
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

