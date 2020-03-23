<?php



?>
<form action="all.php" method="post">
<div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Legajo:</label>
                        <div class="col">
                            <input type="text" id="legajo" name="legajo" class="form-control mb-2" value="" >
                        </div>  
						</div>
<div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Clave:</label>
                        <div class="col">
                            <input type="password" id="clave" name="clave" class="form-control mb-2" value="" >
                        </div>  
						</div>
<div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">ldap_base_dn:</label>
                        <div class="col">
                            <textarea type="input" class="form-control mb-2" id="base" name="base"></textarea>
                        </div>  
						</div>
<div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">search_filter:</label>
                        <div class="col">
                            <textarea type="input" class="form-control mb-2" id="filtro" name="filtro"></textarea>
                        </div>  
						</div>
						

<input type="submit" class="btn btn-dark" id="guardar" name="guardar" value="Guardar Comentario">
</form>






