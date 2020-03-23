<?php

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if ($_POST['peticion']) {
    $documento = $_POST['documento'];
    $inicio = $_POST['fechaInicio'];
    $fin = $_POST['fechaFin'];
    $consulta = "SELECT BLO.Nro_Nit, FEC.fecha 
                FROM [192.168.250.141].[IVR].[dbo].[ClienteBloqueo] BLO
                INNER JOIN (SELECT Nro_Nit, CAST(MAX(Fecha) as date) fecha 
                            FROM [192.168.250.141].[IVR].[dbo].[ClienteBloqueo] 
                            GROUP BY Nro_Nit) FEC ON FEC.Nro_Nit = BLO.Nro_Nit
                WHERE CAST(BLO.Fecha as date) >= CAST('{$inicio}' as date) AND CAST(BLO.Fecha as date) <= CAST('{$fin}' as date)";
    $consulta .= ($documento) ? " AND BLO.Nro_Nit LIKE '%{$documento}%'" : "";
    $consulta .= " GROUP BY BLO.Nro_Nit, FEC.fecha";
} else {
    $consulta = "SELECT TOP(500) BLO.Nro_Nit, FEC.fecha 
                FROM [192.168.250.141].[IVR].[dbo].[ClienteBloqueo] BLO
                INNER JOIN (SELECT Nro_Nit, CAST(MAX(Fecha) as date) fecha 
                                         FROM [192.168.250.141].[IVR].[dbo].[ClienteBloqueo] 
                                         GROUP BY Nro_Nit) FEC ON FEC.Nro_Nit = BLO.Nro_Nit
                group by BLO.Nro_Nit, FEC.fecha";
}

$resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
if ($resultado) {
    if (sqlsrv_has_rows($resultado)) {
        $filas = "";
        while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {

            $fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
            $filas .= "
                <tr>
                    <td class='text-center align-middle'>
                        <input type='checkbox' name='bloqueados[]' id='bloqueados' value='{$row["Nro_Nit"]}'>
                    </td>
                    <td>{$row["Nro_Nit"]}</td>
                    <td>{$fecha}</td>
                </tr>";
        }
        $html = "
            <div id='resultado' name='resultado'></div>
            <form name='formBloqueados' id='formBloqueados' method='POST'>
                <table id='tbBloqueados' class='table table-striped table-bordered' style='width: 100%'> 
                    <thead style='background-color:#024d85; color:white;'>
                        <tr>
                            <th>Seleccionar</th>
                            <th>Número de NIT</th>
                            <th>Última fecha registrada</th>
                        </tr>
                    </thead>
                    <tbody>{$filas}</tbody>
                </table>
            </form>";
    } else {
        $mensaje = "No se obtuvieron resultados";
        $html = "<br><div class='alert alert-warning text-center' role='alert'><strong>{$mensaje}</strong></div>";
    }
} else {
    $mensaje = "Error al realizar la consulta. Informe al administrador del sistema";
    $html = "<br><div class='alert alert-danger text-center' role='alert'><strong>{$mensaje}</strong></div>";
    Log::escribirError($consulta);
}

echo "<div class='container'>" . $html . "</div>";
