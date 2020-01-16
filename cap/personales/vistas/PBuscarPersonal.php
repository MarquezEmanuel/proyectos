<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorPersonal();

if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $datos = ($nombre) ? "'{$nombre}', " . $estado : "TODOS, " . $estado;
    $filtro = "Resultado de la búsqueda: " . $datos;
    $personales = $controlador->buscar($nombre, $estado);
    $_SESSION['BPERSONALES'] = array($nombre, $estado, $datos);
} else {
    if (isset($_SESSION['BPERSONALES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BPERSONALES'];
        $nombre = $parametros[0];
        $estado = $parametros[1];
        $filtro = "Ultima búsqueda realizada: " . $parametros[2];
        $personales = $controlador->buscar($nombre, $estado);
        $_SESSION['BPERSONALES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $personales = $controlador->listarUltimosCreados();
        $filtro = "Resumen inicial";
        $_SESSION['BPERSONALES'] = NULL;
    }
}


if (gettype($personales) == "resource") {
    /* SE OBTUVO UN RESULTADO DESDE LA BASE DE DATOS */
    $filas = "";
    while ($personal = sqlsrv_fetch_array($personales, SQLSRV_FETCH_ASSOC)) {
        if ($personales['pestado'] == 'Activo') {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                        name='{$personal['pid']}' title='Editar'>
                    <i class='far fa-edit'></i>
                </button>
                <button class='btn btn-outline-danger baja' 
                        name='{$personal['pid']}' title='Dar de baja'>
                    <i class='fas fa-trash'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-success alta' 
                    name='{$personal['pid']}' title='Dar de alta'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td>" . utf8_encode($personal['psigla']) . "</td>
                <td>" . utf8_encode($personal['pnombre']) . "</td>
                <td>" . utf8_encode($personal['dnombre']) . "</td> 
                <td>" . utf8_encode($personal['prti']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive">
            <table id="tbFirewalls" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre corto</th>
                        <th>Nombre largo</th>
                        <th>Departamento</th>
                        <th>RTI</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $mensaje .= ($personales == 1) ? " para el filtro ingresado" : "";
    $cuerpo = ControladorHTML::getAlertaOperacion($personales, $mensaje);
}

$formulario = ControladorHTML::getCardBusqueda($filtro, $cuerpo);

echo $formulario;
