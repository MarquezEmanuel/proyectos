<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';
/* Vamos a crear un XML con XMLWriter a partir de la matriz anterior. 
  Lo vamos a crear usando programación orientada a objetos.
  Por lo tanto, empezamos creando un objeto de la clase XMLWriter. */

function data() {
    return $idTransaccion = $_POST['seleccionado'];
}

// Busca en BD transaccion
$idTransaccion = data();
$busca = "SELECT * FROM cuentasComitentes WHERE idCuentaComitente =" . $idTransaccion;
$dato = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $busca);
while ($datos = sqlsrv_fetch_array($dato, SQLSRV_FETCH_ASSOC)) {
    $fecha = utf8_encode($datos["fechaAccion"]);
    $estadoDepositante = utf8_encode($datos["estadoDepositante"]);
    $cuentaDepositante = utf8_encode($datos["cuentaDepositante"]);
    $cuentaComitente = utf8_encode($datos["cuentaComitente"]);
    $cantidadCliente = $datos["cantidadCliente"];
    $tipoAccion = utf8_encode($datos['tipoAccion']);
}

$objetoXML = new XMLWriter();

// Estructura básica del XML
$uri = URL_CuentaComitente . "\\cuentaComitente{$idTransaccion}.xml";

$objetoXML->openURI($uri);
$objetoXML->setIndent(true);
$objetoXML->setIndentString("\t");
$objetoXML->startDocument('1.0', 'ISO-8859-1');
// Inicio del nodo raíz
$objetoXML->startElement("Operacion");
$objetoXML->startElement("Cuentas_Comitentes");
$objetoXML->startAttribute("Version");
$objetoXML->text("1.0");
$objetoXML->endAttribute();


$objetoXML->startElement("Fecha_de_la_acci93n");
$objetoXML->text($fecha);
$objetoXML->endElement();


$objetoXML->startElement("Estado_de_la_cuenta_al_momento_de_realizar_la_acci93n");
$objetoXML->text($estadoDepositante);
$objetoXML->endElement();


$objetoXML->startElement("Cuenta_depositante_Nro");
$objetoXML->text($cuentaDepositante);
$objetoXML->endElement();


$objetoXML->startElement("Cuenta_comitente_Nro");
$objetoXML->text($cuentaComitente);
$objetoXML->endElement();


$objetoXML->startElement("Cantidad_de_clientes_y_otros_sujetos_vinculados_a_la_acci93n");
$objetoXML->text($cantidadCliente);
$objetoXML->endElement();


$objetoXML->startElement("Tipo_de_acci93n");
$objetoXML->text($tipoAccion);
$objetoXML->endElement();


// Busca en BD bajas de cuentas comitentes


$sql = "SELECT * FROM cuentasComitentesBajas WHERE idCuentaComitente = " . $idTransaccion;
$dato = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
if ($dato) {
    $dale = sqlsrv_has_rows($dato);
    if ($dale) {
        while ($datos = sqlsrv_fetch_array($dato, SQLSRV_FETCH_ASSOC)) {
            $vinculado = utf8_encode($datos['vinculado']);
            $tipoCliente = utf8_encode($datos['tipoCliente']);
            $cuil = utf8_encode($datos['cuil']);
            $tipoPersona = utf8_encode($datos['tipoPersona']);
            $apellido = utf8_encode($datos['apellido']);
            $nombre = utf8_encode($datos['nombre']);
            $tipoDocumento = utf8_encode($datos['tipoDocumento']);
            $numeroDocumento = utf8_encode($datos['numeroDocumento']);
            $denominacion = utf8_encode($datos['denominacion']);
            $fechaConstitucion = utf8_encode($datos['fechaConstitucion']);
            $riesgo = utf8_encode($datos['riesgo']);
            $naturalezaDelVinculo = utf8_encode($datos['naturalezaDelVinculo']);


            if ($vinculado === 'NO') {
                /*baja persona*/
                
                $objetoXML->startElement("IDENTIFICACI98N_DE_CLIENTES88Baja");

                $objetoXML->startElement("Tipo_Cliente88Baja");
                $objetoXML->text($tipoCliente);
                $objetoXML->endElement();

                $objetoXML->startElement("CUIT_CUIL_CDI_CIE88Baja");
                $objetoXML->text($cuil);
                $objetoXML->endElement();

                if ($tipoPersona === "Persona humana" || $tipoPersona === "Persona humana extranjera") {
                    /*baja persona humana*/
                    
                    $objetoXML->startElement("Tipo_de_Persona88BajaCliente");
                    $objetoXML->text($tipoPersona);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Apellidos88BajaClientePF");
                    $objetoXML->text($apellido);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Nombres88BajaClientePF");
                    $objetoXML->text($nombre);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Tipo_Documento88BajaClientePF");
                    $objetoXML->text($tipoDocumento);
                    $objetoXML->endElement();

                    $objetoXML->startElement("N94mero_Documento88BajaClientePF");
                    $objetoXML->text($numeroDocumento);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Riesgo_asignado_al_cliente88BajaCliente");
                    $objetoXML->text($riesgo);
                    $objetoXML->endElement();

                    $objetoXML->endElement();
                } else {
                    /*baja persona juridica*/
                    
                    $objetoXML->startElement("Tipo_de_Persona88BajaCliente");
                    $objetoXML->text($tipoPersona);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Denominaci93n88BajaClientePJ");
                    $objetoXML->text($denominacion);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Fecha_de_Constituci93n88BajaClientePJ");
                    $objetoXML->text($fechaConstitucion);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Riesgo_asignado_al_cliente88BajaCliente");
                    $objetoXML->text($riesgo);
                    $objetoXML->endElement();

                    $objetoXML->endElement();
                }
            } else {
                /*sujeto vinculado*/

                $objetoXML->startElement("IDENTIFICACI98N_DE_OTROS_SUJETOS_VINCULADOS_A_LA_ACCI98N88Baja");

                $objetoXML->startElement("Naturaleza_del_v92nculo_con_elX85Xlos_clientes88Baja");
                $objetoXML->text($naturalezaDelVinculo);
                $objetoXML->endElement();

                $objetoXML->startElement("CUIT_CUIL_CDI_CIE88VinculadoBaja");
                $objetoXML->text($cuil);
                $objetoXML->endElement();

                if ($tipoPersona === "Persona humana" || $tipoPersona === "Persona humana extranjera") {

                    /*baja vinculado humana*/
                    
                    $objetoXML->startElement("Tipo_de_Persona88VinculadoBaja");
                    $objetoXML->text($tipoPersona);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Apellidos88VinculadoBajaPF");
                    $objetoXML->text($apellido);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Nombres88VinculadoBajaPF");
                    $objetoXML->text($nombre);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Tipo_Documento8888VinculadoBajaPF");
                    $objetoXML->text($tipoDocumento);
                    $objetoXML->endElement();

                    $objetoXML->startElement("N94mero_Documento8888VinculadoBajaPF");
                    $objetoXML->text($numeroDocumento);
                    $objetoXML->endElement();

                    $objetoXML->endElement();
                } else {
                    /*baja vinculado juridica*/
                    
                    $objetoXML->startElement("Tipo_de_Persona88VinculadoBaja");
                    $objetoXML->text($tipoPersona);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Denominaci93n88VinculadoBajaPJ");
                    $objetoXML->text($denominacion);
                    $objetoXML->endElement();

                    if ($fechaConstitucion) {
                        $objetoXML->startElement("Fecha_de_Constituci93n88VinculadoBajaPJ");
                        $objetoXML->text($fechaConstitucion);
                        $objetoXML->endElement();
                    }

                    $objetoXML->endElement();
                }
            }
        }
    }
}


// Busca en BD altas de cuentas comitentes


$sql = "SELECT * FROM cuentasComitentesAltas WHERE idCuentaComitente =" . $idTransaccion;
$dato = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
if ($dato) {
    $dale = sqlsrv_has_rows($dato);
    if ($dale) {
        while ($datos = sqlsrv_fetch_array($dato, SQLSRV_FETCH_ASSOC)) {
            $vinculado = utf8_encode($datos['vinculado']);
            $tipoCliente = utf8_encode($datos['tipoCliente']);
            $cuil = utf8_encode($datos['cuil']);
            $tipoPersona = utf8_encode($datos['tipoPersona']);
            $apellido = utf8_encode($datos['apellido']);
            $nombre = utf8_encode($datos['nombre']);
            $tipoDocumento = utf8_encode($datos['tipoDocumento']);
            $numeroDocumento = utf8_encode($datos['numeroDocumento']);
            $genero = utf8_encode($datos['genero']);
            $nacionalidad = utf8_encode($datos['nacionalidad']);
            $paisNacimiento = utf8_encode($datos['paisNacimiento']);
            $lugarNacimiento = utf8_encode($datos['lugarNacimiento']);
            $fechaNacimiento = utf8_encode($datos['fechaNacimiento']);
            $declaraSerPEP = utf8_encode($datos['declaraSerPEP']);
            $denominacion = utf8_encode($datos['denominacion']);
            $fechaConstitucion = utf8_encode($datos['fechaConstitucion']);
            $riesgo = utf8_encode($datos['riesgo']);
            $pais = utf8_encode($datos['pais']);
            $provincia = utf8_encode($datos['provincia']);
            $localidad = utf8_encode($datos['localidad']);
            $calle = utf8_encode($datos['calle']);
            $numero = utf8_encode($datos['numero']);
            $piso = utf8_encode($datos['piso']);
            $departamento = utf8_encode($datos['departamento']);
            $otroPais = utf8_encode($datos['otroPais']);
            $provinciaEstado = utf8_encode($datos['provinciaEstado']);
            $localidadCiudad = utf8_encode($datos['localidadCiudad']);
            $domicilioDireccion = utf8_encode($datos['domicilioDireccion']);
            $codigoPostal = utf8_encode($datos['codigoPostal']);
            $codigoArea = utf8_encode($datos['codigoArea']);
            $telefono = utf8_encode($datos['telefono']);
            $correoElectronico = utf8_encode($datos['correoElectronico']);
            $naturalezaDelVinculo = utf8_encode($datos['naturalezaDelVinculo']);


            if ($vinculado === 'NO') {
                /*alta persona*/
                $objetoXML->startElement("IDENTIFICACI98N_DE_CLIENTES88Alta");

                $objetoXML->startElement("Tipo_Cliente88Alta");
                $objetoXML->text($tipoCliente);
                $objetoXML->endElement();

                $objetoXML->startElement("CUIT_CUIL_CDI_CIE88Alta");
                $objetoXML->text($cuil);
                $objetoXML->endElement();

                if ($tipoPersona === "Persona humana" || $tipoPersona === "Persona humana extranjera") {

                    /*alta persona humana*/
                    $objetoXML->startElement("Tipo_de_Persona88AltaCliente");
                    $objetoXML->text($tipoPersona);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Apellidos88AltaClientePF");
                    $objetoXML->text($apellido);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Nombres88AltaClientePF");
                    $objetoXML->text($nombre);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Tipo_Documento88AltaClientePF");
                    $objetoXML->text($tipoDocumento);
                    $objetoXML->endElement();

                    $objetoXML->startElement("N94mero_Documento88AltaClientePF");
                    $objetoXML->text($numeroDocumento);
                    $objetoXML->endElement();

                    $objetoXML->startElement("G91nero88AltaClientePF");
                    $objetoXML->text($genero);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Nacionalidad88AltaClientePF");
                    $objetoXML->text($nacionalidad);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Pa92s_de_nacimiento88AltaClientePF");
                    $objetoXML->text($paisNacimiento);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Lugar_de_nacimiento88AltaClientePF");
                    $objetoXML->text($lugarNacimiento);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Fecha_de_nacimiento88AltaClientePF");
                    $objetoXML->text($fechaNacimiento);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Declar93_ser_PEP88AltaCliente");
                    $objetoXML->text($declaraSerPEP);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Riesgo_asignado_al_cliente88AltaCliente");
                    $objetoXML->text($riesgo);
                    $objetoXML->endElement();

                    if ($pais === "Argentina") {
                        /*alta persona humana pais argentina*/
                        
                        $objetoXML->startElement("Pa92s88AltaCliente");
                        $objetoXML->text($pais);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Provincia88AltaClienteArg");
                        $objetoXML->text($provincia);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Localidad88AltaClienteArg");
                        $objetoXML->text($localidad);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Calle88AltaClienteArg");
                        $objetoXML->text($calle);
                        $objetoXML->endElement();

                        $objetoXML->startElement("N94mero88AltaClienteArg");
                        $objetoXML->text($numero);
                        $objetoXML->endElement();

                        if ($piso) {
                            $objetoXML->startElement("Piso88AltaClienteArg");
                            $objetoXML->text($piso);
                            $objetoXML->endElement();
                        }

                        if ($departamento) {
                            $objetoXML->startElement("Departamento88AltaClienteArg");
                            $objetoXML->text($departamento);
                            $objetoXML->endElement();
                        }
                    } else {
                        /*alta persona humana pais otro*/
                        
                        $objetoXML->startElement("Pa92s88AltaCliente");
                        $objetoXML->text($pais);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Otro_pa92s88AltaClienteExt");
                        $objetoXML->text($otroPais);
                        $objetoXML->endElement();

                        $objetoXML->startElement("ProvinciaX85XEstado88AltaClienteExt");
                        $objetoXML->text($provinciaEstado);
                        $objetoXML->endElement();

                        $objetoXML->startElement("LocalidadX85XCiudad88AltaClienteExt");
                        $objetoXML->text($localidadCiudad);
                        $objetoXML->endElement();

                        $objetoXML->startElement("DomicilioX85XDirecci93n88AltaClienteExt");
                        $objetoXML->text($domicilioDireccion);
                        $objetoXML->endElement();
                    }

                    if ($codigoPostal) {
                        $objetoXML->startElement("C93digo_Postal88AltaCliente");
                        $objetoXML->text($codigoPostal);
                        $objetoXML->endElement();
                    }

                    if ($codigoArea) {
                        $objetoXML->startElement("C93digo_de_90rea_telef93nico88AltaCliente");
                        $objetoXML->text($codigoArea);
                        $objetoXML->endElement();
                    }

                    if ($telefono) {
                        $objetoXML->startElement("Tel91fono88AltaCliente");
                        $objetoXML->text($telefono);
                        $objetoXML->endElement();
                    }

                    if ($correoElectronico) {
                        $objetoXML->startElement("Direcci93n_de_correo_electr93nico88AltaCliente");
                        $objetoXML->text($correoElectronico);
                        $objetoXML->endElement();
                    }

                    $objetoXML->endElement();
                } else {
                    /*alta persona juridica*/
                    $objetoXML->startElement("Tipo_de_Persona88AltaCliente");
                    $objetoXML->text($tipoPersona);
                    $objetoXML->endElement();
                    
                    $objetoXML->startElement("Denominaci93n88AltaClientePJ");
                    $objetoXML->text($denominacion);
                    $objetoXML->endElement();
                    
                    $objetoXML->startElement("Fecha_de_Constituci93n88AltaClientePJ");
                    $objetoXML->text($fechaConstitucion);
                    $objetoXML->endElement();
                    
                    $objetoXML->startElement("Riesgo_asignado_al_cliente88AltaCliente");
                    $objetoXML->text($riesgo);
                    $objetoXML->endElement();
                    
                    if ($pais === "Argentina") {
                        /*alta persona juridica pais argentina*/
                        
                        $objetoXML->startElement("Pa92s88AltaCliente");
                        $objetoXML->text($pais);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Provincia88AltaClienteArg");
                        $objetoXML->text($provincia);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Localidad88AltaClienteArg");
                        $objetoXML->text($localidad);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Calle88AltaClienteArg");
                        $objetoXML->text($calle);
                        $objetoXML->endElement();

                        $objetoXML->startElement("N94mero88AltaClienteArg");
                        $objetoXML->text($numero);
                        $objetoXML->endElement();

                        if ($piso) {
                            $objetoXML->startElement("Piso88AltaClienteArg");
                            $objetoXML->text($piso);
                            $objetoXML->endElement();
                        }

                        if ($departamento) {
                            $objetoXML->startElement("Departamento88AltaClienteArg");
                            $objetoXML->text($departamento);
                            $objetoXML->endElement();
                        }
                    } else {
                        /*alta persona juridica pais otro*/
                        
                        $objetoXML->startElement("Pa92s88AltaCliente");
                        $objetoXML->text($pais);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Otro_pa92s88AltaClienteExt");
                        $objetoXML->text($otroPais);
                        $objetoXML->endElement();

                        $objetoXML->startElement("ProvinciaX85XEstado88AltaClienteExt");
                        $objetoXML->text($provinciaEstado);
                        $objetoXML->endElement();

                        $objetoXML->startElement("LocalidadX85XCiudad88AltaClienteExt");
                        $objetoXML->text($localidadCiudad);
                        $objetoXML->endElement();

                        $objetoXML->startElement("DomicilioX85XDirecci93n88AltaClienteExt");
                        $objetoXML->text($domicilioDireccion);
                        $objetoXML->endElement();
                    }

                    if ($codigoPostal) {
                        $objetoXML->startElement("C93digo_Postal88AltaCliente");
                        $objetoXML->text($codigoPostal);
                        $objetoXML->endElement();
                    }

                    if ($codigoArea) {
                        $objetoXML->startElement("C93digo_de_90rea_telef93nico88AltaCliente");
                        $objetoXML->text($codigoArea);
                        $objetoXML->endElement();
                    }

                    if ($telefono) {
                        $objetoXML->startElement("Tel91fono88AltaCliente");
                        $objetoXML->text($telefono);
                        $objetoXML->endElement();
                    }

                    if ($correoElectronico) {
                        $objetoXML->startElement("Direcci93n_de_correo_electr93nico88AltaCliente");
                        $objetoXML->text($correoElectronico);
                        $objetoXML->endElement();
                    }

                    $objetoXML->endElement();
                    
                }
            } else {
                /*alta cliente vinculado*/
                
                $objetoXML->startElement("IDENTIFICACI98N_DE_OTROS_SUJETOS_VINCULADOS_A_LA_ACCI98N88Alta");

                $objetoXML->startElement("Naturaleza_del_v92nculo_con_elX85Xlos_clientes88Alta");
                $objetoXML->text($naturalezaDelVinculo);
                $objetoXML->endElement();

                if($cuil){
                $objetoXML->startElement("CUIT_CUIL_CDI_CIE88VinculadoAlta");
                $objetoXML->text($cuil);
                $objetoXML->endElement();
                }
                
                if ($tipoPersona === "Persona humana" || $tipoPersona === "Persona humana extranjera") {
                    /*alta cliente vinculado humano*/
                    
                    $objetoXML->startElement("Tipo_de_Persona88VinculadoAlta");
                    $objetoXML->text($tipoPersona);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Apellidos88VinculadoAltaPF");
                    $objetoXML->text($apellido);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Nombres88VinculadoAltaPF");
                    $objetoXML->text($nombre);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Tipo_Documento8888VinculadoAltaPF");
                    $objetoXML->text($tipoDocumento);
                    $objetoXML->endElement();

                    $objetoXML->startElement("N94mero_Documento8888VinculadoAltaPF");
                    $objetoXML->text($numeroDocumento);
                    $objetoXML->endElement();

                    $objetoXML->startElement("G91nero88VinculadoAltaPF");
                    $objetoXML->text($genero);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Nacionalidad88VinculadoAltaPF");
                    $objetoXML->text($nacionalidad);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Pa92s_de_nacimiento88VinculadoAltaPF");
                    $objetoXML->text($paisNacimiento);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Lugar_de_nacimiento88VinculadoAltaPF");
                    $objetoXML->text($lugarNacimiento);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Fecha_de_nacimiento88VinculadoAltaPF");
                    $objetoXML->text($fechaNacimiento);
                    $objetoXML->endElement();
                    
                    if ($pais === "Argentina") {
                        /*alta cliente vinculado humano pais argentina*/
                        
                        $objetoXML->startElement("Pa92s88VinculadoAlta");
                        $objetoXML->text($pais);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Provincia88VinculadoAltaArg");
                        $objetoXML->text($provincia);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Localidad88VinculadoAltaArg");
                        $objetoXML->text($localidad);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Calle88VinculadoAltaArg");
                        $objetoXML->text($calle);
                        $objetoXML->endElement();

                        $objetoXML->startElement("N94mero88VinculadoAltaArg");
                        $objetoXML->text($numero);
                        $objetoXML->endElement();

                        if ($piso) {
                            $objetoXML->startElement("Piso88VinculadoAltaArg");
                            $objetoXML->text($piso);
                            $objetoXML->endElement();
                        }

                        if ($departamento) {
                            $objetoXML->startElement("Departamento88VinculadoAltaArg");
                            $objetoXML->text($departamento);
                            $objetoXML->endElement();
                        }
                    } else {
                        /*alta cliente vinculado humano pais otro*/
                        
                        $objetoXML->startElement("Pa92s88VinculadoAlta");
                        $objetoXML->text($pais);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Otro_pa92s88VinculadoAltaExt");
                        $objetoXML->text($otroPais);
                        $objetoXML->endElement();

                        $objetoXML->startElement("ProvinciaX85XEstado88VinculadoAltaExt");
                        $objetoXML->text($provinciaEstado);
                        $objetoXML->endElement();

                        $objetoXML->startElement("LocalidadX85XCiudad88VinculadoAltaExt");
                        $objetoXML->text($localidadCiudad);
                        $objetoXML->endElement();

                        $objetoXML->startElement("DomicilioX85XDirecci93n88VinculadoAltaExt");
                        $objetoXML->text($domicilioDireccion);
                        $objetoXML->endElement();
                    }

                    if ($codigoPostal) {
                        $objetoXML->startElement("C93digo_Postal88VinculadoAlta");
                        $objetoXML->text($codigoPostal);
                        $objetoXML->endElement();
                    }

                    if ($codigoArea) {
                        $objetoXML->startElement("C93digo_de_90rea_telef93nico88VinculadoAlta");
                        $objetoXML->text($codigoArea);
                        $objetoXML->endElement();
                    }

                    if ($telefono) {
                        $objetoXML->startElement("Tel91fono88VinculadoAlta");
                        $objetoXML->text($telefono);
                        $objetoXML->endElement();
                    }

                    if ($correoElectronico) {
                        $objetoXML->startElement("Direcci93n_de_correo_electr93nico88VinculadoAlta");
                        $objetoXML->text($correoElectronico);
                        $objetoXML->endElement();
                    }

                    $objetoXML->endElement();
                    
                }else{
                    /*alta cliente vinculado juridica*/
                    
                    $objetoXML->startElement("Tipo_de_Persona88VinculadoAlta");
                    $objetoXML->text($tipoPersona);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Denominaci93n88VinculadoAltaPJ");
                    $objetoXML->text($denominacion);
                    $objetoXML->endElement();

                    $objetoXML->startElement("Fecha_de_Constituci93n88VinculadoAltaPJ");
                    $objetoXML->text($fechaConstitucion);
                    $objetoXML->endElement();
                    
                    if ($pais === "Argentina") {
                        /*alta cliente vinculado juridico pais argentina*/
                        
                        $objetoXML->startElement("Pa92s88VinculadoAlta");
                        $objetoXML->text($pais);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Provincia88VinculadoAltaArg");
                        $objetoXML->text($provincia);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Localidad88VinculadoAltaArg");
                        $objetoXML->text($localidad);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Calle88VinculadoAltaArg");
                        $objetoXML->text($calle);
                        $objetoXML->endElement();

                        $objetoXML->startElement("N94mero88VinculadoAltaArg");
                        $objetoXML->text($numero);
                        $objetoXML->endElement();

                        if ($piso) {
                            $objetoXML->startElement("Piso88VinculadoAltaArg");
                            $objetoXML->text($piso);
                            $objetoXML->endElement();
                        }

                        if ($departamento) {
                            $objetoXML->startElement("Departamento88VinculadoAltaArg");
                            $objetoXML->text($departamento);
                            $objetoXML->endElement();
                        }
                    } else {
                        /*alta cliente vinculado juridico pais otro*/
                        
                        $objetoXML->startElement("Pa92s88VinculadoAlta");
                        $objetoXML->text($pais);
                        $objetoXML->endElement();

                        $objetoXML->startElement("Otro_pa92s88VinculadoAltaExt");
                        $objetoXML->text($otroPais);
                        $objetoXML->endElement();

                        $objetoXML->startElement("ProvinciaX85XEstado88VinculadoAltaExt");
                        $objetoXML->text($provinciaEstado);
                        $objetoXML->endElement();

                        $objetoXML->startElement("LocalidadX85XCiudad88VinculadoAltaExt");
                        $objetoXML->text($localidadCiudad);
                        $objetoXML->endElement();

                        $objetoXML->startElement("DomicilioX85XDirecci93n88VinculadoAltaExt");
                        $objetoXML->text($domicilioDireccion);
                        $objetoXML->endElement();
                    }

                    if ($codigoPostal) {
                        $objetoXML->startElement("C93digo_Postal88VinculadoAlta");
                        $objetoXML->text($codigoPostal);
                        $objetoXML->endElement();
                    }

                    if ($codigoArea) {
                        $objetoXML->startElement("C93digo_de_90rea_telef93nico88VinculadoAlta");
                        $objetoXML->text($codigoArea);
                        $objetoXML->endElement();
                    }

                    if ($telefono) {
                        $objetoXML->startElement("Tel91fono88VinculadoAlta");
                        $objetoXML->text($telefono);
                        $objetoXML->endElement();
                    }

                    if ($correoElectronico) {
                        $objetoXML->startElement("Direcci93n_de_correo_electr93nico88VinculadoAlta");
                        $objetoXML->text($correoElectronico);
                        $objetoXML->endElement();
                    }

                    $objetoXML->endElement();
                    
                }
            }
        }
    }
}

$objetoXML->endElement();
$objetoXML->endElement();
$objetoXML->endDocument();
?>


<body>
    <div class="container">
        <div id="contenido4">
            <div class="card-header">
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-12 text-center">
                        <h1 class="h3 mb-3 font-weight-normal text-blue">XML GENERADO CON EXITO</h1>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <h3 class="h3 mb-3 font-weight-normal text-blue">DESCARGAR:</h3>
                        <form action='procesarDescargarCuentaComitente.php' method='POST'>
                            <input type='hidden' name='idOperacion' value='<?php echo $idTransaccion; ?>'>
                            <button class='btn btn-sm btn-outline-info'><img src='../../lib/img/xml.png' name= '<?php echo $idTransaccion; ?>' width='38' height='38' >  </button>
                        </form>
                    </div>
                    <div class="col-lg-2 text-center">
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="cargarCuentaComitente.php">
                            <button class="btn btn-lg btn-bsc btn-block" type="submit">Salir</button>
                        </a>
                    </div>
                    <div class="col-lg-2 text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


