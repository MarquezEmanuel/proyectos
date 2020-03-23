<?php

/* PROCESA BUSCAR ROLES */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorRol();

if ($_POST['peticion']) {
    $nombre = $_POST['nombre'];
    $roles = $controlador->buscar($nombre);
} else {
    $roles = $controlador->listarConTope(10);
}

if (gettype($roles) == "resource") {
    $filas = "";
    while ($rol = sqlsrv_fetch_array($roles, SQLSRV_FETCH_ASSOC)) {
        $filas .= "
            <tr>
                <td>" . utf8_encode($rol['nombre']) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-warning editar' 
                                name='{$rol['id']}' title='Editar'>
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
                    <table id="tbRoles" class="table table-bordered table-hover" cellspacing="0" style="width:100%; background-color:white; border-radius: 0.5em;">
                        <thead>
                            <tr>
                                <th>Nombre</th>
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
    $cuerpo = HTML::getAlerta($roles, $mensaje);
}

echo $cuerpo;
