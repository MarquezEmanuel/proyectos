<?php
/* INICIALIZA LA SESION */
session_start();

function dia(){
	$legajo = $_SESSION['legajo'];
	$usuario = $_SESSION['user'];
	$sql = "SELECT * FROM [10pmcred] where legajo = $legajo AND usuario LIKE '$usuario'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $html = $html . "
                    <tr>
                    <td>{$row['sucursal']}</td>
                    <td>{$row['numeroCuenta']}</td>    
                    <td>{$row['digito']}</td>
					<td>{$row['rubro']}</td>
					<td>{$row['razon']}</td>
                    <td class='text-center' title='Eliminar Cuenta'>
                    <button class='btn btn-sm btn-outline-danger'> 
                        <img src='../../lib/img/DELETE.png' class='detallesCobranzasTC' name='{$row['id']}' width='18' height='18' > 
                    </button>
					</td>
					<td class='text-center' title='Modificar Cuenta'>
                    <button class='btn btn-sm btn-outline-warning'> 
                        <img src='../../lib/img/EDIT.png' class='modificarUsuario' name='{$row['id']}' width='18' height='18' > 
                    </button>
					</td>
                    </tr>";
            }
        } else {
			echo $sql;
            $html = $html . "<tr> <td COLSPAN=7>No hay operaciones</td></tr>";
        }
    } else {
		echo $sql;
        $html = $html . "<tr> <td COLSPAN=7>No hay operaciones</td></tr>";
    }
    return $html;
}

require_once './header.php';
?>
    <div class="card-header">
        <div id="contenido">
            <br><div class="row">
                <div class="col">
                    <div class="text-center">
                        <h4><u>Modificacion o Eliminacion de Operacion</u>
						</h4>
                    </div>
                </div>
            </div>
            <br>
            <div id="centro" class="container">
                    <div class="row">
                        <div class="col">
                            <a href="creacion.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
							&nbsp;&nbsp;
							<a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Salir"></a>
                        </div>
                    </div>
                    <br>
					<div class="form-row align-items-center mx-auto">
                            <table id='conciliacion' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <thead style='background-color:#144c75;color:white;'>
                                    <tr>
                                        <th>Sucursal</th>
                                        <th>Cuenta</th>
                                        <th>Digito</th>
										<th>Rubro</th>
										<th>Razon</th>
                                        <th>Eliminar</th>
                                        <th>Modificar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo dia();
                                    ?>
                                </tbody>
                            </table>
                        </div>
            </div>
        </div>
        <div id="contenido2" name="contenido2">
		
		</div>

    </div>
	
<div class="modal fade" id="mdProcesando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/ajax-loader.gif" class="img-fluid" alt="Responsive image" background="" width="250" height="250">
                </div>
        </div>
</div>



<div class="modal fade" id="infos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">CUENTAS ASJ</h4>
            </div>
            <div class="modal-body" id="mensaje">
				<em align="center">En esta pantalla se encuentran todas las cuentas ASJ para consultar sus saldos.</em>
				<br><br>
				<em align="center">Se pueden agregar cuentas nuevas, modificar existentes o eliminarlas.</em>
			</div>
            <div class="modal-footer">
                <input type='submit' class='btn btn-outline-secondary' data-dismiss="modal" value='Aceptar'>
            </div>
        </div>
    </div>
</div>


</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscar", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarASJ.php",
            data: $("#formBuscarEmpleado").serialize(),
			beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
			},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_cobranzasTC').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Empleados'
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
    
    $("#centro").on("click", "img.detallesCobranzasTC", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "procesarBajaPMCRED.php",
            data: "seleccionado="+idcuotas,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición h</div>');
            }
        });
    });
	
	/*MODIFICAR USUARIO*/
	
	
	$("#centro").on("click", "img.modificarUsuario", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "modificacionPMCRED.php",
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

