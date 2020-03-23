<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* Obtiene los datos del formulario de modificacion */

$idTransaccion = $_POST['idTransaccion'];

$idBajas = $_POST['idBajas'];
$log = new Log();
/* empieza la transaccion */

sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion());

/* PREPARA LOS UPDATE PARA EJECUTAR */

if ($idTransaccion) {

    /* DATOS COMUNES */
    $fecha = utf8_decode($_POST['fecha']);
    $estado = utf8_decode($_POST['estado']);
    $numeroCuentaDepositante = $_POST['depositante'];
    $numeroCuentaComitente = $_POST['comitente'];
    $cantidadVinculados = $_POST['vinculados'];
    $tipoAccion = utf8_decode($_POST['accion']);

    $modificaCuentaComitente = $modificaAlta = $modificaAltaVinculado = $modificaBaja = $modificaBajaVinculado = true;
    $valorAlta = $valorAltaVinculado = $valorBaja = $valorBajaVinculado = "";

    $query = "UPDATE cuentasComitentes SET fechaAccion = '{$fecha}', estadoDepositante = '{$estado}', cuentaDepositante = '{$numeroCuentaDepositante}', 
    cuentaComitente = '{$numeroCuentaComitente}', cantidadCliente = {$cantidadVinculados}, tipoAccion = '{$tipoAccion}'
    WHERE idCuentaComitente=" . $idTransaccion;

    $modificaCuentaComitente = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

    /* Cliente Alta */

    if (isset($_POST['idAltas'])) {
        $idAltas = $_POST['idAltas'];
        $tipoCliente = $_POST['tipoClienteAlta'];
        $cuil = $_POST['cuilAlta'];
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
                    $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;

                    $valorAlta = $valorAlta . "UPDATE cuentasComitentesAltas SET tipoCliente = '$tipoClien', cuil = '$cui', tipoPersona = '$tipoPer', apellido = '$apelli', nombre = '$nom', tipoDocumento = '$tipoDocu', numeroDocumento = $numeroDocumento[$i], "
                            . "genero = '$gener', nacionalidad = '$nacionali', paisNacimiento = '$paisNacimien', lugarNacimiento = '$lugarNacimien', fechaNacimiento = '$fechaNacimiento[$i]', declaraSerPEP = '$pep[$i]', riesgo = '$riesg', pais = '$pais[$i]',"
                            . "provincia = '$provin', localidad = '$locali', calle = '$call', numero = $num, piso = $pis, departamento = '$depar', codigoPostal = '$codPostal', codigoArea = $codArea, telefono = $tel, correoElectronico = '$corr' WHERE idCuentasComitentesAltas = $idAltas[$i]";
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
                    $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;

                    $valorAlta = $valorAlta . "UPDATE cuentasComitentesAltas SET tipoCliente = '$tipoClien', cuil = '$cui', tipoPersona = '$tipoPer', apellido = '$apelli', nombre = '$nom', tipoDocumento = '$tipoDocu', numeroDocumento = $numeroDocumento[$i], "
                            . "genero = '$gener', nacionalidad = '$nacionali', paisNacimiento = '$paisNacimien', lugarNacimiento = '$lugarNacimien', fechaNacimiento = '$fechaNacimiento[$i]', declaraSerPEP = '$pep[$i]', riesgo = '$riesg', pais = '$pais[$i]',"
                            . "otroPais = '$otro', provinciaEstado = '$provinciaEstad', localidadCiudad = '$localidadCiuda', domicilioDireccion = '$domicilioDirecci', codigoPostal = '$codPostal', codigoArea = $codArea, telefono = $tel, correoElectronico = '$corr' WHERE idCuentasComitentesAltas = $idAltas[$i]";
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
                    $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;

                    $valorAlta = $valorAlta . "UPDATE cuentasComitentesAltas SET tipoCliente = '$tipoClien', cuil = '$cui', tipoPersona = '$tipoPer', denominacion = '$denom', fechaConstitucion = '$fechaConstitu',"
                            . "riesgo = '$riesg', pais = '$pais[$i]', provincia = '$provin', localidad = '$locali', calle = '$call', numero = $num, piso =$pis,departamento = '$depar', codigoPostal = '$codPostal', codigoArea = $codArea, telefono = $tel, correoElectronico = '$corr' WHERE idCuentasComitentesAltas = $idAltas[$i]";
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
                    $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;

                    $valorAlta = $valorAlta . "UPDATE cuentasComitentesAltas SET tipoCliente = '$tipoClien', cuil = '$cui', tipoPersona = '$tipoPer', denominacion = '$denom', fechaConstitucion = '$fechaConstitu',"
                            . "riesgo = '$riesg', pais = '$pais[$i]', otroPAis = '$otro', provinciaEstado = '$provinciaEstad', localidadCiudad = '$localidadCiuda', domicilioDireccion = '$domicilioDirecci', codigoPostal = '$codPostal', codigoArea = $codArea, telefono = $tel, correoElectronico = '$corr' WHERE idCuentasComitentesAltas = $idAltas[$i]";
                }
            }
        }
        $query = $query . $valorAlta;
        $modificaAlta = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    }

    /* Cliente ALta Vinculado */

    if (isset($_POST['idSujetoVinculado'])) {
        $idSujetoVinculado = $_POST['idSujetoVinculado'];
        $naturaleza = $_POST['naturalezaSujetoVinculado'];
        $cuil = $_POST['cuilSujetoVinculado'];
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
                    $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;

                    $valorAltaVinculado = $valorAltaVinculado . "UPDATE cuentasComitentesAltas SET cuil = '$cui', tipoPersona = '$tipoPer', apellido = '$apelli', nombre = '$nom', tipoDocumento = '$tipoDocu', numeroDocumento = $numeroDocumento[$i], "
                            . "genero = '$gener', nacionalidad = '$nacionali', paisNacimiento = '$paisNacimien', lugarNacimiento = '$lugarNacimien', fechaNacimiento = '$fechaNacimiento[$i]', pais = '$pais[$i]',"
                            . "provincia = '$provin', localidad = '$locali', calle = '$call', numero = $num, piso = $pis, departamento = '$depar', codigoPostal = '$codPostal', codigoArea = $codArea, telefono = $tel, correoElectronico = '$corr', naturalezaDelVinculo = '$naturale' WHERE idCuentasComitentesAltas = $idSujetoVinculado[$i]";
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
                    $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;

                    $valorAltaVinculado = $valorAltaVinculado . "UPDATE cuentasComitentesAltas SET cuil = '$cui', tipoPersona = '$tipoPer', apellido = '$apelli', nombre = '$nom', tipoDocumento = '$tipoDocu', numeroDocumento = $numeroDocumento[$i], "
                            . "genero = '$gener', nacionalidad = '$nacionali', paisNacimiento = '$paisNacimien', lugarNacimiento = '$lugarNacimien', fechaNacimiento = '$fechaNacimiento[$i]', pais = '$pais[$i]',"
                            . "otroPais = '$otro', provinciaEstado = '$provinciaEstad', localidadCiudad = '$localidadCiuda', domicilioDireccion = '$domicilioDirecci', codigoPostal = '$codPostal', codigoArea = $codArea, telefono = $tel, correoElectronico = '$corr', naturalezaDelVinculo = '$naturale' WHERE idCuentasComitentesAltas = $idSujetoVinculado[$i]";
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
                    $cui = isset($cuil[$i]) ? $cuil[$i]: NULL;

                    $valorAltaVinculado = $valorAltaVinculado . "UPDATE cuentasComitentesAltas SET cuil = '$cui', tipoPersona = '$tipoPer', denominacion = '$denom', fechaConstitucion = '$fechaConstitu',"
                            . "pais = '$pais[$i]', provincia = '$provin', localidad = '$locali', calle = '$call', numero = $num, piso =$pis,departamento = '$depar', codigoPostal = '$codPostal', codigoArea = $codArea, telefono = $tel, correoElectronico = '$corr', naturalezaDelVinculo = '$naturale' WHERE idCuentasComitentesAltas = $idSujetoVinculado[$i]";
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
                    $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;

                    $valorAltaVinculado = $valorAltaVinculado . "UPDATE cuentasComitentesAltas SET cuil = '$cui', tipoPersona = '$tipoPer', denominacion = '$denom', fechaConstitucion = '$fechaConstitu',"
                            . "pais = '$pais[$i]', otroPais = '$otro', provinciaEstado = '$provinciaEstad', localidadCiudad = '$localidadCiuda', domicilioDireccion = '$domicilioDirecci', codigoPostal = '$codPostal', codigoArea = $codArea, telefono = $tel, correoElectronico = '$corr', naturalezaDelVinculo = '$naturale' WHERE idCuentasComitentesAltas = $idSujetoVinculado[$i]";
                }
            }
        }
        $query = $query . $valorAltaVinculado;
        $modificaAltaVinculado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    }


    /* Cliente Baja */


    if (isset($_POST['idBaja'])) {
        $idBaja = $_POST['idBaja'];
        $tipoCliente = $_POST['tipoClienteBaja'];
        $cuil = $_POST['cuilBaja'];
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
                $valorBaja = $valorBaja . "UPDATE cuentasComitentesBajas SET tipoCliente = '$tipoClien', cuil = '$cui', tipoPersona = '$tipoPer', apellido = '$apelli', nombre = '$nom',"
                        . "tipoDocumento = '$tipoDocu', numeroDocumento = $numeroDocumento[$i], riesgo = '$riesg' WHERE idCuentasComitentesBajas = $idBaja[$i]";
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
                $valorBaja = $valorBaja . "UPDATE cuentasComitentesBajas SET tipoCliente = '$tipoClien', cuil = '$cui', tipoPersona = '$tipoPer', denominacion = '$denom', fechaConstitucion = '$fechaConstitu',riesgo = '$riesg' WHERE idCuentasComitentesBajas = $idBaja[$i]";
                
            }
        }
        
        $query = $query . $valorBaja;
        $modificaBaja = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    }


    /* Cliente Baja Vinculado */


    if (isset($_POST['idSujetoVinculadoBaja'])) {
        $idSujetoVinculadoBaja = $_POST['idSujetoVinculadoBaja'];
        $naturaleza = $_POST['naturalezaSujetoVinculadoBaja'];
        $cuil = $_POST['cuilSujetoVinculadoBaja'];
        $tipoPersona = $_POST['tipoPersonaSujetoVinculadoBaja'];
        $cont = count($tipoPersona);
        /* For para todos los clientes */
        for ($i = 0; $i < $cont; $i++) {
            /* Persona humana o persona humana extranjera */
            if ($tipoPersona[$i] === "Persona humana" || $tipoPersona[$i] === "Persona humana extranjera") {
                $apellido = $_POST['apellidoSujetoVinculadoBaja'];
                $nombre = $_POST['nombreSujetoVinculadoBaja'];
                $tipoDocumento = $_POST['tipoDocumentoSujetoVinculadoBaja'];
                $numeroDocumento = $_POST['numeroDocumentoSujetoVinculadoBaja'];
                $apelli = utf8_decode($apellido[$i]);
                $nom = utf8_decode($nombre[$i]);
                $tipoDocu = utf8_decode($tipoDocumento[$i]);
                $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;
                $naturale = utf8_decode($naturaleza[$i]);
                $tipoPer = utf8_decode($tipoPersona[$i]);

                $valorBajaVinculado = $valorBajaVinculado . "UPDATE cuentasComitentesBajas SET cuil = '$cui', tipoPersona = '$tipoPer', apellido = '$apelli', nombre = '$nom', tipoDocumento = '$tipoDocu', numeroDocumento = $numeroDocumento[$i], naturalezaDelVinculo = '$naturale' WHERE idCuentasComitentesBajas = $idSujetoVinculadoBaja[$i]";
            } else {
                /* Persona Juridica */
                $denominacion = $_POST['denominacionSujetoVinculadoBaja'];
                $fechaConstitucion = $_POST['fechaConstitucionSujetoVinculadoBaja'];
                $denom = utf8_decode($denominacion[$i]);
                $fechaConstitu = isset($fechaConstitucion[$i]) ? utf8_decode($fechaConstitucion[$i]) : NULL;
                $cui = isset($cuil[$i]) ? $cuil[$i] : NULL;
                $naturale = utf8_decode($naturaleza[$i]);
                $tipoPer = utf8_decode($tipoPersona[$i]);
                
                $valorBajaVinculado = $valorBajaVinculado . "UPDATE cuentasComitentesBajas SET cuil = '$cui', tipoPersona = '$tipoPer', denominacion = '$denom', fechaConstitucion = '$fechaConstitu', naturalezaDelVinculo = '$naturale' WHERE idCuentasComitentesBajas = $idSujetoVinculadoBaja[$i]";
            }
        }
        $query = $query . $valorBajaVinculado;
        $modificaBajaVinculado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    }
} else {
    echo $mensaje = "No se obutvieron los datos del reporte";
}

$html = '';
if ($modificaCuentaComitente && $modificaAlta && $modificaAltaVinculado && $modificaBaja && $modificaBajaVinculado) {
    sqlsrv_commit(BDConexion::getInstancia()->getConexion());

    function mensaje() {
        $html = '
                        <h1><u>Modificado con exito</u></h1>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
';
        return $html;
    }

} else {
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());

    if (!$modificaCuentaComitente) {
        $log->writeLine("[Error al modificar cuenta comitente][QUERY: $modificaCuentaComitente]");

        function mensaje() {
            $html = '
                        <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Modificar La Cuenta Comitente</h2></div>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
';
            return $html;
        }

    } else {
        if (!$modificaAlta) {
            $log->writeLine("[Error al modificar alta cliente][QUERY: $modificaAlta]");

            function mensaje() {
                $html = '
                        <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Modificar El Alta de Cliente</h2></div>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
';
                return $html;
            }

        } else {
            if (!$modificaAltaVinculado) {
                $log->writeLine("[Error al modificar alta cliente vinculado][QUERY: $modificaAltaVinculado]");

                function mensaje() {
                    $html = '
                        <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Modificar El Alta de Cliente Vinculado</h2></div>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
';
                    return $html;
                }

            } else {
                if (!$modificaBaja) {
                    $log->writeLine("[Error al modificar baja cliente][QUERY: $modificaBaja]");
                    
                    function mensaje() {
                        $html = '
                        <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Modificar La Baja de Cliente</h2></div>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
';
                        return $html;
                    }

                } else {
                    if (!$modificaBajaVinculado) {
                        $log->writeLine("[Error al modificar baja cliente vinculado][QUERY: $modificaBajaVinculado]");

                        function mensaje() {
                            $html = '
                        <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Modificar La Baja de Cliente Vinculado</h2></div>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
';
                            return $html;
                        }

                    }
                }
            }
        }
    }
}

session_start();

require_once './menuReportes.php';
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
    </div>
</body>

</html>


