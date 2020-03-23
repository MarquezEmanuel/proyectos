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
$busca = "SELECT * FROM transaccion WHERE idTransaccion =" . $idTransaccion;
$dato = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $busca);
while ($datos = sqlsrv_fetch_array($dato, SQLSRV_FETCH_ASSOC)) {
    $fecha = utf8_encode($datos["fecha"]);
    $provincia = utf8_encode($datos["provincia"]);
    $localidad = utf8_encode($datos["localidad"]);
    $calle = utf8_encode($datos["calle"]);
    $numero = $datos["numero"];
    $operacion = utf8_encode($datos['operacion']);
    $transaccion = utf8_encode($datos['transaccion']);
    $moneda = utf8_encode($datos['moneda']);
    $monto = $datos["monto"];
    $equivalente = $datos["equivalente"];
}

$objetoXML = new XMLWriter();

// Estructura básica del XML
$uri = URL_RTEOC . "\\CVME{$idTransaccion}.xml";

$objetoXML->openURI($uri);
$objetoXML->setIndent(true);
$objetoXML->setIndentString("\t");
$objetoXML->startDocument('1.0', 'ISO-8859-1');
// Inicio del nodo raíz
$objetoXML->startElement("Operacion");
$objetoXML->startElement("DATOS_GENERALES_DE_LA_TRANSACCI98N88Reporte_de_transacci93n_en_efectivo_operaciones_de_cambio");
$objetoXML->startAttribute("Version");
$objetoXML->text("1.0");
$objetoXML->endAttribute();


$objetoXML->startElement("Fecha_de_la_transacci93n");
$objetoXML->text($fecha);
$objetoXML->endElement();


$objetoXML->startElement("Provincia");
$objetoXML->text($provincia);
$objetoXML->endElement();


$objetoXML->startElement("Localidad");
$objetoXML->text($localidad);
$objetoXML->endElement();


$objetoXML->startElement("Calle");
$objetoXML->text($calle);
$objetoXML->endElement();


$objetoXML->startElement("N94mero");
$objetoXML->text($numero);
$objetoXML->endElement();


$objetoXML->startElement("Operaci93n_que_origin93_la_transacci93n_en_efectivo");
$objetoXML->text($operacion);
$objetoXML->endElement();


$objetoXML->startElement("Transacci93n_a_reportar");
$objetoXML->text($transaccion);
$objetoXML->endElement();

if ($transaccion == "Entidad Entrega Efectivo") {
    $objetoXML->startElement("ENTIDAD_ENTREGA_EFECTIVO");

    $objetoXML->startElement("Tipo_de_moneda_entregada_al_operador88ENTIDAD_ENTREGA_EFECTIVO");
    $objetoXML->text($moneda);
    $objetoXML->endElement();

    $objetoXML->startElement("Monto_entregado_al_operador88ENTIDAD_ENTREGA_EFECTIVO");
    $objetoXML->text($monto);
    $objetoXML->endElement();

    $objetoXML->startElement("Equivalente_en_pesos_Argentinos88ENTIDAD_ENTREGA_EFECTIVO");
    $objetoXML->text($equivalente);
    $objetoXML->endElement();

    $objetoXML->endElement();
} else {
    $objetoXML->startElement("ENTIDAD_RECIBE_EFECTIVO");

    $objetoXML->startElement("Tipo_de_moneda_recibida_del_operador88ENTIDAD_RECIBE_EFECTIVO");
    $objetoXML->text($moneda);
    $objetoXML->endElement();

    $objetoXML->startElement("Monto_recibido_del_operador88ENTIDAD_RECIBE_EFECTIVO");
    $objetoXML->text($monto);
    $objetoXML->endElement();

    $objetoXML->startElement("Equivalente_en_pesos_Argentinos88ENTIDAD_RECIBE_EFECTIVO");
    $objetoXML->text($equivalente);
    $objetoXML->endElement();

    $objetoXML->endElement();
}





// Busca en BD vinculado juridico

$sql = "SELECT * FROM vinculado WHERE nombre IS NULL AND idTransaccion =" . $idTransaccion;
$dato = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
if ($dato) {
    $dale = sqlsrv_has_rows($dato);
    if ($dale) {
        while ($datos = sqlsrv_fetch_array($dato, SQLSRV_FETCH_ASSOC)) {
            $operadorJuridica = utf8_encode($datos['operador']);
            $identificacionJuridica = utf8_encode($datos['identificacion']);
            $cuitJuridica = $datos['cuit'];
            $denominacionJuridica = utf8_encode($datos['apellidoDenominacion']);
            $personaJuridica = "Persona Jurídica";



            $objetoXML->startElement("IDENTIFICACI98N_SUJETOS_VINCULADOS_A_LA_TRANSACCI98N");

            $objetoXML->startElement("El_operador_es_el_cliente_a_nombre_de_quien_se_registra_la_operaci93n");
            $objetoXML->text($operadorJuridica);
            $objetoXML->endElement();

            $objetoXML->startElement("Identificaci93n_de_intervinientes_en_la_operaci93n");
            $objetoXML->text($identificacionJuridica);
            $objetoXML->endElement();

            $objetoXML->startElement("CUIT_CUIL_CDI88sujetovinculo");
            $objetoXML->text($cuitJuridica);
            $objetoXML->endElement();

            $objetoXML->startElement("Tipo_de_persona88sujetovinculo");
            $objetoXML->text($personaJuridica);
            $objetoXML->endElement();

            $objetoXML->startElement("Denominacion88sujetovinculo");
            $objetoXML->text($denominacionJuridica);
            $objetoXML->endElement();

            $objetoXML->endElement();
        }
    }
}





// Busca en BD vinculado fisico


$sql = "SELECT * FROM vinculado WHERE nombre IS NOT NULL AND idTransaccion =" . $idTransaccion;
$dato = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
if ($dato) {
    $dale = sqlsrv_has_rows($dato);
    if ($dale) {
        while ($datos = sqlsrv_fetch_array($dato, SQLSRV_FETCH_ASSOC)) {
            $operador = utf8_encode($datos['operador']);
            $identificacion = utf8_encode($datos['identificacion']);
            $cuit = $datos['cuit'];
            $persona = "Persona Física";
            $apellido = utf8_encode($datos['apellidoDenominacion']);
            $nombres = utf8_encode($datos['nombre']);
            $tipo = utf8_encode($datos['tipoDocumento']);
            $numeroDocumento = $datos['numeroDocumento'];

            $objetoXML->startElement("IDENTIFICACI98N_SUJETOS_VINCULADOS_A_LA_TRANSACCI98N");

            $objetoXML->startElement("El_operador_es_el_cliente_a_nombre_de_quien_se_registra_la_operaci93n");
            $objetoXML->text($operador);
            $objetoXML->endElement();

            $objetoXML->startElement("Identificaci93n_de_intervinientes_en_la_operaci93n");
            $objetoXML->text($identificacion);
            $objetoXML->endElement();

            $objetoXML->startElement("CUIT_CUIL_CDI88sujetovinculo");
            $objetoXML->text($cuit);
            $objetoXML->endElement();

            $objetoXML->startElement("Tipo_de_persona88sujetovinculo");
            $objetoXML->text($persona);
            $objetoXML->endElement();

            $objetoXML->startElement("Apellidos88sujetovinculo");
            $objetoXML->text($apellido);
            $objetoXML->endElement();

            $objetoXML->startElement("Nombres88sujetovinculo");
            $objetoXML->text($nombres);
            $objetoXML->endElement();

            $objetoXML->startElement("Tipo_Documento88sujetovinculo");
            $objetoXML->text($tipo);
            $objetoXML->endElement();

            if (strlen($numeroDocumento) != 8) {
                $objetoXML->startElement("N94mero_Documento88sujetovinculo");
                $objetoXML->text("0" . $numeroDocumento);
                $objetoXML->endElement();
            } else {
                $objetoXML->startElement("N94mero_Documento88sujetovinculo");
                $objetoXML->text($numeroDocumento);
                $objetoXML->endElement();
            }


            $objetoXML->endElement();
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
                            <form action='procesarDescargarRTEOC.php' method='POST'>
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
                            <a href="inicioReportes.php">
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


