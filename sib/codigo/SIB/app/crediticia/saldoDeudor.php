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
        <table id='tb_buscar_saldoDeudor' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                        <th>Cuenta</th>
                                        <th style='display:none;'>Producto</th>
                                        <th style='display:none;'>Definicion estado</th>
                                        <th style='display:none;'>Saldo</th>
                                        <th style='display:none;'>Sucursal</th>
                                        <th>Numero de Cliente</th>
                                        <th>Nombre de Cliente</th>
                                        <th>Estado</th>
                                        <th>Ultimo Movimiento</th>
                                        <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

            $fechaUltimoMovimiento = isset($row['fechaUltimoMovimiento']) ? $row['fechaUltimoMovimiento']->format('d/m/Y') : "";
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $print = $print . "
            <tr>
                <td>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td style='display:none;'>{$row['definicionEstado']}</td>
                <td style='display:none;'>{$row['saldo2']}</td>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td>{$row['numeroCliente']}</td>
                <td>{$nombreCliente}</td>
                <td>{$row['estado']}</td>
                <td>{$fechaUltimoMovimiento}</td>
                <td class='text-center' title='Ir a ver detalles de las Cuentas'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesSaldoDeudor' name='{$row['id']}' width='18' height='18' > 
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
        <h3 class="text-center"><u>Cuentas por cerrar saldo deudor</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarSaldoDeudor" name="formBuscarSaldoDeudor" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Numero de Cliente:</label> 
                        <input type="number" class="form-control" 
                               id="numeroCliente" name="numeroCliente"
                               placeholder="Numero Cliente" 
                               title="Numero Cliente">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Numero de Sucursal:</label> 
                        <input type="text" class="form-control" 
                               id="sucursal" name="sucursal" 
                               pattern="[A-Za-zÁÉÍÚÓáéíúó ]{0,100}"
                               placeholder="Sucursal"
                               title="Sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio"
                               placeholder="DD/MM/AAAA" title="Fecha Inicio">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Fin:</label> 
                        <input type="date" class="form-control" 
                               id="fechaFin" name="fechaFin" 
                               placeholder="DD/MM/AAAA" title="Fecha Fin">
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarSaldoDeudor" name="btnBuscarSaldoDeudor" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="saldoDeudor.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
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
	
	$('#tb_buscar_saldoDeudor').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Cuentas por cerrar saldo deudor'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarSaldoDeudor", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarSaldoDeudor.php",
            data: $("#formBuscarSaldoDeudor").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_saldoDeudor').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Cuentas por cerrar saldo deudor'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
            error: function (data) {
				console.log(data);
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
    
    /* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */
    
    $("#contenido2").on("click", "img.detallesSaldoDeudor", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesSaldoDeudor.php",
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

