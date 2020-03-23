<?php

include_once '../conf/BDConexion.php';
require_once '../conf/Constants.php';
require_once '../../lib/PHPExcel/Classes/PHPExcel.php';
require_once '../conf/Log.php';
session_start();
$print = "";


date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("d-m-Y");
$imagenes = $_FILES['imagenTasPren'];
$name = $imagenes["name"][0];
$tmpName = $imagenes["tmp_name"][0];
$destino = CREDI . "\\" . $name;
$movido = move_uploaded_file($tmpName, $destino);
$archivo = $name;
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();


//empieza insert a BD

$sql = "INSERT INTO [bd_sib].[dbo].[4pmdeb]
           ([causal]
           ,[tipocta]
           ,[sucursal]
           ,[cuenta]
           ,[digito]
           ,[monto]
		   ,[fechaActualizacion])
     VALUES ";
	 
//empieza creacion de archivo PMDEB

$hasta = date("d/m/y", strtotime($actual));
$fecha = str_replace("/","",$hasta);
$url = URL_PMDEB . "\\".$actual."-PMDEB-SIB.txt";
$archivo = file_exists($url) ? fopen($url, 'a') : fopen($url, 'w');
	
$head = "0HEAD 00000000   000000000000000000000{$fecha}000000000000000000000000000000000000000000 000000             00                            000000000000000000000000000000000000000000000000000  0000000000000000000000                                                                                                       000000". PHP_EOL;
	
fwrite($archivo, $head);

$contador = 0;
	
for ($row = 2; $row <= $highestRow; $row++){ 

	//saca datos del excel y guarda en BD
		
	$causal = $sheet->getCell("A".$row)->getValue();
	$tipo = $sheet->getCell("B".$row)->getValue();
	$sucursal = $sheet->getCell("C".$row)->getValue();
	$cuenta = $sheet->getCell("D".$row)->getValue();
	$digito = $sheet->getCell("E".$row)->getValue();
	$monto = $sheet->getCell("F".$row)->getValue();
	$sql = $sql . "($causal,'$tipo',$sucursal,$cuenta,$digito,'$monto','$actual'),";
		
	//carga datos en PMDEB
		
	$contador = $contador + 1;
			
	$contador2 = str_pad($contador, 6, 0, STR_PAD_LEFT);
			
	//primera linea contador autoincremental
			
	$linea = "      {$contador2}           ";
	
	//tipo de cuenta si es cuenta corriente o caja de ahorro
			
	if($tipo == 'CC'){
		$tipoCuenta = 1;
		$transaccion = 170;
	} else {
		$tipoCuenta = 2;
		$transaccion = 270;
	}
	
	//sucursal
			
	$sucursal = str_pad($sucursal, 3, 0, STR_PAD_LEFT);
			
	//cuenta
			
	$cuenta = str_pad($cuenta, 6, 0, STR_PAD_LEFT);
	
	//monto
		
	if(substr_count($monto, '.') == 1){
		if(substr_count(substr($monto,-2), '.') == 1){
			$monto = $monto . "0";
			$monto = str_replace(".","",$monto);
			$monto = str_pad($monto, 14, 0, STR_PAD_LEFT);
		}else {
			$monto = str_replace(".","",$monto);
			$monto = str_pad($monto, 14, 0, STR_PAD_LEFT);
		}
	}else {
		$monto = $monto . "00";
		$monto = str_pad($monto, 14, 0, STR_PAD_LEFT);
	}
	
	//linea
			
	$final = "N000000N          NN00 OFF LINE         OFF LINE  000000000000000000000000000000000000000000000000000  0000000000000000000000                                                                                                       000000";
			
	$linea = $linea . "20{$tipoCuenta}80{$sucursal}{$cuenta}{$digito}{$fecha}000000000095{$transaccion}{$causal}0000000000{$monto}{$final}". PHP_EOL;

	//escribe la linea

	fwrite($archivo, $linea);
}

//pie del archivo
		
$footer= "0TAIL 00000000   000000000000000000000{$fecha}000000000000000000000000000000000000000000 000000             00                            000000000000000000000000000000000000000000000000000  0000000000000000000000                                                                                                       000000". PHP_EOL;
	
//escribe el pie del archivo
	
fwrite($archivo, $footer);
	
$sql = trim($sql, ',');

$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);


unlink($name);

if ($contador > 0) {
        $print = '
        <br>
        <h4 class="text-center p-4">GENERAR PMDEB</h4>
        <div class="container">
            <div class="alert alert-success text-center" role="alert"> Cantidad de clientes procesados: ' . $contador . ' </div>
            <form action="procesarDescargarPmdeb.php" method="post">
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" value="Descargar">
                            <a href="pmdeb.php">
                                <input type="button" class="btn btn-dark" value="Volver">
                            </a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>';
    } else {
        $print = '<br>
        <h4 class="text-center p-4">GENERAR ARCHIVOS TXT</h4>
        <div class="container">
            <div class="alert alert-warning text-center" role="alert"> Cantidad de clientes procesados: ' . $contador . ' </div>
        </div>';
    }

include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();


/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
	<?= $print; ?>
</div>


