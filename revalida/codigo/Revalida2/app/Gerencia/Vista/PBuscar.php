<?php

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorGerencia();
if ($_POST['peticion']) {
    $nombre = $_POST['nombre'];
    $delegado = $_POST['delegado'];
    $subdelegado = $_POST['subdelegado'];
    $gerencias = $controlador->buscar($nombre, $delegado, $subdelegado);
} else {
    $gerencias = $controlador->listarConTope(10);
}

if (gettype($gerencias) == "resource") {
    $filas = "";
    while ($gerencia = sqlsrv_fetch_array($gerencias, SQLSRV_FETCH_ASSOC)) {
        $estado = ($gerencia['estado_gerencia'] == 1) ? "Activo" : "Inactivo";
        $filas .= "
            <tr>
                <td>" . utf8_encode($gerencia['nombre_gerencia']) . "</td>
                <td>" . utf8_encode($gerencia['nombre_delegado']) . "</td>
                <td>" . utf8_encode($gerencia['nombre_subdelegado']) . "</td>
                <td>" . $estado . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-warning editar' 
                                name='{$gerencia['id_gerencia']}' title='Editar'>
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
                    <table id="tbGerencias" class="table table-bordered table-hover" cellspacing="0" style="width:100%; background-color:white; border-radius: 0.5em;">
                        <thead>
                            <tr>
                                <th>Gerencia</th>
                                <th>Nombre delegado</th>
                                <th>Nombre subdelegado</th>
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
    $cuerpo = HTML::getAlerta($gerencias, $mensaje);
}

echo $cuerpo;
