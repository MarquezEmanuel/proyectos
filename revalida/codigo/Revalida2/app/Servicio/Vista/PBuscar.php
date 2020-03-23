<?php

/* PROCESA BUSCAR SERVICIOS */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorServicio();
if ($_POST['peticion']) {
    $nombre = $_POST['nombre'];
    $servicios = $controlador->buscar($nombre);
} else {
    $servicios = $controlador->listarConTope(10);
}

if (gettype($servicios) == "resource") {
    $filas = "";
    while ($servicio = sqlsrv_fetch_array($servicios, SQLSRV_FETCH_ASSOC)) {
        $estado = ($servicio['estado'] == 1) ? "Activo" : "Inactivo";
        $filas .= "
            <tr>
                <td>" . utf8_encode($servicio['nombre']) . "</td>
                <td>" . $estado . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-warning editar' 
                                name='{$servicio['id']}' title='Editar'>
                                <i class='far fa-edit'></i>
                        </button>
                    </div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbServicios" class="table table-bordered table-hover" cellspacing="0" style="width:100%; background-color:white; border-radius: 0.5em;">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>
            </div>
        </div>';
} else {
    $mensaje = $controlador->getMensaje();
    $cuerpo = HTML::getAlerta($servicios, $mensaje);
}

echo $cuerpo;
