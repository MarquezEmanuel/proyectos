<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function saldos() {
    $sql = "SELECT * FROM [bd_sib].[dbo].[3chequerasPendientesEntrega] WHERE SUCURSAL = {$_SESSION['sucursal']}";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$nombre = utf8_encode($row['nombreCuenta']);
                $producto = $row['producto'];
                $dias = $row['diasAtraso'];
                if($producto == 107 || $producto == 117){
                    if($dias < 45){
                        $html = $html . "<tr>
                            <td>{$nombre}</td>
                            <td>{$row['sucursal']}</td> 
                            <td>{$row['cuenta']}</td> 
                            <td>{$row['numeroInicial']}</td> 
                            <td>{$row['numeroFinal']}</td>
                            <td>{$row['diasAtraso']}</td>
                            <td>{$row['producto']}</td>
                            <td><img src='/lib/img/verde.png' width='30' height='30'></td>
							<td><input type='button' class='btn btn-dark btnTratar' id='{$row['id']}' name='{$row['id']}' value='Tratar'></td>
                            </tr>";
                    }else{
                        if($dias < 60){
                            $html = $html . "<tr>
                            <td>{$nombre}</td>
                            <td>{$row['sucursal']}</td> 
                            <td>{$row['cuenta']}</td> 
                            <td>{$row['numeroInicial']}</td> 
                            <td>{$row['numeroFinal']}</td>
                            <td>{$row['diasAtraso']}</td>
                            <td>{$row['producto']}</td>
                            <td><img src='/lib/img/amarillo.png' width='30' height='30'></td>
							<td><input type='button' class='btn btn-dark btnTratar' id='{$row['id']}' name='{$row['id']}' value='Tratar'></td>
                            </tr>";
                        }else{
                            $html = $html . "<tr>
                            <td>{$nombre}</td>
                            <td>{$row['sucursal']}</td> 
                            <td>{$row['cuenta']}</td> 
                            <td>{$row['numeroInicial']}</td> 
                            <td>{$row['numeroFinal']}</td>
                            <td>{$row['diasAtraso']}</td>
                            <td>{$row['producto']}</td>
                            <td><img src='/lib/img/rojo.png' width='30' height='30'></td>
							<td><input type='button' class='btn btn-dark btnTratar' id='{$row['id']}' name='{$row['id']}' value='Tratar'></td>
                            </tr>";
                        }
                    }
                }else{
                    if($producto == 100 || $producto == 101 || $producto == 103){
                    if($dias < 15){
                        $html = $html . "<tr>
                            <td>{$nombre}</td>
                            <td>{$row['sucursal']}</td> 
                            <td>{$row['cuenta']}</td> 
                            <td>{$row['numeroInicial']}</td> 
                            <td>{$row['numeroFinal']}</td>
                            <td>{$row['diasAtraso']}</td>
                            <td>{$row['producto']}</td>
                            <td><img src='/lib/img/verde.png' width='30' height='30'></td>
							<td><input type='button' class='btn btn-dark btnTratar' id='{$row['id']}' name='{$row['id']}' value='Tratar'></td>
                            </tr>";
                    }else{
                        if($dias < 30){
                            $html = $html . "<tr>
                            <td>{$nombre}</td>
                            <td>{$row['sucursal']}</td> 
                            <td>{$row['cuenta']}</td> 
                            <td>{$row['numeroInicial']}</td> 
                            <td>{$row['numeroFinal']}</td>
                            <td>{$row['diasAtraso']}</td>
                            <td>{$row['producto']}</td>
                            <td><img src='/lib/img/amarillo.png' width='30' height='30'></td>
							<td><input type='button' class='btn btn-dark btnTratar' id='{$row['id']}' name='{$row['id']}' value='Tratar'></td>
                            </tr>";
                        }else{
                            $html = $html . "<tr>
                            <td>{$nombre}</td>
                            <td>{$row['sucursal']}</td> 
                            <td>{$row['cuenta']}</td> 
                            <td>{$row['numeroInicial']}</td> 
                            <td>{$row['numeroFinal']}</td>
                            <td>{$row['diasAtraso']}</td>
                            <td>{$row['producto']}</td>
                            <td><img src='/lib/img/rojo.png' width='30' height='30'></td>
							<td><input type='button' class='btn btn-dark btnTratar' id='{$row['id']}' name='{$row['id']}' value='Tratar'></td>
                            </tr>";
                        }
                    }
                }
                }
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=8>No hay chequeras pendientes en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=8>No hay chequeras pendientes en la fecha</td></tr>";
    }
    return $html;
}

require_once './menuSucursal.php';
?>

<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Chequeras Pendientes de Entrega</u></h3>
                        </div>
                        <br>
                        <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosSaldos' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 15%'/>
                                    <col style='width: 8%'/>
                                    <col style='width: 8%'/>
                                    <col style='width: 13%'/>
                                    <col style='width: 13%'/>
                                    <col style='width: 15%'/>
                                    <col style='width: 10%'/>
                                    <col style='width: 8%'/>
									<col style='width: 10%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Denominacion</th>
                                        <th>Sucursal</th>
                                        <th>Cuenta</th>
                                        <th>Numero Inicial</th>
                                        <th>Numero Final</th>
                                        <th>Dias de Atraso</th>
                                        <th>Producto</th>
                                        <th>Estado</th>
										<th>Tratar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo saldos();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" charset="utf8" src="/lib/JQuery/diarios.js"></script>
<script> 
$(document).ready(function () {

    /* MODAL PARA CARGAR UN NUEVO USUARIO */

    $('.btnTratar').click(function () {
        var idcuenta = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formComentario.php",
            data: "seleccionado="+idcuenta,
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
    
    /* CONFIRMA LA OPERACION DE ALTA. REALIZA LAS VALIDACIONES Y MUESTRA EL RESULTADO */
    
    $('#btnCargarUsuario').click(function () {
        $.ajax({
            type: "POST",
            url: "procesarComentario.php",
            data: $("#formCargarUsuario").serialize(),
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").html(data);
                },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
            $('#mdTratar').modal('toggle');
            return false;
            
    }); 

});
</script>
</html>



