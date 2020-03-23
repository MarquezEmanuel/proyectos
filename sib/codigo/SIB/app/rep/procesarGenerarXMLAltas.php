<?php
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';


/* INICIALIZA LA SESION */
session_start();
$queryTransaccion = 'SELECT * FROM [192.168.250.251].[ORAPROXY].[dbo].[SIB_AltasXML]';
$resultOperacion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryTransaccion);

$tipoDocumento = "Tipo de documento no encontrado";
 
$zip = new ZipArchive();
$filename = 'altasXML.zip';

$errores = array();

if (!is_dir("./altasXML")) {
    mkdir("./altasXML");
}

if (sqlsrv_has_rows($resultOperacion)) {

	 while ($row = sqlsrv_fetch_array($resultOperacion, SQLSRV_FETCH_ASSOC)) {
		
		$objetoXML = new XMLWriter();
				
		if($row['documento'] != null) {
		
			$queryScoIdent = "SELECT * FROM OPENQUERY (M4000SF, 'SELECT SCO_IDENT FROM SFB_BSADO WHERE SNU_DOCUM = ".$row['documento']."')";
		
			$resultScoIdent = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryScoIdent);
				if (sqlsrv_has_rows($resultScoIdent)) {
					while ($row2 = sqlsrv_fetch_array($resultScoIdent, SQLSRV_FETCH_ASSOC)) {
				
						$sco_ident = "0".$row2['SCO_IDENT'];
						$sco_identTrim = ltrim($sco_ident, "0");
						$nombreXML = "./altasXML/Fisicas#".$sco_identTrim.".xml";
						$tipoDocumento = getTipoDoc($sco_identTrim);
							
						}
				}
				else{
				$nombreXML = "./altasXML/Fisicas#".$row['apellido'].$row['primer_nombre']."_scoidentNULO.xml";
				$nombreArchivo = ltrim($nombreXML, "./altasXML/");
				 array_push($errores, "No se ha encontrado el n&uacute;mero de cliente - Revisar archivo: ".$nombreArchivo);
				}
		}
		else{
				$nombreXML = "./altasXML/Fisicas#".$row['apellido'].$row['primer_nombre']."_cuitNULO.xml";
				$nombreArchivo = ltrim($nombreXML, "./altasXML/");
				$row['documento'] = "00000000000";
				array_push($errores, "No se ha encontrado el CUIT/CUIL del cliente - Revisar archivo: ".$nombreArchivo);
		}
			
		
		$objetoXML->openURI($nombreXML);
		$objetoXML->setIndent(true);
		$objetoXML->setIndentString("\t");
		$objetoXML->startDocument('1.0', 'ISO-8859-1', 'no');
	
		$objetoXML->startElement("Operacion");
		$objetoXML->startElement("Entidades_Financieras_Alta_Cliente_Persona_F92sica");
		$objetoXML->writeAttribute("Version", "1.1"); 
		
		$objetoXML->startElement("Apellido");
		$objetoXML->text(utf8_encode($row['apellido']));
		$objetoXML->endElement();
		
		$objetoXML->startElement("Nombre");
		$objetoXML->text(utf8_encode($row['primer_nombre']));
		$objetoXML->endElement();
		
		$objetoXML->startElement("Segundo_Nombre");
		$objetoXML->text( utf8_encode($row['segundo_nombre']));
		$objetoXML->endElement();
		
		$objetoXML->startElement("Tipo_Documento");
		$objetoXML->text(utf8_encode($tipoDocumento));
		$objetoXML->endElement();
		
		$objetoXML->startElement("N94mero_Documento");
		$objetoXML->text(utf8_encode(substr($row['documento'] ,2 ,8 )));
		$objetoXML->endElement();
		
		$objetoXML->startElement("Nro_de_CUIT_CUIL_CDI");
		$objetoXML->text(utf8_encode($row['documento']));
		$objetoXML->endElement();
		
			
		$objetoXML->startElement("Fecha_de_Alta");
		$objetoXML->text(utf8_encode(formateaFecha($row['fecha_alta'])));
		$objetoXML->endElement();
		
		$objetoXML->startElement("Productos_Activos");
				$objetoXML->startElement("Producto");
				$objetoXML->text(utf8_encode($row['producto_activos']));
				$objetoXML->endElement();
		$objetoXML->endElement();
		
		$objetoXML->endElement(); 
		$objetoXML->endElement(); 
		$objetoXML->fullEndElement();
		$objetoXML->endDocument();
		$objetoXML->flush();	
		
		if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {
        $zip->addFile($nombreXML);			
		}
	   } 
	   
$zip->close();
require_once './menuReportes.php';
    echo '
            <div>
                <div id="contenido" class="container">
                    <h4 class="text-center p-4">XML Altas</h4>
                    <div class="alert alert-success text-center" role="alert"> Se han generado los archivos XML </div>
					';
					
					foreach($errores as $error){
					echo '
					<div class="alert alert-warning text-center" role="alert">'. $error.'</div>
					';
					}
					echo 
					'
                    <form action="descargarXMLAltas.php" method="POST">
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
	   
}
else{
require_once './menuReportes.php';
    echo '
            <div>
                <div id="contenido" class="container">
                    <h4 class="text-center p-4">XML Altas</h4>
                    <div class="alert alert-danger text-center" role="alert"> No se han podido generar los archivos XML, no se encontraron resultados en la consulta </div>
					';
					echo 
					'
                    <form action="inicioXMLAltas.php" method="POST">
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <input type="submit" class="btn btn-info"  value="Atr&aacute;s">
                                </div>
                            </div>
                        </div>   
                    </form>
                </div>
            </div>
        </body>
    </html>';
	

}

	

function getTipoDoc($sco_ident){
$queryTipoDoc = "SELECT * FROM OPENQUERY(M4000SF, 'SELECT SCOTIPDOC FROM SFB_BSADO WHERE SCO_IDENT = ".$sco_ident." ')";
$resultTipoDoc = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryTipoDoc);

	if (sqlsrv_has_rows($resultTipoDoc)) {
		while ($row3 = sqlsrv_fetch_array($resultTipoDoc, SQLSRV_FETCH_ASSOC)) {
			if($row3['SCOTIPDOC'] == '31'){
				return "Documento Nacional de Identidad";
			}
			if($row3['SCOTIPDOC'] == '32'){
				return "Libreta de Enrolamiento";
			}
			if($row3['SCOTIPDOC'] == '33'){
				return "Libreta Cívica";
			}
			if($row3['SCOTIPDOC'] == '02'){
				return "Cédula Mercosur";
			}
			if($row3['SCOTIPDOC'] == '36'){
				return "Pasaporte";
			}
			if($row3['SCOTIPDOC'] == '46'){
				return "Documento EXT";
			}			
		}
	}
	else{
		return "No se han encontrado tipos de documento para el sco_ident: ".$sco_ident;
		}
}

function completaFecha($fechaOriginal){
	return $fechaOriginal;
	// return str_pad($fechaOriginal, 10, "0", STR_PAD_LEFT);  
	
}

function formateaFecha($fecha){
	$fechaCompleta = completaFecha($fecha);
	$dia = substr($fechaCompleta, 0, 2);
	$mes = substr($fechaCompleta, 3, 2);
	$anio = substr($fechaCompleta, 6, 4);
	return "20".$anio."/".$mes."/".$dia;
	//return $anio."/".$mes."/".$dia;
}

?>










    
    






