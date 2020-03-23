<?php
include_once '../conf/BDConexion.php';
include_once '../conf/Constants.php';
include_once '../conf/Log.php';

$path = $_POST["identificador"];
$tipo = $_POST["tipo"];
$ruta = $_POST["ruta"];
$mensaje = "";

sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion()) === false;

if ($path) {
    if ($tipo === "hipoteca") {
        $query = "DELETE imagenesHipoteca WHERE id = $path";
        $resultHipoteca = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
        if ($resultHipoteca) {
            if (file_exists($ruta)) {
                unlink($ruta);
                sqlsrv_commit(BDConexion::getInstancia()->getConexion());
                $mensaje = "<div class='alert alert-success text-center' role='alert'> Imagen eliminada con exito <div>";
            } else {
                $log = new Log();
                $log->writeLine("[No se puede borrar el archivo de $tipo porque no existe][URL: $ruta]");
                $mensaje = "<div class='alert alert-danger text-center' role='alert'> No se pudo borrar el documento solicitado. Por favor informe del error <div>";
            }
        } else {
            $log = new Log();
            $log->writeLine("[No se pudo borrar la imagen de la base de datos porque no existe][SQL: $query]");
            $mensaje = "<div class='alert alert-danger text-center' role='alert'> No se pudo borrar el documento solicitado. Por favor informe del error <div>";
        }
    } else {
        if ($tipo === "prenda") {
            $query = "DELETE imagenesPrenda WHERE id = $path";
            $resultHipoteca = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if ($resultHipoteca) {
                if (file_exists($ruta)) {
                    unlink($ruta);
                    sqlsrv_commit(BDConexion::getInstancia()->getConexion());
                    $mensaje = "<div class='alert alert-success text-center' role='alert'> Imagen eliminada con exito <div>";
                } else {
                    $log = new Log();
                    $log->writeLine("[No se puede borrar el archivo de $tipo porque no existe][URL: $ruta]");
                    $mensaje = "<div class='alert alert-danger text-center' role='alert'> No se pudo borrar el documento solicitado. Por favor informe del error <div>";
                }
            } else {
                $log = new Log();
                $log->writeLine("[No se pudo borrar la imagen de la base de datos porque no existe][SQL: $query]");
                $mensaje = "<div class='alert alert-danger text-center' role='alert'> No se pudo borrar el documento solicitado. Por favor informe del error <div>";
            }
        } else {
            if ($tipo === "fianza") {
                $query = "DELETE imagenesFianza WHERE id = $path";
                $resultHipoteca = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
                if ($resultHipoteca) {
                    if (file_exists($ruta)) {
                        unlink($ruta);
                        sqlsrv_commit(BDConexion::getInstancia()->getConexion());
                        $mensaje = "<div class='alert alert-success text-center' role='alert'> Imagen eliminada con exito <div>";
                    } else {
                        $log = new Log();
                        $log->writeLine("[No se puede borrar el archivo de $tipo porque no existe][URL: $ruta]");
                        $mensaje = "<div class='alert alert-danger text-center' role='alert'> No se pudo borrar el documento solicitado. Por favor informe del error <div>";
                    }
                } else {
                    $log = new Log();
                    $log->writeLine("[No se pudo borrar la imagen de la base de datos porque no existe][SQL: $query]");
                    $mensaje = "<div class='alert alert-danger text-center' role='alert'> No se pudo borrar el documento solicitado. Por favor informe del error <div>";
                }
            } else {
                if ($tipo === "leasing") {
                    $query = "DELETE imagenesLeasing WHERE id = $path";
                    $resultHipoteca = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
                    if ($resultHipoteca) {
                        if (file_exists($ruta)) {
                            unlink($ruta);
                            sqlsrv_commit(BDConexion::getInstancia()->getConexion());
                            $mensaje = "<div class='alert alert-success text-center' role='alert'> Imagen eliminada con exito <div>";
                        } else {
                            $log = new Log();
                            $log->writeLine("[No se puede borrar el archivo de $tipo porque no existe][URL: $ruta]");
                            $mensaje = "<div class='alert alert-danger text-center' role='alert'> No se pudo borrar el documento solicitado. Por favor informe del error <div>";
                        }
                    } else {
                        $log = new Log();
                        $log->writeLine("[No se pudo borrar la imagen de la base de datos porque no existe][SQL: $query]");
                        $mensaje = "<div class='alert alert-danger text-center' role='alert'> No se pudo borrar el documento solicitado. Por favor informe del error <div>";
                    }
                } else {
                    if ($tipo === "cartera") {
                        $query = "DELETE imagenesCartera WHERE id = $path";
                        $resultHipoteca = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
                        if ($resultHipoteca) {
                            if (file_exists($ruta)) {
                                unlink($ruta);
                                sqlsrv_commit(BDConexion::getInstancia()->getConexion());
                                $mensaje = "<div class='alert alert-success text-center' role='alert'> Imagen eliminada con exito <div>";
                            } else {
                                $log = new Log();
                                $log->writeLine("[No se puede borrar el archivo de $tipo porque no existe][URL: $ruta]");
                                $mensaje = "<div class='alert alert-danger text-center' role='alert'> No se pudo borrar el documento solicitado. Por favor informe del error <div>";
                            }
                        } else {
                            $log = new Log();
                            $log->writeLine("[No se pudo borrar la imagen de la base de datos porque no existe][SQL: $query]");
                            $mensaje = "<div class='alert alert-danger text-center' role='alert'> No se pudo borrar el documento solicitado. Por favor informe del error <div>";
                        }
                    }
                }
            }
        }
    }
} else {
    $log = new Log();
    $log->writeLine("[No se pudo borrar el documento PDF $tipo porque no existe][ID: $path]");
    $mensaje = "<div class='alert alert-danger text-center' role='alert'> No se pudo borrar el documento solicitado. Por favor informe del error <div>";
}

/* INICIALIZA LA SESION */
session_start();

if (!isset($_SESSION["user"])) {
    $log = new Log();
    $log->writeLine("[No hay usuario en sesion para mostrar el formulario][Redirecciona: index]");
    header("Location: ../../index.php");
}

require_once "./menuGarantias.php";
?>
<div class="container">
    <div class="card-header">
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-12 text-center p-2">
                <?php echo $mensaje; ?>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="formBuscarGarantia.php">
                    <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar Garantia</button>
                </a>
            </div>
            <div class="col-lg-2 text-center">
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto text-center">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="formBuscarEstados.php">
                    <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar Estado</button>
                </a>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="formCargarGarantia.php"> 
                    <button class="btn btn-lg btn-bsc btn-block" type="submit">Cargar Garantia</button>
                </a>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="../procesarLogout.php">
                    <button class="btn btn-lg btn-bsc btn-block" type="submit">Salir</button>
                </a>
            </div>
            <div class="col-lg-2 text-center">
            </div>
        </div>
    </div>
</div>
</body>

</html>