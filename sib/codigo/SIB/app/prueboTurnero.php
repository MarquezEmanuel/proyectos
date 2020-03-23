<?php

include_once 'conf/Constants.php';
include_once 'conf/Log.php';
include_once 'conf/BDConexion.php';


function turnero() {
    $querySolicitudes = "SELECT count(*) cantidad FROM [VM000DB00].[STE].[dbo].[vw_H_INS_TaskInterval] WHERE PartitionId = 20190726";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitudes);
    $html = "";
    if ($result) {
        $cantidad = 0;
        $html = '<tr><th><a href="turnero.php" class="text-dark"><font size=4>Solicitudes de workflow</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $fila["cantidad"];
            $html = '<tr><th><a href="turnero.php" class="text-danger"><font size=6>Solicitudes de workflow</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de solicitudes workflow][QUERY: $querySolicitudes]");
    }
    return $html;
}


?>

<html id="html">
    <head>
        <meta charset="UTF-8">
        <title> SIB </title>
        <link rel="stylesheet" href="../lib/css/bootstrap-toggle.min.css"/>
        <link rel="stylesheet" href="../lib/css/estilos.css"/>
        <link rel="stylesheet" href="../lib/css/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" href="../lib/css/datatables/jquery.dataTables.css">
        <link rel="stylesheet" href="../lib/css/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../lib/css/buttons.dataTables.min.css">
        <script type="text/javascript" src="../lib/JQuery/jquery-3.3.1.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/bootstrap-toggle.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/buttons.flash.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/buttons.html5.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/buttons.print.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/loader.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/JQuery/jquery.tablesorter.min.js"></script>
    </head>
    <body style="background-color:lavender;">
    <navbar id="menu-horizontal" class="navbar navbar-expand-lg navbar-dark" style="background-color: #024d85;">
        <div class="container">
            <span><a href="gsuc/reportesTablas.php"><img src="../lib/img/cabezera.png" class="img-thumbnail" alt="Responsive image" width="70" height="70"></a></span>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        &nbsp;&nbsp;<h3 class="text-white">Gestion de reportes</h3>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    </ul>
                </div>
            </div>
        </div>
    </navbar>
    <div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <br>
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido1" class="col-lg-12 contenido1">
                        <div class="form-row align-items-center mx-auto">
                            <table class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style="width: 85%"/>
                                    <col style="width: 15%"/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Nombre de Reporte</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo turnero();
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
</html>

