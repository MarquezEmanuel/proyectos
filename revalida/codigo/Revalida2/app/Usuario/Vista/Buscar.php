<?php include_once '../../Principal/Vista/Header.php'; ?>
<div id="content-wrapper">
    <div id="superior" class="container mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white">BUSCAR USUARIO</div>
            <div class="card-body">
                <form name="formBuscarUsuario" id="formBuscarUsuario" method="POST">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="form-row">
                        <label class="col-sm-2 col-form-label">Legajo: </label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="legajo" id="legajo" maxlength="10"
                                   placeholder="Legajo de usuario">
                        </div>
                        <label class="col-sm-2 col-form-label">Nombre: </label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre" maxlength="40"
                                   placeholder="Nombre de usuario">
                        </div>
                    </div>
                    <div class="form-row">
                        <label class="col-sm-2 col-form-label">Cargo: </label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="cargo" id="cargo" maxlength="40"
                                   placeholder="Nombre del cargo">
                        </div>
                        <label class="col-sm-2 col-form-label">Gerencia: </label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="gerencia" id="gerencia" maxlength="40"
                                   placeholder="Nombre de la gerencia">
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
        <script type="text/javascript" src="../Js/Buscar.js"></script>
    </div>
    <div id="inferior" class="container mb-4 mt-4"></div>
     <div class="modal fade" id="ModalCargando" tabindex="-1" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-sm" style="width: 240px">
            <div class="modal-content" style=" background-color: transparent; border: transparent; ">
                <div class="modal-body">
                    <div id="loader-icon"><img src="../../../lib/img/loading.png" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</div>
