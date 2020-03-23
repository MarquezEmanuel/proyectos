<?php

require_once '../../../lib/PHPExcel/Classes/PHPExcel.php';
require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
$resultado = "cargo";
if ($_POST['nombreAplicacion'] && $_POST['idAplicacion']) {

    $nombreAplicacion = strtoupper($_POST['nombreAplicacion']);
    $idAplicacion = $_POST['idAplicacion'];

    // LEVANTA EL ARCHIVO Y LO MUEVE A UNA CARPETA TEMPORAL

    $nombreArchivo = $_FILES['archivo']["name"];
    $nombreTemporal = $_FILES['archivo']["tmp_name"];
    $rutaDestino = TMP . "\\" . $nombreArchivo;
    $movido = move_uploaded_file($nombreTemporal, $rutaDestino);
    $inputFileType = PHPExcel_IOFactory::identify($rutaDestino);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($rutaDestino);
    $hoja = $objPHPExcel->getSheet(0);
    $nroFilas = $hoja->getHighestRow();
    libxml_disable_entity_loader(false);

    $controlador = new ControladorAcceso();
    switch ($nombreAplicacion) {
        case "SWIFT":
            $accesos = array();
            for ($fila = 17; $fila <= $nroFilas; $fila++) {
                $legajo = $hoja->getCell("A" . $fila)->getValue();
                $nombre = $hoja->getCell("B" . $fila)->getValue();
                $perfil = $hoja->getCell("C" . $fila)->getValue();
                $estado = $hoja->getCell("F" . $fila)->getValue();
                if (is_numeric($legajo)) {
                    $accesos[] = array($legajo, $nombre, $perfil, $estado, $idAplicacion);
                }
            }
            $carga = $controlador->cargar($idAplicacion, $accesos);
            $mensaje = $controlador->getMensaje();
            $resultado = HTML::getAlerta($carga, $mensaje);
            break;
        default:
            $mensaje = "Opción desconocida";
            $resultado = HTML::getAlerta(1, $mensaje);
            break;
    }
    unlink($rutaDestino);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = HTML::getAlerta(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
