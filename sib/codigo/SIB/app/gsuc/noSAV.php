<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function noSAV() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual." 00:00:00";
    $actualfinal = $actualfinal." 23:59:59";
    
    //Rio Gallegos
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 1 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Rio Gallegos";
                $html = $html. "
                    <tr>
                    <td>1</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Rio Gallegos</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Rio Gallegos</td></tr>";
    }
    
    //BS AS
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 5 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Buenos Aires";
                $html = $html. "
                    <tr>
                    <td>5</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Buenos Aires</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Buenos Aires</td></tr>";
    }
    
    //Caleta
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 10 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Caleta Olivia";
                $html = $html. "
                    <tr>
                    <td>10</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Caleta Olivia</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Caleta Olivia</td></tr>";
    }
    
    //Rio Turbio
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 15 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Rio Turbio";
                $html = $html. "
                    <tr>
                    <td>15</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Rio Turbio</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Rio Turbio</td></tr>";
    }
    
    //Piedra Buena
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 20 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Piedra Buena";
                $html = $html. "
                    <tr>
                    <td>20</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Piedra Buena</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Piedra Buena</td></tr>";
    }
    
    //Calafate
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 25 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Calafate";
                $html = $html. "
                    <tr>
                    <td>25</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Calafate</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Calafate</td></tr>";
    }
    
    //Gobernador Gregores
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 30 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Gobernador Gregores";
                $html = $html. "
                    <tr>
                    <td>30</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Gobernador Gregores</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Gobernador Gregores</td></tr>";
    }
    
    //Perito Moreno
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 40 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Perito Moreno";
                $html = $html. "
                    <tr>
                    <td>40</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Perito Moreno</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Perito Moreno</td></tr>";
    }
    
    //Los Antiguos
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 41 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Los Antiguos";
                $html = $html. "
                    <tr>
                    <td>41</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Los Antiguos</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Los Antiguos</td></tr>";
    }
    
    //Las Heras
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 45 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Las Heras";
                $html = $html. "
                    <tr>
                    <td>45</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Las Heras</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Las Heras</td></tr>";
    }
    
    //Pico Truncado
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 50 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Pico Truncado";
                $html = $html. "
                    <tr>
                    <td>50</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Pico Truncado</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Pico Truncado</td></tr>";
    }
    
    //Puerto Deseado
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 55 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Puerto Deseado";
                $html = $html. "
                    <tr>
                    <td>55</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Puerto Deseado</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Puerto Deseado</td></tr>";
    }
    
    //San Julian
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 60 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "San Julian";
                $html = $html. "
                    <tr>
                    <td>60</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en San Julian</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en San Julian</td></tr>";
    }
    
    //Puerto Santa Cruz
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 70 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Puerto Santa Cruz";
                $html = $html. "
                    <tr>
                    <td>70</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Puerto Santa Cruz</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Puerto Santa Cruz</td></tr>";
    }
    
    //Comodoro Rivadavia
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 80 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "Comodoro Rivadavia";
                $html = $html. "
                    <tr>
                    <td>80</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Comodoro Rivadavia</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en Comodoro Rivadavia</td></tr>";
    }
    
    //28 de Noviembre
    
    $sql = "SELECT count(*)cantidad FROM [3crucePPMAPySAV] WHERE pcuOfici = 85 AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreSucursal = "28 de Noviembre";
                $html = $html. "
                    <tr>
                    <td>85</td>
                    <td>{$nombreSucursal}</td>    
                    <td>{$row['cantidad']}</td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en 28 de Noviembre</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=3>No hay pagares no cargados en SAV en la fecha en 28 de Noviembre</td></tr>";
    }
    
    return $html;
}
require_once './header.php';
?>

<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Pagare no cargados en SAV</u></h3>
                        </div>
                        <br>
                        <a href="buscarPagare.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                                <table id='diariosPagare' class='table table-striped table-bordered' border="3" style="width: 100%">
                                    <colgroup>
                                    <col style='width: 20%'/>
                                    <col style='width: 60%'/>
                                    <col style='width: 20%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Numero de Sucursal</th>
                                            <th>Nombre de Sucursal</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    echo noSAV();
                                    ?>
                                    </tbody>
                                </table>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" charset="utf8" src="/lib/JQuery/buscarPagare.js"></script>
<script type="text/javascript" charset="utf8" src="/lib/JQuery/diarios.js"></script>
</html>

