<?php
/* CONSTANTES PARA LAS RUTAS - LOG PARA REGISTRAR Y CONEXION A BASE DE DATOS */
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* Obtiene los datos del formulario de modificacion */

$idGarantia = $_POST['id_garantia'];
$idHipoteca = $_POST['id_hipoteca'];
$idPrenda = $_POST['id_prenda'];
$idFianza = $_POST['id_fianza'];
$idLeasing = $_POST['id_leasing'];
$idCartera = $_POST['id_cartera'];

/* PREPARA LOS UPDATE PARA EJECUTAR */

if ($idGarantia) {

    $sucursal = ($_POST['sucursal']) ? "'" . $_POST['sucursal'] . "'" : "null";
    $moneda = ($_POST['moneda']) ? $_POST['moneda'] : "null";
    $fecAltOp = ($_POST['fecAltaOpe']) ? "'" . $_POST['fecAltaOpe'] . "'" : "null";
    $fecVtoOp = ($_POST['fecVtoOpe']) ? "'" . $_POST['fecVtoOpe'] . "'" : "null";
    $nroCli = ($_POST['nroCli']) ? $_POST['nroCli'] : "null";
    $nomCli = strtoupper($_POST['nomCli']);
    $descProd = strtoupper($_POST['descProd']);
    $opeRel = ($_POST['opeRela']) ? $_POST['opeRela'] : "null";
    $sav = ($_POST['sav']) ? $_POST['sav'] : "null";
    $proCre = ($_POST['prodCred']) ? $_POST['prodCred'] : "null";
    $entGar = strtoupper($_POST['entGtia']);
    $gesCan = strtoupper($_POST['gesCan']);
    $oriGtia = strtoupper($_POST['oriGtia']);
    $estado = ($_POST['estado']) ? $_POST['estado'] : "null";
    $valNom = ($_POST['valNomi']) ? $_POST['valNomi'] : "null";
    $observacion = strtoupper($_POST['observacion']);

    /* empieza la transaccion */

    sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion());

    $modGtia = $modHip = $modPre = $modFia = $modLea = $modCar = true;

    $queryGarantia = "UPDATE garantia SET sucursal = {$sucursal}, fecAltaOpe = {$fecAltOp}, fecVtoOpe = {$fecVtoOp}, nomCli = '{$nomCli}', nroCli = {$nroCli}, valNomi = {$valNom}, moneda = {$moneda}, descProd = '{$descProd}', opeRela = {$opeRel}, prodCred = {$proCre}, entGtia = '{$entGar}', oriGtia = '{$oriGtia}', sav = {$sav},  estado = '{$estado}', gesCan = '{$gesCan}', observacion = '{$observacion}' WHERE id_garantia=" . $idGarantia;
    $modGtia = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryGarantia);

    if (isset($idHipoteca) && $idHipoteca != null) {

        /* HIPOTECA */

        $prodGtiaHip = ($_POST['prodGtiaHip']) ? $_POST['prodGtiaHip'] : "null";
        $nroGtiaHip = ($_POST['numGtiaHip']) ? $_POST['numGtiaHip'] : "null";
        $fecVtoGtiaHip = ($_POST['fecVtoGtiaHip']) ? "'" . $_POST['fecVtoGtiaHip'] . "'" : "null";
        $fecEscHip = ($_POST['fecInscHip']) ? "'" . $_POST['fecInscHip'] . "'" : "null";
        $cotizaHip = ($_POST['cotizaHip']) ? $_POST['cotizaHip'] : "null";
        $nroInsHip = ($_POST['nroInscHip']) ? $_POST['nroInscHip'] : "null";
        $escDomHip = ($_POST['escDomHip']) ? $_POST['escDomHip'] : "null";
        $deudorHip = strtoupper($_POST['deudorHip']);
        $nomSegHip = strtoupper($_POST['nomSegHip']);
        $vtoSegHip = strtoupper($_POST['vtoSegHip']);
        $montoHip = ($_POST['montoHip']) ? $_POST['montoHip'] : "null";
        $datosHip = strtoupper($_POST['datGtiaHip']);

        $queryHipoteca = "UPDATE hipoteca SET prodGtiaHip={$prodGtiaHip}, nroGtiaHip={$nroGtiaHip}, fecVtoGtiaHip={$fecVtoGtiaHip}, escDomHip = {$escDomHip}, fecInscHip = {$fecEscHip}, cotizaHip = {$cotizaHip}, nroInscHip = {$nroInsHip}, deudorHip = '{$deudorHip}', nomSegHip = '{$nomSegHip}', vtoSegHip = '{$vtoSegHip}', montoHip={$montoHip}, datGtiaHip = '{$datosHip}' WHERE id_hipoteca=" . $idHipoteca;
        $modHip = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryHipoteca);

        if ($modHip) {
            /* CARGA LA IMAGEN DE GARANTIA */

            if (isset($_FILES['imagenGarHip'])) {
                $imagenes = $_FILES['imagenGarHip'];
                $cont = count($imagenes["name"]);
                for ($i = 0; $i < $cont; ++$i) {
                    /* RECORRE EL ARREGLO DE IMAGENES GARANTIA PARA LA HIPOTECA */
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log = new Log();
                        $log->writeLine("[Error al recibir imagen garantia de hipoteca][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutImgGtiaHip = URL_HIP . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutImgGtiaHip);
                        if ($movido) {
                            /* SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            if ($i == 0) {
                                $sql = "DELETE imagenesHipoteca WHERE $idHipoteca = idHipoteca AND tipo LIKE '%garantia%'";
                                $imghip = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                            }
                            $sql = "INSERT INTO imagenesHipoteca (ruta, idHipoteca, tipo) VALUES('$rutImgGtiaHip',$idHipoteca,'garantia')";
                            $imghip = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                        } else {
                            /* NO SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            $log = new Log();
                            $log->writeLine("[Error al mover imagen tasacion de hipoteca]");
                        }
                    }
                }
            } else {
                $log = new Log();
                $log->writeLine("[No se obtuvo el parametro con imagenes garantia de hipoteca desde _POST]");
            }

            /* CARGA LA IMAGEN DE TASACION */

            if (isset($_FILES['imagenTasHip'])) {
                $imagenes = $_FILES['imagenTasHip'];
                $cont = count($imagenes["name"]);
                for ($i = 0; $i < $cont; ++$i) {
                    /* RECORRE EL ARREGLO DE IMAGENES TASACION PARA LA HIPOTECA */
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log = new Log();
                        $log->writeLine("[Error al recibir imagen tasacion de hipoteca][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutImgTasHip = URL_HIP . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutImgTasHip);
                        if ($movido) {
                            /* SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            if ($i == 0) {
                                /* PISA TODOS LAS IMAGENES PREVIAS */
                                $sql = "DELETE imagenesHipoteca WHERE $idHipoteca = idHipoteca AND tipo LIKE '%tasacion%'";
                                $imghiptas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                            }
                            $sql = "INSERT INTO imagenesHipoteca (ruta, idHipoteca, tipo) VALUES('$rutImgTasHip',$idHipoteca,'tasacion')";
                            $imghiptas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                        } else {
                            /* NO SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            $log = new Log();
                            $log->writeLine("[Error al mover imagen tasacion de hipoteca]");
                        }
                    }
                }
            } else {
                $log = new Log();
                $log->writeLine("[No se obtuvo el parametro con imagenes tasacion de hipoteca desde _POST]");
            }
        } else {
            $log = new Log();
            $log->writeLine("[Error al modificar la hipoteca en la BD][QUERY: $queryHipoteca]");
        }
    }

    if (isset($idPrenda) && $idPrenda != null) {

        /* PRENDA (11 CAMPOS) */

        $prodGtiaPren = ($_POST['prodGtiaPren']) ? $_POST['prodGtiaPren'] : "null";
        $nroGtiaPren = ($_POST['numGtiaPren']) ? $_POST['numGtiaPren'] : "null";
        $fecVtoGtiaPren = ($_POST['fecVtoGtiaPren']) ? "'" . $_POST['fecVtoGtiaPren'] . "'" : "null";
        $cotizaPren = ($_POST['cotizaPre']) ? $_POST['cotizaPre'] : "null";
        $nomSegPren = strtoupper($_POST['nomSegPre']);
        $vtoSegPren = strtoupper($_POST['vtoSegPre']);
        $nroInsPren = ($_POST['nroInscPre']) ? $_POST['nroInscPre'] : "null";
        $fecInscPren = ($_POST['fecEscPre']) ? "'" . $_POST['fecEscPre'] . "'" : "null";
        $deudorPren = strtoupper($_POST['deudorPre']);
        $montoPren = ($_POST['montoPren']) ? $_POST['montoPren'] : "null";
        $datosPren = strtoupper($_POST['datGtiaPre']);

        $queryPrenda = "UPDATE prenda SET prodGtiaPre={$prodGtiaPren}, nroGtiaPre={$nroGtiaPren}, fecVtoGtiaPre={$fecVtoGtiaPren}, nroInscPre = {$nroInsPren}, fecEscPre = {$fecInscPren}, cotizaPre ={$cotizaPren}, deudorPre = '{$deudorPren}', nomSegPre = '{$nomSegPren}', vtoSegPre = '{$vtoSegPren}', montoPre={$montoPren}, datGtiaPre = '{$datosPren}' WHERE id_prenda=" . $idPrenda;
        $modPre = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryPrenda);
        
        
        if ($modPre) {
            /* CARGA LA  IMAGEN DE GARANTIA */
            
            if (isset($_FILES['rutaImgGtiaPre'])) {
            
                $imagenes = $_FILES['rutaImgGtiaPre'];
                $cont = count($imagenes["name"]);
                for ($i = 0; $i < $cont; ++$i) {
                    $log = new Log();
                    $log->writeLine("[----RECORRE PRENDA]");
                    /* RECORRE EL ARREGLO DE IMAGENES GARANTIA PARA LA PRENDA */
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log = new Log();
                        $log->writeLine("[Error al recibir imagen garantia de prenda][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutImgGarPren = URL_PRE . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutImgGarPren);
                        if ($movido) {
                            /* SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            if ($i == 0) {
                                $sql = "DELETE imagenesPrenda WHERE $idPrenda = idPrenda AND tipo LIKE '%garantia%'";
                                $imghiptas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                            }
                            $sql = "INSERT INTO imagenesPrenda (ruta, idPrenda, tipo) VALUES('$rutImgGarPren',$idPrenda,'garantia')";
                            $imgpren = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                        } else {
                            /* NO SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            $log = new Log();
                            $log->writeLine("[Error al mover imagen garantia de prenda]");
                        }
                    }
                }
            } else {
                $log = new Log();
                $log->writeLine("[No se obtuvo el parametro con imagenes garantia de prenda desde _POST]");
            }

            /* CARGA LA IMAGEN DE TASACION */

            if (isset($_FILES['rutaImgTasPre'])) {
                $imagenes = $_FILES['rutaImgTasPre'];
                $cont = count($imagenes["name"]);
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log = new Log();
                        $log->writeLine("[Error al recibir imagen tasacion de prenda][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutImgTasPren = URL_PRE . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutImgTasPren);
                        if ($movido) {
                            /* SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            if ($i == 0) {
                                $sql = "DELETE imagenesPrenda WHERE $idPrenda = idPrenda AND tipo LIKE '%tasacion%'";
                                $imghiptas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                            }
                            $sql = "INSERT INTO imagenesPrenda (ruta, idPrenda,tipo) VALUES('$rutImgTasPren',$idPrenda,'tasacion')";
                            $imgprentas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                        } else {
                            /* NO SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            $log = new Log();
                            $log->writeLine("[Error al mover imagen tasacion de prenda]");
                        }
                    }
                }
            } else {
                $log = new Log();
                $log->writeLine("[No se obtuvo el parametro con imagenes trasacion prenda desde _POST]");
            }
        } else {
            $log = new Log();
            $log->writeLine("[Error al modificar la prenda en la BD][QUERY: $queryPrenda]");
        }
    }

    if (isset($idFianza) && $idFianza != null) {

        /* FIANZA (8 CAMPOS) */

        $prodGtiaFia = ($_POST['prodGtiaFia']) ? $_POST['prodGtiaFia'] : "null";
        $nroGtiaFia = ($_POST['numGtiaFia']) ? $_POST['numGtiaFia'] : "null";
        $fecVtoGtiaFia = ($_POST['fecVtoGtiaFia']) ? "'" . $_POST['fecVtoGtiaFia'] . "'" : "null";
        $fechaEscFian = ($_POST['fecEscFia']) ? "'" . $_POST['fecEscFia'] . "'" : "null";
        $fechaInstFian = ($_POST['fecInscFia']) ? "'" . $_POST['fecInscFia'] . "'" : "null";
        $montoFian = ($_POST['montoFia']) ? $_POST['montoFia'] : "null";
        $datAcuFian = strtoupper($_POST['datAcue']);
        $datFiaFian = strtoupper($_POST['datFiad']);

        $queryFianza = "UPDATE fianza SET prodGtiaFia={$prodGtiaFia}, nroGtiaFia={$nroGtiaFia}, fecVtoGtiaFia={$fecVtoGtiaFia}, fecInscFia={$fechaInstFian}, fecEscFia={$fechaEscFian}, montoFia = {$montoFian}, datAcue='{$datAcuFian}', datFiad='{$datFiaFian}' WHERE id_fianza=" . $idFianza;
        $modFia = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryFianza);

        if ($modFia) {
            /* CARGA LA IMAGEN DE GARANTIA */

            if (isset($_FILES['rutaImgGtiaFia'])) {
                $imagenes = $_FILES['rutaImgGtiaFia'];
                $cont = count($imagenes["name"]);
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log = new Log();
                        $log->writeLine("[Error al recibir imagen garantia de fianza][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutImgGarFian = URL_FIA . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutImgGarFian);
                        if ($movido) {
                            /* SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            if ($i == 0) {
                                $sql = "DELETE imagenesFianza WHERE $idFianza = idFianza AND tipo LIKE '%garantia%'";
                                $imghiptas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                            }
                            $sql = "INSERT INTO imagenesFianza (ruta, idFianza, tipo) VALUES('$rutImgGarFian',$idFianza,'garantia')";
                            $imgfian = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                        } else {
                            /* NO SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            $log = new Log();
                            $log->writeLine("[Error al mover imagen garantia de fianza]");
                        }
                    }
                }
            } else {
                $log = new Log();
                $log->writeLine("[No se obtuvo el parametro con imagenes garantia de fianza desde _POST]");
            }
        } else {
            $log = new Log();
            $log->writeLine("[Error al modificar la fianza en la BD][QUERY: $queryFianza]");
        }
    }

    if (isset($idLeasing) && $idLeasing != null) {

        /* LEASING (8 CAMPOS) */

        $prodGtiaLea = ($_POST['prodGtiaLea']) ? $_POST['prodGtiaLea'] : "null";
        $nroGtiaLea = ($_POST['numGtiaLea']) ? $_POST['numGtiaLea'] : "null";
        $fecVtoGtiaLea = ($_POST['fecVtoGtiaLea']) ? "'" . $_POST['fecVtoGtiaLea'] . "'" : "null";
        $fecInsLea = ($_POST['fecEscLea']) ? "'" . $_POST['fecEscLea'] . "'" : "null";
        $nomSegLea = strtoupper($_POST['nomSegLea']);
        $vtoSegLea = strtoupper($_POST['vtoSegLea']);
        $nroInsLea = ($_POST['nroInscLea']) ? $_POST['nroInscLea'] : "null";
        $cotizaLea = ($_POST['cotizaLea']) ? $_POST['cotizaLea'] : "null";
        $montoLea = ($_POST['montoLea']) ? $_POST['montoLea'] : "null";
        $datosLea = strtoupper($_POST['datGtiaLea']);

        $queryLeasing = "UPDATE leasing SET prodGtiaLea={$prodGtiaLea}, nroGtiaLea={$nroGtiaLea}, fecVtoGtiaLea={$fecVtoGtiaLea},  fecEscLea = {$fecInsLea}, nomSegLea = '{$nomSegLea}', vtoSegLea = '{$vtoSegLea}', cotizaLea={$cotizaLea}, nroInscLea = {$nroInsLea}, montoLea={$montoLea}, datGtiaLea = '{$datosLea}' WHERE id_leasing=" . $idLeasing;
        $modLea = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryLeasing);

        if ($modLea) {
            /* CARGA LA IMAGEN DE GARANTIA */

            if (isset($_FILES['rutaImgGtiaLea'])) {
                $imagenes = $_FILES['rutaImgGtiaLea'];
                $cont = count($imagenes["name"]);
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log = new Log();
                        $log->writeLine("[Error al recibir imagen garantia de leasing][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutImgGarLea = URL_LEA . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutImgGarLea);
                        if ($movido) {
                            if ($i == 0) {
                                $sql = "DELETE imagenesLeasing WHERE $idLeasing = idLeasing AND tipo LIKE '%contrato%'";
                                $imghiptas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                            }
                            $sql = "INSERT INTO imagenesLeasing (ruta, idLeasing,tipo) VALUES('$rutImgGarLea',$idLeasing,'contrato')";
                            $imglea = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                        } else {
                            /* NO SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            $log = new Log();
                            $log->writeLine("[Error al mover imagen garantia de leasing]");
                        }
                    }
                }
            } else {
                $log = new Log();
                $log->writeLine("[No se obtuvo el parametro con imagenes garantia leasing desde _POST]");
            }

            /* CARGA LA TASACION */

            if (isset($_FILES['rutaImgTasLea'])) {
                $imagenes = $_FILES['rutaImgTasLea'];
                $cont = count($imagenes["name"]);
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    
                    if ($error > 0) {
                        $log = new Log();
                        $log->writeLine("[Error al recibir imagen tasacion de leasing][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutImgTasLea = URL_LEA . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutImgTasLea);
                        if ($movido) {
                            if ($i == 0) {
                                $sql = "DELETE imagenesLeasing WHERE $idLeasing = idLeasing AND tipo LIKE '%tasacion%'";
                                $imghiptas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                            }
                            $sql = "INSERT INTO imagenesLeasing (ruta, idLeasing,tipo) VALUES('$rutImgTasLea',$idLeasing,'tasacion')";
                            $imgleatas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                        } else {
                            /* NO SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            $log = new Log();
                            $log->writeLine("[Error al mover imagen tasacion de leasing]");
                        }
                    }
                }
            } else {
                $log = new Log();
                $log->writeLine("[No se obtuvo el parametro con imagenes tasacion leasing desde _POST]");
            }
        } else {
            $log = new Log();
            $log->writeLine("[Error al modificar leasing en la BD][QUERY: $queryLeasing]");
        }
    }

    if (isset($idCartera) && $idCartera != null) {

        /* CARTERA (7 CAMPOS) */

        $prodGtiaCar = ($_POST['prodGtiaCar']) ? $_POST['prodGtiaCar'] : "null";
        $nroGtiaCar = ($_POST['numGtiaCar']) ? $_POST['numGtiaCar'] : "null";
        $fecVtoGtiaCar = ($_POST['fecVtoGtiaCar']) ? "'" . $_POST['fecVtoGtiaCar'] . "'" : "null";
        $fecInstGtiaCar = ($_POST['fecInscCart']) ? "'" . $_POST['fecInscCart'] . "'" : "null";
        $fecCertEscCar = ($_POST['fecEscCart']) ? "'" . $_POST['fecEscCart'] . "'" : "null";
        $montoCar = ($_POST['montoCar']) ? $_POST['montoCar'] : "null";
        $datosCar = strtoupper($_POST['datCart']);

        $queryCartera = "UPDATE cartera SET prodGtiaCart = {$prodGtiaCar}, nroGtiaCart = {$nroGtiaCar}, fecVtoGtiaCart = {$fecVtoGtiaCar}, fecInscCart = {$fecInstGtiaCar}, fecEscCart = {$fecCertEscCar}, montoCart={$montoCar}, datCart = '{$datosCar}' WHERE id_cartera=" . $idCartera;
        $modCar = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCartera);
        
        if ($modCar) {
            /* CARGA LA IMAGEN DE GARANTIA */

            if (isset($_FILES['rutaImgGtiaCart'])) {
                $imagenes = $_FILES['rutaImgGtiaCart'];
                $cont = count($imagenes["name"]);
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log = new Log();
                        $log->writeLine("[Error al recibir imagen garantia de cartera ($i de $cont)][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutImgGarCar = URL_CAR . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutImgGarCar);
                        if ($movido) {
                            if ($i == 0) {
                                $sql = "DELETE imagenesCartera WHERE $idCartera = idCartera AND tipo LIKE '%garantia%'";
                                $imghiptas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                            }
                            $sql = "INSERT INTO imagenesCartera (ruta, idCartera,tipo) VALUES('$rutImgGarCar',$idCartera,'garantia')";
                            $imgcar = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                        } else {
                            /* NO SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            $log = new Log();
                            $log->writeLine("[Error al mover imagen garantia de cartera]");
                        }
                    }
                }
            } else {
                $log = new Log();
                $log->writeLine("[No se obtuvo el parametro con imagenes garantia de cartera desde _POST]");
            }

            /* CARGA IMAGEN DE EL CONTRATO */

            if (isset($_FILES['rutaImgCont'])) {
                $imagenes = $_FILES['rutaImgCont'];
                $cont = count($imagenes["name"]);
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log = new Log();
                        $log->writeLine("[Error al recibir imagen garantia de cartera][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutImgConCar = URL_CAR . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutImgConCar);
                        if ($movido) {
                            if ($i == 0) {
                                $sql = "DELETE imagenesCartera WHERE $idCartera = idCartera AND tipo LIKE '%contrato%'";
                                $imghiptas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                            }
                            $sql = "INSERT INTO imagenesCartera (ruta, idCartera,tipo) VALUES('$rutImgConCar',$idCartera,'contrato')";
                            $imgcarcon = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                        } else {
                            /* NO SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            $log = new Log();
                            $log->writeLine("[Error al mover imagen contrato de cartera]");
                        }
                    }
                }
            } else {
                $log = new Log();
                $log->writeLine("[No se obtuvo el parametro con imagenes contrato de cartera desde _POST]");
            }

            /* CARGA IMAGEN DEL PAGARE */

            if (isset($_FILES['rutaImgPaga'])) {
                $imagenes = $_FILES['rutaImgPaga'];
                $cont = count($imagenes["name"]);
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log = new Log();
                        $log->writeLine("[Error al recibir imagen garantia de cartera][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutImgPagCar = URL_CAR . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutImgPagCar);
                        if ($movido) {
                            if ($i == 0) {
                                $sql = "DELETE imagenesCartera WHERE $idCartera = idCartera AND tipo LIKE '%pagare%'";
                                $imghiptas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                            }
                            $sql = "INSERT INTO imagenesCartera (ruta, idCartera,tipo) VALUES('$rutImgPagCar',$idCartera,'pagare')";
                            $imgcarpag = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                        } else {
                            /* NO SE MOVIO EL ARCHIVO TEMPORAL A LA CARPETA */
                            $log = new Log();
                            $log->writeLine("[Error al mover imagen contrato de cartera]");
                        }
                    }
                }
            } else {
                $log = new Log();
                $log->writeLine("[No se obtuvo el parametro con imagenes pagare de cartera desde _POST]");
            }
        } else {
            $log = new Log();
            $log->writeLine("[Error al modificar cartera en la BD][QUERY: $queryCartera]");
        }
    }
} else {
    $log = new Log();
    $log->writeLine("[No se obtuvo el identificador de garantia(idGarantia) de _POST]");
}

if ($modGtia && $modHip && $modPre && $modLea && $modFia && $modCar) {
    sqlsrv_commit(BDConexion::getInstancia()->getConexion());
    $mensaje = '<div class="alert alert-success text-center" role="alert"> Garantia guardada con exito <div>';
} else {
    $log = new Log();
    $log->writeLine("[No se pudo ejecutar la modificacion de garantia en la BD][modGtia: $modGtia][modHip: $modHip][modPre: $modPre][modFia: $modFia][modCar: $modCar][modLea: $modLea]");
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
    $mensaje = '<div class="alert alert-danger text-center" role="alert"> Garantia no guardada <div>';
}

/* INICIALIZA LA SESION */
session_start();

if (!isset($_SESSION['user'])) {
    /* NO SE HA LOGEADO - NO TIENE PERMISOS */
    $log = new Log();
    $log->writeLine("[No hay usuario en sesion para mostrar el formulario][Redirecciona: index]");
    header('Location: ../../index.php');
}
require_once './menuGarantias.php';
?>
<div class="container">
    <div class="card-header">
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-12 text-center">
                <?php echo $mensaje; ?>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto text-center">
            <div class="col-lg-2 text-center"></div>
            <div class="col-lg-8 text-center">
                <a href="formBuscarGarantia.php">
                    <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar Garantias</button>
                </a>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto text-center">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="formBuscarEstados.php">
                    <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar Estado</button>
                </a>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="formCargarGarantia.php"> 
                    <button class="btn btn-lg btn-bsc btn-block" type="submit">Cargar Garantia</button>
                </a>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="../procesarLogout.php">
                    <button class="btn btn-lg btn-bsc btn-block" type="submit">Salir</button>
                </a>
            </div>
            <div class="col-lg-2 text-center">
            </div>
        </div>
    </div>
</div>
</body>

</html>



