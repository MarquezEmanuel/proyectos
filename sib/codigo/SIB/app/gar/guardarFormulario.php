<?php

/* CONSTANTES PARA LAS RUTAS - LOG PARA REGISTRAR Y CONEXION A BASE DE DATOS */
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* Carga Datos Comunes */

$proGtia = strtoupper($_POST['prodGar']);
$sucursal = $_POST['sucursal'];
$fecAltOp = $_POST['fechaAlta'];
$fecVtoOp = $_POST['fechaVto'];
$nroGtia = $_POST['numeroGar'];
$fecVtoGtia = $_POST['fechaGar'];
$nomCli = strtoupper($_POST['nombreCliente']);
$nroCli = $_POST['numeroCli'];
$valNom = $_POST['valorNomi'];
$moneda = $_POST['moneda'];
$desPro = strtoupper($_POST['descripcionProd']);
$opeRel = $_POST['oper'];
$proCre = $_POST['prodCred'];
$entGar = strtoupper($_POST['entregaGar']);
$oriGtia = strtoupper($_POST['origen']);
$sav = $_POST['sav'];
$estGtiaOpe = $_POST['estado'];
$gesCan = strtoupper($_POST['gestionCan']);
$observacion = strtoupper($_POST['observacion']);

/* Datos Hipoteca */

$escDomHip = $_POST['escDominioHip'];
$fecEscHip = $_POST['fechaHip'];
$cotizaHip = $_POST['cotizacionHip'];
$nroInsHip = $_POST['numInsHip'];
$deudorHip = strtoupper($_POST['deudorHip']);
$nomSegHip = strtoupper($_POST['seguroHip']);
$vtoSegHip = strtoupper($_POST['vencHip']);
$datosHip = strtoupper($_POST['datosGarHip']);

/* Datos Prenda */

$nroInsPren = $_POST['numInscripcionPren'];
$nomSegPren = strtoupper($_POST['seguroPren']);
$vtoSegPren = strtoupper($_POST['vencimientoPren']);
$cotizaPren = $_POST['cotizacionPren'];
$deudorPren = strtoupper($_POST['deudorPren']);
$datosPren = strtoupper($_POST['bienGtiaPren']);
$fecCertEscPren = $_POST['fechaInsPren'];

/* Datos Fianza */

$monto = $_POST['monto'];
$datAcuFian = strtoupper($_POST['datosAcuerdoFian']);
$datFiaFian = strtoupper($_POST['datosFiadorFian']);
$fecInstGtiaFian = $_POST['fechaInstFian'];
$fecCertEscFian = $_POST['fechaEscribaniaFian'];

/* Datos Leasing */

$nroInsLea = $_POST['numInsLea'];
$nomSegLea = strtoupper($_POST['seguroLea']);
$vtoSegLea = strtoupper($_POST['vtoLea']);
$cotizaLea = $_POST['cotizacionLea'];
$fecInsLea = $_POST['fechaInsLea'];
$datosLea = strtoupper($_POST['datosLeasingLea']);

/* Datos Datos Compra Cartera */

$fecInstGtiaCar = $_POST['fechaInstCar'];
$fecCertEscCar = $_POST['fechaEscribaniaCar'];
$datosCar = strtoupper($_POST['datosCarteraCar']);


/* numericos a null */

if ($valNom == NULL) {
    $valNom = 'null';
}
if ($monto == NULL) {
    $monto = 'null';
}
if ($cotizaHip == NULL) {
    $cotizaHip = 'null';
}
if ($cotizaLea == NULL) {
    $cotizaLea = 'null';
}
if ($cotizaPren == NULL) {
    $cotizaPren = 'null';
}
if ($sucursal == NULL) {
    $sucursal = 'null';
}
if ($nroGtia == NULL) {
    $nroGtia = 'null';
}
if ($nroCli == NULL) {
    $nroCli = 'null';
}
if ($moneda == NULL) {
    $moneda = 'null';
}
if ($proCre == NULL) {
    $proCre = 'null';
}
if ($sav == NULL) {
    $sav = 'null';
}
if ($escDomHip == NULL) {
    $escDomHip = 'null';
}
if ($nroInsHip == NULL) {
    $nroInsHip = 'null';
}
if ($nroInsLea == NULL) {
    $nroInsLea = 'null';
}
if ($nroInsPren == NULL) {
    $nroInsPren = 'null';
}
if ($opeRel == NULL) {
    $opeRel = 'null';
}


/* guarda fecha con null */


if ($fecAltOp == '') {
    $fecAltOp = 'null';
}
if ($fecCertEscCar == '') {
    $fecCertEscCar = 'null';
}
if ($fecCertEscFian == '') {
    $fecCertEscFian = 'null';
}
if ($fecCertEscPren == '') {
    $fecCertEscPren = 'null';
}
if ($fecEscHip == '') {
    $fecEscHip = 'null';
}
if ($fecInsLea == '') {
    $fecInsLea = 'null';
}
if ($fecInstGtiaCar == '') {
    $fecInstGtiaCar = 'null';
}
if ($fecInstGtiaFian == '') {
    $fecInstGtiaFian = 'null';
}
if ($fecVtoGtia == '') {
    $fecVtoGtia = 'null';
}
if ($fecVtoOp == '') {
    $fecVtoOp = 'null';
}


/* Inserta en tabla hipoteca */


$sqlHip = "INSERT INTO hipoteca (cotizaHip, datGtiaHip, deudorHip, escDomHip,
fecInscHip, nomSegHip, nroInscHip, vtoSegHip) 
 VALUES($cotizaHip,'$datosHip','$deudorHip',$escDomHip,$fecEscHip,'$nomSegHip',$nroInsHip,'$vtoSegHip')";
$consultaHip = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlHip);


/* Inserta en tabla prenda */

$sqlPre = "INSERT INTO prenda (nomSegPre, vtoSegPre, cotizaPre, deudorPre, datGtiaPre, fecEscPre,
 nroInscPre) 
 VALUES('$nomSegPren','$vtoSegPren',$cotizaPren,'$deudorPren','$datosPren',$fecCertEscPren,$nroInsPren)";
$consultaPre = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlPre);


/* Inserta en tabla fianza */


$sqlFia = "INSERT INTO fianza (datAcue, datFiad, fecInscFia, fecEscFia, monto) 
 VALUES('$datAcuFian','$datFiaFian',$fecInstGtiaFian,$fecCertEscFian,$monto)";
$consultaFia = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlFia);


/* Inserta en tabla leasing */


$sqlLea = "INSERT INTO leasing (nroInscLea, nomSegLea, vtoSegLea, cotizaLea, fecEscLea, datGtiaLea) 
 VALUES($nroInsLea,'$nomSegLea','$vtoSegLea',$cotizaLea,$fecInsLea,'$datosLea')";
$consultaLea = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlLea);


/* Inserta en tabla compra de cartera */


$sqlCar = "INSERT INTO cartera (fecEscCart, fecInscCart, datCart) 
 VALUES($fecCertEscCar,$fecInstGtiaCar,'$datosCar')";
$consultaCar = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlCar);


/* busca id cartera */


$sqlIdCar = "SELECT id_cartera FROM cartera WHERE (fecEscCart = $fecCertEscCar OR fecEscCart IS NULL) AND (fecInscCart = $fecInstGtiaCar OR fecInscCart IS NULL) AND "
        . "datCart = '$datosCar'";
$resultIdCar = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlIdCar);
$idCar = 'null';
if ($resultIdCar) {
    $filasIdCar = sqlsrv_has_rows($resultIdCar);
    if ($filasIdCar) {
        while ($row = sqlsrv_fetch_array($resultIdCar, SQLSRV_FETCH_ASSOC)) {
            $idCar = $row['id_cartera'];
        }
    } else {
        $idCar = 'null';
    }
} else {
    $idCar = 'null';
}


/* busca id fianza */


$sqlIdFia = "SELECT id_fianza FROM fianza WHERE datAcue = '$datAcuFian' AND datFiad = '$datFiaFian' AND "
        . "(fecInscFia = $fecInstGtiaFian OR fecInscFia IS NULL) AND (fecEscFia = $fecCertEscFian OR fecEscFia IS NULL) AND (monto = $monto OR monto IS NULL)";
$resultIdFia = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlIdFia);
$idFia = 'null';
if ($resultIdFia) {
    $filasIdFia = sqlsrv_has_rows($resultIdFia);
    if ($filasIdFia) {
        while ($row = sqlsrv_fetch_array($resultIdFia, SQLSRV_FETCH_ASSOC)) {
            $idFia = $row['id_fianza'];
        }
    } else {
        $idFia = 'null';
    }
} else {
    $idFia = 'null';
}


/* busca id hipoteca */


$sqlIdHip = "SELECT id_hipoteca FROM hipoteca WHERE (cotizaHip = $cotizaHip OR cotizaHip IS NULL) AND datGtiaHip = '$datosHip' AND "
        . "deudorHip = '$deudorHip' AND (escDomHip = $escDomHip OR escDomHip IS NULL) AND (fecInscHip = $fecEscHip OR fecInscHip IS NULL) AND nomSegHip = '$nomSegHip' AND "
        . "(nroInscHip = $nroInsHip OR nroInscHip IS NULL) AND vtoSegHip = '$vtoSegHip'";
$resultIdHip = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlIdHip);
$idHip = 'null';
if ($resultIdHip) {
    $filasIdHip = sqlsrv_has_rows($resultIdHip);
    if ($filasIdHip) {
        while ($row = sqlsrv_fetch_array($resultIdHip, SQLSRV_FETCH_ASSOC)) {
            $idHip = $row['id_hipoteca'];
        }
    } else {
        $idHip = 'null';
    }
} else {
    $idHip = 'null';
}


/* busca id leasing */


$sqlIdLea = "SELECT id_leasing FROM leasing WHERE (nroInscLea = $nroInsLea OR nroInscLea IS NULL) AND nomSegLea = '$nomSegLea' AND "
        . "vtoSegLea = '$vtoSegLea' AND (cotizaLea = $cotizaLea OR cotizaLea IS NULL) AND (fecEscLea = $fecInsLea OR fecEscLea IS NULL) AND datGtiaLea = '$datosLea'";
$resultIdLea = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlIdLea);
$idLea = 'null';
if ($resultIdLea) {
    $filasIdLea = sqlsrv_has_rows($resultIdLea);
    if ($filasIdLea) {
        while ($row = sqlsrv_fetch_array($resultIdLea, SQLSRV_FETCH_ASSOC)) {
            $idLea = $row['id_leasing'];
        }
    } else {
        $idLea = 'null';
    }
} else {
    $idLea = 'null';
}


/* busca id prenda */


$sqlIdPren = "SELECT id_prenda FROM prenda WHERE nomSegPre = '$nomSegPren' AND "
        . "vtoSegPre = '$vtoSegPren' AND (cotizaPre = $cotizaPren OR cotizaPre IS NULL) AND deudorPre = '$deudorPren' AND datGtiaPre = '$datosPren' AND "
        . "(fecEscPre = $fecCertEscPren OR fecEscPre IS NULL) AND (nroInscPre = $nroInsPren OR nroInscPre IS NULL)";
$resultIdPren = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlIdPren);
$idPren = 'null';
if ($resultIdPren) {
    $filasIdPren = sqlsrv_has_rows($resultIdPren);
    if ($filasIdPren) {
        while ($row = sqlsrv_fetch_array($resultIdPren, SQLSRV_FETCH_ASSOC)) {
            $idPren = $row['id_prenda'];
        }
    } else {
        $idPren = 'null';
    }
} else {
    $idPren = 'null';
}


/* carga imagen garantia hipoteca en carpeta */


if (isset($_FILES['imagenGarHip'])) {
    $imagenes = $_FILES['imagenGarHip'];
    $cont = count($imagenes["name"]);
    for ($i = 0; $i < $cont; ++$i) {
        $name = $imagenes["name"][$i];
        $tmpName = $imagenes["tmp_name"][$i];
        $error = $imagenes["error"][$i];
        if ($error > 0) {
            "<br>Error: " . $error . "<br>";
        } else {
            move_uploaded_file($tmpName, "documents\\hipoteca\\" . $name);
        }
        $rutImgGtiaHip = "documents/hipoteca/" . $name;
        $documents = "documents/hipoteca/";
        if (strcmp($rutImgGtiaHip, $documents) == 0) {
            $rutImgGtiaHip = null;
        }
        if ($rutImgGtiaHip != null) {
            $sql = "INSERT INTO imagenesHipoteca (ruta, idHipoteca, tipo) VALUES('$rutImgGtiaHip',$idHip,'garantia')";
            $imghip = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        } else {
            $imghip = true;
        }
    }
}


/* carga imagen tasacion hipoteca en carpeta */


if (isset($_FILES['imagenTasHip'])) {
    $imagenes = $_FILES['imagenTasHip'];
    $cont = count($imagenes["name"]);
    for ($i = 0; $i < $cont; ++$i) {
        $name = $imagenes["name"][$i];
        $tmpName = $imagenes["tmp_name"][$i];
        $error = $imagenes["error"][$i];
        if ($error > 0) {
            "<br>Error: " . $error . "<br>";
        } else {
            move_uploaded_file($tmpName, "documents/hipoteca/" . $name);
        }
        $rutImgTasHip = "documents/hipoteca/" . $name;
        $documents = "documents/hipoteca/";
        if (strcmp($rutImgTasHip, $documents) == 0) {
            $rutImgTasHip = null;
        }
        if ($rutImgTasHip != null) {
            $sql = "INSERT INTO imagenesHipoteca (ruta, idHipoteca, tipo) VALUES('$rutImgTasHip',$idHip,'tasacion')";
            $imghiptas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        } else {
            $imghiptas = true;
        }
    }
}


/* carga imagen garantia prenda en carpeta */


if (isset($_FILES['imagenGarPren'])) {
    $imagenes = $_FILES['imagenGarPren'];
    $cont = count($imagenes["name"]);
    for ($i = 0; $i < $cont; ++$i) {
        $name = $imagenes["name"][$i];
        $tmpName = $imagenes["tmp_name"][$i];
        $error = $imagenes["error"][$i];
        if ($error > 0) {
            "<br>Error: " . $error . "<br>";
        } else {
            move_uploaded_file($tmpName, "documents/prenda/" . $name);
        }
        $rutImgGarPren = "documents/prenda/" . $name;
        $documents = "documents/prenda/";
        if (strcmp($rutImgGarPren, $documents) == 0) {
            $rutImgGarPren = null;
        }
        if ($rutImgGarPren != null) {
            $sql = "INSERT INTO imagenesPrenda (ruta, idPrenda, tipo) VALUES('$rutImgGarPren',$idPren,'garantia')";
            $imgpren = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        } else {
            $imgpren = true;
        }
    }
}


/* carga imagen tasacion prenda en carpeta */


if (isset($_FILES['imagenTasPren'])) {
    $imagenes = $_FILES['imagenTasPren'];
    $cont = count($imagenes["name"]);
    for ($i = 0; $i < $cont; ++$i) {
        $name = $imagenes["name"][$i];
        $tmpName = $imagenes["tmp_name"][$i];
        $error = $imagenes["error"][$i];
        if ($error > 0) {
            "<br>Error: " . $error . "<br>";
        } else {
            move_uploaded_file($tmpName, "documents/prenda/" . $name);
        }
        $rutImgTasPren = "documents/prenda/" . $name;
        $documents = "documents/prenda/";
        if (strcmp($rutImgTasPren, $documents) == 0) {
            $rutImgTasPren = null;
        }
        if ($rutImgTasPren != null) {
            $sql = "INSERT INTO imagenesPrenda (ruta, idPrenda,tipo) VALUES('$rutImgTasPren',$idPren,'tasacion')";
            $imgprentas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        } else {
            $imgprentas = true;
        }
    }
}


/* carga imagen garantia fianza en carpeta */


if (isset($_FILES['imagenGarFian'])) {
    $imagenes = $_FILES['imagenGarFian'];
    $cont = count($imagenes["name"]);
    for ($i = 0; $i < $cont; ++$i) {
        $name = $imagenes["name"][$i];
        $tmpName = $imagenes["tmp_name"][$i];
        $error = $imagenes["error"][$i];
        if ($error > 0) {
            "<br>Error: " . $error . "<br>";
        } else {
            move_uploaded_file($tmpName, "documents/fianza/" . $name);
        }
        $rutImgGarFian = "documents/fianza/" . $name;
        $documents = "documents/fianza/";
        if (strcmp($rutImgGarFian, $documents) == 0) {
            $rutImgGarFian = null;
        }
        if ($rutImgGarFian != null) {
            $sql = "INSERT INTO imagenesFianza (ruta, idFianza, tipo) VALUES('$rutImgGarFian',$idFia,'garantia')";
            $imgfian = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        } else {
            $imgfian = true;
        }
    }
}


/* carga imagen garantia leasing en carpeta */


if (isset($_FILES['imagenGarLea'])) {
    $imagenes = $_FILES['imagenGarLea'];
    $cont = count($imagenes["name"]);
    for ($i = 0; $i < $cont; ++$i) {
        $name = $imagenes["name"][$i];
        $tmpName = $imagenes["tmp_name"][$i];
        $error = $imagenes["error"][$i];
        if ($error > 0) {
            "<br>Error: " . $error . "<br>";
        } else {
            move_uploaded_file($tmpName, "documents/leasing/" . $name);
        }
        $rutImgGarLea = "documents/leasing/" . $name;
        $documents = "documents/leasing/";
        if (strcmp($rutImgGarLea, $documents) == 0) {
            $rutImgGarLea = null;
        }
        if ($rutImgGarLea != null) {
            $sql = "INSERT INTO imagenesLeasing (ruta, idLeasing,tipo) VALUES('$rutImgGarLea',$idLea,'garantia')";
            $imglea = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        } else {
            $imglea = true;
        }
    }
}


/* carga imagen tasacion leasing en carpeta */


if (isset($_FILES['imagenTasLea'])) {
    $imagenes = $_FILES['imagenTasLea'];
    $cont = count($imagenes["name"]);
    for ($i = 0; $i < $cont; ++$i) {
        $name = $imagenes["name"][$i];
        $tmpName = $imagenes["tmp_name"][$i];
        $error = $imagenes["error"][$i];
        if ($error > 0) {
            "<br>Error: " . $error . "<br>";
        } else {
            move_uploaded_file($tmpName, "documents/leasing/" . $name);
        }
        $rutImgTasLea = "documents/leasing/" . $name;
        $documents = "documents/leasing/";
        if (strcmp($rutImgTasLea, $documents) == 0) {
            $rutImgTasLea = null;
        }
        if ($rutImgTasLea != null) {
            $sql = "INSERT INTO imagenesLeasing (ruta, idLeasing,tipo) VALUES('$rutImgTasLea',$idLea,'tasacion')";
            $imgleatas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        } else {
            $imgleatas = true;
        }
    }
}


/* carga imagen garantia cartera en carpeta */


if (isset($_FILES['imagenGarCar'])) {
    $imagenes = $_FILES['imagenGarCar'];
    $cont = count($imagenes["name"]);
    for ($i = 0; $i < $cont; ++$i) {
        $name = $imagenes["name"][$i];
        $tmpName = $imagenes["tmp_name"][$i];
        $error = $imagenes["error"][$i];
        if ($error > 0) {
            "<br>Error: " . $error . "<br>";
        } else {
            move_uploaded_file($tmpName, "documents/cartera/" . $name);
        }
        $rutImgGarCar = "documents/cartera/" . $name;
        $documents = "documents/cartera/";
        if (strcmp($rutImgGarCar, $documents) == 0) {
            $rutImgGarCar = null;
        }
        if ($rutImgGarCar != null) {
            $sql = "INSERT INTO imagenesCartera (ruta, idCartera,tipo) VALUES('$rutImgGarCar',$idCar,'garantia')";
            $imgcar = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        } else {
            $imgcar = true;
        }
    }
}


/* carga imagen contrato cartera en carpeta */


if (isset($_FILES['imagenConCar'])) {
    $imagenes = $_FILES['imagenConCar'];
    $cont = count($imagenes["name"]);
    for ($i = 0; $i < $cont; ++$i) {
        $name = $imagenes["name"][$i];
        $tmpName = $imagenes["tmp_name"][$i];
        $error = $imagenes["error"][$i];
        if ($error > 0) {
            "<br>Error: " . $error . "<br>";
        } else {
            move_uploaded_file($tmpName, "documents/cartera/" . $name);
        }
        $rutImgConCar = "documents/cartera/" . $name;
        $documents = "documents/cartera/";
        if (strcmp($rutImgConCar, $documents) == 0) {
            $rutImgConCar = null;
        }
        if ($rutImgConCar != null) {
            $sql = "INSERT INTO imagenesCartera (ruta, idCartera,tipo) VALUES('$rutImgConCar',$idCar,'contrato')";
            $imgcarcon = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        } else {
            $imgcarcon = true;
        }
    }
}


/* carga imagen pagare cartera en carpeta */


if (isset($_FILES['imagenPagCar'])) {
    $imagenes = $_FILES['imagenPagCar'];
    $cont = count($imagenes["name"]);
    for ($i = 0; $i < $cont; ++$i) {
        $name = $imagenes["name"][$i];
        $tmpName = $imagenes["tmp_name"][$i];
        $error = $imagenes["error"][$i];
        if ($error > 0) {
            "<br>Error: " . $error . "<br>";
        } else {
            move_uploaded_file($tmpName, "documents/cartera/" . $name);
        }
        $rutImgPagCar = "documents/cartera/" . $name;
        $documents = "documents/cartera/";
        if (strcmp($rutImgPagCar, $documents) == 0) {
            $rutImgPagCar = null;
        }
        if ($rutImgPagCar != null) {
            $sql = "INSERT INTO imagenesCartera (ruta, idCartera,tipo) VALUES('$rutImgPagCar',$idCar,'pagare')";
            $imgcarpag = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
        } else {
            $imgcarpag = true;
        }
    }
}


/* Inserta en tabla Garantia */


$sqlGar = "INSERT INTO garantia (id_cartera, id_fianza, id_hipoteca, id_leasing, id_prenda, descProd,
    estado, entGtia, fecAltaOpe, fecVtoGtia, fecVtoOpe, gesCan, moneda, nomCli, nroCli, nroGtia, prodGtia,
    prodCred, observacion, oriGtia, opeRela, sav, sucursal, valNomi) 
 VALUES($idCar,$idFia,$idHip,$idLea,$idPren,'$desPro','$estGtiaOpe','$entGar',$fecAltOp,$fecVtoGtia,"
        . "$fecVtoOp,'$gesCan',$moneda,'$nomCli',$nroCli,$nroGtia,'$proGtia',$proCre,'$observacion',"
        . "'$oriGtia',$opeRel,$sav,$sucursal,$valNom)";
$consultaGar = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlGar);


/* guarda en base de datos si los insert son correctos */


$html = '';
if ($consultaHip && $consultaCar && $consultaFia && $consultaGar && $consultaLea && $consultaPre && $imgcar && $imgcarcon && $imgcarpag && $imgfian && $imghip && $imghiptas && $imglea && $imgleatas && $imgpren && $imgprentas) {
    sqlsrv_commit(BDConexion::getInstancia()->getConexion());
	function mensaje(){
    $html = '
                    <h1><u>Guardado con exito</u></h1>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
';
return $html;
	}
} else {
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
	function mensaje(){
    $html = '
                    <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Guardar</h2></div>
                    <h3><u>Revise la sintaxis del formulario, recuerde no colocar comillas simples, comillas dobles o comas en los campos.</u></h3>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
';
return $html;
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
                <div class="col-lg-12 text-center">
                    <?php echo $output = mensaje(); ?>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="principal3.php">
                        <button class="btn btn-lg btn-bsc btn-block" type="submit">Cargar</button>
                    </a>
                </div>
                <div class="col-lg-2 text-center">
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formBuscarGarantia.php">
                        <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar</button>
                    </a>
                </div>
                <div class="col-lg-2 text-center">
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="inicioGarantias.php">
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