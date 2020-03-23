<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function cuentaCorrentista() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad from cuentaCorrentistasInhabilitados";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="centralCuentacorrentista.php" class="text-danger"><font size=6>Central de cuentacorrentistas inhabilitados</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            if ($cantidad > 4) {
                $html = $html . '<tr><th><a href="centralCuentacorrentista.php"><font size=5 style="color:FORESTGREEN;">Central de cuentacorrentistas inhabilitados</font></a>&nbsp;&nbsp;<img src="/lib/img/amarillo.svg" width="18" height="18"></th><th><font size=5 class="text-success">' . $cantidad . '</font></th></tr>';
            } else {
                $html = $html . '<tr><th><a href="centralCuentacorrentista.php" class="text-dark"><font size=4>Central de cuentacorrentistas inhabilitados</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
            }
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Central de cuentacorrentistas inhabilitados</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Canje Interno (Cheques que deben darse caída para su correspondiente deposito) 

function canjeInterno() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3canjeInterno] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="canjeInterno.php" class="text-danger"><font size=6>Canje interno</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            if ($cantidad > 4) {
                $html = $html . '<tr><th><a href="canjeInterno.php"><font size=5 style="color:FORESTGREEN;">Canje interno</font></a>&nbsp;&nbsp;<img src="/lib/img/amarillo.svg" width="18" height="18"></th><th><font size=5 class="text-success">' . $cantidad . '</font></th></tr>';
            } else {
                $html = $html . '<tr><th><a href="canjeInterno.php" class="text-dark"><font size=4>Canje interno</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
            }
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Canje interno</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Cobro de cuotas a un cliente distinto del titular del préstamo (Cobro de cuota de préstamo distinta de la cuenta del titular.) 

function cobroCuotas() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3prestamosConCuentaAsociada] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="cobroCuotas.php" class="text-danger"><font size=6>Cobro de cuotas a un cliente distinto del titular del préstamo</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            if ($cantidad > 4) {
                $html = $html . '<tr><th><a href="cobroCuotas.php"><font size=5 style="color:FORESTGREEN;">Cobro de cuotas a un cliente distinto del titular del préstamo</font></a>&nbsp;&nbsp;<img src="/lib/img/amarillo.svg" width="18" height="18"></th><th><font size=5 class="text-success">' . $cantidad . '</font></th></tr>';
            } else {
                $html = $html . '<tr><th><a href="cobroCuotas.php" class="text-dark"><font size=4>Cobro de cuotas a un cliente distinto del titular del préstamo</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
            }
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Cobro de cuotas a un cliente distinto al titular del prestamo</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Alta de clientes en forma manual. (altas no procedas por WF evadiendo el control, no asignando valor de riesgo inicial) 

function altaClientes() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3altaCliente] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="altaClientes.php" class="text-danger"><font size=6>Alta de clientes en forma manual</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            if ($cantidad > 4) {
                $html = $html . '<tr><th><a href="altaClientes.php"><font size=5 style="color:FORESTGREEN;">Alta de clientes en forma manual</font></a>&nbsp;&nbsp;<img src="/lib/img/amarillo.svg" width="18" height="18"></th><th><font size=5 class="text-success">' . $cantidad . '</font></th></tr>';
            } else {
                $html = $html . '<tr><th><a href="altaClientes.php" class="text-dark"><font size=4>Alta de clientes en forma manual</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
            }
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Alta de clientes en forma manual</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Reporte Extracciones por caja mayores y menores a $15.000 (reporte de control de extracciones para gestión operativa y derivación.)

function reporteExtracciones() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3mayores15] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad > 9) {
            $html = $html . '<tr><th><a href="extraccionesMayores.php" class="text-danger"><font size=6>Extracciones por caja menores a $20.000</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            if ($cantidad > 4) {
                $html = $html . '<tr><th><a href="extraccionesMayores.php"><font size=5 style="color:FORESTGREEN;">Extracciones por caja menores a $20.000</font></a>&nbsp;&nbsp;<img src="/lib/img/amarillo.svg" width="18" height="18"></th><th><font size=5 class="text-success">' . $cantidad . '</font></th></tr>';
            } else {
                $html = $html . '<tr><th><a href="extraccionesMayores.php" class="text-dark"><font size=4>Extracciones por caja menores a $20.000</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
            }
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Extracciones por caja menores a $20.000</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Reporte de Reversas (reporte de operaciones reversadas con control en supervisores por su anulación. )

function reporteReversas() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3reversas] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="reversas.php" class="text-danger"><font size=6>Reversas</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            if ($cantidad > 4) {
                $html = $html . '<tr><th><a href="reversas.php"><font size=5 style="color:FORESTGREEN;">Reversas</font></a>&nbsp;&nbsp;<img src="/lib/img/amarillo.svg" width="18" height="18"></th><th><font size=5 class="text-success">' . $cantidad . '</font></th></tr>';
            } else {
                $html = $html . '<tr><th><a href="reversas.php" class="text-dark"><font size=4>Reversas</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
            }
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Reversas</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Cuentas por Cerrar Saldo Deudor (cuentas en proceso de cierre con saldo deudor que pueden generar previsionamiento si no se concluyen antes de fin de mes)

function cuentasPorCerrar() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3ACMOL] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="cuentasPorCerrar.php" class="text-danger"><font size=6>Cuentas por Cerrar Saldo Deudor</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            if ($cantidad > 4) {
                $html = $html . '<tr><th><a href="cuentasPorCerrar.php"><font size=5 style="color:FORESTGREEN;">Cuentas por Cerrar Saldo Deudor</font></a>&nbsp;&nbsp;<img src="/lib/img/amarillo.svg" width="18" height="18"></th><th><font size=5 class="text-success">' . $cantidad . '</font></th></tr>';
            } else {
                $html = $html . '<tr><th><a href="cuentasPorCerrar.php" class="text-dark"><font size=4>Cuentas por Cerrar Saldo Deudor</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
            }
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Cuentas por cerrar saldo deudor</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Pagare no cargados en SAV. (documentos pagaré que están vigente y no fueron cargados en SAV.)

function pagareNoSAV() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad > 9) {
            $html = $html . '<tr><th><a href="noSAV.php" class="text-danger"><font size=6>Pagare no cargados en SAV</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            if ($cantidad > 4) {
                $html = $html . '<tr><td><a href="noSAV.php"><font size=5 style="color:FORESTGREEN;">Pagare no cargados en SAV</font></a>&nbsp;&nbsp;<img src="/lib/img/amarillo.svg" width="18" height="18"></td><th><font size=5 class="text-success">' . $cantidad . '</font></th></tr>';
            } else {
                $html = $html . '<tr><th><a href="noSAV.php" class="text-dark"><font size=4>Pagare no cargados en SAV</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
            }
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Pagares no cargados en SAV</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Incorrecta identificacion de clientes en operaciones por caja.

function incorrectaIdentificacion() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3transaccionIncorrecta] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="incorrectaIdentificacion.php" class="text-danger"><font size=6>Incorrecta identificacion de clientes</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            if ($cantidad > 4) {
                $html = $html . '<tr><td><a href="incorrectaIdentificacion.php"><font size=5 style="color:FORESTGREEN;">Incorrecta identificacion de clientes</font></a>&nbsp;&nbsp;<img src="/lib/img/amarillo.svg" width="18" height="18"></td><th><font size=5 class="text-success">' . $cantidad . '</font></th></tr>';
            } else {
                $html = $html . '<tr><th><a href="incorrectaIdentificacion.php" class="text-dark"><font size=4>Incorrecta identificacion de clientes</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
            }
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Incorrecta identificacion de clientes</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Fallas de caja.

function fallas() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3fallas] WHERE montoTransaccion > 14999 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="fallas.php" class="text-danger"><font size=6>Fallas de caja</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            if ($cantidad > 4) {
                $html = $html . '<tr><td><a href="fallas.php"><font size=5 style="color:FORESTGREEN;">Fallas de caja</font></a>&nbsp;&nbsp;<img src="/lib/img/amarillo.svg" width="18" height="18"></td><th><font size=5 class="text-success">' . $cantidad . '</font></th></tr>';
            } else {
                $html = $html . '<tr><th><a href="fallas.php" class="text-dark"><font size=4>Fallas de caja</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
            }
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Fallas de caja</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Saldos contables diarios.

function saldos() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    if (date("l") == "Monday") {
        $actual = $actualfinal = date("d-m-Y", strtotime("last Saturday"));
    }
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3saldosSucursales] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="saldos.php" class="text-danger"><font size=6>Saldos contables diarios</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            if ($cantidad > 4) {
                $html = $html . '<tr><td><a href="saldos.php"><font size=5 style="color:FORESTGREEN;">Saldos contables diarios</font></a>&nbsp;&nbsp;<img src="/lib/img/amarillo.svg" width="18" height="18"></td><th><font size=5 class="text-success">' . $cantidad . '</font></th></tr>';
            } else {
                $html = $html . '<tr><th><a href="saldos.php" class="text-dark"><font size=4>Saldos contables diarios</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
            }
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Saldos contables diarios</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Saldos contables diarios.

function clientesPotenciales() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3clientesPotenciales] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="clientesPotenciales.php" class="text-danger"><font size=6>Clientes potenciales</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            if ($cantidad > 4) {
                $html = $html . '<tr><td><a href="clientesPotenciales.php"><font size=5 style="color:FORESTGREEN;">Clientes potenciales</font></a>&nbsp;&nbsp;<img src="/lib/img/amarillo.svg" width="18" height="18"></td><th><font size=5 class="text-success">' . $cantidad . '</font></th></tr>';
            } else {
                $html = $html . '<tr><th><a href="clientesPotenciales.php" class="text-dark"><font size=4>Clientes potenciales</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
            }
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Clientes potenciales</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Moras CPD.

function morasCPD() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3morasCPD] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="morasCPD.php" class="text-danger"><font size=6>Moras CPD</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="morasCPD.php" class="text-dark"><font size=4>Moras CPD</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        }
    } else {
        $html = '
            <tr>
                <th><font size=4>Moras CPD</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Datos Clientes con tarjeta.

function telefonosTarjetas() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3telefonosTarjetas] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="telefonosTarjetas.php" class="text-danger"><font size=6>Datos de clientes con tarjetas en el tesoro</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="telefonosTarjetas.php" class="text-dark"><font size=4>Datos de clientes con tarjetas en el tesoro</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Datos de clientes con tarjetas en el tesoro</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//Moras Caja de Seguridad.

function morasCajaSeguridad() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3morasCajaSeguridad] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="morasCajaSeguridad.php" class="text-danger"><font size=6>Moras en Caja de Seguridad</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="morasCajaSeguridad.php" class="text-dark"><font size=4>Moras en Caja de Seguridad</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Moras en cajas de seguridad</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

function movimientosSinDepositantes() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*)cantidad FROM [3movimientoSinDepositantes] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="movimientosSinDepositantes.php" class="text-danger"><font size=6>Movimientos Sin Depositantes</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="movimientosSinDepositantes.php" class="text-dark"><font size=4>Movimientos Sin Depositantes</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        }
    } else {
        $html = '
            <tr>
                <th><font size=4>Movimientos sin depositantes</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

function solicitudesWF() {
    $querySolicitudes = "SELECT count(*) cantidad FROM solicitudesWF";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitudes);
    $html = "";
    if ($result) {
        $cantidad = 0;
        $html = '<tr><th><a href="buscarSolicitudesWF.php" class="text-dark"><font size=4>Solicitudes de workflow</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $fila["cantidad"];
            $html = '<tr><th><a href="buscarSolicitudesWF.php" class="text-danger"><font size=6>Solicitudes de workflow</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de solicitudes workflow][QUERY: $querySolicitudes]");
    }
    return $html;
}

function plazoVencidoSAV() {
    $querySolicitudes = "SELECT count(*) cantidad FROM plazoVencidoSAV";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitudes);
    $html = "";
    if ($result) {
        $cantidad = 0;
        $html = '<tr><th><a href="buscarPlazoVencidoSAV.php" class="text-dark"><font size=4>Plazos Vencidos en SAV</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $fila["cantidad"];
            $html = '<tr><th><a href="buscarPlazoVencidoSAV.php" class="text-danger"><font size=6>Plazos Vencidos en SAV</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de Plazos Vencidos en SAV][QUERY: $querySolicitudes]");
    }
    return $html;
}

function turnero() {

    //sucursales

    $sucursales = [01, 02, 03, 04, 05, 15, 20, 25, 30, 41, 45, 50, 55, 60, 70, 75, 85];

    //fecha

    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha = date('Y/m/d', strtotime('yesterday'));
    $fechats = strtotime($fecha);
    if (date('w', $fechats) == 0) {
        $actual = date("Y/m/d", strtotime($fecha . "- 2 days"));
    } else {
        if (date('w', $fechats) == 6) {
            $actual = date("Y/m/d", strtotime($fecha . "- 1 days"));
        } else {
            $actual = $fecha;
        }
    }
    $actualFinal = explode("/", $actual);
    $total = count($actualFinal);
    $fecha = "";
    for ($i = 0; $i < $total; ++$i) {
        $fecha = $fecha . $actualFinal[$i];
    }

    $total = 0;
    //cantidad de espera

    for ($i = 0; $i < count($sucursales); ++$i) {
        $medioEspera = "SELECT max(Duration)/60 espera
        FROM [VM000DB00].[STE].[dbo].[vw_H_INS_TaskInterval] WHERE PartitionId = $fecha AND OrganizationCode = $sucursales[$i] AND DTECode LIKE '%Totem%' AND StateId = 2 AND AdminStopped = 0";
        $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $medioEspera);
        if ($result) {
            if (sqlsrv_has_rows($result)) {
                $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                $espera = $fila["espera"];
                if ($espera > 91) {
                    $total = $total + 1;
                }
            }
        } else {
            Log::escribirError("[Error al realizar la consulta de turnero][QUERY: $medioEspera]");
        }
    }

    //cantidad de atencion

    for ($i = 0; $i < count($sucursales); ++$i) {
        $medioAtencion = "SELECT max(Duration)/60 espera
        FROM [VM000DB00].[STE].[dbo].[vw_H_INS_TaskInterval] WHERE PartitionId = $fecha AND OrganizationCode = $sucursales[$i] AND DTECode NOT LIKE '%Totem%' AND StateId IN (4) AND AdminStopped = 0";
        $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $medioAtencion);
        if ($result) {
            if (sqlsrv_has_rows($result)) {
                $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                $espera = $fila["espera"];
                if ($espera > 91) {
                    $total = $total + 1;
                }
            }
        } else {
            Log::escribirError("[Error al realizar la consulta de turnero rio gallegos][QUERY: $medioAtencion]");
        }
    }

    //compara cantidades

    $html = "";
    if ($total != 0) {
        $html = $html . '<tr><th><a href="prueboTurnero.php" class="text-danger"><font size=6>Turnero</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $total . '</font></th></tr>';
    } else {
        $html = $html . '<tr><th><a href="prueboTurnero.php" class="text-dark"><font size=4>Turnero</font></a></th><th><font size=4>' . $total . '</font></th></tr>';
    }


    return $html;
}

//firma grafometrica

function firma() {
    $html = '<tr><th><a href="firmaGrafometrica.php" class="text-dark"><font size=4>Reporte de Firmas Grafometricas</font></a></th><th><font size=4></font></th></tr>';
    return $html;
}

//chequeres pendientes

function chequeras() {
    $sql = "SELECT count(id) cantidad FROM [bd_sib].[dbo].[3chequerasPendientesEntrega] WHERE producto IN(107,117) AND diasAtraso > 45";
    $sql2 = "SELECT count(id) cantidad FROM [bd_sib].[dbo].[3chequerasPendientesEntrega] WHERE producto IN(100,101,103) AND diasAtraso > 15";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $result2 = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql2);
    $total = 0;
    $html = '';
    if ($result) {
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $total = $fila["cantidad"];
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de Plazos Vencidos en SAV][QUERY: $querySolicitudes]");
    }
    if ($result2) {
        if (sqlsrv_has_rows($result2)) {
            $fila = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);
            $total = $total + $fila["cantidad"];
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de Plazos Vencidos en SAV][QUERY: $querySolicitudes]");
    }

    if ($total != 0) {
        $html = $html . '<tr><th><a href="chequerasPendientes.php" class="text-danger"><font size=6>Chequeras Pendientes de Entregar</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $total . '</font></th></tr>';
    } else {
        $html = $html . '<tr><th><a href="chequerasPendientes.php" class="text-dark"><font size=4>Chequeras Pendientes de Entregar</font></a></th><th><font size=4>' . $total . '</font></th></tr>';
    }
    return $html;
}

//autorizacion de cheques en camara

function chequesCamara() {
    $querySolicitudes = "SELECT count(*) cantidad FROM [autorizacionChequesEnCamara]";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitudes);
    $html = "";
    if ($result) {
        $cantidad = 0;
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $fila["cantidad"];
        }
        if ($cantidad == 0) {
            $html = '<tr><th><a href="chequesCamara.php" class="text-dark"><font size=4>Autorizacion de cheques en camara</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        } else {
            $html = '<tr><th><a href="chequesCamara.php" class="text-danger"><font size=6>Autorizacion de cheques en camara</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de cheques en camara][QUERY: $querySolicitudes]");
    }
    return $html;
}

//pagares cancelados

function pagaresCancelados() {
    $querySolicitudes = "SELECT count(*) cantidad FROM [3pagaresCancelados]";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitudes);
    $html = "";
    if ($result) {
        $cantidad = 0;
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $fila["cantidad"];
        }
        if ($cantidad == 0) {
            $html = '<tr><th><a href="pagaresCancelados.php" class="text-dark"><font size=4>Pagares Cancelados en SAV</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        } else {
            $html = '<tr><th><a href="pagaresCancelados.php" class="text-danger"><font size=6>Pagares Cancelados en SAV</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de Plazos Vencidos en SAV][QUERY: $querySolicitudes]");
    }
    return $html;
}

//riesgo no informado

function riesgo() {
    $querySolicitudes = "select count(*) cantidad from openquery(M4000SF,'SELECT MCL.SCO_IDENT CODCLIENTE,
                                                                   MCL.SNO_CLIEN NOMCLIENTE,
                                                                   ADO.SNU_DOCUM CUIL,
                                                                   SUBSTR(ADO.SNU_DOCUM, 3, 8) DOCUMENTO,
                                                                   MCL.CCOEJECUE OFICIAL,
                                                                   MTG.ANO_LARGA ESTADO,
                                                                   ''NO INFORMADO'' RIESGO,
                                                                   TO_CHAR ( TO_DATE ( LPAD(MCL.SFE_ALTA, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHAALTA
                                                      FROM SFB_BSMCL MCL
                                                      INNER JOIN SFB_DAMCP MCP ON MCL.SFE_ALTA = DFE_DAN1 AND MCP.DCO_SUCUR4 = 9999
                                                      INNER JOIN SFB_BSADO ADO ON ADO.SCO_IDENT = MCL.SCO_IDENT AND ADO.SCOTIPDOC IN (34, 35)
                                                      INNER JOIN SFB_BSMTG MTG ON MTG.ACO_CODIG = LPAD(MCL.SCOESTPER, 2, 0) AND ACO_TABLA = ''ESTCLIEN'' AND ACO_CODIG <> '' ''
                                                      WHERE MCL.SSERIESGO = ''9'' ')
";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitudes);
    $html = "";
    if ($result) {
        $cantidad = 0;
        $html = '<tr><th><a href="riesgo.php" class="text-dark"><font size=4>Alta de Clientes con Riesgo no Informado</font></a></th><th><font size=4>' . $cantidad . '</font></th>
		</tr>';
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $fila["cantidad"];
            if ($cantidad != 0) {
                $html = '<tr><th><a href="riesgo.php" class="text-danger"><font size=6>Alta de Clientes con Riesgo no Informado</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th>
			</tr>';
            }
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de Riesgo no informado][QUERY: $querySolicitudes]");
    }
    return $html;
}

//CONSTANCIA DE SALDOS

function constanciaSaldos() {
    $html = '<tr><th><a href="buscarConstanciaSaldos.php" class="text-dark"><font size=4>Constancia de saldos</font></a></th><th><font size=4></font></th></tr>';
    return $html;
}

//Prestamos ATM

function prestamosATM() {
    $querySolicitudes = "select SUM(b.liqui) cantidad from(
						select SUM(IMPORTE) liqui from openquery(M4000SF,'SELECT 
						A.PVA_CREDI IMPORTE
						FROM SFB_PPMAP A , SFB_PPASO B
						WHERE A.PCU_PRODU in (925, 926,480, 489, 927, 497)
						AND A.PCUNUMCUE = B.PCUNUMCUE
						AND B.AFERELSOL = (SELECT DRE_DAN1 FROM SFB_DAMCP WHERE DCO_SUCUR4 = 9999)')
						union
						select SUM(IMPORTE) cred from openquery(M4000SF,'SELECT
						DECODE (ACOTRAATM,306,AVAMOVAT1 * -1, AVAMOVAT1) IMPORTE
						FROM SFB_AUALA
						WHERE AFE_NEGOC IN (SELECT DFE_DAN1 FROM SFB_DAMCP WHERE DCO_SUCUR4 = 9999)
						AND ACOTRAATM <> 309
						AND DCO_TRANS = 220
						AND ACOTRAATM IN (306)
						AND DCOCLAUSU <> ''REVERSION''
						AND VNU_ERROR = 0
						AND ACOTIPTRA NOT IN (''XC'',''ZC'')
						')
					) b ";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitudes);
    $html = "";
    if ($result) {
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $fila["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad == 0) {
            $html = '<tr><th><a href="prestamosATM.php" class="text-dark"><font size=4>Diferencias en prestamos ATM</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        } else {
            $html = '<tr><th><a href="prestamosATM.php" class="text-danger"><font size=6>Diferencias en prestamos ATM</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de Plazos Vencidos en SAV][QUERY: $querySolicitudes]");
    }
    return $html;
}

//ARCHIVOS CONTA

function conta() {
    $elemento = scandir(URL_Conta);
    $total = count($elemento);
    $total = $total - 2;
    $html = '<tr><th><a href="conta.php" class="text-danger"><font size=6>Archivos conta</font></a></th><th class="text-danger"><font size=6>' . $total . '</font></th></tr>';
    return $html;
}

//ALTA DE CHEQUERAS

function altaChequeras() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = date("ymd");
    $primero = date('ymd', strtotime('-7 days'));
    $sql = "select count(*) cantidad
	from [BSCBASES4].[TRXLINK].[dbo].[CHEQUERAS]
	WHERE CONVERT(datetime,RTRIM(LTRIM(TRANDAT)), 112) BETWEEN CONVERT(datetime,RIGHT('000000'+rtrim(ltrim('$primero')),6), 112) 
	AND CONVERT(datetime,RIGHT('000000'+rtrim(ltrim('$actual')),6), 112) 
	";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="altaChequeras.php" class="text-danger"><font size=6>Altas de chequeras</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="altaChequeras.php" class="text-dark"><font size=4>Altas de chequeras</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Altas de chequeras</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//CUENTAS PUENTE

function cuentasPuente() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "select count(*) cantidad
	from [bd_sib].[dbo].[3cuentasPuente]
	WHERE suc01 != 0 OR suc10 != 0 OR suc20 != 0 OR suc25 != 0 OR suc30 != 0 OR suc41 != 0 OR suc50 != 0 OR suc55 != 0 OR suc60 != 0 OR suc80 != 0 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="cuentasPuente.php" class="text-danger"><font size=6>Cuentas Puente</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="cuentasPuente.php" class="text-dark"><font size=4>Cuentas Puente</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Cuentas puente</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//UP TIME

function uptime() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT COUNT(*) cantidad FROM (
--san julian
SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2765','3571','6271','9381')
--rio turbio
UNION ALL
SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2766','6291', '9365', '9366')
  --rio gallegos
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2788',
'3560', '3591', '3592', '6280', '6281', '6282', '6283', '6284', '9356', '9360', '9374', '3582', '3583', '3584', '3585', '6290',
'6302', '6303', '2753', '2755', '2756', '2772', '2794', '2795', '3595', '3596', '3599', '6276', '6288', '6309', '9378', '9390', '9391', '9392', '9393', '9394', '9397', '9398')
  --santa cruz
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2769','6268', '9367', '9368')
  --puerto deseado
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2759','3562', '3563', '6306', '9370')
  --piedra buena
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2774','3566', '6274')
  --pico truncado
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('3572','3573', '3574', '6292', '6308', '9362' )
  --perito moreno
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2773','3570', '6270','9379', '9380')
  --los antiguos
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2790','3597', '6275')
  --las heras
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('3576',
'3577', '3578', '3579', '3580', '3581', '9363')
  --gregores
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2767',
'3565', '6279', '9369')
  --calafate
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2752',
'3567', '3568', '3569', '6278', '9364')
  --comodoro
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2784',
'6289' )
  --caleta olivia
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('2754',
'2783', '3586', '3587', '3589', '3594', '6269', '6293', '6307', '9361', '9375', '2775', '2780', '3564', '9396', '9399')
  --buens aires
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('9376',
'9377', '3598')
  --28
  UNION ALL
  SELECT convert(varchar,cast(SUM(convert(numeric,UPT)) / COUNT(*) as money),1) AS promedio
  FROM [bd_sib].[dbo].[upTimeDiario] where fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND cajero IN ('3588',
'6272', '6299')) a WHERE convert(numeric,a.promedio) < 95
";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="uptime.php" class="text-danger"><font size=6>Tiempo de Actividad - Cajeros</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="uptime.php" class="text-dark"><font size=4>Tiempo de Actividad - Cajeros</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Tiempo de actividad - Cajeros </font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//PAQUETES PENDIENTES

function paquetesPendientes() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = date("d/m/Y", strtotime('-7 days'));
    $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT count(*) cantidad FROM [BSCWF00].[DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDPAQUETES] 
            where estadoId IN (7,8,9) AND fechaMod between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad != 0) {
            $html = $html . '<tr><th><a href="paquetesPendientes.php" class="text-danger"><font size=6>Paquetes pendientes</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="paquetesPendientes.php" class="text-dark"><font size=4>Paquetes pendientes</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        }
    } else {
        Log::escribirError("[$sql]");
        $html = '
            <tr>
                <th><font size=4>Paquetes pendientes</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

function clientesBloqueadosEnIVR() {
    $consulta = "SELECT COUNT(*) cantidad FROM [VM000DB00].[IVR].[dbo].[ClienteBloqueo]";
    $resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
    if ($resultado) {
        $cantidad = 0;
        if (sqlsrv_has_rows($resultado)) {
            $filas = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        }
        if ($cantidad != 0) {
            $html = '
                <tr>
                    <th><a href="formClientesBloqueadosIVR.php" class="text-danger"><font size=6>Clientes bloqueados en IVR</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th>
                    <th class="text-danger"><font size=6>' . $cantidad . '</font></th>
                </tr>';
        } else {
            $html = '
                <tr>
                    <th><font size=4>Clientes bloqueados en IVR</font></th>
                    <th><font size=4>' . $cantidad . '</font></th>
                </tr>';
        }
    } else {
        Log::escribirError("[$consulta]");
        $html = '
            <tr>
                <th><font size=4>Clientes bloqueados en IVR</font></th>
                <th><font size=4>ERROR</font></th>
            </tr>';
    }
    return $html;
}

//SERVICIOS ADHERIDOS

function servicios() {
    $html = '<tr><th><a href="buscarServicios.php" class="text-dark"><font size=4>Buscar Servicios Adheridos</font></a></th><th><font size=4></font></th></tr>';
    return $html;
}

require_once './header.php';

session_start();

$_SESSION['buscar'] = null;
?>

<div class="container mt-4">
    <section id="tabs" class="project-tab">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-diario-tab" data-toggle="tab" href="#nav-diario" role="tab" aria-controls="nav-home" aria-selected="true">REPORTES DE CONTROL</a>
                            <a class="nav-item nav-link" id="nav-linea-tab" data-toggle="tab" href="#nav-linea" role="tab" aria-controls="nav-profile" aria-selected="false">REPORTES DE GESTION</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-diario" role="tabpanel" aria-labelledby="nav-diario-tab">
                            <table class="table table-striped table-bordered"> 
                                <thead style='background-color:#024d85; color:white;'>
                                    <tr> 
                                        <th> Nombre de reporte</th>
                                        <th> Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo turnero();
                                    echo cuentaCorrentista();
                                    echo canjeInterno();
                                    echo cobroCuotas();
                                    echo cuentasPorCerrar();
                                    echo pagareNoSAV();
                                    echo incorrectaIdentificacion();
                                    echo fallas();
                                    echo saldos();
                                    echo clientesPotenciales();
                                    echo riesgo();
                                    echo morasCPD();
                                    echo plazoVencidoSAV();
                                    echo chequeras();
                                    echo chequesCamara();
                                    echo pagaresCancelados();
                                    echo prestamosATM();
                                    echo conta();
                                    echo altaChequeras();
                                    echo cuentasPuente();
                                    echo uptime();
                                    echo paquetesPendientes();
                                    echo clientesBloqueadosEnIVR();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-linea" role="tabpanel" aria-labelledby="nav-linea-tab">
                            <table class="table table-striped table-bordered"> 
                                <thead style='background-color:#024d85; color:white;'>
                                    <tr> 
                                        <th> Nombre de reporte</th>
                                        <th> Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo altaClientes();
                                    echo reporteExtracciones();
                                    echo reporteReversas();
                                    echo telefonosTarjetas();
                                    echo morasCajaSeguridad();
                                    echo movimientosSinDepositantes();
                                    echo solicitudesWF();
									echo servicios();
                                    echo firma();
                                    echo constanciaSaldos();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>