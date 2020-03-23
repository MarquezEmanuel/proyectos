<?php

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if ($_POST['peticion']) {
    $documento = $_POST['documento'];
    $inicio = $_POST['fechaInicio'];
    $fin = $_POST['fechaFin'];
    $consulta = "SELECT TOP(100) Nro_Nit, CAST(Fecha as date) fecha, Bloqueo, Conteo "
            . "FROM [192.168.250.141].[IVR].[dbo].[ClienteBloqueo] "
            . "WHERE CAST(Fecha as date) >= CAST('{$inicio}' as date) AND CAST(Fecha as date) <= CAST('{$fin}' as date) ";
    $consulta .= ($documento) ? " AND Nro_Nit LIKE '%{$documento}%'" : "";
} else {
    $consulta = "SELECT TOP(100) Nro_Nit, CAST(Fecha as date) fecha, Bloqueo, Conteo "
            . "FROM [192.168.250.141].[IVR].[dbo].[ClienteBloqueo]";
}

$resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
if ($resultado) {
    if (sqlsrv_has_rows($resultado)) {
        $filas = "";
        while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
            
            $fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
            $filas .= "
                <tr>
                    <td class='text-center align-middle'><input type='checkbox' value='' id='clientes' name='clientes[]'></td>
                    <td>{$row["Nro_Nit"]}</td>
                    <td>{$fecha}</td>
                    <td>{$row["Bloqueo"]}</td>
                    <td>{$row["Conteo"]}</td>
                </tr>";
        }
        $html = "
            <table id='tbBloqueados' class='table table-striped table-bordered' style='width: 100%'> 
                <thead style='background-color:#024d85; color:white;'>
                    <tr>
                        <th class='text-center align-middle'><input type='checkbox' id='seleccionarTodos' name='seleccionarTodos'></th>
                        <th>Nro de NIT</th>
                        <th>Fecha</th>
                        <th>Bloqueo</th>
                        <th>Conteo</th>
                    </tr>
                </thead>
                <tbody>{$filas}</tbody>
            </table>";
    } else {
        $mensaje = "No se obtuvieron resultados";
        $html = "<br><div class='alert alert-warning text-center' role='alert'><strong>{$mensaje}</strong></div>";
    }
} else {
    $mensaje = "Error al realizar la consulta. Informe al administrador del sistema";
    $html = "<br><div class='alert alert-danger text-center' role='alert'><strong>{$mensaje}</strong></div>";
}

echo "<div class='container'>" . $html . "</div>";
