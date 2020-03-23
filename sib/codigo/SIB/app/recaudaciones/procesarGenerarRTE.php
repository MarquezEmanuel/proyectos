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
	
	$log = new Log();
            $log->writeLine("principio");

	$hasta = date("d/m/y", strtotime($actual));
	$fecha = str_replace("/","",$hasta);
	$hora = date("H");
	$minutos = date("i");
	
	$url = URL_RTEOC . "\\FallecidosCuentaAnses.txt";
	$archivo = file_exists($url) ? fopen($url, 'a') : fopen($url, 'w');
	
	
	$head = "0HEAD 00000000   000000000000000000000{$fecha}000000000000000000000000000000000000000000 000000             00                            000000000000000000000000000000000000000000000000000  0000000000000000000000                                                                                                       000000". PHP_EOL;
	
	fwrite($archivo, $head);
	
	$contador = 0;
	$numero = 120000;


	$log = new Log();
            $log->writeLine("final");

    foreach ($transacciones as $referencia) {
		
		$log = new Log();
            $log->writeLine("[Entra");

        $busca = "select *,convert(varchar,cast(SALDO as money),1) AS SALDO2,convert(varchar,cast(MONTOBLOQUEO as money),1) AS MONTOBLOQUEO2
										from openquery (M4000SF, 'SELECT DISTINCT MOL.HCNCLIREL CLIRELACIONADOS,
                                                                     MOL.HCU_PRODU PRODUCTO, 
                                                                     MOL.HCU_OFICI SUCURSAL, 
                                                                     MOL.HCUNUMCUE CUENTA, 
                                                                     MOL.HCUDIGVER DIGITO, 
                                                                     MOL.HNO_CUENT NOMCUENTA, 
                                                                     MOL.HSAEFEHOY SALDO,
                                                                     MOL.SCO_IDENT CODCLIENTE,
                                                                     MCL.SNO_CLIEN NOMCLIENTE,
                                                                     MCL.SFEFALLEC FALLECIMIENTO,
                                                                     MCL.SFENOVFAL NOVEDAD,
                                                                     ABL.ACO_BLOQU TIPOBLOQUEO,
																	 TB.ANO_BLOQU DESCBLOQUEO,
                                                                     ABL.TVA_MOVIM MONTOBLOQUEO,
																	 MOL.HCU_MONED MONEDA
                                                            FROM SFB_AHMOL MOL
                                                            INNER JOIN SFB_BSMCL MCL ON MCL.SCO_IDENT = MOL.SCO_IDENT AND MCL.SFEFALLEC <> 0 AND MOL.HSAEFEHOY <> 0.00
                                                            INNER JOIN SFB_AHABL ABL ON ABL.HCU_OFICI = MOL.HCU_OFICI AND ABL.HCUNUMCUE = MOL.HCUNUMCUE AND ABL.HCUDIGVER = MOL.HCUDIGVER
															INNER JOIN SFB_AAMTB TB ON TB.ACO_BLOQU = ABL.ACO_BLOQU
                                                            WHERE MOL.HCOESTCUE = 1 AND MOL.HCU_PRODU IN (215, 237, 248, 249, 246, 269)') WHERE CUENTA = ". $referencia;

		$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $busca);
        
        if ($result) {
			
            $contador = $contador + 1;

            $cuenta = sqlsrv_fetch_array($result);

			$numero = $numero + 1;
			
			$contador2 = str_pad($contador, 10, 0, STR_PAD_LEFT);
			
			$monto = str_replace(",","",$cuenta['SALDO2']);
			
			$monto = str_replace(".","",$monto);
			
			$monto = str_pad($monto, 14, 0, STR_PAD_LEFT);
			
			$linea = "      {$numero}           ";			
			
			$moneda = str_pad($cuenta['MONEDA'], 2, 0, STR_PAD_LEFT);
			
			$sucursal = str_pad($cuenta['SUCURSAL'], 3, 0, STR_PAD_LEFT);
			
			$cuentaNum = str_pad($cuenta['CUENTA'], 6, 0, STR_PAD_LEFT);
			
			$digito = $cuenta['DIGITO'];
			
			$final = "N000000N          NN00 DEBITO AUTOMATICODebAutomat000000000000000000000000000000000000000000000000000  0000000000000000000000                                                                                                       000000";
			
			$linea = $linea . "202{$moneda}{$sucursal}{$cuentaNum}{$digito}{$fecha}00000{$hora}{$minutos}095250682{$contador2}{$monto}{$final}". PHP_EOL;

			fwrite($archivo, $linea);
			
			//linea dos para creditos
			
			$numero = $numero + 1;
			
			$linea2 = "      {$numero}           ";	
			
			$contador = $contador + 1;
			
			$contador2 = str_pad($contador, 10, 0, STR_PAD_LEFT);
			
			$linea2 = $linea2 . "201{$moneda}0012292024{$fecha}00000{$hora}{$minutos}095120682{$contador2}{$monto}{$final}". PHP_EOL;
			
			fwrite($archivo, $linea2);
			
        } else {
            $log = new Log();
            $log->writeLine("[Error al consultar la base de datos][QUERY: $query");
        }
    }
	
	
	$footer= "0TAIL 00000000   000000000000000000000{$fecha}000000000000000000000000000000000000000000 000000             00                            000000000000000000000000000000000000000000000000000  0000000000000000000000                                                                                                       000000". PHP_EOL;
	
	fwrite($archivo, $footer);
	
    $recibidos = count($transacciones);

    if ($contador > 0) {
        echo '
        <br>
        <h4 class="text-center p-4">GENERAR ARCHIVOS TXT</h4>
        <div class="container">
            <div class="alert alert-success text-center" role="alert"> Cantidad de clientes procesados: ' . $contador/2 . ' de ' . $recibidos . ' </div>
            <form action="procesarDescargarRTE.php" method="post">';
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







