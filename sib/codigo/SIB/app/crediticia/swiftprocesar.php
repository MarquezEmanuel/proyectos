<?php

require_once '../conf/Constants.php';
require_once '../../lib/PHPExcel/Classes/PHPExcel.php';
require_once '../conf/Log.php';

$print = "";

//CREA ARCHIVO TEMPORAL PARA TRABAJAR EN DIRECTORIO CREDI

date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("d-m-Y");
$ingreso = $_FILES['archivoSwift'];
$name = $ingreso["name"][0];
$tmpName = $ingreso["tmp_name"][0];
$destino = CREDI . "\\" . $name;
$movido = move_uploaded_file($tmpName, $destino);
$archivo = $name;
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

$contador = 0;

//BUSCA EL ID DEL APLICATIVO

$sql = "SELECT id FROM [BD_Formulario].[dbo].[aplicativo] WHERE nombre LIKE ''Swift''";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
	$idSwift = $row['id'];
}

//CONSULTA PARA BORRAR

$sql2 = "DELETE FROM [dbo].[usuarioAcceso] WHERE aplicativo = {$idSwift}";

//CONSULTA PARA INSERTAR USUARIOS

$consulta = "INSERT INTO [dbo].[usuarioAcceso]
           ([legajo]
           ,[nombre]
           ,[perfil]
           ,[estado]
           ,[aplicativo]
           ,[fechaActualizacion]) VALUES ";
	
for ($row = 17; $row <= $highestRow; $row++){ 

	//saca datos del excel y crea insert
		
	$legajo = $sheet->getCell("A".$row)->getValue();
	$nombre = $sheet->getCell("B".$row)->getValue();
	$perfil = $sheet->getCell("C".$row)->getValue();
	$estado = $sheet->getCell("F".$row)->getValue();
	
	if(is_numeric($causal)){
		$consulta .= "('{$legajo}','{$nombre}','{$perfil}','{$estado}',{$idSwift},'{$actual}'),";
	}		
	 $contador ++;	
}

//BORRA ARCHIVO TEMPORAL

unlink($name);

//RESPUESTA SI AGREGO USUARIOS

if ($contador > 0) {
	
	//BORRA BASE ANTERIOR
	
	sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql2);
	
	//AGREGA BASE NUEVA
	
	sqlsrv_query(BDConexion::getInstancia()->getConexion(), substr($consulta, 0, -1));	
	
    $print = '<br>
        <h4 class="text-center p-4">ARCHIVO SWIFT</h4>
        <div class="container">
            <div class="alert alert-success text-center" role="alert"> Cantidad de usuarios agregados: ' . $contador . ' </div>
        </div>';
    } else {
        $print = '<br>
        <h4 class="text-center p-4">ARCHIVO SWIFT</h4>
        <div class="container">
            <div class="alert alert-warning text-center" role="alert"> Cantidad de usuarios agregados: ' . $contador . ' </div>
        </div>';
}

/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
	<?= $print; ?>
</div>


