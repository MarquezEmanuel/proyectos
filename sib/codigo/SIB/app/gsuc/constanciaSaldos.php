<?php
include_once '../conf/BDConexion.php';
include_once '../conf/Log.php';

/* INICIALIZA LA SESION */
session_start();


$_SESSION['buscar'] = null;
$usuario = trim($_SESSION['legajo']);
date_default_timezone_set('America/Argentina/Buenos_Aires');
$month = date('m', strtotime('-1 month'));
$day = date("d", mktime(0, 0, 0, $month + 1, 0, date('Y')));
if ($month == 12) {
    $fecha2 = date('d/m/y', mktime(0, 0, 0, $month, $day, date('Y', strtotime('-1 year'))));
} else {
    $fecha2 = date('d/m/y', mktime(0, 0, 0, $month, $day, date('Y')));
}
$fecha2 = str_replace("/", "", $fecha2);

$clientes = "select * from [3cuentasConstanciaSaldo]";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $clientes);
if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = '<div id="centro" class="container">
                    <div class="row">
                        <div class="col">
                            <a href="altaCuenta.php"><input type="button" class="btn btn-dark" id="" name="" value="Nueva Cuenta"></a>
							&nbsp;&nbsp;
							<a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                    <br>
					<div class="form-row align-items-center mx-auto">
                            <table id="conciliacion" class="table table-striped table-bordered" border="3" style="width: 100%">
                                <thead style="background-color:#144c75;color:white;">
                                    <tr>
                                        <th>Sucursal</th>
                                        <th>Cuenta</th>
                                        <th>Digito</th>
                                        <th>Eliminar</th>
                                        <th>Modificar</th>
                                    </tr>
                                </thead>
                                <tbody>';
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $print = $print . "
            <tr>
                    <td>{$row['sucursal']}</td>
                    <td>{$row['cuenta']}</td>    
                    <td>{$row['digito']}</td>
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
        $print = $print . " </tbody>
                            </table>
                        </div>
                    </form>";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados</div>';
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

        $("#contenido").on("click", "#btnBuscarAltaClientes", function () {
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
                    }, 1000)
                },
                error: function () {
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
            return false;
        });

        /* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */

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

        /*MODIFICAR USUARIO*/


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


    });
</script>
</html>



