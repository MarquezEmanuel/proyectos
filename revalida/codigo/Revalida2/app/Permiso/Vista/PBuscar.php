<?php

/* PROCESA BUSCAR PERMISOS */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorPermiso();
if ($_POST['peticion']) {
    $nombre = $_POST['nombre'];
    $permisos = $controlador->buscar($nombre);
} else {
    $permisos = $controlador->listarConTope(10);
}

if (gettype($permisos) == "resource") {
    $filas = "";
    while ($permiso = sqlsrv_fetch_array($permisos, SQLSRV_FETCH_ASSOC)) {
        $filas .= "
            <tr>
                <td>" . utf8_encode($permiso['nombre']) . "</td>
                <td>" . utf8_encode($permiso['nivel']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-warning editar' 
                                name='{$permiso['id']}' title='Editar'>
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
                    <table id="tbPermisos" class="table table-bordered table-hover" cellspacing="0" style="width:100%; background-color:white; border-radius: 0.5em;">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Nivel</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>
            </div>
        </div>';
} else {
    /* AGREGAR ESTILO SANTIAGO */
    $cuerpo = $controlador->getMensaje();
}

echo $cuerpo;

