<?php

/* PROCESA BUSCAR APLICACIONES */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$controlador = new ControladorAplicacion();

if ($_POST['peticion']) {
    $nombre = $_POST['nombre'];
    $gerencia = $_POST['gerencia'];
    $delegado = $_POST['delegado'];
    $subdelegado = $_POST['subdelegado'];
    $aplicaciones = $controlador->buscar($nombre, $gerencia, $delegado, $subdelegado);
} else {
    LOG::escribirLineaError("HOLA");
    $aplicaciones = $controlador->listarConTope(10);
}

if (gettype($aplicaciones) == "resource") {
    $filas = "";
    while ($aplicacion = sqlsrv_fetch_array($aplicaciones, SQLSRV_FETCH_ASSOC)) {
        $estado = ($aplicacion['estado'] == 1) ? "Activo" : "Inactivo";
        $filas .= "
            <tr>
                <td>" . utf8_encode($aplicacion['nombreAplicacion']) . "</td>
                <td>" . utf8_encode($aplicacion['nombreGerencia']) . "</td>
                <td style='display: none'>" . utf8_encode($aplicacion['legajoDelegado']) . "</td>
                <td>" . utf8_encode($aplicacion['nombreDelegado']) . "</td>
                <td style='display: none'>" . utf8_encode($aplicacion['legajoSubdelegado']) . "</td>
                <td>" . utf8_encode($aplicacion['nombreSubdelegado']) . "</td>
                <td>" . $estado . "</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-warning editar' 
                                name='{$aplicacion['idAplicacion']}' title='Editar'>
                                <i class='far fa-edit'></i>
                        </button>
                    </div>
                </td>
            </tr>";
    }
    $cuerpo = '

    <div class="card">
        <div id="cuerpo" class="card-body">
            <div  class="table-responsive">
                <table style="background-color:white; border-radius: 0.5em; " id="tbAplicaciones" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Gerencia</th>
                            <th style="display: none">Legajo Delegado</th>
                            <th>Nombre Delegado</th>
                            <th style="display: none">Legajo Subdelegado</th>
                            <th>Nombre Subdelegado</th>
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
    $cuerpo = HTML::getAlerta($aplicaciones, $mensaje);
}

 echo $cuerpo;
