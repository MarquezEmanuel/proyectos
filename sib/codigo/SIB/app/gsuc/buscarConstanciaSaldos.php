<?php
include_once '../conf/BDConexion.php';
/* INICIALIZA LA SESION */
session_start();


$_SESSION['buscar'] = null;
$usuario = trim($_SESSION['legajo']);
date_default_timezone_set('America/Argentina/Buenos_Aires');
$month = date('m', strtotime('-1 month'));
$day = date("d", mktime(0, 0, 0, $month + 1, 0, date('Y')));
$fecha = ($month == 12) ? date('d/m/y', mktime(0, 0, 0, $month, $day, date('Y', strtotime('-1 year')))) : date('d/m/y', mktime(0, 0, 0, $month, $day, date('Y')));
$fecha2 = str_replace("/", "", $fecha);
if ($usuario == '01563S' || $usuario == '85') {
    header('Location: constanciaSaldos.php');
} else {
    if ($usuario == '01737' || $usuario == '01564' || $usuario == '01512' || $usuario == '07489' || $usuario == '07488' || $usuario == '11111') {
        $print = '<div id="centro" class="container">
            <form id="formBuscarAltaClientes" name="formBuscarAltaClientes" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Cuenta:</label> 
                        <input type="number" class="form-control" 
                               id="cuenta" name="cuenta" 
                               placeholder="Numero de cuenta"
                               title="Cuenta">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Nombre:</label> 
                        <input type="text" class="form-control" 
                               id="nombre" name="nombre" 
                               pattern="[A-Za-zÁÉÍÚÓáéíúó ]{0,100}"
                               placeholder="Nombre de Cliente"
                               title="Cliente">
                    </div>
					<div class="col">
                        <label class="mr-sm-2">CUIT:</label> 
                        <input type="number" class="form-control" 
                               id="cuit" name="cuit" 
                               placeholder="Numero de cuit"
                               title="cuit">
                    </div>
                </div>
				<br>
				<hr>
				<div class="row">
					<div class="col">
                        <label class="mr-sm-2">Fecha Inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio" 
                               title="Seleccionar SIEMPRE primer dia del mes">
                    </div>
					<div class="col">
                        <label class="mr-sm-2">Fecha Fin:</label> 
                        <input type="date" class="form-control" 
                               id="fechaFin" name="fechaFin" 
                               title="Seleccionar SIEMPRE ultimo dia del mes">
                    </div>
				</div>
                <br> <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
							<a href="constanciaSaldos.php"><input type="button" class="btn btn-dark" id="" name="" value="Editar Cuentas"></a>
                            &nbsp;
                            <input type="submit" class="btn btn-dark" id="btnBuscarConstancias" name="btnBuscarConstancias" value="Buscar" class="btn btn-bsc mt-4">
							&nbsp;
                            <a href="buscarConstanciaSaldos.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                             &nbsp;
                             <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>';
    } else {
        $print = '<br>
            <div class="alert alert-warning text-center" role="alert"> No tiene acceso al reporte solicitado</div>
            &nbsp;
            <div class="text-center">
                <a href="reportesTablas.php">
                    <input type="button" class="btn btn-dark" value="Volver">
                </a>
            </div>';
    }
}

/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Constancia de saldos</u></h3>
        <br>
        <?php
        echo $print;
        ?>
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

        $("#contenido2").on("click", "#seleccionarTodos", function () {
            if ($(this).is(':checked')) {
                $("input[name='cbCorreos[]']").each(function () {
                    $(this).prop('checked', true);
                });
            } else {
                $("input[name='cbCorreos[]']").each(function () {
                    $(this).prop('checked', false);
                });
            }
        });

        /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */

        $("#contenido").on("click", "#btnBuscarConstancias", function () {
            $.ajax({
                type: "POST",
                url: "procesarBuscarConstanciaSaldo.php",
                data: $("#formBuscarAltaClientes").serialize(),
                beforeSend: function () {
                    $('#mdCargando').modal({show: true, backdrop: 'static'});
                },
                success: function (data) {
                    $("#contenido2").html(data);
                    $('#tb_buscar_alta').DataTable({
                        dom: 'Brtip',
                        responsive: true,
                        scrollX: true,
                        pageLength: 15,
                        language: {url: "/lib/js/Spanish.json"
                        }
                    });
                },
                complete: function () {
                    setTimeout(function () {
                        $('#mdCargando').modal('hide');
                    }, 1000);
                },
                error: function (data) {
                    console.log(data);
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
            return false;
        });

        /* 
         
         $("#contenido").on("click", "img.detallesCobranzasTC", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
         type: "POST",
         url: "procesarBaja.php",
         data: "seleccionado=" + idcuotas,
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
         
         $("#contenido").on("click", "img.modificarUsuario", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
         type: "POST",
         url: "modificacion.php",
         data: "seleccionado=" + idcuotas,
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
         
         */


    });
</script>
</html>



