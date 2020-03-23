<?php
/* PROCESA BUSCAR PERMISOS */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();


$controlador = new ControladorReporte();
$categorias = $controlador->listarCategorias();
if (gettype($categorias) == "resource") {
    $items = '';
    $contadorCategoria = 0;
    while ($categoria = sqlsrv_fetch_array($categorias, SQLSRV_FETCH_ASSOC)) {
        $modulo = $categoria['modulo'];
        $icono = $categoria['icono'];
        $active = ($contadorCategoria == 0) ? "active" : "";
        $items .= '
            <li class="nav-item">
                <a class="nav-link ' . $active . '" id="' . $modulo . '-tab" 
                   data-toggle="tab" href="#' . $modulo . '" role="tab" 
                   aria-controls="' . $modulo . '" aria-selected="true">
                    <div class="row">
                        <div class="col text-center mb-2">' . $icono . '</div>
                    </div>
                    <div class="row">
                        <div class="col text-center">' . $modulo . '</div>
                    </div>
                </a>
            </li>';
        $arreglo[] = $modulo;
        $contadorCategoria++;
    }

    $panes = '';
    $contadorReporte = 0;
    foreach ($arreglo as $categoria) {
        $reportes = $controlador->listarReportes($categoria);
        if (gettype($reportes) == "resource") {
            $active = ($contadorReporte == 0) ? "active" : "";
            $cards = '';
            while ($reporte = sqlsrv_fetch_array($reportes, SQLSRV_FETCH_ASSOC)) {
                $nombre = $reporte['reporte'];
                $cards .= '
                    <div class="col">
                        <div class="card" id="' . $categoria . '" name="' . utf8_encode($nombre) . '">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-1"><i class="fas fa-chart-pie fa-lg"></i></div>
                                    <div class="col">' . utf8_encode($nombre) . '</div>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            $panes .= '
                <div class="tab-pane fade show ' . $active . '" id="' . $categoria . '" role="tabpanel" aria-labelledby="' . $categoria . '-tab">
                    <div class="bg-white">
                        <br><div class="container">
                            <div class="form-row">' . $cards . '</div>
                        </div>
                        <div class="container mb-4 mt-4 resultado" id="resultado' . $categoria . '"></div><br>
                    </div>
                </div>';
            $contadorReporte++;
        }
    }

    $tab = '<ul class="nav nav-tabs nav-fill" id="tab" role="tablist">' . $items . '</ul>
            <div class="tab-content" id="myTabContent">' . $panes . '</div>';

    $formulario = $tab;
} else {
    $formulario = "falala";
}
include_once '../../Principal/Vista/Header.php';
?>
<div id="content-wrapper">
    <div id="superior" class="container mt-4">
        <?= $formulario; ?>
    </div>
    <div class="modal fade" id="ModalCargando" tabindex="-1" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-sm" style="width: 240px">
            <div class="modal-content" style=" background-color: transparent; border: transparent; ">
                <div class="modal-body">
                    <div id="loader-icon"><img src="../../../lib/img/loading.png" alt=""></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../Js/Gestor.js"></script>
</div>
