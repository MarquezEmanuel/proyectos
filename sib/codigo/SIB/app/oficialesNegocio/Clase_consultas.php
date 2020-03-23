<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Clase_consultas {

    public static function clientesBloqueadosEnIVR() {
        $nombreReporte = "Clientes bloqueados en IVR";
        $descripcionReporte = "Muestra el total de clientes que se encuentran bloqueados en IVR";
        $cantidad = "ERROR";
        /* REALIZA LA CONSULTA A LA BASE DE DATOS DE IVR */
        $consulta = " SELECT COUNT(DISTINCT Nro_Nit) cantidad FROM [192.168.250.141].[IVR].[dbo].[ClienteBloqueo]";
        $resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
        if ($resultado) {
            $cantidad = 0;
            if (sqlsrv_has_rows($resultado)) {
                $filas = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
                $cantidad = $filas["cantidad"];
            }
            if ($cantidad != 0) {
                $nombreReporte = '<a href="formClientesBloqueadosIVR.php" class="text-dark">' . $nombreReporte . '</a>';
            }
        } else {
            Log::escribirError("['$nombreReporte'][$consulta]");
        }
        return '<tr title="' . $descripcionReporte . '">
                <th><h5>' . $nombreReporte . '</h5></th>
                <th><h5>' . $cantidad . '</h5></th>
            </tr>';
    }

}
