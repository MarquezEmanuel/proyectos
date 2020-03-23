
<div id="resultado" class="mb-4 mt-4"></div>
<div class="card">
    <div class="card-header bg-dark text-white">NUEVO USUARIO</div>
    <div class="card-body">
        <form name="formCrearUsuario" id="formCrearUsuario" method="POST">
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Nombre: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           placeholder="Nombre del usuario" required>
                </div>
                <label class="col-sm-2 col-form-label">Apellido: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="apellido" id="apellido" maxlength="50"
                           placeholder="Apellido del usuario" required>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Legajo: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="legajo" id="legajo" maxlength="10"
                           placeholder="Legajo del usuario" required>
                </div>
                <label class="col-sm-2 col-form-label">Cargo: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="cargo" id="cargo" maxlength="50"
                           placeholder="Cargo" required>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Gerencia: </label>
                <div class="col">
                    <select class="form-control mb-2" name="gerencia" id="gerencia"></select>
                </div>
                <label class="col-sm-2 col-form-label">Rol: </label>
                <div class="col">
                    <select class="form-control mb-2" name="rol" id="rol"></select>
                </div>
            </div>
            <div class="form-row mt-4">
                <div class="col text-center">
                    <button type="button" class="btn btn-outline-secondary" id="btnVolver" name="bntVolver">
                        <i class="fas fa-arrow-left"></i> VOLVER
                    </button>
                    <button type="submit" class="btn btn-dark">
                        <i class="far fa-save"></i> GUARDAR
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../Js/Crear.js"></script>