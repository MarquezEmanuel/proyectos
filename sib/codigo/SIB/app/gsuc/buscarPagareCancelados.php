<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
//session_start();

/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Pagare cancelados en SAV</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarPagare" name="formBuscarPagare" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Producto:</label> 
                        <input type="number" class="form-control" 
                               id="producto" name="producto"
                               placeholder="producto" 
                               title="producto">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Numero de Pagare:</label> 
                        <input type="number" class="form-control" 
                               id="pagare" name="pagare"
                               placeholder="Numero de pagare">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="sucursal" title="Sucursal">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarPagare" name="btnBuscarPagare" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="buscarPagareCancelados.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                            &nbsp;
                            <a href="pagaresCancelados.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
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

<div class="modal fade" id="mdDetalleChequePagado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-center" id="myModalLabel">DETALLES</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Codigo de Cliente:</label> 
                                <div class="col">
                                    <input class="form-control" id="suc" name="suc" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre de Cliente: </label> 
                                <div class="col">
                                    <input class="form-control" id="cuenta" name="cuenta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Producto: </label> 
                                <div class="col">
                                    <input class="form-control" id="prod" name="prod" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Numero de Pagare: </label> 
                                <div class="col">
                                    <input class="form-control" id="moneda" name="moneda" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Fecha de Liquidacion: </label> 
                                <div class="col">
                                    <input class="form-control" id="nombreProducto" name="nombreProducto" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Fecha de Vencimiento: </label> 
                                <div class="col">
                                    <input class="form-control" id="est" name="est" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Descripcion: </label> 
                                <div class="col">
                                    <input class="form-control" id="fechaAlta" name="fechaAlta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sucursal: </label> 
                                <div class="col">
                                    <input class="form-control" id="cuota" name="cuota" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre Sucursal Deposito: </label> 
                                <div class="col">
                                    <input class="form-control" id="fechaMCP" name="fechaMCP" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-outline-secondary" data-dismiss="modal" value="Aceptar">
                        </div>
                    </div>
                </div>
            </div>
</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
	$('#tb_buscar_cobranzasTC').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Pagares Cancelados SAV'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarPagare", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarPagareCancelados.php",
            data: $("#formBuscarPagare").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
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
                            title: 'Pagares Cancelados SAV'
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
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la peticiĂ³n </div>');
            }
        });
        return false;
    });
    $("#contenido2").on("click", ".detallesCobranzasTC", function (){
                        var fila = $(this).attr('name');
                        var columnas = $('tr#' + fila).find('td');
                        $('#suc').val(columnas.eq(0).text());
                        $('#cuenta').val(columnas.eq(1).text());
                        $('#prod').val(columnas.eq(2).text());
                        $('#moneda').val(columnas.eq(3).text());
                        $('#nombreProducto').val(columnas.eq(4).text());
                        $('#est').val(columnas.eq(5).text());
                        $('#fechaAlta').val(columnas.eq(6).text());
                        $('#cuota').val(columnas.eq(7).text());
                        $('#fechaMCP').val(columnas.eq(8).text());
                        $('#mdDetalleChequePagado').modal({});
                        return false;
                    });
});

</script>
</html>
