<?php
/* INICIALIZA LA SESION */
session_start();

require_once './menuReportes.php';
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
        <form action="procesarCrearRTEOC.php" method="post" enctype="multipart/form-data">
            <div class="card-header">
                <div id="centro" class="container">
                    <div class="col-lg-12">
                        <div class="row">
                            <div id="contenido1" class="col-lg-12 contenido1">
                                <div class="center">
                                    <h4 class="text-center">CREAR RTE - OPERACIÓN DE CAMBIO </h4>
                                </div>
                                <br>
                                <div class="form-row align-items-center mx-auto">
                                    <div class="col-auto">
                                        <h5><u>DATOS GENERALES</u></h5>
                                        <br>
                                        <table>
                                            <tr>
                                                <td><label for="fecha">Fecha de la transaccion:</label></td>
                                                <td><input size=60 type="text" class="form-control mb-3" id="fecha" name="fecha" placeholder="Fecha y Hora (AAAA-MM-DDT00:00:00)" required="true"></td>                        
                                            </tr>
                                            <tr>
                                                <td><label for="provincia">Provincia:</label></td>
                                                <td><input type="text" class="form-control mb-3" id="provincia" name="provincia" placeholder="Provincia" required="true"></td>
                                            </tr>
                                            <tr>
                                                <td><label for="localidad">Localidad:</label></td>
                                                <td><input type="text" class="form-control mb-3" id="localidad" name="localidad" placeholder="Localidad" required="true"></td>
                                            </tr>
                                            <tr>
                                                <td><label for="calle">Calle:</label></td>
                                                <td><input type="text" class="form-control mb-3" id="calle" name="calle" placeholder="Calle" required="true"></td>
                                            </tr>
                                            <tr>
                                                <td><label for="numero">Numero:</label></td>
                                                <td><input type="number" class="form-control mb-3" id="numero" name="numero" placeholder="Numero" required="true"></td>
                                            </tr>
                                            <tr>
                                                <td><label for="operacion">Operacion que origina la transaccion:</label></td>
                                                <td><input type="text" class="form-control mb-3" id="operacion" name="operacion" placeholder="Operacion que origina la transaccion en efectivo" required="true"></td>
                                            </tr>
                                            <tr>
                                                <td><label for="transaccion">Transaccion a reportar:</label></td>
                                                <td><select id="transaccion" name="transaccion" class="form-control mb-2">
                                                        <option name="Entidad Entrega Efectivo" id="Entidad Entrega Efectivo">Entidad Entrega Efectivo</option>
                                                        <option name="Entidad Recibe Efectivo" id="Entidad Recibe Efectivo">Entidad Recibe Efectivo</option>
                                                    </select></td>
                                            </tr>
                                            <tr>
                                                <td><label for="moneda">Tipo de moneda:</label></td>
                                                <td><input type="text" class="form-control mb-3" id="moneda" name="moneda" placeholder="Tipo de moneda" required="true"></td>
                                            </tr>
                                            <tr>
                                                <td><label for="monto">Monto:</label></td>
                                                <td><input type="number" class="form-control mb-3" id="monto" name="monto" placeholder="Monto en moneda extranjera" required="true"></td>
                                            </tr>
                                            <tr>
                                                <td><label for="equivalente">Equivalente en pesos argentinos:</label></td>
                                                <td><input type="number" class="form-control mb-3" id="equivalente" name="equivalente" placeholder="Equivalente en moneda local" required="true"></td>
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
                        </tr>
                    </table>                 
                </div>
                
                
                <!--Panel de Botones -->
                <hr /><hr />

                
                <div class="container">
                    <div class="form-row align-items-center mx-auto">
                        <div class="col-lg-12 text-left">
                            <button id="btnGuardar" name="btnGuardar" type="submit" class="btn btn-bsc mt-4">Guardar</button>
                            <button type="reset" class="btn btn-bsc mt-4">Borrar Campos</button>
                            <a href="inicioRTEOC.php"><input type="button" class="btn btn-secondary mt-4" value="Salir"></a>
                        </div>
                    </div> 
                </div> 
            </div>
        </form>
    </div>
</body>
</html>
