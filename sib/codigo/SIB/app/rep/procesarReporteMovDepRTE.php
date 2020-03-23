<?php

/* INICIALIZA LA SESION */
session_start();

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (!empty($_POST['fechaInicio'])) {
    $tipo = ($_POST['tipo'] == "NO") ? "" : "AND tipo = '{$_POST['tipo']}'";
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $_SESSION['REPMOVRTE'] = array($tipo, $fechaInicio, $fechaFin);
    $query = "SELECT * FROM [dbo].[rteSinDepositantes] WHERE fecha >= CAST('{$fechaInicio}' AS DATE) AND fecha <= CAST('{$fechaFin}' AS DATE) {$tipo}";
} else {
    if (isset($_SESSION['REPMOVRTE'])) {
        $parametros = $_SESSION['REPMOVRTE'];
        $tipo = ($parametros[0] == "") ? "" : "AND tipo = '{$parametros[0]}'";
        $fechaInicio = $parametros[1];
        $fechaFin = $parametros[2];
        $_SESSION['REPMOVRTE'] = NULL;
        $query = "SELECT * FROM [dbo].[rteSinDepositantes] WHERE fecha >= CAST('{$fechaInicio}' AS DATE) AND fecha <= CAST('{$fechaFin}' AS DATE) {$tipo}";
    } else {
        $query = "SELECT TOP(10) * FROM [dbo].[rteSinDepositantes] ORDER BY fecha DESC";
    }
}

$html = "";
$resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
if ($resultado) {
    if (sqlsrv_has_rows($resultado)) {
        $filas = "";
        while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
            $filas .= "
                <tr>
                    <td class='align-middle'>{$row['referencia']}</td>
                    <td class='align-middle' style='display: none;'>{$row['concepto']}</td>
                    <td class='align-middle'>{$row['cuenta']}</td>
                    <td class='align-middle'>{$row['fecha']->format('d/m/Y')}</td>
                    <td class='align-middle'>" . utf8_encode($row['tipo']) . "</td>
                    <td class='align-middle'>" . utf8_encode($row['moneda']) . "</td>
                    <td class='align-middle' style='display: none;'>{$row['montoOrigen']}</td>
                    <td class='align-middle'>{$row['montoPesos']}</td>    
                    <td class='align-middle'>{$row['relacion']}</td>
                    <td class='align-middle'>{$row['cuil']}</td>
                    <td class='align-middle'>" . utf8_encode($row['nombre']) . "</td>    
                    <td class='align-middle' style='display: none;'>{$row['codigoUsuario']}</td>
                    <td class='align-middle' style='display: none;'>" . utf8_encode($row['nombreUsuario']) . "</td> 
                </tr>";
        }
        $html = "
            <div class='table-responsive'>
                <table id='tablaRepMovRTE' class='table table-bordered table-hover' >
                    <thead style='background-color:#024d85; color:white;'>
                        <th class='text-center align-middle'>Referencia</th>
                        <th class='text-center align-middle' style='display: none;'>Concepto</th>
                        <th class='text-center align-middle'>Número de Cuenta</th>
                        <th class='text-center align-middle'>Fecha</th>
                        <th class='text-center align-middle'>Tipo</th>
                        <th class='text-center align-middle'>Moneda</th>
                        <th class='text-center align-middle' style='display: none;'>Monto Origen</th>
                        <th class='text-center align-middle'>Monto en Pesos</th>
                        <th class='text-center align-middle'>Relación</th>
                        <th class='text-center align-middle'>CUIT/CUIL</th>
                        <th class='text-center align-middle'>Nombre</th>
                        <th class='text-center align-middle' style='display: none;'>Legajo usuario</th>
                        <th class='text-center align-middle' style='display: none;'>Nombre usuario</th>
                    </thead>
                    <tbody style='background-color: white;'>{$filas}</tbody>
                </table>
            </div>";
    } else {
        $html = '<div class="alert alert-warning text-center" role="alert"> No se encontraron resultados </div>';
    }
} else {
    Log::escribirError("[Error al realizar la consulta con la base de datos][QUERY: {$query}]");
    $html = '<div class="alert alert-danger text-center" role="alert"> Error al realizar búsqueda </div>';
}


echo "<div class='container mt-4'>{$html}</div>";
