<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
//session_start();

/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Clientes con telefonos validos</u></h3>
        <div id="centro" class="container">
            <form id="formBuscarChequesCobrados" name="formBuscarChequesCobrados" method="POST">
			<br>
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Codigo Cliente:</label> 
                        <input type="number" class="form-control" 
                               id="codigo" name="codigo"
                               placeholder="Numero de Codigo">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Nombre:</label> 
                        <input type="text" class="form-control" 
                               id="nombre" name="nombre"
                               placeholder="Nombre o apellido">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Usuario:</label> 
                        <input type="text" class="form-control" 
                               id="usuario" name="usuario"
                               placeholder="Usuario de creacion">
                    </div>
                </div>
                <br>
				<hr />
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarChequesCobrados" name="btnBuscarChequesCobrados" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="telefonos.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                             &nbsp;
                             <a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
				<hr />
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2"></div>
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
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarChequesCobrados", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarTelefonos.php",
            data: $("#formBuscarChequesCobrados").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_cheques').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Telefonos Particulares Invalidos'
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
});

</script>
</html>

