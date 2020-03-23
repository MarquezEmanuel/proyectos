<?php
 include('pruactive.php');
function validarPermiso()
{ 
	global $ad_dc, $ad_dominio, $ad_dn, $grupos_permitidos;
	
	$ad_dc			=	'DCBSC0010.santacruz.net';

$ad_dominio		=	'SANTACRUZ';

$ad_dn			=	'DC=santacruz,DC=net';

$grupos_permitidos = array('Gestion y Control de TI');

	$adh = new pruactive();
	$adh->connect($ad_dc);
	$adh->setOptions();
	$adh->bind('SANTACRUZ\svpprod', 'FME168qu');	
	
	$env = obtenerDatosEntorno();
	$tmp = $_SERVER['LOGON_USER'];
	
	//--Agregado 1
//	fputs($log,'MENSAJE DE CONEXIÓN: |'.$adh->error().'|'."\n");
//	fputs($log, 'USUARIO CON DOMINIO: |'.$tmp.'|'."\n");
	//--Fin agregado 1
	
	$usr = quitarDominio($tmp, $ad_dominio);
		
	$filtro = '(&(objectclass=person)(!(objectclass=contact))(!(objectclass=computer))(samaccountname='.$usr.'))';
	
	//--Agregado 2
//	fputs($log,'FILTRO UTILIZADO: |'.$filtro.'|'."\n");
	//--Fin agregado 2
	
    $atributos = array('samaccountname', 'memberof');
	$adh->search($ad_dn, $filtro, $atributos);
	
	//--Agregado 3 parsearResultado()
//	fputs($log,"RESULTADO PARSEADO: \n".$adh->parsearResultado()."\n");
//	fputs($log,'MENSAJE DE BÚSQUEDA DE GRUPOS: |'.$adh->error().'| CÓDIGO: |'.$adh->errno()."|\n");
	//--Fin agregado 3
	
	$entradas = $adh->get_entries();
	
	//--Agregado 4
//	fputs($log,'MENSAJE DESPUÉS DE OBTENER ENTRADAS: |'.$adh->error().'| CÓDIGO: |'.$adh->errno()."|\n");
	//--Fin agregado 4
	
    $autorizado = false;		## ESTE ES FALSE
	

	if ($entradas['count'] == 1)
	{
		if ($entradas[0]['memberof']['count'] > 0)
		{
			$grupos_dn = $entradas[0]['memberof'];
			
			
//			fputs($log,"GRUPOS ENCONTRADOS: "."\n");
			for ($i=0; $i<$grupos_dn['count']; $i++)
			{

				$grupo = explode(',', $grupos_dn[$i]);
				$grupo = str_replace('CN=', '', $grupo);
				
								
//				fputs($log,$grupo[0]."\n");
				
				if (in_array($grupo[0], $grupos_permitidos))
					$autorizado = true;
			}
		}
	}
    
	$adh->unbind();
	
	return $autorizado;
}

function obtenerDatosEntorno()
{
	$ip = '';
	$proxy = '';
	$logon_user = '';
	
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$proxy = $_SERVER['HTTP_CLIENT_IP'];
		else
			$proxy = $_SERVER['REMOTE_ADDR'];
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		else
			$ip = $_SERVER['REMOTE_ADDR'];
	}
	if (isset($_SERVER['LOGON_USER']))
		$logon_user = $_SERVER['LOGON_USER'];
	
	$ret['ip'] = $ip;
	$ret['proxy'] = $proxy;
	$ret['maquina'] = gethostbyaddr($ip);
	$ret['logon_user'] = $logon_user;
	
	return $ret;
	
    
}

function quitarDominio($logon_user, $dominio)
{
	if ($dominio[strlen($dominio)-1] == '\\')
	{
		$ret = str_ireplace($dominio, '', $logon_user);
	}
	else
	{
		$ret = str_ireplace($dominio.'\\', '', $logon_user);
	}
	return $ret;
}


function obtenerGrupo($usr)
{

    // variables cargadas en config.inc.php 
	$ad_dc			=	'DCBSC0010.santacruz.net';

$ad_dominio		=	'SANTACRUZ';

$ad_dn			=	'DC=santacruz,DC=net';

$grupos_permitidos = array('Gestion y Control de TI');

	// conexion 
	$objet = new pruactive();
	$objet->connect($ad_dc);
	$objet->setOptions();
	$objet->bind('SANTACRUZ\svpprod', 'FME168qu');

	
	$filtro = '(&(objectclass=person)(!(objectclass=contact))(!(objectclass=computer))(samaccountname='.$usr.'))';
	$atributos = array('memberof'); // perfil
	$objet->search($ad_dn, $filtro, $atributos);
	$entradas = $objet->get_entries();
	$perfil = '';
	if ($entradas['count'] > 0)
	{
		if ($entradas[0]['memberof']['count'] > 0)
		{
		  $contador =  $entradas[0]['memberof']['count'];
		  for ($contador; $contador >= 0 ; $contador--)
		  {
			$data   = str_replace('CN=', '', $entradas[0]['memberof'][$contador]);
			$perfil = explode ("," , $data);
			
            $buscar = "CodigoDescuento";
            $temp = current($perfil);
            $longitud = strlen($buscar);
			
            while($temp)
            {
              $sub=substr($temp,0,$longitud); 

              if(strtoupper($sub)==strtoupper($buscar))
                { 
				 return str_replace('CodigoDescuento','',$temp);
                } 
                 $temp=next($perfil);
            }

		  }	
		}
	}
	return $perfil;
}

$validarPer = validarPermiso();
$obtieneGru = obtenerGrupo(quitarDominio($_SERVER['LOGON_USER'],'SANTACRUZ'));
?>
<form action="all.php" method="post">
<div class="form-group row">
						<label for="causal" class="col-sm-2 col-form-label">Validar Permiso:</label>
                        <div class="col">
                            <?php echo $validarPer;?>
                        </div>  
						</div>
<div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Obtener grupo:</label>
                        <div class="col">
							<?php for($i = 0; $i <= count($obtieneGru); $i++){
										echo current($obtieneGru);
										next($obtieneGru);
										echo '<br>'; }?>
                        </div>  
						</div>
<a href="pruad.php"><input type="button" class="btn btn-secondary my-2 my-sm-0" value="Salir"></a>
</form>






