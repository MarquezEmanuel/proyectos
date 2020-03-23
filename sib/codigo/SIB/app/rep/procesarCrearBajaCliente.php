<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

$fecha = utf8_decode($_POST['fecha']);
$estado = utf8_decode($_POST['estado']);
$numeroCuentaDepositante = $_POST['numeroCuentaDepositante'];
$numeroCuentaComitente = $_POST['numeroCuentaComitente'];
$cantidadVinculados = $_POST['cantidadVinculados'];
$tipoAccion = utf8_decode($_POST['tipoAccion']);
$html = '';
$log = new Log();

if (sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion()) === false) {
    $log->writeLine("[Error al inicializar la transaccion (begin_transaction)]");

    function mensaje() {
        $html = '<div class="alert alert-danger text-center" role="alert"> No se inicializó la transacción con la base de datos </div>';
        return $html;
    }

} else {
    /* Carga la cuenta comitente */
    $query = "INSERT INTO cuentasComitentes VALUES ('$fecha', '$estado', '$numeroCuentaDepositante', '$numeroCuentaComitente', '$cantidadVinculados', '$tipoAccion')";
    $insertOperacion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

    if ($insertOperacion) {
        /* Busca el id del ultimo insert */
        $query = "SELECT SCOPE_IDENTITY() id";
        $lastId = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

        if ($lastId) {
            $row = sqlsrv_fetch_array($lastId);
            $idCuentaComitente = $row['id'];
            $query = "INSERT INTO cuentasComitentesBajas VALUES";
            $values = "";
            $posicion = 0;
            /* Carga clientes */
            if (isset($_POST['tipoClienteBaja'])) {
                $tipoCliente = $_POST['tipoClienteBaja'];
                $cuil = $_POST['cuitBaja'];
                $tipoPersona = $_POST['tipoPersonaBaja'];
                $cont = count($tipoPersona);
                /* For para todos los clientes */
                for ($i = 0; $i < $cont; $i++) {
                    /* Persona humana o persona humana extranjera */
                    if ($tipoPersona[$i] === "Persona humana" || $tipoPersona[$i] === "Persona humana extranjera") {
                        $apellido = $_POST['apellidoBaja'];
                        $nombre = $_POST['nombreBaja'];
                        $tipoDocumento = $_POST['tipoDocumentoBaja'];
                        $numeroDocumento = $_POST['numeroDocumentoBaja'];
                        $riesgo = $_POST['riesgoBaja'];
                        $apelli = utf8_decode($apellido[$i]);
                        $nom = utf8_decode($nombre[$i]);
                        $tipoDocu = utf8_decode($tipoDocumento[$i]);
                        $riesg = isset($riesgo[$i]) ? utf8_decode($riesgo[$i]) : NULL;
                        $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;
                        $tipoClien = utf8_decode($tipoCliente[$i]);
                        $tipoPer = utf8_decode($tipoPersona[$i]);

                        $values = $values . "($idCuentaComitente, 'NO', '$tipoClien', $cui, '$tipoPer', '$apelli', '$nom', '$tipoDocu', $numeroDocumento[$i], '', '', '$riesg', ''),";
                    } else {
                        /* Persona Juridica */
                        $denominacion = $_POST['denominacionBaja'];
                        $fechaConstitucion = $_POST['fechaConstitucionBaja'];
                        $riesgo = $_POST['riesgoBaja'];
                        $denom = utf8_decode($denominacion[$i]);
                        $fechaConstitu = isset($fechaConstitucion[$i]) ? utf8_decode($fechaConstitucion[$i]) : NULL;
                        $riesg = isset($riesgo[$i]) ? utf8_decode($riesgo[$i]) : NULL;
                        $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;
                        $tipoClien = utf8_decode($tipoCliente[$i]);
                        $tipoPer = utf8_decode($tipoPersona[$i]);

                        $values = $values . "($idCuentaComitente, 'NO', '$tipoClien', $cui, '$tipoPer', '', '', '', '', '$denom', '$fechaConstitu', '', ''),";
                    }
                }
            }
            /* Carga Clientes Vinculados */
            if (isset($_POST['naturalezaSujetoVinculado'])) {
                $naturaleza = $_POST['naturalezaSujetoVinculado'];
                $cuil = $_POST['cuitSujetoVinculado'];
                $tipoPersona = $_POST['tipoPersonaSujetoVinculado'];
                $cont = count($tipoPersona);
                /* For para todos los clientes */
                for ($i = 0; $i < $cont; $i++) {
                    /* Persona humana o persona humana extranjera */
                    if ($tipoPersona[$i] === "Persona humana" || $tipoPersona[$i] === "Persona humana extranjera") {
                        $apellido = $_POST['apellidoSujetoVinculado'];
                        $nombre = $_POST['nombreSujetoVinculado'];
                        $tipoDocumento = $_POST['tipoDocumentoSujetoVinculado'];
                        $numeroDocumento = $_POST['numeroDocumentoSujetoVinculado'];
                        $apelli = utf8_decode($apellido[$i]);
                        $nom = utf8_decode($nombre[$i]);
                        $tipoDocu = utf8_decode($tipoDocumento[$i]);
                        $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;
                        $naturale = utf8_decode($naturaleza[$i]);
                        $tipoPer = utf8_decode($tipoPersona[$i]);

                        $values = $values . "($idCuentaComitente, 'SI', '', $cui, '$tipoPer', '$apelli', '$nom', '$tipoDocu', $numeroDocumento[$i], '', '', '', '$naturale'),";
                    } else {
                        /* Persona Juridica */
                        $denominacion = $_POST['denominacionSujetoVinculado'];
                        $fechaConstitucion = $_POST['fechaConstitucionSujetoVinculado'];
                        $denom = utf8_decode($denominacion[$i]);
                        $fechaConstitu = isset($fechaConstitucion[$i]) ? utf8_decode($fechaConstitucion[$i]) : NULL;
                        $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;
                        $naturale = utf8_decode($naturaleza[$i]);
                        $tipoPer = utf8_decode($tipoPersona[$i]);

                        $values = $values . "($idCuentaComitente, 'SI', '', $cui, '$tipoPer', '', '', '', '', '$denom', '$fechaConstitu', '', '$naturale'),";
                    }
                }
            }


            $query = $query . substr($values, 0, -1);
            $insertSujetos = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if ($insertOperacion && $insertSujetos) {
                sqlsrv_commit(BDConexion::getInstancia()->getConexion());

                function mensaje() {
                    $html = '<div class="alert alert-success text-center" role="alert"> Se realizó la creación de la cuenta comitente correctamente <div>';
                    return $html;
                }

            } else {
                $log->writeLine("[Error al crear operacion o sujetos en la BD][QUERY: $query]");
                sqlsrv_rollback(BDConexion::getInstancia()->getConexion());

                function mensaje() {
                    $html = '<div class="alert alert-danger text-center" role="alert"> No se realizó la creación de la cuenta comitente <div>';
                    return $html;
                }

            }
        } else {
            $log->writeLine("[Error al obtener el identificador de operacion desde la BD][QUERY: $query]");
            sqlsrv_rollback(BDConexion::getInstancia()->getConexion());

            function mensaje() {
                $html = '<div class="alert alert-danger text-center" role="alert"> No se realizó la creación de la operación indicada<div>';
                return $html;
            }

        }
    } else {
        $log->writeLine("[Error al realizar la insercion en la BD][QUERY: $query]");

        function mensaje() {
            $html = '<div class="alert alert-danger text-center" role="alert"> No se realizó la creación de la operación <div>';
            return $html;
        }

    }
}
?>
<body id="body">
    <div class="card-header">
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-12 text-center">
                <h5 class="text-center"><u><?php echo $output = mensaje(); ?></u></h5>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="formAltaCliente.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Crear Cuenta Comitente Alta Cliente</button></a>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="formBajaCliente.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Crear Cuenta Comitente Baja Cliente</button></a>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="formBuscarCuentaComitente.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar Cuenta Comitente</button></a>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="cargarCuentaComitente.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Salir</button></a>
            </div>
        </div>
        <br>
    </div>
</body>

</html>




