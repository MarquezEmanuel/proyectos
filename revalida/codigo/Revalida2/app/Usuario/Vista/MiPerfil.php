<?php
include_once '../../Principal/Vista/Header.php';

$usuario = $_SESSION['usuario'];

$id = $usuario->getId();
$legajo = $usuario->getLegajo();
$nombre = $usuario->getNombre() . ', ' . $usuario->getApellido();
$cargo = $usuario->getCargo();
$gerencia = $usuario->getGerencia();
$rol = $usuario->getRol();
$estado = ($usuario->getEstado() == 1) ? "Activo" : "Inactivo";
$foto = "../../../lib/img/Perfil/{$usuario->getFoto()}";

$nombreGerencia = $gerencia->getNombre();
$delegado = $gerencia->getDelegado();
$subdelegado = $gerencia->getSubDelegado();
$nombreDelegado = ($delegado) ? $delegado->getNombre() . ', ' . $delegado->getApellido() : "No posee";
$nombreSubDelegado = ($subdelegado) ? $subdelegado->getNombre() . ', ' . $subdelegado->getApellido() : "No posee";
$nombreRol = $rol->getNombre();
$permisos = count($rol->getPermisos());

$controlador = new ControladorUsuario();
$actividades = $controlador->listarActividad($legajo);
$listaActividad = "";
if (gettype($actividades) == "resource") {
    $items = '';
    while ($dato = sqlsrv_fetch_array($actividades, SQLSRV_FETCH_ASSOC)) {
        $items .= '
            <dt class="col-sm-6">' . $dato['dato'] . ':</dt>
            <dd class="col-sm-6">' . $dato['cantidad'] . '</dd>';
    }
    $listaActividad = '
        <div class="form-row">
            <div class="col">
                <dl class="row">' . $items . '</dl>
            </div>
        </div>';
} else {
    $listaActividad = '
        <div class="col"><p>' . $controlador->getMensaje() . '</p></div>';
}

$directorio = opendir(AVA);
$card = $group = '';
while ($primero = readdir($directorio)) {
    if ($primero != "." && $primero != ".." && $primero != 'usuario.png' && $primero != "Thumbs.db") {
        /* TOMA LOS DEMAS ELEMENTOS DE LA GRILLA */
        $segundo = readdir($directorio);
        $tercero = readdir($directorio);
        $cuarto = readdir($directorio);

        $radio = '<input type="radio" name="imagenes" id="imagenes" value="' . $primero . '">';
        $ruta = "../../../lib/img/Perfil/{$primero}";
        $card .= HTML::generarCardParaImagen($radio, $ruta, "40%");
        if ($segundo && $segundo != "." && $segundo != ".." && $segundo != 'usuario.png' && $segundo != "Thumbs.db") {
            $radio = '<input type="radio" name="imagenes" id="imagenes" value="' . $segundo . '">';
            $ruta = "../../../lib/img/Perfil/{$segundo}";
            $card .= HTML::generarCardParaImagen($radio, $ruta, "40%");
        }
        if ($tercero && $tercero != "." && $tercero != ".." && $tercero != 'usuario.png' && $tercero != "Thumbs.db") {
            $radio = '<input type="radio" name="imagenes" id="imagenes" value="' . $tercero . '">';
            $ruta = "../../../lib/img/Perfil/{$tercero}";
            $card .= HTML::generarCardParaImagen($radio, $ruta, "40%");
        }
        if ($cuarto && $cuarto != "." && $cuarto != ".." && $cuarto != 'usuario.png' && $cuarto != "Thumbs.db") {
            $radio = '<input type="radio" name="imagenes" id="imagenes" value="' . $cuarto . '">';
            $ruta = "../../../lib/img/Perfil/{$cuarto}";
            $card .= HTML::generarCardParaImagen($radio, $ruta, "40%");
        }
        $group .= '<div class="card-group">' . $card . '</div><br>';
        $card = '';
    }
}

if (strlen($group) == 0) {
    $cuerpoAvatares = '
        <div class="form-row">
            <div class="col">
                <div class="alert alert-warning text-center" role="alert">
                    <i class="fas fa-exclamation-circle"></i> <strong> No hay imagenes disponibles </strong>
                </div>
            </div>
        </div>';
} else {
    $cuerpoAvatares = '
        <div class="mb-2 mt-2" id="resultado" name="resultado"></div>
        <form mehtod="POST" name="formCambiarAvatar" id="formCambiarAvatar">
            <input type="hidden" name="id" id="id" value="' . $id . '">
            <div class="form-row">
                <div class="col">' . $group . '</div>
            </div>
            <div class="form-row">
                <div class="col text-center">
                    <button type="submit" class="btn btn-dark"> SELECCIONAR </button>
                </div>
            </div>
        </form>';
}

$formulario = '
    <div class="card-group">
        <div class="card">
            <div class="card-header bg-dark text-white text-center">AVATAR DE USUARIO</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col text-center">
                        <img src="' . $foto . '" class="img-fluid rounded p-4 mx-auto d-block" alt="Responsive image">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-dark text-white text-center">INFORMACIÓN DE USUARIO</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col">
                        <dl class="row">
                            <dt class="col-sm-4">Nombre:</dt>
                            <dd class="col-sm-8">' . $nombre . '</dd>
                            <dt class="col-sm-4">Legajo:</dt>
                            <dd class="col-sm-8">' . $legajo . '</dd>
                            <dt class="col-sm-4">Gerencia:</dt>
                            <dd class="col-sm-8">' . $nombreGerencia . '</dd>
                            <dt class="col-sm-4">Delegado:</dt>
                            <dd class="col-sm-8">' . $nombreDelegado . '</dd>
                            <dt class="col-sm-4">Suplente:</dt>
                            <dd class="col-sm-8">' . $nombreSubDelegado . '</dd>
                            <dt class="col-sm-4">Cargo:</dt>
                            <dd class="col-sm-8">' . $cargo . '</dd>
                            <dt class="col-sm-4">Perfil:</dt>
                            <dd class="col-sm-8">' . $nombreRol . '</dd>
                            <dt class="col-sm-4">Permisos:</dt>
                            <dd class="col-sm-8">' . $permisos . '</dd>
                            <dt class="col-sm-4">Estado:</dt>
                            <dd class="col-sm-8">' . $estado . '</dd>
                        </dl>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <button class="btn btn-dark btn-block" id="btnCambiarAvatar" name="btnCambiarAvatar"> CAMBIAR AVATAR </button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-dark text-white text-center">ACTIVIDAD DE USUARIO</div>
            <div class="card-body">
                <div class="form-row">
                    ' . $listaActividad . '
                 </div>
                <div class="form-row">
                    <a href="../../Principal/Vista/procesarSalir.php" class="btn-block">
                        <button class="btn btn-outline-danger btn-block">
                            <i class="fas fa-sign-out-alt"></i> SALIR 
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4" id="cardAvatares" name="cardAvatares" style="display: none;">
        <div class="card-header bg-dark text-white">AVATARES DISPONIBLES</div>
        <div class="card-body">' . $cuerpoAvatares . '</div>
    </div>';
?>
<div id="content-wrapper">
    <div id="superior" class="container mt-4">  <?= $formulario; ?> </div>
    <div id="inferior" class="container mb-4 mt-4"></div>
    <div class="modal fade" id="ModalCargando" tabindex="-1" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-sm" style="width: 240px">
            <div class="modal-content" style=" background-color: transparent; border: transparent; ">
                <div class="modal-body">
                    <div id="loader-icon"><img src="../../../lib/img/loading.png" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../Js/MiPerfil.js"></script>
