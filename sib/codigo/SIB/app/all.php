<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$host = "ldap://192.168.250.150";
$puerto = 389;
$dominio = "desarrollo\\";
$legajo = $_POST['legajo'];
$clave = $_POST['clave'];
$base = $_POST['base'];
$filtro = $_POST['filtro'];
$conexion = ldap_connect($host, $puerto);
if ($conexion) {
    ldap_set_option($conexion, LDAP_OPT_PROTOCOL_VERSION, 3);

    $user = $dominio . $legajo;
    if (@ldap_bind($conexion, $user, $clave)) {
        $attributes = array();
        $attributes[] = 'givenname';
        $attributes[] = 'mail';
        $attributes[] = 'samaccountname';
        $attributes[] = 'sn';
        $result = ldap_search($conexion, $base, $filtro, $attributes);
        if (FALSE !== $result) {
            $entries = ldap_get_entries($conexion, $result);
            echo '<BR> TOTAL --- ' . count($entries) . "<br>";
            for ($x = 0; $x < $entries['count']; $x++) {
                $countname = (empty($entries[$x]['samaccountname'][0])) ? "" : $entries[$x]['samaccountname'][0];
                $nombre = (empty($entries[$x]['sn'][0])) ? "" : $entries[$x]['sn'][0];
                $apellido = (empty($entries[$x]['givenname'][0])) ? "" : $entries[$x]['givenname'][0];
                $email = (empty($entries[$x]['mail'][0])) ? "" : $entries[$x]['mail'][0];
                $dn = (empty($entries[$x]['dn'][0])) ? "" : $entries[$x]['dn'];
                echo "<br><B>USUARIO N° " . ($x + 1) . "</B><br>";
                echo "Nombre cuenta: " . $countname . "<br>";
                echo "Nombre: " . $nombre . "<br>";
                echo "Apellido: " . $apellido . "<br>";
                echo "Email: " . $email . "<br>";
                echo "DN: " . $dn . "<br>";
            }
        } else {
            echo '<br> BUSQUEDA SIN RESULTADOS';
        }
        ldap_unbind($conexion); // Clean up after ourselves.
    } else {
        echo "<br> USUARIO INCORRECTO";
    }
} else {
    echo "<br> NO HAY CONEXION";
}