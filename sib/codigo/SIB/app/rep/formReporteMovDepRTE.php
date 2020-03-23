<?php
/* INICIALIZA LA SESION */
session_start();

require_once './menuReportes.php';

/* OBTIENE LA FECHA ACTUAL PARA CARGAR EL FORMULARIO */

date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y-m-d");

$fechaInicio = (isset($_SESSION['fechaInicioRTE'])) ? $_SESSION['fechaInicioRTE'] : "";
?>

<div class="card-header" id="FormInformeRTE">
    <div id="contenido">
        <h4 class="text-center p-4">INFORME RTE - MOVIMIENTOS SIN DEPOSITANTES</h4>
        <div class="container">
            <form method="POST" name="formInformeRTE" id="formInformeRTE">
                <div class="form-group row">
                    <div class="col">
                        <label class="mr-sm-2" title="Campo no obligatorio">Tipo de transacción:</label> 
                        <select class="form-control" name="tipo" id="tipo" title="Tipo de transacción para la consulta">
                            <option value="NO">No aplicar filtro</option>
                            <option value="Depósito">Depósito</option>
                            <option value="Extracción">Extracción</option>
                        </select>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2" title="Campo obligatorio">* Fecha de inicio:</label> 
                        <input type="date" class="form-control"
                               id="fechaInicio" name="fechaInicio" min="2019-04-01" max="<?= $actual ?>" value="<?= $fechaInicio ?>"
                               title="Fecha de inicio para la consulta" required>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2" title="Campo obligatorio">* Fecha de fin:</label> 
                        <input type="date" class="form-control"
                               id="fechaFin" value="<?= $actual ?>"
                               name="fechaFin" min="2019-04-02" max="<?= $actual ?>"
                               title="Fecha de fin para la consulta" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-success" 
                                   id="btnConsultarRTE" name="btnConsultarRTE" value="Consultar">
                            <a href="formReporteMovDepRTE.php"><input type="button" class="btn btn-outline-secondary" value="Cancelar"></a>
                            <a href="inicioRTE.php"><input type="button" class="btn btn-outline-secondary" value="Volver"></a>
                        </div>
                    </div>
                </div> 
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2"></div>
    <script>
        $(document).ready(function () {
            enviarPeticion();
            
            $("#formInformeRTE").submit(function (e) {
                e.preventDefault();
                enviarPeticion();
            });

            function enviarPeticion() {
                $.ajax({
                    type: "POST",
                    url: "procesarReporteMovDepRTE.php",
                    data: $("#formInformeRTE").serialize(),
                    success: function (data) {
                        $("#contenido2").html(data);
                        $("#tablaRepMovRTE").DataTable({
                            dom: 'Bfrtip',
                            paging: false,
                            responsive: true,
                            scrollX: true,
                            buttons: [{
                                    extend: 'excelHtml5',
                                    title: 'RTE - Movimientos sin depositantes'
                                }, {
                                    extend: 'pdfHtml5',
                                    title: 'RTE - Movimientos sin depositantes',
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL',
                                    text: 'PDF',
                                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]}
                                }
                            ],
                            language: {url: "../../lib/js/Spanish.json"
                            }
                        });
                    },
                    error: function () {
                        $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                    }
                });
            }

        });
    </script>
</div>