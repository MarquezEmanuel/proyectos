<?php include_once '../../Principal/Vista/Header.php'; ?>
<div id="content-wrapper">
    <div id="superior" class="container mt-4">

        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="acceso-tab" 
                   data-toggle="tab" href="#acceso" role="tab" 
                   aria-controls="acceso" aria-selected="true">
                    <div class="row">
                        <div class="col text-center mb-2"><i class="fas fa-key fa-2x"></i></div>
                    </div>
                    <div class="row">
                        <div class="col text-center">ACCESOS</div>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="aplicativo-tab" 
                   data-toggle="tab" href="#aplicativo" role="tab" 
                   aria-controls="aplicativo" aria-selected="false">
                    <div class="col text-center mb-2"><i class="fas fa-laptop-code fa-2x"></i></div>
                    <div class="row">
                        <div class="col text-center">APLICACIONES</div>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="formulario-tab" 
                   data-toggle="tab" href="#formulario" role="tab" 
                   aria-controls="formulario" aria-selected="false">
                    <div class="row">
                        <div class="col text-center mb-2"><i class="fas fa-file-pdf fa-2x"></i></div>
                    </div>
                    <div class="row">
                        <div class="col text-center">FORMULARIOS</div>
                    </div></a>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="usuario-tab" 
                   data-toggle="tab" href="#usuario" role="tab" 
                   aria-controls="usuario" aria-selected="false">
                    <div class="row">
                        <div class="col text-center mb-2"><i class="fas fa-user fa-2x"></i></div>
                    </div>
                    <div class="row">
                        <div class="col text-center">USUARIOS</div>
                    </div>
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="acceso" role="tabpanel" aria-labelledby="acceso-tab">

                <div class="bg-white">
                    <br>
                    <div class="container">
                        <div class="form-row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-1"><i class="fas fa-chart-pie fa-lg"></i></div>
                                            <div class="col">GENERAR POR APLICACIÓN</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-1"><i class="fas fa-chart-pie fa-lg"></i></div>
                                            <div class="col">GENERAR POR PERFIL</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card ">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-1"><i class="fas fa-chart-pie fa-lg"></i></div>
                                            <div class="col">GENERAR POR USUARIO</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>

            </div>
            <div class="tab-pane fade" id="aplicativo" role="tabpanel" aria-labelledby="aplicativo-tab">
                <div class="card mt-4">
                    <div class="card-header bg-dark text-white">APLICACIONES</div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="formulario" role="tabpanel" aria-labelledby="formulario-tab">
                ...gg
            </div>
            <div class="tab-pane fade" id="usuario" role="tabpanel" aria-labelledby="usuario-tab">
                ...gg
            </div>
        </div>

    </div>
</div>
