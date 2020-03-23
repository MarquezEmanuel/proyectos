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
            $query = "INSERT INTO cuentasComitentesAltas VALUES";
            $values = "";
            $posicion = 0;
            /* Carga clientes */
            if (isset($_POST['tipoClienteAlta'])) {
                $tipoCliente = $_POST['tipoClienteAlta'];
                $cuil = $_POST['cuitAlta'];
                $tipoPersona = $_POST['tipoPersonaAlta'];
                $cont = count($tipoPersona);
                /* For para todos los clientes */
                for ($i = 0; $i < $cont; $i++) {
                    /* Persona humana o persona humana extranjera */
                    if ($tipoPersona[$i] === "Persona humana" || $tipoPersona[$i] === "Persona humana extranjera") {
                        $apellido = $_POST['apellidoAlta'];
                        $nombre = $_POST['nombreAlta'];
                        $tipoDocumento = $_POST['tipoDocumentoAlta'];
                        $numeroDocumento = $_POST['numeroDocumentoAlta'];
                        $genero = $_POST['generoAlta'];
                        $nacionalidad = $_POST['nacionalidadAlta'];
                        $paisNacimiento = $_POST['paisNacimientoAlta'];
                        $lugarNacimiento = $_POST['lugarNacimientoAlta'];
                        $fechaNacimiento = $_POST['fechaNacimientoAlta'];
                        $pep = $_POST['pepAlta'];
                        $riesgo = $_POST['riesgoAlta'];
                        $pais = $_POST['paisAlta'];
                        if ($pais[$i] === "Argentina") {
                            $provincia = $_POST['provinciaAlta'];
                            $localidad = $_POST['localidadAlta'];
                            $calle = $_POST['calleAlta'];
                            $numero = $_POST['numeroAlta'];
                            $num = $numero[$i] ? utf8_decode($numero[$i]) : "null";
                            $piso = $_POST['pisoAlta'];
                            $pis = $piso[$i] ? utf8_decode($piso[$i]) : "null";
                            $departamento = $_POST['departamentoAlta'];
                            $depar = isset($departamento[$i]) ? utf8_decode($departamento[$i]) : NULL;

                            $codigoPostal = $_POST['codigoPostalAlta'];
                            $codPostal = isset($codigoPostal[$i]) ? utf8_decode($codigoPostal[$i]) : NULL;
                            $codigoArea = $_POST['codigoAreaAlta'];
                            $codArea = $codigoArea[$i] ? utf8_decode($codigoArea[$i]) : "null";
                            $telefono = $_POST['telefonoAlta'];
                            $tel = $telefono[$i] ? utf8_decode($telefono[$i]) : "null";
                            $correo = $_POST['correoElectronicoAlta'];

                            $tipoClien = utf8_decode($tipoCliente[$i]);
                            $tipoPer = utf8_decode($tipoPersona[$i]);
                            $apelli = utf8_decode($apellido[$i]);
                            $nom = utf8_decode($nombre[$i]);
                            $tipoDocu = utf8_decode($tipoDocumento[$i]);
                            $gener = utf8_decode($genero[$i]);
                            $nacionali = utf8_decode($nacionalidad[$i]);
                            $paisNacimien = utf8_decode($paisNacimiento[$i]);
                            $lugarNacimien = utf8_decode($lugarNacimiento[$i]);
                            $riesg = isset($riesgo[$i]) ? utf8_decode($riesgo[$i]) : NULL;

                            $provin = utf8_decode($provincia[$i]);
                            $locali = utf8_decode($localidad[$i]);
                            $call = utf8_decode($calle[$i]);
                            $corr = isset($correo[$i]) ? utf8_decode($correo[$i]) : NULL;
                            $cui = $cuil[$i] ? $cuil[$i] : "null";

                            $values = $values . "($idCuentaComitente, 'NO', '$tipoClien', $cui, '$tipoPer', '$apelli', '$nom', '$tipoDocu', $numeroDocumento[$i], '$gener', '$nacionali', '$paisNacimien', '$lugarNacimien', "
                                    . "'$fechaNacimiento[$i]', '$pep[$i]', '','','$riesg', '$pais[$i]', '$provin', '$locali', '$call', $num, $pis, '$depar', '','','','', '$codPostal', $codArea, $tel, '$corr', ''),";
                        } else {
                            $otroPais = $_POST['otroPaisAlta'];
                            $provinciaEstado = $_POST['provinciaEstadoAlta'];
                            $localidadCiudad = $_POST['localidadCiudadAlta'];
                            $domicilioDireccion = $_POST['domicilioDireccionAlta'];

                            $codigoPostal = $_POST['codigoPostalAlta'];
                            $codPostal = isset($codigoPostal[$i]) ? utf8_decode($codigoPostal[$i]) : NULL;
                            $codigoArea = $_POST['codigoAreaAlta'];
                            $codArea = $codigoArea[$i] ? utf8_decode($codigoArea[$i]) : "null";
                            $telefono = $_POST['telefonoAlta'];
                            $tel = $telefono[$i] ? utf8_decode($telefono[$i]) : "null";
                            $correo = $_POST['correoElectronicoAlta'];

                            $tipoClien = utf8_decode($tipoCliente[$i]);
                            $tipoPer = utf8_decode($tipoPersona[$i]);
                            $apelli = utf8_decode($apellido[$i]);
                            $nom = utf8_decode($nombre[$i]);
                            $tipoDocu = utf8_decode($tipoDocumento[$i]);
                            $gener = utf8_decode($genero[$i]);
                            $nacionali = utf8_decode($nacionalidad[$i]);
                            $paisNacimien = utf8_decode($paisNacimiento[$i]);
                            $lugarNacimien = utf8_decode($lugarNacimiento[$i]);
                            $riesg = isset($riesgo[$i]) ? utf8_decode($riesgo[$i]) : NULL;

                            $otro = isset($otroPais[$i]) ? utf8_decode($otroPais[$i]) : NULL;
                            $provinciaEstad = isset($provinciaEstado[$i]) ? utf8_decode($provinciaEstado[$i]) : NULL;
                            $localidadCiuda = isset($localidadCiudad[$i]) ? utf8_decode($localidadCiudad[$i]) : NULL;
                            $domicilioDirecci = isset($domicilioDireccion[$i]) ? utf8_decode($domicilioDireccion[$i]) : NULL;
                            $corr = isset($correo[$i]) ? utf8_decode($correo[$i]) : NULL;
                            $cui = $cuil[$i] ? $cuil[$i]: "null";

                            $values = $values . "($idCuentaComitente, 'NO', '$tipoClien', $cui, '$tipoPer', '$apelli', '$nom', '$tipoDocu', $numeroDocumento[$i], '$gener', '$nacionali', '$paisNacimien', '$lugarNacimien', "
                                    . "'$fechaNacimiento[$i]', '$pep[$i]', '','','$riesg', '$pais[$i]', '', '', '', '', '', '', '$otro','$provinciaEstad','$localidadCiuda','$domicilioDirecci', '$codPostal', $codArea, $tel, '$corr', ''),";
                        }
                    } else {
                        /* Persona Juridica */
                        $denominacion = $_POST['denominacionAlta'];
                        $fechaConstitucion = $_POST['fechaConstitucionAlta'];
                        $riesgo = $_POST['riesgoAlta'];
                        $pais = $_POST['paisAlta'];
                        if ($pais[$i] === "Argentina") {
                            $provincia = $_POST['provinciaAlta'];
                            $localidad = $_POST['localidadAlta'];
                            $calle = $_POST['calleAlta'];
                            $numero = $_POST['numeroAlta'];
                            $num = $numero[$i] ? utf8_decode($numero[$i]) : "null";
                            $piso = $_POST['pisoAlta'];
                            $pis = $piso[$i] ? utf8_decode($piso[$i]) : "null";
                            $departamento = $_POST['departamentoAlta'];
                            $depar = isset($departamento[$i]) ? utf8_decode($departamento[$i]) : NULL;

                            $codigoPostal = $_POST['codigoPostalAlta'];
                            $codPostal = isset($codigoPostal[$i]) ? utf8_decode($codigoPostal[$i]) : NULL;
                            $codigoArea = $_POST['codigoAreaAlta'];
                            $codArea = $codigoArea[$i] ? utf8_decode($codigoArea[$i]) : "null";
                            $telefono = $_POST['telefonoAlta'];
                            $tel = $telefono[$i] ? utf8_decode($telefono[$i]) : "null";
                            $correo = $_POST['correoElectronicoAlta'];

                            $tipoClien = utf8_decode($tipoCliente[$i]);
                            $tipoPer = utf8_decode($tipoPersona[$i]);
                            $denom = utf8_decode($denominacion[$i]);
                            $riesg = isset($riesgo[$i]) ? utf8_decode($riesgo[$i]) : NULL;

                            $provin = utf8_decode($provincia[$i]);
                            $locali = utf8_decode($localidad[$i]);
                            $call = utf8_decode($calle[$i]);
                            $corr = isset($correo[$i]) ? utf8_decode($correo[$i]) : NULL;
                            $fechaConstitu = isset($fechaConstitucion[$i]) ? utf8_decode($fechaConstitucion[$i]) : NULL;
                            $cui = $cuil[$i] ? $cuil[$i]: "null";

                            $values = $values . "($idCuentaComitente, 'NO', '$tipoClien', $cui, '$tipoPer', '', '', '', '', '', '', '', '', "
                                    . "'', '', '$denom','$fechaConstitu','$riesg', '$pais[$i]', '$provin', '$locali', '$call', $num, $pis, '$depar', '','','','', '$codPostal', $codArea, $tel, '$corr', ''),";
                        } else {
                            $otroPais = $_POST['otroPaisAlta'];
                            $provinciaEstado = $_POST['provinciaEstadoAlta'];
                            $localidadCiudad = $_POST['localidadCiudadAlta'];
                            $domicilioDireccion = $_POST['domicilioDireccionAlta'];

                            $codigoPostal = $_POST['codigoPostalAlta'];
                            $codPostal = isset($codigoPostal[$i]) ? utf8_decode($codigoPostal[$i]) : NULL;
                            $codigoArea = $_POST['codigoAreaAlta'];
                            $codArea = $codigoArea[$i] ? utf8_decode($codigoArea[$i]) : "null";
                            $telefono = $_POST['telefonoAlta'];
                            $tel = $telefono[$i] ? utf8_decode($telefono[$i]) : "null";
                            $correo = $_POST['correoElectronicoAlta'];

                            $tipoClien = utf8_decode($tipoCliente[$i]);
                            $tipoPer = utf8_decode($tipoPersona[$i]);
                            $denom = utf8_decode($denominacion[$i]);
                            $riesg = isset($riesgo[$i]) ? utf8_decode($riesgo[$i]) : NULL;

                            $otro = isset($otroPais[$i]) ? utf8_decode($otroPais[$i]) : NULL;
                            $provinciaEstad = isset($provinciaEstado[$i]) ? utf8_decode($provinciaEstado[$i]) : NULL;
                            $localidadCiuda = isset($localidadCiudad[$i]) ? utf8_decode($localidadCiudad[$i]) : NULL;
                            $domicilioDirecci = isset($domicilioDireccion[$i]) ? utf8_decode($domicilioDireccion[$i]) : NULL;
                            $corr = isset($correo[$i]) ? utf8_decode($correo[$i]) : NULL;
                            $fechaConstitu = isset($fechaConstitucion[$i]) ? utf8_decode($fechaConstitucion[$i]) : NULL;
                            $cui = $cuil[$i] ? $cuil[$i] : "null";

                            $values = $values . "($idCuentaComitente, 'NO', '$tipoClien', $cui, '$tipoPer', '', '', '', '', '', '', '', '', "
                                    . "'', '', '$denom','$fechaConstitu','$riesg', '$pais[$i]', '', '', '', '', '', '', '$otro','$provinciaEstad','$localidadCiuda','$domicilioDirecci', '$codPostal', $codArea, $tel, '$corr', ''),";
                        }
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
                        $genero = $_POST['generoSujetoVinculado'];
                        $nacionalidad = $_POST['nacionalidadSujetoVinculado'];
                        $paisNacimiento = $_POST['paisNacimientoSujetoVinculado'];
                        $lugarNacimiento = $_POST['lugarNacimientoSujetoVinculado'];
                        $fechaNacimiento = $_POST['fechaNacimientoSujetoVinculado'];
                        $pais = $_POST['paisSujetoVinculado'];
                        if ($pais[$i] === "Argentina") {
                            $provincia = $_POST['provinciaSujetoVinculado'];
                            $localidad = $_POST['localidadSujetoVinculado'];
                            $calle = $_POST['calleSujetoVinculado'];
                            $numero = $_POST['numeroSujetoVinculado'];
                            $num = $numero[$i] ? utf8_decode($numero[$i]) : "null";
                            $piso = $_POST['pisoSujetoVinculado'];
                            $pis = $piso[$i] ? utf8_decode($piso[$i]) : "null";
                            $departamento = $_POST['departamentoSujetoVinculado'];
                            $depar = isset($departamento[$i]) ? utf8_decode($departamento[$i]) : NULL;

                            $codigoPostal = $_POST['codigoPostalSujetoVinculado'];
                            $codPostal = isset($codigoPostal[$i]) ? utf8_decode($codigoPostal[$i]) : NULL;
                            $codigoArea = $_POST['codigoAreaSujetoVinculado'];
                            $codArea = $codigoArea[$i] ? utf8_decode($codigoArea[$i]) : "null";
                            $telefono = $_POST['telefonoAlta'];
                            $tel = $telefono[$i] ? utf8_decode($telefono[$i]) : "null";
                            $correo = $_POST['correoElectronicoSujetoVinculado'];

                            $naturale = utf8_decode($naturaleza[$i]);
                            $tipoPer = utf8_decode($tipoPersona[$i]);
                            $apelli = utf8_decode($apellido[$i]);
                            $nom = utf8_decode($nombre[$i]);
                            $tipoDocu = utf8_decode($tipoDocumento[$i]);
                            $gener = utf8_decode($genero[$i]);
                            $nacionali = utf8_decode($nacionalidad[$i]);
                            $paisNacimien = utf8_decode($paisNacimiento[$i]);
                            $lugarNacimien = utf8_decode($lugarNacimiento[$i]);

                            $provin = utf8_decode($provincia[$i]);
                            $locali = utf8_decode($localidad[$i]);
                            $call = utf8_decode($calle[$i]);
                            $corr = isset($correo[$i]) ? utf8_decode($correo[$i]) : NULL;
                            $cui = $cuil[$i] ? $cuil[$i]: "null";

                            $values = $values . "($idCuentaComitente, 'SI', '', $cui, '$tipoPer', '$apelli', '$nom', '$tipoDocu', $numeroDocumento[$i], '$gener', '$nacionali', '$paisNacimien', '$lugarNacimien', "
                                    . "'$fechaNacimiento[$i]', '', '','','', '$pais[$i]', '$provin', '$locali', '$call', $num, $pis, '$depar', '','','','', '$codPostal', $codArea, $tel, '$corr', '$naturale'),";
                        } else {
                            $otroPais = $_POST['otroPaisSujetoVinculado'];
                            $provinciaEstado = $_POST['provinciaEstadoSujetoVinculado'];
                            $localidadCiudad = $_POST['localidadCiudadSujetoVinculado'];
                            $domicilioDireccion = $_POST['domicilioDireccionSujetoVinculado'];

                            $codigoPostal = $_POST['codigoPostalSujetoVinculado'];
                            $codPostal = isset($codigoPostal[$i]) ? utf8_decode($codigoPostal[$i]) : NULL;
                            $codigoArea = $_POST['codigoAreaSujetoVinculado'];
                            $codArea = $codigoArea[$i] ? utf8_decode($codigoArea[$i]) : "null";
                            $telefono = $_POST['telefonoAlta'];
                            $tel = $telefono[$i] ? utf8_decode($telefono[$i]) : "null";
                            $correo = $_POST['correoElectronicoSujetoVinculado'];

                            $naturale = utf8_decode($naturaleza[$i]);
                            $tipoPer = utf8_decode($tipoPersona[$i]);
                            $apelli = utf8_decode($apellido[$i]);
                            $nom = utf8_decode($nombre[$i]);
                            $tipoDocu = utf8_decode($tipoDocumento[$i]);
                            $gener = utf8_decode($genero[$i]);
                            $nacionali = utf8_decode($nacionalidad[$i]);
                            $paisNacimien = utf8_decode($paisNacimiento[$i]);
                            $lugarNacimien = utf8_decode($lugarNacimiento[$i]);

                            $otro = isset($otroPais[$i]) ? utf8_decode($otroPais[$i]) : NULL;
                            $provinciaEstad = isset($provinciaEstado[$i]) ? utf8_decode($provinciaEstado[$i]) : NULL;
                            $localidadCiuda = isset($localidadCiudad[$i]) ? utf8_decode($localidadCiudad[$i]) : NULL;
                            $domicilioDirecci = isset($domicilioDireccion[$i]) ? utf8_decode($domicilioDireccion[$i]) : NULL;
                            $corr = isset($correo[$i]) ? utf8_decode($correo[$i]) : NULL;
                            $cui = $cuil[$i] ? $cuil[$i] : "null";

                            $values = $values . "($idCuentaComitente, 'SI', '', $cui, '$tipoPer', '$apelli', '$nom', '$tipoDocu', $numeroDocumento[$i], '$gener', '$nacionali', '$paisNacimien', '$lugarNacimien', "
                                    . "'$fechaNacimiento[$i]', '', '','','', '$pais[$i]', '', '', '', '', '', '', '$otro','$provinciaEstad','$localidadCiuda','$domicilioDirecci', '$codPostal', $codArea, $tel, '$corr', '$naturale'),";
                        }
                    } else {
                        /* Persona Juridica */
                        $denominacion = $_POST['denominacionSujetoVinculado'];
                        $fechaConstitucion = $_POST['fechaConstitucionSujetoVinculado'];
                        $pais = $_POST['paisSujetoVinculado'];
                        if ($pais[$i] === "Argentina") {
                            $provincia = $_POST['provinciaSujetoVinculado'];
                            $localidad = $_POST['localidadSujetoVinculado'];
                            $calle = $_POST['calleSujetoVinculado'];
                            $numero = $_POST['numeroSujetoVinculado'];
                            $num = $numero[$i] ? utf8_decode($numero[$i]) : "null";
                            $piso = $_POST['pisoSujetoVinculado'];
                            $pis = $piso[$i] ? utf8_decode($piso[$i]) : "null";
                            $departamento = $_POST['departamentoSujetoVinculado'];
                            $depar = isset($departamento[$i]) ? utf8_decode($departamento[$i]) : NULL;

                            $codigoPostal = $_POST['codigoPostalSujetoVinculado'];
                            $codPostal = isset($codigoPostal[$i]) ? utf8_decode($codigoPostal[$i]) : NULL;
                            $codigoArea = $_POST['codigoAreaSujetoVinculado'];
                            $codArea = $codigoArea[$i] ? utf8_decode($codigoArea[$i]) : "null";
                            $telefono = $_POST['telefonoAlta'];
                            $tel = $telefono[$i] ? utf8_decode($telefono[$i]) : "null";
                            $correo = $_POST['correoElectronicoSujetoVinculado'];

                            $naturale = utf8_decode($naturaleza[$i]);
                            $tipoPer = utf8_decode($tipoPersona[$i]);
                            $denom = utf8_decode($denominacion[$i]);

                            $provin = utf8_decode($provincia[$i]);
                            $locali = utf8_decode($localidad[$i]);
                            $call = utf8_decode($calle[$i]);
                            $corr = isset($correo[$i]) ? utf8_decode($correo[$i]) : NULL;
                            $fechaConstitu = isset($fechaConstitucion[$i]) ? utf8_decode($fechaConstitucion[$i]) : NULL;
                            $cui = $cuil[$i] ? $cuil[$i]: "null";

                            $values = $values . "($idCuentaComitente, 'SI', '', $cui, '$tipoPer', '', '', '', '', '', '', '', '', "
                                    . "'', '', '$denom','$fechaConstitu','', '$pais[$i]', '$provin', '$locali', '$call', $num, $pis, '$depar', '','','','', '$codPostal', $codArea, $tel, '$corr', '$naturale'),";
                        } else {
                            $otroPais = $_POST['otroPaisSujetoVinculado'];
                            $provinciaEstado = $_POST['provinciaEstadoSujetoVinculado'];
                            $localidadCiudad = $_POST['localidadCiudadSujetoVinculado'];
                            $domicilioDireccion = $_POST['domicilioDireccionSujetoVinculado'];

                            $codigoPostal = $_POST['codigoPostalSujetoVinculado'];
                            $codPostal = isset($codigoPostal[$i]) ? utf8_decode($codigoPostal[$i]) : NULL;
                            $codigoArea = $_POST['codigoAreaSujetoVinculado'];
                            $codArea = $codigoArea[$i] ? utf8_decode($codigoArea[$i]) : "null";
                            $telefono = $_POST['telefonoAlta'];
                            $tel = $telefono[$i] ? utf8_decode($telefono[$i]) : "null";
                            $correo = $_POST['correoElectronicoSujetoVinculado'];

                            $naturale = utf8_decode($naturaleza[$i]);
                            $tipoPer = utf8_decode($tipoPersona[$i]);
                            $denom = utf8_decode($denominacion[$i]);

                            $otro = isset($otroPais[$i]) ? utf8_decode($otroPais[$i]) : NULL;
                            $provinciaEstad = isset($provinciaEstado[$i]) ? utf8_decode($provinciaEstado[$i]) : NULL;
                            $localidadCiuda = isset($localidadCiudad[$i]) ? utf8_decode($localidadCiudad[$i]) : NULL;
                            $domicilioDirecci = isset($domicilioDireccion[$i]) ? utf8_decode($domicilioDireccion[$i]) : NULL;
                            $corr = isset($correo[$i]) ? utf8_decode($correo[$i]) : NULL;
                            $fechaConstitu = isset($fechaConstitucion[$i]) ? utf8_decode($fechaConstitucion[$i]) : NULL;
                            $cui = $cuil[$i] ? $cuil[$i]: "null";

                            $values = $values . "($idCuentaComitente, 'SI', '', $cui, '$tipoPer', '', '', '', '', '', '', '', '', "
                                    . "'', '', '$denom','$fechaConstitu','', '$pais[$i]', '', '', '', '', '', '', '$otro','$provinciaEstad','$localidadCiuda','$domicilioDirecci', '$codPostal', $codArea, $tel, '$corr', '$naturale'),";
                        }
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
                echo $insertSujetos;
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




