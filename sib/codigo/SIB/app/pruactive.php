<?php

class pruactive
{
	var $conn; // RES; handle de la conexion
	var $bind; // T o F; lleva control de si esta bindeada la conexion o no
	var $result; // RES; handle de la busqueda
	var $entries; // ARRAY; variable para almacenar los resultados de la busqueda

	var $hostname; // STRING; variable para almacenar el host del directorio
	var $username; // STRING; variable para almacenar el usuario de logon al directorio
	var $password; // STRING; variable para almacenar la contraseña de logon al directorio
	

	function pruactive()
	{
		// constructor al dope
	}
	
	function connect($host = '')
	{
		if (!empty($host)) 
		{
			$this->hostname = $host;
			
			$this->conn = ldap_connect($this->hostname,389);
		}
	}
	
	function setOptions()
	{
		$ret1 = ldap_set_option($this->conn, LDAP_OPT_PROTOCOL_VERSION, 3);
		$ret2 = ldap_set_option($this->conn, LDAP_OPT_REFERRALS, 0);
		
		if ($ret1 && $ret2)
			return true;
		else
			return false;
	}
	
	function bind($user = '', $pass = '')
	{
		if (!empty($user))
			$this->username = $user;
		if (!empty($pass))
			$this->password = $pass;

		if (is_resource($this->conn))
			$this->bind = ldap_bind($this->conn, $this->username, $this->password);
		else
			$this->bind = false;

		return $this->bind;
	}
	
	function unbind()
	{
		if ($this->bind)
			if (ldap_unbind($this->conn))
				$this->bind = false;
	}
	
	function search($base_dn = '', $filtro = '', $atributos)
	{
		if ($this->bind)
			$this->result = ldap_search($this->conn, $base_dn, $filtro, $atributos);
	}
	
	function get_entries()
	{ 
		if ($this->bind)
		{ 
			if (is_resource($this->result))
			{
				$this->entries = ldap_get_entries($this->conn, $this->result);
				$ret = $this->entries;
				if (!is_array($this->entries))
					$ret = false;
			}
			else
				$ret = false;
		}
		else
			$ret = false;

		return $ret;
	}
	

	function error()
	{
		return ldap_error($this->conn);
	}

	function errno()
	{
		return ldap_errno($this->conn);
	}
	
	//Función agregada
	function parsearResultado()
	{
		$errcode = $dn = $errmsg = $refs = null;
		
		$mensaje_final = "SIN RESULTADO";
		
		if (ldap_parse_result($this->conn, $this->result, $errcode, $dn, $errmsg, $refs)) 
		{
			// do something with $errcode, $dn, $errmsg and $refs
			$mensaje_final = "ERRCODE: ".$errcode."\n ERRMSG: ".$errmsg."\n REFS: ".$refs."\n DN: ".$dn."\n";
		}
		
		return $mensaje_final;
	}
	
	
	
}

?>