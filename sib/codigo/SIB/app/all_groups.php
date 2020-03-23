<?php

$tmp = $_SERVER['LOGON_USER'];
$ad_dominio = "SANTACRUZ";
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

echo $algo = quitarDominio($tmp, $ad_dominio);

?>
