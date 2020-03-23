<?php

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorAcceso();

if ($_POST['peticion'] == "true") {
    $legajo = $_POST['legajo'];
    $nombre = $_POST['nombre'];
    $perfil = $_POST['perfil'];
    $aplicativo = $_POST['aplicativo'];
    $accesos = $controlador->buscar($legajo, $nombre, $perfil, $aplicativo);
} else {
    $accesos = $controlador->listarConTope(100);
}

if (gettype($accesos) == "resource") {
    $filas = "";
    while ($acceso = sqlsrv_fetch_array($accesos, SQLSRV_FETCH_ASSOC)) {
        $base = utf8_encode($acceso['nombreBase']);
        $acciones = ($base == "ARCHIVO") ? "
                <div class='btn-group btn-group-sm'>
                    <button class='btn btn-outline-warning editar' 
                            name='{$acceso['id']}' title='Editar'>
                            <i class='far fa-edit'></i>
                    </button>
                    <button class='btn btn-outline-danger borrar ' 
                            name='{$acceso['id']}' title='Borrar'>
                            <i class='fas fa-trash'></i>
                    </button>
                </div>" : "";
        $filas .= "
            <tr>
                <td>" . utf8_encode($acceso['legajo']) . "</td>
                <td>" . utf8_encode($acceso['nombreUsuario']) . "</td>
                <td>" . utf8_encode($acceso['perfil']) . "</td>
                <td>" . utf8_encode($acceso['nombreAplicativo']) . "</td>
                <td>{$base}</td> 
                <td class='text-center'>{$acciones}</td> 
            </tr>";
    }

    $cuerpo = '
        <div class="card">
            <div id="cuerpo" class="card-body">
                <div class="table-responsive">
                    <table id="tbAccesos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th>Legajo</th>
                                <th>Nombre usuario</th>
                                <th>Perfil</th>
                                <th>Aplicación</th>
                                <th>Base de datos</th>
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
    $cuerpo = HTML::getAlerta($accesos, $mensaje);
}

echo $cuerpo;
