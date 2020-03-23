<?php
/* CONSTANTES PARA LAS RUTAS - LOG PARA REGISTRAR Y CONEXION A BASE DE DATOS */
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* Carga Datos Comunes */

$sucursal = ($_POST['sucursal']) ? "'" . $_POST['sucursal'] . "'" : "null";
$fecAltOp = ($_POST['fechaAlta']) ? "'" . $_POST['fechaAlta'] . "'" : "null";
$fecVtoOp = ($_POST['fechaVto']) ? "'" . $_POST['fechaVto'] . "'" : "null";
$nomCli = strtoupper($_POST['nombreCliente']);
$nroCli = ($_POST['numeroCli']) ? $_POST['numeroCli'] : "null";
$valNom = ($_POST['valorNomi']) ? $_POST['valorNomi'] : "null";
$moneda = ($_POST['moneda']) ? $_POST['moneda'] : "null";
$desPro = strtoupper($_POST['descripcionProd']);
$opeRel = ($_POST['oper']) ? $_POST['oper'] : "null";
$proCre = ($_POST['prodCred']) ? $_POST['prodCred'] : "null";
$entGar = strtoupper($_POST['entregaGar']);
$oriGtia = strtoupper($_POST['origen']);
$sav = ($_POST['sav']) ? $_POST['sav'] : "null";
$estGtiaOpe = ($_POST['estado']) ? $_POST['estado'] : "null";
$gesCan = strtoupper($_POST['gestionCan']);
$observacion = strtoupper($_POST['observacion']);

/* Datos Hipoteca */

$prodGtiaHip = ($_POST['prodGtiaHip']) ? $_POST['prodGtiaHip'] : "null";
$nroGtiaHip = ($_POST['numGtiaHip']) ? $_POST['numGtiaHip'] : "null";
$fecVtoGtiaHip = ($_POST['fecVtoGtiaHip']) ? "'" . $_POST['fecVtoGtiaHip'] . "'" : "null";
$escDomHip = ($_POST['escDominioHip']) ? $_POST['escDominioHip'] : "null";
$fecEscHip = ($_POST['fechaHip']) ? "'" . $_POST['fechaHip'] . "'" : "null";
$cotizaHip = ($_POST['cotizacionHip']) ? $_POST['cotizacionHip'] : "null";
$nroInsHip = ($_POST['numInsHip']) ? $_POST['numInsHip'] : "null";
$deudorHip = strtoupper($_POST['deudorHip']);
$nomSegHip = strtoupper($_POST['seguroHip']);
$vtoSegHip = strtoupper($_POST['vencHip']);
$montoHip = ($_POST['montoHip']) ? $_POST['montoHip'] : "null";
$datosHip = strtoupper($_POST['datosGarHip']);


/* Datos Prenda */

$prodGtiaPren = ($_POST['prodGtiaPren']) ? $_POST['prodGtiaPren'] : "null";
$nroGtiaPren = ($_POST['numGtiaPren']) ? $_POST['numGtiaPren'] : "null";
$fecVtoGtiaPren = ($_POST['fecVtoGtiaPren']) ? "'" . $_POST['fecVtoGtiaPren'] . "'" : "null";
$nroInsPren = ($_POST['numInscripcionPren']) ? $_POST['numInscripcionPren'] : "null";
$nomSegPren = strtoupper($_POST['seguroPren']);
$vtoSegPren = strtoupper($_POST['vencimientoPren']);
$cotizaPren = ($_POST['cotizacionPren']) ? $_POST['cotizacionPren'] : "null";
$deudorPren = strtoupper($_POST['deudorPren']);
$montoPren = ($_POST['montoPren']) ? $_POST['montoPren'] : "null";
$datosPren = strtoupper($_POST['bienGtiaPren']);
$fecCertEscPren = ($_POST['fechaInsPren']) ? "'" . $_POST['fechaInsPren'] . "'" : "null";

/* Datos Fianza */

$prodGtiaFia = ($_POST['prodGtiaFia']) ? $_POST['prodGtiaFia'] : "null";
$nroGtiaFia = ($_POST['numGtiaFia']) ? $_POST['numGtiaFia'] : "null";
$fecVtoGtiaFia = ($_POST['fecVtoGtiaFia']) ? "'" . $_POST['fecVtoGtiaFia'] . "'" : "null";
$fecInstGtiaFian = ($_POST['fechaInstFian']) ? "'" . $_POST['fechaInstFian'] . "'" : "null";
$fecCertEscFian = ($_POST['fechaEscribaniaFian']) ? "'" . $_POST['fechaEscribaniaFian'] . "'" : "null";
$montoFian = ($_POST['montoFian']) ? $_POST['montoFian'] : "null";
$datAcuFian = strtoupper($_POST['datosAcuerdoFian']);
$datFiaFian = strtoupper($_POST['datosFiadorFian']);


/* Datos Leasing */

$prodGtiaLea = ($_POST['prodGtiaLea']) ? $_POST['prodGtiaLea'] : "null";
$nroGtiaLea = ($_POST['numGtiaLea']) ? $_POST['numGtiaLea'] : "null";
$fecVtoGtiaLea = ($_POST['fecVtoGtiaLea']) ? "'" . $_POST['fecVtoGtiaLea'] . "'" : "null";
$nroInsLea = ($_POST['numInsLea']) ? $_POST['numInsLea'] : "null";
$nomSegLea = strtoupper($_POST['seguroLea']);
$vtoSegLea = strtoupper($_POST['vtoLea']);
$cotizaLea = ($_POST['cotizacionLea']) ? $_POST['cotizacionLea'] : "null";
$fecInsLea = ($_POST['fechaInsLea']) ? "'" . $_POST['fechaInsLea'] . "'" : "null";
$montoLea = ($_POST['montoLea']) ? $_POST['montoLea'] : "null";
$datosLea = strtoupper($_POST['datosLeasingLea']);

/* Datos Datos Compra Cartera */

$prodGtiaCar = ($_POST['prodGtiaCar']) ? $_POST['prodGtiaCar'] : "null";
$nroGtiaCar = ($_POST['numGtiaCar']) ? $_POST['numGtiaCar'] : "null";
$fecVtoGtiaCar = ($_POST['fecVtoGtiaCar']) ? "'" . $_POST['fecVtoGtiaCar'] . "'" : "null";
$fecInstGtiaCar = ($_POST['fechaInstCar']) ? "'" . $_POST['fechaInstCar'] . "'" : "null";
$fecCertEscCar = ($_POST['fechaEscribaniaCar']) ? "'" . $_POST['fechaEscribaniaCar'] . "'" : "null";
$montoCar = ($_POST['montoCar']) ? $_POST['montoCar'] : "null";
$datosCar = strtoupper($_POST['datosCarteraCar']);

$mensaje = "";
$log = new Log();

if (sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion()) === false) {
    $mensaje = '<div class="alert alert-danger text-center" role="alert"> No se inicializó la transacción con la base de datos </div>';
    $log->writeLine("[Error al inicializar la transaccion con la base de datos]");
} else {
    /* SQL INSERT en tabla hipoteca */

    $sqlHip = "INSERT INTO hipoteca (cotizaHip, datGtiaHip, deudorHip, escDomHip,fecInscHip, fecVtoGtiaHip, nomSegHip, nroGtiaHip, nroInscHip, prodGtiaHip, vtoSegHip, montoHip) OUTPUT INSERTED.id_hipoteca  VALUES($cotizaHip,'$datosHip','$deudorHip',$escDomHip, $fecEscHip, $fecVtoGtiaHip, '$nomSegHip', $nroGtiaHip, $nroInsHip, $prodGtiaHip,'$vtoSegHip', $montoHip)";

    /* SQL INSERT en tabla prenda */

    $sqlPre = "INSERT INTO prenda (nomSegPre, vtoSegPre, cotizaPre, deudorPre, datGtiaPre, fecEscPre, fecVtoGtiaPre, nroGtiaPre, nroInscPre, prodGtiaPre, montoPre) OUTPUT INSERTED.id_prenda  VALUES('$nomSegPren','$vtoSegPren',$cotizaPren,'$deudorPren','$datosPren',$fecCertEscPren,$fecVtoGtiaPren, $nroGtiaPren, $nroInsPren, $prodGtiaPren, $montoPren)";

    /* SQL INSERT en tabla fianza */

    $sqlFia = "INSERT INTO fianza (datAcue, datFiad, fecInscFia, fecEscFia, montoFia, prodGtiaFia, nroGtiaFia, fecVtoGtiaFia) OUTPUT INSERTED.id_fianza  VALUES('$datAcuFian', '$datFiaFian', $fecInstGtiaFian, $fecCertEscFian, $montoFian, $prodGtiaFia, $nroGtiaFia, $fecVtoGtiaFia)";

    /* SQL INSERT en tabla leasing */

    $sqlLea = "INSERT INTO leasing (nroInscLea, nomSegLea,vtoSegLea, cotizaLea, fecEscLea, datGtiaLea, prodGtiaLea, nroGtiaLea, fecVtoGtiaLea, montoLea) OUTPUT INSERTED.id_leasing  VALUES($nroInsLea,'$nomSegLea','$vtoSegLea', $cotizaLea,$fecInsLea,'$datosLea', $prodGtiaLea, $nroGtiaLea, $fecVtoGtiaLea, $montoLea)";

    /* SQL INSERT en tabla compra de cartera */

    $sqlCar = "INSERT INTO cartera (fecEscCart, fecInscCart, datCart, prodGtiaCart, nroGtiaCart, fecVtoGtiaCart, montoCart) OUTPUT INSERTED.id_cartera  VALUES($fecCertEscCar, $fecInstGtiaCar, '$datosCar', $prodGtiaCar, $nroGtiaCar, $fecVtoGtiaCar, $montoCar)";


    $consultaHip = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlHip);
    $consultaPre = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlPre);
    $consultaFia = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlFia);
    $consultaLea = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlLea);
    $consultaCar = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlCar);

    if ($consultaHip && $consultaPre && $consultaFia && $consultaLea && $consultaCar) {

        /* extrae el registro generador a partir de la consulta SQL */

        $hipoteca = sqlsrv_fetch_array($consultaHip, SQLSRV_FETCH_ASSOC);
        $prenda = sqlsrv_fetch_array($consultaPre, SQLSRV_FETCH_ASSOC);
        $fianza = sqlsrv_fetch_array($consultaFia, SQLSRV_FETCH_ASSOC);
        $leasing = sqlsrv_fetch_array($consultaLea, SQLSRV_FETCH_ASSOC);
        $cartera = sqlsrv_fetch_array($consultaCar, SQLSRV_FETCH_ASSOC);

        /* obtiene los id de cada registro */

        $idHipoteca = $hipoteca['id_hipoteca'];
        $idPrenda = $prenda['id_prenda'];
        $idFianza = $fianza['id_fianza'];
        $idLeasing = $leasing['id_leasing'];
        $idCartera = $cartera['id_cartera'];

        /* SQL INSERT en la tabla garantia con los id asociados */

        $sqlGar = "INSERT INTO garantia (id_cartera, id_fianza, id_hipoteca, id_leasing, id_prenda, descProd, estado, entGtia, fecAltaOpe, fecVtoOpe, gesCan, moneda, nomCli, nroCli, prodCred, observacion, oriGtia, opeRela, sav, sucursal, valNomi) VALUES($idCartera, $idFianza, $idHipoteca, $idLeasing, $idPrenda,'$desPro', '$estGtiaOpe', '$entGar', $fecAltOp, $fecVtoOp, '$gesCan', $moneda, '$nomCli', $nroCli, $proCre, '$observacion', '$oriGtia', $opeRel, $sav, $sucursal, $valNom)";
        $consultaGar = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlGar);

        if ($consultaGar) {

            /* Confirma las transacciones para comenzar a trabajar con los documentos */

            sqlsrv_commit(BDConexion::getInstancia()->getConexion());

            $contGtiaHipoteca = 0;

            /* procesa los PDF para HIPOTECA ********************************** */

            if (isset($_FILES['imagenGarHip'])) {
                $imagenes = $_FILES['imagenGarHip'];
                $cont = count($imagenes["name"]);
                $values = "";
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0 && $i > 0) {
                        $log->writeLine("[Error al recibir imagen garantia de hipoteca][Indice: $i]Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutImgGtiaHip = URL_HIP . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutImgGtiaHip);
                        if ($movido) {
                            $contGtiaHipoteca++;
                            $values = $values . "('$rutImgGtiaHip', $idHipoteca, 'garantia'),";
                        } else {
                            $log->writeLine("[Error al mover imagen garantia de hipoteca][Name: $name][TempName: $tmpName][URL: $rutImgGtiaHip]");
                        }
                    }
                }
                if ($contGtiaHipoteca > 0) {
                    $values = substr($values, 0, -1);
                    $sql = "INSERT INTO imagenesHipoteca (ruta, idHipoteca, tipo) VALUES $values";
                    $imghip = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                    if (!$imghip) {
                        $contGtiaHipoteca = 0;
                        $log->writeLine("[Error al insertar imagenes garantia de hipoteca][QUERY: $sql]");
                    }
                }
            }

            $contTasHipoteca = 0;

            if (isset($_FILES['imagenTasHip'])) {
                $imagenes = $_FILES['imagenTasHip'];
                $cont = count($imagenes["name"]);
                $values = "";
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log->writeLine("[Error al recibir imagen tasacion de hipoteca][Indice: $i][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutImgGtiaHip = URL_HIP . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutImgGtiaHip);
                        if ($movido) {
                            $contTasHipoteca++;
                            $values = $values . "('$rutImgGtiaHip' ,$idHipoteca, 'tasacion'),";
                        } else {
                            $log->writeLine("[Error al mover imagen tasacion de hipoteca][Name: $name][TempName: $tmpName][URL: $rutImgGtiaHip]");
                        }
                    }
                }
                if ($contTasHipoteca > 0) {
                    $values = substr($values, 0, -1);
                    $sql = "INSERT INTO imagenesHipoteca (ruta, idHipoteca, tipo) VALUES $values";
                    $imghip = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                    if (!$imghip) {
                        $contTasHipoteca = 0;
                        $log->writeLine("[Error al insertar imagenes tasacion de hipoteca][QUERY: $sql]");
                    }
                }
            }

            /* procesa los PDF para PRENDA *************************************** */

            $contGtiaPrenda = 0;

            if (isset($_FILES['imagenGarPren'])) {
                $imagenes = $_FILES['imagenGarPren'];
                $cont = count($imagenes["name"]);
                $values = "";
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log->writeLine("[Error al recibir imagen garantia de prenda][Indice: $i][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutaImgPrenda = URL_PRE . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutaImgPrenda);
                        if ($movido) {
                            $contGtiaPrenda++;
                            $values = $values . "('$rutaImgPrenda', $idPrenda, 'garantia'),";
                        } else {
                            $log->writeLine("[Error al mover imagen garantia de prenda][Name: $name][TempName: $tmpName][URL: $rutaImgPrenda]");
                        }
                    }
                }
                if ($contGtiaPrenda > 0) {
                    $values = substr($values, 0, -1);
                    $sql = "INSERT INTO imagenesPrenda (ruta, idPrenda, tipo) VALUES $values";
                    $imgpren = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                    if (!$imgpren) {
                        $contGtiaPrenda = 0;
                        $log->writeLine("[Error al insertar imagenes garantia de prenda][QUERY: $sql]");
                    }
                }
            }

            $contTasPrenda = 0;

            if (isset($_FILES['imagenTasPren'])) {
                $imagenes = $_FILES['imagenTasPren'];
                $cont = count($imagenes["name"]);
                $values = "";
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log->writeLine("[Error al recibir imagen tasacion de prenda][Indice: $i][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutaImgPrenda = URL_PRE . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutaImgPrenda);
                        if ($movido) {
                            $contTasPrenda++;
                            $values = $values . "('$rutaImgPrenda', $idPrenda, 'tasacion'),";
                        } else {
                            $log->writeLine("[Error al mover imagen tasacion de prenda][Name: $name][TempName: $tmpName][URL: $rutaImgPrenda]");
                        }
                    }
                }
                if ($contTasPrenda > 0) {
                    $values = substr($values, 0, -1);
                    $sql = "INSERT INTO imagenesPrenda (ruta, idPrenda, tipo) VALUES $values";
                    $imgpren = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                    if (!$imgpren) {
                        $contTasPrenda = 0;
                        $log->writeLine("[Error al insertar imagenes tasacion de prenda][QUERY: $sql]");
                    }
                }
            }

            /* procesa los PDF para FIANZA ************************************** */

            $contGtiaFianza = 0;

            if (isset($_FILES['imagenGarFian'])) {
                $imagenes = $_FILES['imagenGarFian'];
                $cont = count($imagenes["name"]);
                $values = "";
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log->writeLine("[Error al recibir imagen garantia de fianza][Indice: $i][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutaImgFianza = URL_FIA . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutaImgFianza);
                        if ($movido) {
                            $contGtiaFianza++;
                            $values = $values . "('$rutaImgFianza', $idFianza, 'garantia'),";
                        } else {
                            $log->writeLine("[Error al mover imagen garantia de fianza][Name: $name][TempName: $tmpName][URL: $rutaImgFianza]");
                        }
                    }
                }
                if ($contGtiaFianza > 0) {
                    $values = substr($values, 0, -1);
                    $sql = "INSERT INTO imagenesFianza (ruta, idFianza, tipo) VALUES $values";
                    $imgFian = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                    if (!$imgFian) {
                        $contGtiaFianza = 0;
                        $log->writeLine("[Error al insertar imagenes garantia de fianza][QUERY: $sql]");
                    }
                }
            }

            /* procesa los PDF para LEASING ************************************** */

            $contGtiaLeasing = 0;

            if (isset($_FILES['imagenGarLea'])) {
                $imagenes = $_FILES['imagenGarLea'];
                $cont = count($imagenes["name"]);
                $values = "";

                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log->writeLine("[Error al recibir imagen garantia de leasing][Indice: $i]Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutaImgLeasing = URL_LEA . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutaImgLeasing);
                        if ($movido) {
                            $contGtiaLeasing++;
                            $values = $values . "('$rutaImgLeasing', $idLeasing, 'contrato'),";
                        } else {
                            $log->writeLine("[Error al mover imagen garantia de leasing][Name: $name][TempName: $tmpName][URL: $rutaImgLeasing]");
                        }
                    }
                }
                if ($contGtiaLeasing > 0) {
                    $values = substr($values, 0, -1);
                    $sql = "INSERT INTO imagenesLeasing (ruta, idLeasing,tipo) VALUES $values";
                    $imgLea = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                    if (!$imgLea) {
                        $contGtiaLeasing = 0;
                        $log->writeLine("[Error al insertar imagenes garantia de leasing][QUERY: $sql]");
                    }
                }
            }

            $contTasLeasing = 0;

            if (isset($_FILES['imagenTasLea'])) {
                $imagenes = $_FILES['imagenTasLea'];
                $cont = count($imagenes["name"]);
                $values = "";

                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log->writeLine("[Error al recibir imagen tasacion de leasing][Idicen: $i][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutaImgLeasing = URL_LEA . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutaImgLeasing);
                        if ($movido) {
                            $contTasLeasing++;
                            $values = $values . "('$rutaImgLeasing', $idLeasing, 'tasacion'),";
                        } else {
                            $log->writeLine("[Error al mover imagen tasacion de leasing][Name: $name][TempName: $tmpName][URL: $rutaImgLeasing]");
                        }
                    }
                }
                if ($contTasLeasing > 0) {
                    $values = substr($values, 0, -1);
                    $sql = "INSERT INTO imagenesLeasing (ruta, idLeasing,tipo) VALUES $values";
                    $imgLea = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                    if (!$imgLea) {
                        $contGtiaLeasing = 0;
                        $log->writeLine("[Error al insertar imagenes tasacion de leasing][QUERY: $sql]");
                    }
                }
            }

            /* procesa los PDF para CARTERA ************************************** */

            $contGtiaCartera = 0;

            if (isset($_FILES['imagenGarCar'])) {
                $imagenes = $_FILES['imagenGarCar'];
                $cont = count($imagenes["name"]);
                $values = "";
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log->writeLine("[Error al recibir imagen garantia de leasing][Indice: $i][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutaImgCartera = URL_CAR . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutaImgCartera);
                        if ($movido) {
                            $contGtiaCartera++;
                            $values = $values . "('$rutaImgCartera', $idCartera, 'garantia'),";
                        } else {
                            $log->writeLine("[Error al mover imagen garantia de cartera][Name: $name][TempName: $tmpName][URL: $rutaImgCartera]");
                        }
                    }
                }
                if ($contGtiaCartera > 0) {
                    $values = substr($values, 0, -1);
                    $sql = "INSERT INTO imagenesCartera (ruta, idCartera,tipo) VALUES $values";
                    $imgCar = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                    if (!$imgCar) {
                        $contGtiaCartera = 0;
                        $log->writeLine("[Error al insertar imagenes garantia de cartera][QUERY: $sql]");
                    }
                }
            }

            $contConCartera = 0;

            if (isset($_FILES['imagenConCar'])) {
                $imagenes = $_FILES['imagenConCar'];
                $cont = count($imagenes["name"]);
                $values = "";
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log->writeLine("[Error al recibir imagen contrato de cartera][Indice: $i][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutaImgCartera = URL_CAR . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutaImgCartera);
                        if ($movido) {
                            $contConCartera++;
                            $values = $values . "('$rutaImgCartera', $idCartera, 'contrato'),";
                        } else {
                            $log->writeLine("[Error al mover imagen contrato de cartera][Name: $name][TempName: $tmpName][URL: $rutaImgCartera]");
                        }
                    }
                }
                if ($contConCartera) {
                    $values = substr($values, 0, -1);
                    $sql = "INSERT INTO imagenesCartera (ruta, idCartera,tipo) VALUES $values";
                    $imgCar = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                    if (!$imgCar) {
                        $contGtiaCartera = 0;
                        $log->writeLine("[Error al insertar imagenes contrato de cartera][QUERY: $sql]");
                    }
                }
            }

            $contPagCartera = 0;

            if (isset($_FILES['imagenPagCar'])) {
                $imagenes = $_FILES['imagenPagCar'];
                $cont = count($imagenes["name"]);
                $values = "";
                for ($i = 0; $i < $cont; ++$i) {
                    $error = $imagenes["error"][$i];
                    if ($error > 0) {
                        $log->writeLine("[Error al recibir imagen pagare de cartera][Indice: $i][Error: $error]");
                    } else {
                        $name = $imagenes["name"][$i];
                        $tmpName = $imagenes["tmp_name"][$i];
                        $rutaImgCartera = URL_CAR . "\\" . $name;
                        $movido = move_uploaded_file($tmpName, $rutaImgCartera);
                        if ($movido) {
                            $contPagCartera++;
                            $values = $values . "('$rutaImgCartera', $idCartera, 'pagare'),";
                        } else {
                            $log->writeLine("[Error al mover imagen pagare de cartera][Name: $name][TempName: $tmpName][URL: $rutaImgCartera]");
                        }
                    }
                }
                if ($contPagCartera > 0) {
                    $values = substr($values, 0, -1);
                    $sql = "INSERT INTO imagenesCartera (ruta, idCartera,tipo) VALUES $values";
                    $imgCar = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                    if (!$imgCar) {
                        $contPagCartera = 0;
                        $log->writeLine("[Error al insertar imagenes pagare de cartera][QUERY: $sql]");
                    }
                }
            }
            $cantidad = $contGtiaHipoteca + $contTasHipoteca + $contGtiaPrenda + $contTasPrenda + $contGtiaFianza + $contGtiaLeasing + $contTasLeasing + $contConCartera + $contGtiaCartera + $contPagCartera;
            $mensaje = '<div class="alert alert-success text-center" role="alert"> Garantia guardada con exito (Documentos procesados: ' . $cantidad . ') <div>';
        } else {
            $log->writeLine("[Error al realizar la creacion de la garantia][SQL: $sqlHip][SQL: $sqlPre][SQL: $sqlFia][SQL: $sqlLea][SQL: $sqlCar][SQL: $sqlGar]");
            sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
            $mensaje = '<div class="alert alert-danger text-center" role="alert"> Error al crear la garantia <div>';
        }
    } else {
        /* fallo alguno de los insert en la base de datos */
        $log->writeLine("[Error al realizar la creacion de algun tipo de garantia][SQL: $sqlHip][SQL: $sqlPre][SQL: $sqlFia][SQL: $sqlLea][SQL: $sqlCar]");
        sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
        $mensaje = '<div class="alert alert-danger text-center" role="alert"> Error al crear los tipos de garantia <div>';
    }
}



/* INICIALIZA LA SESION */
session_start();

if (!isset($_SESSION["user"])) {
    $log = new Log();
    $log->writeLine("[No hay usuario en sesion para mostrar el formulario][Redirecciona: index]");
    header("Location: ../../index.php");
}

require_once "./menuGarantias.php";
?>
<div class="container">
    <div class="card-header">
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-12 text-center p-2">
                <?php echo $mensaje; ?>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="formBuscarGarantia.php">
                    <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar Garantia</button>
                </a>
            </div>
            <div class="col-lg-2 text-center">
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