<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la garantia seleccionada */

function data(){
    return $idTransaccion = $_POST['seleccionado'];
}
/* Se obtiene el id para obtener los datos de la BD */
$idTransaccion = data();
$query = "SELECT * FROM transaccion t
                        WHERE t.idTransaccion =" . $idTransaccion;
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
?>

<script>
            $(document).ready(function () {
                $('#fisica').click(function () {
                    agregarFisica();
                });
                $("body").on('click', "#borrarFisica", eliminarFisica);
                $('#juridica').click(function () {
                    agregarJuridica();
                });
                $("body").on('click', "#borrarJuridica", eliminarJuridica);
            });
            function agregarFisica() {
                $("#tablaFisicas")
                        .append
                        (
                                $('<tr>')
                                .append
                                (
                                        $('<td>')
                                        .append
                                        (
                                                $('<input>').attr('type', 'text').addClass('form-control').attr('name', 'operador[]').attr('id', 'operador[]').attr('placeholder', 'SI/NO').attr('required', 'true')
                                                )
                                        )
                                .append
                                (
                                        $('<td>')
                                        .append
                                        (
                                                $('<input>').attr('type', 'text').addClass('form-control').attr('name', 'identificacion[]').attr('id', 'identificacion[]').attr('placeholder', 'Identificacion').attr('required', 'true')
                                                )
                                        )
                                .append
                                (
                                        $('<td>')
                                        .append
                                        (
                                                $('<input>').attr('type', 'number').addClass('form-control').attr('id', 'cuit[]').attr('name', 'cuit[]').attr('placeholder', 'CUIT').attr('required', 'true')
                                                )
                                        )
                                .append
                                (
                                        $('<td>')
                                        .append
                                        (
                                                $('<input>').attr('type', 'text').addClass('form-control').attr('name', 'apellidos[]').attr('id', 'apellidos[]').attr('placeholder', 'Apellidos').attr('required', 'true')
                                                )
                                        )
                                .append
                                (
                                        $('<td>')
                                        .append
                                        (
                                                $('<input>').attr('type', 'text').addClass('form-control').attr('name', 'nombres[]').attr('id', 'nombres[]').attr('placeholder', 'Nombres').attr('required', 'true')
                                                )
                                        )
                                .append
                                (
                                        $('<td>')
                                        .append
                                        (
                                                $('<input>').attr('type', 'text').addClass('form-control').attr('name', 'tipo[]').attr('id', 'tipo[]').attr('placeholder', 'Tipo').attr('required', 'true')
                                                )
                                        )
                                .append
                                (
                                        $('<td>')
                                        .append
                                        (
                                                $('<input>').attr('type', 'number').addClass('form-control').attr('name', 'documento[]').attr('id', 'documento[]').attr('placeholder', 'Numero').attr('required', 'true')
                                                )
                                        )
                                .append
                                (
                                        $('<td>').addClass('text-center')
                                        .append
                                        (
                                                $('<button>').attr('type', 'button').addClass('btn btn-danger').attr('id', 'borrarFisica').attr('name', 'borrarFisica').text('Eliminar')
                                                )
                                        )
                                );
            }

            function eliminarFisica() {
                $(this).parent().parent().fadeOut("slow", function () {
                    $(this).remove();
                });

            }
            function agregarJuridica() {
                $("#tablaJuridicas")
                        .append
                        (
                                $('<tr>')
                                .append
                                (
                                        $('<td>')
                                        .append
                                        (
                                                $('<input>').attr('type', 'text').addClass('form-control').attr('name', 'operadorJuridica[]').attr('id', 'operadorJuridica[]').attr('placeholder', 'SI/NO').attr('required', 'true')
                                                )
                                        )
                                .append
                                (
                                        $('<td>')
                                        .append
                                        (
                                                $('<input>').attr('type', 'text').addClass('form-control').attr('name', 'identificacionJuridica[]').attr('id', 'identificacionJuridica[]').attr('placeholder', 'Identificacion').attr('required', 'true')
                                                )
                                        )
                                .append
                                (
                                        $('<td>')
                                        .append
                                        (
                                                $('<input>').attr('type', 'number').addClass('form-control').attr('name', 'cuitJuridica[]').attr('id', 'cuitJuridica[]').attr('placeholder', 'CUIT').attr('required', 'true')
                                                )
                                        )
                                .append
                                (
                                        $('<td>')
                                        .append
                                        (
                                                $('<input>').attr('type', 'text').addClass('form-control').attr('name', 'denominacionJuridica[]').attr('id', 'denominacionJuridica[]').attr('placeholder', 'Denominacion').attr('required', 'true')
                                                )
                                        )
                                .append
                                (
                                        $('<td>').addClass('text-center')
                                        .append
                                        (
                                                $('<button>').attr('type', 'button').addClass('btn btn-danger').attr('id', 'borrarFisica').attr('name', 'borrarFisica').text('Eliminar')
                                                )
                                        )
                                );
            }

            function eliminarJuridica() {
                $(this).parent().parent().fadeOut("slow", function () {
                    $(this).remove();
                });

            }
        </script>
<div class="container">
    <div id="contenido">
        <h4 class="text-center p-4">MODIFICAR REPORTE</h4>
        <div id="centro" class="container">
            <?php
            if (!$idTransaccion || !$result) {

                echo "No se";
            } else {
                $row = sqlsrv_fetch_array($result);

                $idTransaccion = $row['idTransaccion'];
                $fecha = utf8_encode($row['fecha']);
                $provincia = utf8_encode($row['provincia']);
                $localidad = utf8_encode($row['localidad']);
                $calle = utf8_encode($row['calle']);
                $numero = $row['numero'];
                $operacion = utf8_encode($row['operacion']);
                $transaccion = utf8_encode($row['transaccion']);
                $moneda = utf8_encode($row['moneda']);
                $monto = $row['monto'];
                $equivalente = $row['equivalente'];

                //tabla juridicas
                function personasJuridicas() {
                    $idTransaccion = data();
                    $usuario = "SELECT * FROM vinculado WHERE idTransaccion = '{$idTransaccion}' AND nombre IS NULL";
                    $usuarios = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $usuario);
                    $primero = 0;
                    $html = '';
                    if ($row = sqlsrv_fetch_array($usuarios)) {
                        if("Persona Jurídica" == utf8_encode($row["tipo"])){                           
                        $idJuridica = $row["id"];
                        do {
                            if ($primero == 0) {
                                $html .= '<tr><td><input type="text" class="form-control" name="operadorJuridica[]" id="operadorJuridica[]" placeholder="SI/NO" required="required" value = "'.utf8_decode($row["operador"]).'"></td>
                                        <td><input type="text" class="form-control" name="identificacionJuridica[]" id="identificacionJuridica[]" placeholder="Identificacion" required="required" value = "'.utf8_decode($row["identificacion"]).'"></td>
                                        <td><input type="number" class="form-control" name="cuitJuridica[]" id="cuitJuridica[]" placeholder="CUIT" required="required" value = '.$row["cuit"].'></td>
                                        <td><input type="text" class="form-control" name="denominacionJuridica[]" id="denominacionJuridica[]" placeholder="Denominacion" required="required" value = "'.utf8_decode($row["apellidoDenominacion"]).'"></td>
                                        <td class="text-center"><button type="button" class="btn btn-danger" id="borrarFisica" name="borrarFisica">Eliminar</button></td></tr>';
                                ++$primero;
                            } else {
                                $html .= '<tr><td><input type="text" class="form-control" name="operadorJuridica[]" id="operadorJuridica[]" placeholder="SI/NO" required="required" value = "'.utf8_decode($row["operador"]).'"></td>
                                        <td><input type="text" class="form-control" name="identificacionJuridica[]" id="identificacionJuridica[]" placeholder="Identificacion" required="required" value = "'.utf8_decode($row["identificacion"]).'"></td>
                                        <td><input type="number" class="form-control" name="cuitJuridica[]" id="cuitJuridica[]" placeholder="CUIT" required="required" value = '.$row["cuit"].'></td>
                                        <td><input type="text" class="form-control" name="denominacionJuridica[]" id="denominacionJuridica[]" placeholder="Denominacion" required="required" value = "'.utf8_decode($row["apellidoDenominacion"]).'"></td>
                                        <td class="text-center"><button type="button" class="btn btn-danger" id="borrarFisica" name="borrarFisica">Eliminar</button></td></tr>';
                                ++$primero;
                            }
                        } while ($row = sqlsrv_fetch_array($usuarios));
                        }
                    } else {
                        if ($primero == 0) {
                            $html .= '<tr><td><input type="text" class="form-control" name="operadorJuridica[]" id="operadorJuridica[]" placeholder="SI/NO" required="required" value =></td>
                                        <td><input type="text" class="form-control" name="identificacionJuridica[]" id="identificacionJuridica[]" placeholder="Identificacion" required="required"></td>
                                        <td><input type="number" class="form-control" name="cuitJuridica[]" id="cuitJuridica[]" placeholder="CUIT" required="required"></td>
                                        <td><input type="text" class="form-control" name="denominacionJuridica[]" id="denominacionJuridica[]" placeholder="Denominacion" required="required"></td>
                                        <td class="text-center"><button type="button" class="btn btn-danger" id="borrarFisica" name="borrarFisica">Eliminar</button></td></tr>';
                        }
                    }
                    return $html;
                }
                
                
                //tabla fisicas
                function personasFisicas() {
                    $idTransaccion = data();
                    $usuario = "SELECT * FROM vinculado WHERE idTransaccion = '{$idTransaccion}' AND nombre IS NOT NULL";
                    $usuarios = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $usuario);
                    $primero = 0;
                    $html = '';
                    if ($row = sqlsrv_fetch_array($usuarios)) {
                        if("Persona Física" == utf8_encode($row["tipo"])){
                            $idFisica = $row["id"];
                        do {
                            if ($primero == 0) {
                                $html .= '<tr><td><input type="text" class="form-control" name="operador[]" id="operador[]" placeholder="SI/NO" required="required" value = "'.utf8_decode($row["operador"]).'"></td>
                                        <td><input type="text" class="form-control" name="identificacion[]" id="identificacion[]" placeholder="Identificacion" required="required" value = "'.utf8_decode($row["identificacion"]).'"></td>
                                        <td><input type="number" class="form-control" id="cuit[]" name="cuit[]" placeholder="CUIT" required="required" value = '.$row["cuit"].'></td>
                                        <td><input type="text" class="form-control" name="apellidos[]" id="apellidos[]" placeholder="Apellidos" required="required" value = "'.utf8_decode($row["apellidoDenominacion"]).'"></td>
                                        <td><input type="text" class="form-control" name="nombres[]" id="nombres[]" placeholder="Nombres" required="required" value = "'.utf8_decode($row["nombre"]).'"></td>
                                        <td><input type="text" class="form-control" name="tipo[]" id="tipo[]" placeholder="Tipo" required="required" value = "'.utf8_decode($row["tipoDocumento"]).'"></td>
                                        <td><input type="number" class="form-control" name="documento[]" id="documento[]" placeholder="Numero" required="required" value = '.$row["numeroDocumento"].'></td>
                                        <td class="text-center"><button type="button" class="btn btn-danger" id="borrarFisica" name="borrarFisica">Eliminar</button></td></tr>';
                                ++$primero;
                            } else {
                                $html .= '<tr><td><input type="text" class="form-control" name="operador[]" id="operador[]" placeholder="SI/NO" required="required" value = "'.utf8_decode($row["operador"]).'"></td>
                                        <td><input type="text" class="form-control" name="identificacion[]" id="identificacion[]" placeholder="Identificacion" required="required" value = "'.utf8_decode($row["identificacion"]).'"></td>
                                        <td><input type="number" class="form-control" id="cuit[]" name="cuit[]" placeholder="CUIT" required="required" value = '.$row["cuit"].'></td>
                                        <td><input type="text" class="form-control" name="apellidos[]" id="apellidos[]" placeholder="Apellidos" required="required" value = "'.utf8_decode($row["apellidoDenominacion"]).'"></td>
                                        <td><input type="text" class="form-control" name="nombres[]" id="nombres[]" placeholder="Nombres" required="required" value = "'.utf8_decode($row["nombre"]).'"></td>
                                        <td><input type="text" class="form-control" name="tipo[]" id="tipo[]" placeholder="Tipo" required="required" value = "'.utf8_decode($row["tipoDocumento"]).'"></td>
                                        <td><input type="number" class="form-control" name="documento[]" id="documento[]" placeholder="Numero" required="required" value = '.$row["numeroDocumento"].'></td>
                                        <td class="text-center"><button type="button" class="btn btn-danger" id="borrarFisica" name="borrarFisica">Eliminar</button></td></tr>';
                                ++$primero;
                            }
                        } while ($row = sqlsrv_fetch_array($usuarios));
                        }
                    } else {
                        if ($primero == 0) {
                            $html .= '<tr><td><input type="text" class="form-control" name="operador[]" id="operador[]" placeholder="SI/NO" required="required"></td>
                                        <td><input type="text" class="form-control" name="identificacion[]" id="identificacion[]" placeholder="Identificacion" required="required"></td>
                                        <td><input type="number" class="form-control" id="cuit[]" name="cuit[]" placeholder="CUIT" required="required"></td>
                                        <td><input type="text" class="form-control" name="apellidos[]" id="apellidos[]" placeholder="Apellidos" required="required"></td>
                                        <td><input type="text" class="form-control" name="nombres[]" id="nombres[]" placeholder="Nombres" required="required"></td>
                                        <td><input type="text" class="form-control" name="tipo[]" id="tipo[]" placeholder="Tipo" required="required"></td>
                                        <td><input type="number" class="form-control" name="documento[]" id="documento[]" placeholder="Numero" required="required"></td>
                                        <td class="text-center"><button type="button" class="btn btn-danger" id="borrarFisica" name="borrarFisica">Eliminar</button></td></tr>';
                        }
                    }
                    return $html;
                }              
                
                ?>
            <form action="procesarModificarRTEOC.php" id='formModificarGtia' name='formModificarGtia' method="post" enctype="multipart/form-data">
                    <div id="centro" class="container">
                        <div class="col-lg-12">
                            <div class="row">
                                <div id="contenido1" class="col-lg-12 contenido1">
                                    <div class="center">
                                        <h3 class="text-center">Reporte De Transferencias Internacionales: </h3>
                                    </div>
                                    <br>
                                    <div class="form-row align-items-center mx-auto">
                                        <div class="col-auto">
                                            <h5><u>DATOS GENERALES</u></h5>
                                            <br>
                                            <table>
                                                <tr>
                                                    <input type="hidden" id="idTransaccion" name="idTransaccion" value="<?= $idTransaccion ?>">
                                                    <td><label for="fecha">Fecha de la transaccion:</label></td>
                                                    <td><input size=60 type="text" class="form-control mb-3" id="fecha" name="fecha" placeholder="Fecha y Hora (AAAA-MM-DDT00:00:00)" required="true" value="<?= $fecha ?>"></td>                        
                                                </tr>
                                                <tr>
                                                    <td><label for="provincia">Provincia:</label></td>
                                                    <td><input type="text" class="form-control mb-3" id="provincia" name="provincia" placeholder="Provincia" required="true" value="<?= $provincia ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="localidad">Localidad:</label></td>
                                                    <td><input type="text" class="form-control mb-3" id="localidad" name="localidad" placeholder="Localidad" required="true" value="<?= $localidad ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="calle">Calle:</label></td>
                                                    <td><input type="text" class="form-control mb-3" id="calle" name="calle" placeholder="Calle" required="true" value="<?= $calle ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="numero">Numero:</label></td>
                                                    <td><input type="number" class="form-control mb-3" id="numero" name="numero" placeholder="Numero" required="true" value="<?= $numero ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="operacion">Operacion que origina la transaccion:</label></td>
                                                    <td><input type="text" class="form-control mb-3" id="operacion" name="operacion" placeholder="Operacion que origina la transaccion en efectivo" required="true" value="<?= $operacion ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="transaccion">Transaccion a reportar:</label></td>
                                                    <td><select id="transaccion" name="transaccion" class="form-control mb-2">
                                                            <?php
                                                            if ($transaccion == "Entidad Entrega Efectivo") {
                                                                echo "<option name='Entidad Entrega Efectivo' id='Entidad Entrega Efectivo'>Entidad Entrega Efectivo</option>
                                                        <option name='Entidad Recibe Efectivo' id='Entidad Recibe Efectivo'>Entidad Recibe Efectivo</option>";
                                                            } else {
                                                                echo "<option name='Entidad Recibe Efectivo' id='Entidad Recibe Efectivo'>Entidad Recibe Efectivo</option>
                                                            <option name='Entidad Entrega Efectivo' id='Entidad Entrega Efectivo'>Entidad Entrega Efectivo</option>";
                                                            }
                                                            ?>
                                                        </select></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="moneda">Tipo de moneda:</label></td>
                                                    <td><input type="text" class="form-control mb-3" id="moneda" name="moneda" placeholder="Tipo de moneda" required="true" value="<?= $moneda ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="monto">Monto:</label></td>
                                                    <td><input type="number" class="form-control mb-3" id="monto" name="monto" placeholder="Monto en moneda extranjera" required="true" value="<?= $monto ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="equivalente">Equivalente en pesos argentinos:</label></td>
                                                    <td><input type="number" class="form-control mb-3" id="equivalente" name="equivalente" placeholder="Equivalente en moneda local" required="true" value="<?= $equivalente ?>"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>



                    <hr /><hr />
                    <!-- TABLA JURIDICAS -->


                    <div class="form-group">
                        <label>
                            <button type="button" class='btn btn-bsc mt-4' id="juridica">Nueva Persona Juridica</button>
                        </label>
                        <table class='table table-bordered table-striped' id="tablaJuridicas">
                            <tr>
                                <th>El operador es el cliente:</th>
                                <th>Identificacion de intervinientes:</th>
                                <th>CUIT - CUIL:</th>
                                <th>Denominacion:</th>
                                <th>Eliminar:</th>
                            </tr>
                            <tr>
                                <?php
                                echo $output = personasJuridicas()
                                ?>
                            </tr>
                        </table>                 
                    </div>


                    <hr /><hr />
                <!-- TABLA FISICAS -->
                
                
                <div class="form-group">
                    <label>
                        <button type="button" class='btn btn-bsc mt-4' id="fisica">Nueva Persona Fisica</button>
                    </label>
                    <table class='table table-bordered table-striped' id="tablaFisicas">
                        <tr>
                            <th>El operador es el cliente:</th>
                            <th>Identificacion de intervinientes:</th>
                            <th>CUIT - CUIL:</th>
                            <th>Apellidos:</th>
                            <th>Nombres:</th>
                            <th>Tipo de Documento:</th>
                            <th>Numero de Documento:</th>
                            <th>Eliminar:</th>
                        </tr>
                        <tr>    
                            <?php
                                echo $output = personasFisicas()
                                ?>
                        </tr>
                    </table>                 
                </div>

                    <br>
                    <!--Panel de Botones -->

                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <input type="submit" class="btn btn-bsc" id="btnGuardar" name="btnGuardar" value="Guardar">
                                <a href="formBuscarRTEOC.php"><input type="button" class="btn btn-outline-secondary" value="Cancelar"></a>
                            </div>
                        </div>
                    </div><br>
                </form>
            <?php } // ELSE          ?>
        </div>
    </div>
    <div id="contenido2"></div>
    
</div>
</body>
</html>
