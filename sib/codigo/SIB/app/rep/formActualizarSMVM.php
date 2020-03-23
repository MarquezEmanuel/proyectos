<?php
/* INICIALIZA LA SESION */
session_start();

require_once './menuReportes.php';

if (isset($_POST['enviado']) && isset($_SESSION['user']) && isset($_SESSION['legajo']) && isset($_SESSION['nombreRol'])) {
    $SMVM = $_POST['SMVM'];
    $enviado = "";
    if (sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion()) === false) {
        $mensaje = "No se inicializó la transacción con la base de datos";
        Log::escribirError("[$mensaje]");
        $alerta = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
    } else {
        $nombreUsuario = $_SESSION['user'];
        $legajoUsuario = $_SESSION['legajo'];
        $nombreRol = $_SESSION['nombreRol'];
        $querySMVM = "UPDATE [SMVM] SET saldo = {$SMVM}, fechaActualizacion = GETDATE()";
        $queryLog = "INSERT INTO [logs] VALUES ('REGISTRO', '{$legajoUsuario}','{$nombreUsuario}','{$nombreRol}','ACTUALIZA SMVM','VALOR: {$SMVM}',GETDATE())";
        $resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySMVM);
        $log = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryLog);
        if ($resultado && $log) {
            sqlsrv_commit(BDConexion::getInstancia()->getConexion());
            $mensaje = "Se modificó el SMVM correctamente a " . $SMVM;
            $alerta = '<div class="alert alert-success text-center mt-2" role="alert"><b>' . $mensaje . '</b></div>';
        } else {
            Log::escribirError("[ERROR AL ACTUALIZAR SMVM] [$querySMVM] [$queryLog]");
            $mensaje = "No se pudo modificar el valor del SMVM";
            $alerta = '<div class="alert alert-danger text-center mt-2" role="alert">' . $mensaje . '</div>';
        }
    }
} else {
    $SMVM = $alerta = "";
    $enviado = 'value="true"';
    $consulta = "SELECT * FROM [SMVM]";
    $resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
    if ($resultado && sqlsrv_has_rows($resultado)) {
        $row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $SMVM = (double) $row['saldo'];
    }
}
?>
<div id="contenido">
    <div class="card-header">
        <h4 class="text-center p-4">ACTUALIZAR SMVM</h4>
        <div class="container">
            <div id='resultado' name='resultado'><?= $alerta; ?></div>
            <form method="POST" name="formActualizaSMVM" id="formActualizaSMVM">
                <input type="hidden" name="enviado" id="enviado"<?= $enviado; ?> >
                <div class="form-row">
                    <label class="col-sm-2 col-form-label">* Valor SMVM:</label>
                    <div class="col">
                        <input type="number" class="form-control mb-2" step="0.01"
                               id="SMVM" name="SMVM" value="<?= $SMVM; ?>" min="1"
                               placeholder="Valor del Salario Minimo Vital y Movil"
                               title="Valor del Salario Minimo Vital y Movil" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-success" 
                                   id="btnActualizarSMVM" name="btnActualizarSMVM" disabled
                                   title="Actualizar Salario Minimo Vital y Movil" value="Actualizar">
                            <a href="regimenTC.php">
                                <input type="button" class="btn btn-outline-secondary" 
                                       title="Regresar a opciones de Regimen TC" value="Volver">
                            </a>
                        </div>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf8">
    $(document).ready(function () {
        var formOriginal = $("#formActualizaSMVM").serialize();

        $("#formActualizaSMVM").change(function () {
            var formModificado = $("#formActualizaSMVM").serialize();
            var disabled = (formOriginal !== formModificado) ? false : true;
            $("#btnActualizarSMVM").prop("disabled", disabled);
        });
    });
</script>