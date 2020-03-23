<?php

require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();

if (isset($_POST['transacciones'])) {

    $transacciones = $_POST['transacciones'];

    $archivos = array();

    foreach ($transacciones as $referencia) {

        $params = array();
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);

        $queryTransaccion = "SELECT * FROM rte_transaccion WHERE referencia='" . $referencia . "'";
        $queryVinculado = "SELECT * FROM rte_vinculado WHERE referencia='" . $referencia . "' ORDER BY CASE WHEN relacionFondo = 'Operador' THEN 1 WHEN relacionFondo = 'Operador/Titular' THEN 2 WHEN relacionFondo = 'Titular' THEN 3 WHEN relacionFondo = 'Vinculado al producto operado' THEN 4 END";
        $queryCantidad = "select referencia, count(*) cantidad  from rte_vinculado  where (relacionFondo = 'Vinculado al producto operado' OR (relacionFondo IN ('Operador/Titular','Titular','Operador') AND relacionProducto = 'SI') ) and referencia='$referencia' GROUP BY referencia";
        
        $resultOperacion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryTransaccion);
        $resultSujetos = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryVinculado, $params, $options);
        $resultCantidad = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCantidad);
        
        if ($resultOperacion && $resultSujetos && $resultCantidad) {

            $cantidad = sqlsrv_fetch_array($resultCantidad);
            $operacion = sqlsrv_fetch_array($resultOperacion);

            $objetoXML = new XMLWriter();

            $uri = URL_RTE . "\\RTE{$referencia}.xml";

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
            $objetoXML->text($operacion['montoOrigen']);
            $objetoXML->endElement();

            $objetoXML->startElement("Monto_total_operado_en_efectivo_en_pesos_o_su_equivalente");
            $objetoXML->text($operacion['montoPesos']);
            $objetoXML->endElement();

            $objetoXML->startElement("Cantidad_personas_vinculados_al_producto88DatosOperacion");
            $objetoXML->text($cantidad['cantidad']);
            $objetoXML->endElement();

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
                $objetoXML->text($sujeto['cuil']);
                $objetoXML->endElement();

                $tipoPersona = utf8_encode($sujeto['tipoPersona']);

                $objetoXML->startElement("Tipo_de_persona88sujetovinculo");
                $objetoXML->text($tipoPersona);
                $objetoXML->endElement();

                if ($tipoPersona == "Persona física") {
                    $objetoXML->startElement("Apellidos88sujetovinculo");
                    $objetoXML->text(utf8_encode($sujeto['apellido']));
                    $objetoXML->endElement();

                    $objetoXML->startElement("Nombres88sujetovinculo");
                    $objetoXML->text(utf8_encode($sujeto['nombre']));
                    $objetoXML->endElement();

                    $objetoXML->startElement("Tipo_Documento88sujetovinculo");
                    $objetoXML->text(utf8_encode($sujeto['tipoDocumento']));
                    $objetoXML->endElement();
                    
                    $documento =  $sujeto['numeroDocumento'];
                    $documento = ($documento[0] === '0') ? substr($documento, 1): $documento;

                    $objetoXML->startElement("N94mero_Documento88sujetovinculo");
                    $objetoXML->text($documento);
                    $objetoXML->endElement();
                } else {
                    $objetoXML->startElement("Denominacion88sujetovinculo");
                    $objetoXML->text(utf8_encode($sujeto['apellido']));
                    $objetoXML->endElement();
                }
                $objetoXML->endElement();
            }

            $objetoXML->endElement(); /* CIERRA DATOS GENERALES */

            $objetoXML->endElement(); /* CIERRA OPERACION */

            $archivos[] = $referencia;
        } else {
            $log = new Log();
            $log->writeLine("[Error al consultar la base de datos][QUERY: $queryTransaccion][QUERY: $queryVinculado]");
        }
    }
    $recibidos = count($transacciones);
    $procesados = count($archivos);
    if ($procesados > 0) {
        echo '
        <br>
        <h4 class="text-center p-4">GENERAR ARCHIVOS XML</h4>
        <div class="container">
            <div class="alert alert-success text-center" role="alert"> Cantidad de archivos procesados: ' . $procesados . ' de ' . $recibidos . ' </div>
            <form action="procesarDescargarRTE.php" method="post">';
        foreach ($archivos as $referencia) {
            echo "<input type='hidden' id='transacciones' name='transacciones[]' value='{$referencia}'>";
        }
        echo '
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-success" value="Descargar">
                            <a href="formBuscarRTE.php">
                                <input type="button" class="btn btn-outline-secondary" value="Cancelar">
                            </a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>';
    } else {
        echo '<br>
        <h4 class="text-center p-4">GENERAR ARCHIVOS XML</h4>
        <div class="container">
            <div class="alert alert-warning text-center" role="alert"> Cantidad de archivos procesados: ' . $procesados . ' de ' . $recibidos . ' </div>
        </div>';
    }
} else {
    echo '<br>
    <h4 class="text-center p-4">GENERAR ARCHIVOS XML</h4>
    <div class="container">
        <div class="alert alert-danger text-center" role="alert"> No se recibieron transacciones para procesar </div>
    </div>';
}







