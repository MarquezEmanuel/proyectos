<?php

require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');
	$actual = date("Y-m-d");

if (isset($_POST['transacciones'])) {
	
	$transacciones = $_POST['transacciones'];

	$hasta = date("d/m/y", strtotime($actual));
	$fecha = str_replace("/","",$hasta);
	$hora = date("H");
	$minutos = date("i");
	
	$url = URL_RTEOC . "\\PMCRED-PMDEB-SIB.txt";
	$archivo = file_exists($url) ? fopen($url, 'a') : fopen($url, 'w');
		
	$head = "0HEAD 00000000   000000000000000000000{$fecha}000000000000000000000000000000000000000000 000000             00                            000000000000000000000000000000000000000000000000000  0000000000000000000000                                                                                                       000000". PHP_EOL;
	
	fwrite($archivo, $head);
	
	$contador = 0;

	$log = new Log();
            $log->writeLine("final");

    foreach ($transacciones as $referencia) {

        $busca = "select * from [10pmcred] WHERE id = ". $referencia;

		$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $busca);
        
        if ($result) {
			
            $contador = $contador + 1;

            $cuenta = sqlsrv_fetch_array($result);
			
			$contador2 = str_pad($contador, 6, 0, STR_PAD_LEFT);
			
			//primera linea contador autoincremental
			
			$linea = "      {$contador2}           ";
			
			//tipo de cuenta si es cuenta corriente o caja de ahorro
			
			if($cuenta['tipoCuenta'] == 'cc'){
				$tipoCuenta = 01;
			} else {
				$tipoCuenta = 02;
			}
			
			//tipo de moneda
			
			$moneda = str_pad($cuenta['moneda'], 2, 0, STR_PAD_LEFT);
			
			//sucursal
			
			$sucursal = str_pad($cuenta['sucursal'], 3, 0, STR_PAD_LEFT);
			
			//cuenta
			
			$cuentaNume = str_pad($cuenta['numeroCuenta'], 6, 0, STR_PAD_LEFT);
			
			//digito
			
			$digito = $cuenta['digito'];
			
			//fecha de la transaccion
			
			$fechaTransaccion = isset($cuenta['fecha']) ? $cuenta['fecha']->format('d/m/y') : "";
			
			$fechaTransaccion = str_replace("/","",$fechaTransaccion);
			
			//oficina
			
			$oficina = str_pad($cuenta['oficina'], 3, 0, STR_PAD_LEFT);
			
			//codigo de la transaccion saber si es cc o ca revisar codigos
			
			if($cuenta['tipo'] == 'debito'){
				$transaccion = 150;
			} else {
				$transaccion = 120;
			}
			
			//causal
			
			$causal = str_pad($cuenta['causal'], 3, 0, STR_PAD_LEFT);
			
			//monto
			
			$monto = str_pad($cuenta['importe'], 14, 0, STR_PAD_LEFT);
			
			//linea
			
			$final = "N000000N          NN00 OFF LINE         OFF LINE  000000000000000000000000000000000000000000000000000  0000000000000000000000                                                                                                       000000";
			
			$linea = $linea . "2{$tipoCuenta}{$moneda}{$sucursal}{$cuentaNume}{$digito}{$fechaTransaccion}000000000{$oficina}{$transaccion}{$causal}0000000000{$monto}{$final}". PHP_EOL;

			//escribe la linea

			fwrite($archivo, $linea);
			
        } else {
            $log = new Log();
            $log->writeLine("[Error al consultar la base de datos][QUERY: $query");
        }
    }
	
	//pie del archivo
		
	$footer= "0TAIL 00000000   000000000000000000000{$fecha}000000000000000000000000000000000000000000 000000             00                            000000000000000000000000000000000000000000000000000  0000000000000000000000                                                                                                       000000". PHP_EOL;
	
	//escribe el pie del archivo
	
	fwrite($archivo, $footer);
	
    $recibidos = count($transacciones);

    if ($contador > 0) {
        echo '
        <br>
        <h4 class="text-center p-4">GENERAR ARCHIVOS TXT</h4>
        <div class="container">
            <div class="alert alert-success text-center" role="alert"> Cantidad de clientes procesados: ' . $contador . ' de ' . $recibidos . ' </div>
            <form action="procesarDescargarGeneracion.php" method="post">';
        foreach ($archivos as $referencia) {
            echo "<input type='hidden' id='transacciones' name='transacciones[]' value='{$referencia}'>";
        }
        echo '
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" value="Descargar">
                            <a href="inicio.php">
                                <input type="button" class="btn btn-dark" value="Cancelar">
                            </a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>';
    } else {
        echo '<br>
        <h4 class="text-center p-4">GENERAR ARCHIVOS TXT</h4>
        <div class="container">
            <div class="alert alert-warning text-center" role="alert"> Cantidad de clientes procesados: ' . $contador . ' de ' . $recibidos . ' </div>
        </div>';
    }
} else {
    echo '<br>
    <h4 class="text-center p-4">GENERAR ARCHIVOS TXT</h4>
    <div class="container">
        <div class="alert alert-danger text-center" role="alert"> No se recibieron clientes fallecidos para procesar </div>
    </div>';
}







