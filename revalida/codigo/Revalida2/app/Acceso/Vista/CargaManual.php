<div id="resultado" class="mb-4 mt-4"></div>
<div class="card">
    <div class="card-header bg-dark text-white">CARGA MANUAL DE ACCESOS</div>
    <div class="card-body">
        <form method="post" id="formCargaManual" name="formCargaManual" enctype="multipart/form-data">
            <input type="hidden" name="nombreAplicacion" id="nombreAplicacion">
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Sistema: </label>
                <div class="col">
                    <select class="form-control mb-2" name="idAplicacion" id="idAplicacion" required></select>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <div class="card-deck mt-4 mb-4">
                        <div class="card">
                            <div class="card-header">CARGA INDIVIDUAL</div>
                            <div class="card-body">
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Legajo: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" 
                                               name="legajo" id="legajo"
                                               maxlength="10" disabled
                                               placeholder="Legajo de usuario" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Nombre: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" 
                                               name="nombre" id="nombre"
                                               maxlength="50" disabled
                                               placeholder="Nombre de usuario" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Perfil: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" 
                                               name="perfil" id="perfil"
                                               maxlength="50" disabled
                                               placeholder="Perfil asignado">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Estado: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" 
                                               name="estado" id="estado"
                                               maxlength="20" disabled
                                               placeholder="Estado en la aplicación">
                                    </div>
                                </div>
                                <div class="form-row mt-4">
                                    <div class="col text-center">
                                        <button type="button" class="btn btn-dark" id="btnCargaIndividual" name="btnCargaIndividual" disabled>
                                            <i class="far fa-save"></i> GUARDAR
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">CARGA MEDIANTE ARCHIVO</div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col">
                                        <p class="text-justify">NOTA: <em>Recuerde que el archivo seleccionado debe respetar
                                                la extensión XLS para ser válido. Ademas, según el sistema 
                                                a cargar, se debe respetar el orden, formato y cantidad de
                                                columnas.</em></p>
                                    </div>
                                </div>
                                <div class="form-row mt-2">
                                    <label class="col-sm-2 col-form-label">Archivo: </label>
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" 
                                                       id="archivo" name="archivo"
                                                       aria-describedby="inputGroupFileAddon01"
                                                       disabled required>
                                                <label class="custom-file-label" for="archivo">XLS</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mt-4">
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-dark" id="btnCargaArchivo" name="btnCargaArchivo" disabled>
                                            <i class="fas fa-file-upload"></i> PROCESAR
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-4">
                <div class="col text-center">
                    <button type="button" class="btn btn-outline-secondary" id="btnVolver" name="bntVolver">
                        <i class="fas fa-arrow-left"></i> VOLVER
                    </button>
                </div>
            </div>
        </form>
    </div>
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
<script type="text/javascript" src="../Js/CargaManual.js"></script>