<?php include_once '../../Principal/Vista/Header.php'; ?>
<div id="content-wrapper">
    <div id="superior" class="container mt-4">
        <div id="cuerpe" class="card">
            <div class="card-header text-white bg-dark">BUSCAR APLICACIÓN</div>
            <div id="cuerpo" class="card-body">
                <form name="formBuscarAplicacion" id="formBuscarAplicacion" method="POST">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="form-row">
                        <label class="col-sm-2 col-form-label">Nombre: </label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre" maxlength="10"
                                   placeholder="Nombre de la aplicación">
                        </div>
                        <label class="col-sm-2 col-form-label">Gerencia: </label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  
                                   name="gerencia" id="gerencia" maxlength="40"
                                   placeholder="Nombre de la gerencia">
                        </div>
                    </div>
                    <div class="form-row">
                        <label class="col-sm-2 col-form-label">Delegado: </label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   name="delegado" id="delegado" maxlength="40"
                                   placeholder="Nombre del delegado de gerencia">
                        </div>
                        <label class="col-sm-2 col-form-label">Subdelegado: </label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="subdelegado" id="subdelegado" maxlength="40"
                                   placeholder="Nombre del subdelegado de gerencia">
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col text-center">
                            <button type="button" name="btnCrear" id="btnCrear" class="btn btn-outline-secondary">
                                <i class="fas fa-plus"></i> CREAR
                            </button>
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-search"></i> BUSCAR
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="inferior" class="container mt-4 mb-4"></div>
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
<script type="text/javascript" src="../Js/Buscar.js"></script>
