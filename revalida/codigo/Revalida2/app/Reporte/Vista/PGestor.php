<?php

/* PROCESA BUSCAR PERMISOS */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

if ($_POST['modulo'] && $_POST['reporte']) {
    $modulo = $_POST['modulo'];
    $reporte = $_POST['reporte'];
    $tope = 1000;
    $controlador = new ControladorReporte();
    $resultado = $controlador->obtenerReporte($modulo, $reporte, $tope);

    if (gettype($resultado) == "resource") {
        $filas = "";
        while ($dato = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($dato['nombre']);
            $cantidad = $dato['cantidad'];
            $filas .= "
                <tr>
                    <td>{$nombre}</td>
                    <td>{$cantidad}</td>
                </tr>";
        }
        $formulario = '
            <div class="card">
                <div class="card-header bg-dark text-white">RESULTADO DEL REPORTE: ' . $modulo . ' / ' . $reporte . '</div>
                <div class="card-body">
                    <div class="form-row mb-2">
                        <div class="col">
                            <div class="card">
                                <div class="card-header"> Gráficos </div>
                                <div class="card-body">
                                    <div class="row" style="margin:0 !important;">
                                        <div class="col-md-6">
                                          <div id="graficoTorta" style="width: 100%; min-height: 450px;"></div>
                                        </div>
                                        <div class="col-md-6">
                                          <div id="graficoBarras" style="width: 100%; min-height: 450px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <div class="col">
                            <div class="card">
                                <div class="card-header"> 
                                    <div class="row">
                                        <div class="col">Información detallada</div>
                                        <div class="col text-right"><i class="far fa-eye fa-lg" id="eyeInformacionDetallada"></i></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive" id="informacionDetallada" style="display: none;">
                                        <table id="tbReportes" cellspacing="0" 
                                               class="table table-bordered table-hover"
                                               style="width:100%; background-color:white; border-radius: 0.5em;">
                                            <thead>
                                                <tr>
                                                    <th>Dato</th>
                                                    <th title="Total de registros asociados">Cantidad total</th>
                                                </tr>
                                            </thead>
                                            <tbody>' . $filas . '</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
    } else {
        $mensaje = $controlador->getMensaje();
        $formulario = HTML::getAlerta($resultado, $mensaje);
    }
} else {
    $mensaje = "No se obtuvieron los datos desde el formulario";
    $formulario = HTML::getAlerta(0, $mensaje);
}

echo $formulario;

