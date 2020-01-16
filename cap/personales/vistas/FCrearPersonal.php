<?php require_once '../../principal/vistas/header.php'; ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div id="seccionSuperior" class="form-row mt-3 mb-3">
            <div class="col text-left">
                <h4><i class="fas fa-fire-alt"></i> CREAR PERSONAL</h4>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <form id="formCrearPersonal" name="formCrearPersonal" method="POST">
            <div class="card border-azul-clasico mt-3">
                <div class="card-header bg-azul-clasico text-white">Complete el formulario</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="sigla" class="col-sm-2 col-form-label">* Nombre corto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="sigla" id="sigla" maxlength="20"
                                   placeholder="Nombre corto" required>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">* Nombre largo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre" maxlength="50"
                                   placeholder="Nombre largo" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="departamento" class="col-sm-2 col-form-label">* Departamento:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="departamento" name="departamento"></select>
                        </div>
                        <label for="rti" class="col-sm-2 col-form-label">* RTI:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="rti" name="rti">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success"><i class="far fa-save"></i> GUARDAR</button>
                    <a href="FBuscarPersonal.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/CrearPersonal.js"></script>