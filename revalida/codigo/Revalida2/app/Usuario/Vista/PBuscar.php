<?php

/* PROCESA BUSCAR USUARIOS */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorUsuario();

if ($_POST['peticion']) {
    $legajo = $_POST['legajo'];
    $nombre = $_POST['nombre'];
    $cargo = $_POST['cargo'];
    $gerencia = $_POST['gerencia'];
    $usuarios = $controlador->buscar($legajo, $nombre, $cargo, $gerencia);
} else {
    $usuarios = $controlador->listarConTope(10);
}

if (gettype($usuarios) == "resource") {
    $filas = "";
    while ($usuario = sqlsrv_fetch_array($usuarios, SQLSRV_FETCH_ASSOC)) {
        $estado = ($usuario['estado'] == 1) ? "Activo" : "Inactivo";
        $filas .= "
            <tr>
                <td>" . utf8_encode($usuario['legajo']) . "</td>
                <td>" . utf8_encode($usuario['nombre_usuario']) . "</td>
                <td>" . utf8_encode($usuario['cargo']) . "</td>
                <td>" . utf8_encode($usuario['nombre_gerencia']) . "</td>
                <td>" . utf8_encode($usuario['nombre_rol']) . "</td>
                <td>" . utf8_encode($estado) . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-warning editar' 
                                name='{$usuario['legajo']}' title='Editar'>
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
                    <table id="tbUsuarios" class="table table-bordered table-hover" cellspacing="0" style="width:100%; background-color:white; border-radius: 0.5em;">
                        <thead>
                            <tr>
                                <th>Legajo</th>
                                <th>Nombre</th>
                                <th>Cargo</th>
                                <th>Gerencia</th>
                                <th>Rol</th>
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
    $cuerpo = HTML::getAlerta($usuarios, $mensaje);
}

echo $cuerpo;
