<?php include_once '../../Principal/Vista/Header.php'; ?>
<div id="content-wrapper">
    <div id="contenedor" class="container mt-4">
        <div class="card">
            <div class="card-header text-white bg-dark">ACCESOS DE USUARIOS</div>
            <div class="card-body">
                <form name="formBuscarAccesoUsuario" id="formBuscarAccesoUsuario" method="POST">
                    <input type="hidden" name="peticion" id="peticion">
                    <div class="form-row">
                        <label class="col-sm-2 col-form-label">Legajo: </label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="legajo" id="legajo" maxlength="10"
                                   placeholder="Número de legajo">
                        </div>
                        <label class="col-sm-2 col-form-label">Nombre: </label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre" maxlength="40"
                                   placeholder="Nombre de usuario">
                        </div>
                    </div>
                    <div class="form-row">
                        <label class="col-sm-2 col-form-label">Pefil: </label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="perfil" id="perfil" maxlength="40"
                                   placeholder="Nombre del perfil">
                        </div>
                        <label class="col-sm-2 col-form-label">Aplicación: </label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="aplicativo" id="aplicativo" maxlength="40"
                                   placeholder="Nombre de la aplicación">
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col text-center">
                            <button type="button" name="btnCrear" id="btnCrear" class="btn btn-outline-secondary">
                                <i class="fas fa-plus"></i> CREAR
                            </button>
                            <button type="submit" class="btn btn-dark" name="btnBuscarAcceso" id="btnBuscarAcceso">
                                <i class="fas fa-search"></i> BUSCAR
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
                        <div id="loader-icon" style=" "><img src="../../../lib/img/loading.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalBorrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">CONFIRME LA OPERACIÓN</h4>
                    </div>
                    <div class="modal-body" id="cuerpoModalBorrar">
                        <form id="formBorrar" name="formBorrar" method="POST">
                            <input type="hidden" name="idAcceso" id="idAcceso">
                            <input type="hidden" name="datosUsuario" id="datosUsuario">
                            <div class="form-row">
                                <b><p id="datosAcceso" name="datosAcceso"></p></b>
                                <p>&nbsp;Presione <b>GUARDAR</b> para efectuar la operación.</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" 
                                name="btnEliminacion" id="btnEliminacion"
                                data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-dark"
                                name="btnBorrar" id="btnBorrar">
                            <i class="far fa-save"></i> GUARDAR</button>
                        <input type='submit' class='btn btn-outline-secondary' 
                               style="display: none;"
                               name="btnRefrescarPantalla" id="btnRefrescarPantalla" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="../Js/Buscar.js"></script>
    </div> <!-- FIN DEL CONTENEDOR SUPERIOR -->
    <div id="inferior" class="container mb-4 mt-4"></div>
</div>


