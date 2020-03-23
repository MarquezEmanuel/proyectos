<?php

include_once './Header.php';
require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();

$consulta = "SELECT * FROM vw_panel";
$resultado = SQLServer::instancia()->seleccionar($consulta, array());

?>

<html>

<head>
    <link href="../css/Tabs.css" rel="stylesheet" id="bootstrap-css">


    <script type="text/javascript" src="../Js/Tab.js"></script>
    <script type="text/javascript" src="../Js/backlog.js"></script>

</head>

<body>
    <div class="container">
        <div>
            <div class="row justify-content-center " style="margin-top:1%;">
                <div class="col-lg-12  col-center ">
                    <div class="card ">
                        <div class="card-body">
                            <form name="importa" id="importa" method="post" enctype="multipart/form-data">
                                <input class="form-control form-control-lg" type="text" placeholder=".form-control-lg">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="tabs" class="project-tab">
        <div class="container" style="margin-top:1%;">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs md-tabs " id="myTabMD" role="tablist">

                        <?php
                        if (gettype($resultado)) {
                            while ($panel = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                if ($panel['estado'] == "ESPERANDO APROBACION") {
                                    $activado = "active";
                                } else {
                                    $activado = "";
                                }
                                echo "
                                <li class=' item item1 nav-item' id='" . utf8_encode($panel['estado']) . "' value='1'>
                                <a class='nav-link " . $activado . "' id='home-tab-md' value='1' data-toggle='tab' href='#home-md' role='tab' aria-controls='home-md' aria-selected='true'>
                                    <div id='cantSolicitudes' class='alert alert-" . utf8_encode($panel['color']) . " ' role='alert'>
                                        <font id='fuente'><b>" . utf8_encode($panel['cantidad']) . "</b></font>
                                    </div>
                                    <font class='font'>" . utf8_encode($panel['estado']) . "</font>
                                </a>
                            </li>";
                            }
                        } ?>
                    </ul>
                    <div class="tab-content card pt-5" id="myTabContentMD">
                        <div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">

                            <div class="container" style="margin-top:-3%;">
                                <fieldset class=" section-content-bar ">
                                    <div class="panel panel-default">
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="card-body" style="margin-top:3%; margin-bottom:10px">
                                <div class="card-body">
                                    <div id="SolicitudesEnEspera">
                                        <div class="container" id="cargando" align="center">
                                            <div id="loader-icon"><img src="../../../lib/img/loading.png" alt=""></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
                        </div>
                        <div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container" style="margin-top:1%;">
        <div class="card" id="backlog">
        <div class="card-header text-white bg-dark">BackLog</div>
            <div id="cuerpo" class="card-body">
        <div id="donutchart" style="width: 900px; height: 500px;"></div>
        </div>
        </div>
    </div>

</body>

</html>