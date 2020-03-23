<?php

require_once '../conf/Constants.php';
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();

$idOperacion = $_POST['idOperacion'];

$query = "SELECT * FROM rte_operacion WHERE idOperacion=" . $idOperacion;
$resultOperacion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$query = "SELECT * FROM rte_sujeto WHERE idOperacion=" . $idOperacion;
$resultSujetos = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

if ($resultOperacion && $resultSujetos) {

    $operacion = sqlsrv_fetch_array($resultOperacion);

    $objetoXML = new XMLWriter();

    $uri = URL_RTEPF . "\\RTEPF{$operacion['idOperacion']}.xml";

    $objetoXML->openURI($uri);
    $objetoXML->setIndent(true);
    $objetoXML->setIndentString("\t");
    $objetoXML->startDocument('1.0', 'ISO-8859-1');
    $objetoXML->startElement("Operacion");

    $objetoXML->startElement("DATOS_GENERALES_DE_LA_TRANSACCI98N88Reporte_de_transacci93n_en_efectivo");
    $objetoXML->writeAttribute('Version', '1.1');

    $objetoXML->startElement("Fecha_de_la_transacci93n");
    $objetoXML->text($operacion['fecha']->format('Y-m-d') . "T00:00:00");
    $objetoXML->endElement();

    $objetoXML->startElement("Tipo_de_transacci93n");
    if (utf8_encode($operacion['tipo']) == "Depósito") {
        $objetoXML->text("Depósito");
    } else {
        $objetoXML->text("Extracción");
    }
    $objetoXML->endElement();

    $objetoXML->startElement("Moneda_de_origen");
    $objetoXML->text(utf8_encode($operacion['moneda']));
    $objetoXML->endElement();

    $objetoXML->startElement("Monto_total_operado_en_efectivo_moneda_de_origen");
    $objetoXML->text($operacion['montoMo']);
    $objetoXML->endElement();

    $objetoXML->startElement("Monto_total_operado_en_efectivo_en_pesos_o_su_equivalente");
    $objetoXML->text($operacion['montoPesos']);
    $objetoXML->endElement();

    $objetoXML->startElement("Cantidad_personas_vinculados_al_producto88DatosOperacion");
    $objetoXML->text($operacion['numeroPersonas']);
    $objetoXML->endElement();

    if (utf8_encode($operacion['tipo']) == "Depósito") {
        $objetoXML->startElement("Provincia");
        $objetoXML->text(utf8_encode($operacion['provincia']));
        $objetoXML->endElement();

        $objetoXML->startElement("Localidad");
        $objetoXML->text(utf8_encode($operacion['localidad']));
        $objetoXML->endElement();

        $objetoXML->startElement("Calle");
        $objetoXML->text(utf8_encode($operacion['calle']));
        $objetoXML->endElement();

        $objetoXML->startElement("N94mero");
        $objetoXML->text($operacion['numero']);
        $objetoXML->endElement();
    }

    while ($sujeto = sqlsrv_fetch_array($resultSujetos, SQLSRV_FETCH_ASSOC)) {

        $objetoXML->startElement("SUJETOS_VINCULADOS_A_LA_TRANSACCI98N");

        $objetoXML->startElement("Relacion_con_los_fondos88sujetovinculo");
        $objetoXML->text($sujeto['relacionFondo']);
        $objetoXML->endElement();

        if ($sujeto['relacionFondo'] != "Vinculado al producto operado") {
            $objetoXML->startElement("Relaci93n_con_el_producto88sujetovinculo");
            $objetoXML->text($sujeto['relacionProducto']);
            $objetoXML->endElement();
        }

        $objetoXML->startElement("CUIT_CUIL_CDI88sujetovinculo");
        $objetoXML->text($sujeto['cuit']);
        $objetoXML->endElement();

        $tipoPersona = utf8_encode($sujeto['tipoPersona']);

        $objetoXML->startElement("Tipo_de_persona88sujetovinculo");
        $objetoXML->text($tipoPersona);
        $objetoXML->endElement();

        if ($tipoPersona == "Persona física") {
            $objetoXML->startElement("Apellidos88sujetovinculo");
            $objetoXML->text(utf8_encode($sujeto['apellidos']));
            $objetoXML->endElement();

            $objetoXML->startElement("Nombres88sujetovinculo");
            $objetoXML->text(utf8_encode($sujeto['nombres']));
            $objetoXML->endElement();

            $objetoXML->startElement("Tipo_Documento88sujetovinculo");
            $objetoXML->text(utf8_encode($sujeto['tipoDocumento']));
            $objetoXML->endElement();

            $objetoXML->startElement("N94mero_Documento88sujetovinculo");
            $objetoXML->text($sujeto['numeroDocumento']);
            $objetoXML->endElement();
        } else {
            $objetoXML->startElement("Denominacion88sujetovinculo");
            $objetoXML->text(utf8_encode($sujeto['apellidos']));
            $objetoXML->endElement();
        }
        $objetoXML->endElement();
    }

    $objetoXML->endElement(); /* CIERRA DATOS GENERALES */

    $objetoXML->endElement(); /* CIERRA OPERACION */

    require_once './menuReportes.php';
    echo '
            <div>
                <div id="contenido" class="container">
                    <h4 class="text-center p-4">XML PARA REPORTE TRANSACCIÓN EN EFECTIVO</h4>
                    <div class="alert alert-success text-center" role="alert"> Se ha generado el archivo XML para el RTE </div>
                    <form action="procesarDescargarRTEPF.php" method="POST">
                        <input type="hidden" id="idOperacion" name="idOperacion" value="' . $operacion['idOperacion'] . '">
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <input type="submit" class="btn btn-success"  value="Descargar">
                                </div>
                            </div>
                        </div>   
                    </form>
                </div>
            </div>
        </body>
    </html>';
} else {
    require_once './menuReportes.php';
    echo '
            <div>
                <div id="contenido" class="container">
                    <h4 class="text-center p-4">XML PARA REPORTE TRANSACCIÓN EN EFECTIVO</h4>
                    <div class="alert alert-success text-center" role="alert"> No se pudo realizar la búsqueda del RTE </div>
                </div>
            </div>
        </body>
    </html>';
}



