<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();


/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Clientes potenciales</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarPotenciales" name="formBuscarPotenciales" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Nombre de Cliente:</label> 
                        <input type="text" class="form-control" 
                               id="nombre" name="nombre" 
                               pattern="[A-Za-zÁÉÍÚÓáéíúó ]{0,100}"
                               placeholder="Nombre de cliente"
                               title="Transaccion">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Numero de Cliente:</label> 
                        <input type="number" class="form-control" 
                               id="numero" name="numero"
                               placeholder="Numero de cliente" title="sucursal girada">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio" 
                               placeholder="DD/MM/AAAA" title="Fecha inicio">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Fin:</label> 
                        <input type="date" class="form-control" 
                               id="fechaFin" name="fechaFin" 
                               placeholder="DD/MM/AAAA" title="Fecha fin">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarPotenciales" name="btnBuscarPotenciales" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="buscarClientesPotenciales.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                            &nbsp;
                            <a href="clientesPotenciales.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2">
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
	
	$('#tb_buscar_potenciales').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Clientes Potenciales'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarPotenciales", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarClientesPotenciales.php",
            data: $("#formBuscarPotenciales").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_potenciales').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Clientes Potenciales'
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
    
    $("#contenido2").on("click", "img.detallesPotenciales", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesClientesPotenciales.php",
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
    
    $("#contenido").on("click", "img.detallesPotenciales2", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesClientesPotenciales.php",
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


