<div id="resultado" class="mb-4 mt-4"></div>
<div class="card">
    <div class="card-header bg-dark text-white">CREAR SERVICIO</div>
    <div class="card-body">
        <form name="formCrearServicio" id="formCrearServicio" method="POST">
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Nombre: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           placeholder="Nombre del servicio" required>
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
