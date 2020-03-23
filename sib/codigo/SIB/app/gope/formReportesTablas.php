<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';
require_once './ControladorReportesDiarios.php';
require_once './ControladorReportesLinea.php';
require_once './menuOperaciones.php';


$diarios = "";
$controlador = new ControladorReportesDiarios();
foreach ($controlador->getReportesDiarios() as $reporte) {
    if (!is_null($reporte[2])) {
        if ($reporte[2] > 0) {
            $diarios .= "<tr style='background-color:#cfcffa;'>
                            <td><a href='{$reporte[1]}' class='text-dark font-weight-bold'>{$reporte[0]}</a></td>
                            <td class='text-right font-weight-bold'>{$reporte[2]}</td>
                         <tr>";
        } else {
            $diarios .= "<tr style='background-color:#cfcffa;'>
                            <td>{$reporte[0]}</td>
                            <td class='text-right'>{$reporte[2]}</td>
                         <tr>";
        }
    } else {
        $diarios .= "<tr style='background-color:#cfcffa;'><td>{$reporte[0]}</td><td class='text-right'>--</td><tr>";
    }
}

$linea = "";
$controladorLinea = new ControladorReportesLinea();
foreach ($controladorLinea->getReportesLinea() as $reporte) {
    if (!is_null($reporte[2])) {
        if ($reporte[2] > 0) {
            $linea .= "<tr style='background-color:#cfcffa;'>
                            <td><a href='{$reporte[1]}' class='text-dark font-weight-bold'>{$reporte[0]}</a></td>
                            <td class='text-right font-weight-bold'>{$reporte[2]}</td>
                         <tr>";
        } else {
            $linea .= "<tr style='background-color:#cfcffa;'>
                            <td>{$reporte[0]}</td>
                            <td class='text-right'>{$reporte[2]}</td>
                         <tr>";
        }
    } else {
        $linea .= "<tr style='background-color:#cfcffa;'><td>{$reporte[0]}</td><td class='text-right'>--</td><tr>";
    }
}
?>

<div class="container mt-4">
    <section id="tabs" class="project-tab">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-diario-tab" data-toggle="tab" href="#nav-diario" role="tab" aria-controls="nav-home" aria-selected="true">REPORTES DIARIOS</a>
                            <a class="nav-item nav-link" id="nav-linea-tab" data-toggle="tab" href="#nav-linea" role="tab" aria-controls="nav-profile" aria-selected="false">REPORTES EN LINEA</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-diario" role="tabpanel" aria-labelledby="nav-diario-tab">
                            <table class="table table-hover"> 
                                <thead style='background-color:#024d85; color:white;'>
                                    <tr> 
                                        <th> Nombre de reporte</th>
                                        <th class="text-right"> Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody class="table-light">
                                    <?php echo $diarios; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-linea" role="tabpanel" aria-labelledby="nav-linea-tab">
                            <table class="table table-hover"> 
                                <thead style='background-color:#024d85; color:white;'>
                                    <tr> 
                                        <th> Nombre de reporte</th>
                                        <th class="text-right"> Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody class="table-light">
                                    <?php echo $linea; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>