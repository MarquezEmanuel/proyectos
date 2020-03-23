<div class="modal fade" id="mdCargarEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">ALTA DE ESTADO</h4>
            </div>
            <div class="modal-body">
                <form id="formCargarEstado" name="formCargarEstado" method="POST">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nombre:</label> 
                        <div class="col">
                            <input type="text" class="form-control mb-2" id="nombreEstado" name="nombreEstado" maxlength="50" placeholder="Nombre de estado" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Descripción: </label> 
                        <div class="col">
                            <textarea class="form-control mb-2" id="descripcion" name="descripcion" placeholder="Descripción del estado" maxlength="100" required></textarea>
                            
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type='submit' class='btn btn-success' id='btnCargarEstado' value='Guardar'>
                <input type='submit' class='btn btn-outline-secondary' id='btnCancelarCarga' value='Cancelar'>
            </div>
        </div>
    </div>
</div>
 