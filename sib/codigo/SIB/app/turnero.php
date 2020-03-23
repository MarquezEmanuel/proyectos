<?php
include_once 'conf/BDConexion.php';

function reversas() {
    $sql = "SELECT * FROM [chatsParticipante]";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    echo $sql;
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $fechaInicio = $row['fechaInicio'];
                $fechaFin = $row['fechaFin'];
                $html = $html . "
                    <tr>
                    <td>{$fechaInicio}</td>    
                    <td>{$fechaFin}</td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=2>No hay reportes de reversas en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=2>No hay reportes de reversas en la fecha</td></tr>";
    }
    return $html;
}

function mensaje() {
    $sqlParticipante = "  SELECT a.*, b.total
  FROM [bd_sib].[dbo].[turnero] a,
  (SELECT count(*) total
  FROM [bd_sib].[dbo].[turnero]) b";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlParticipante);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $totalTodo = 0;
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $cantidad = $row['total'];
                $fechaAlta = isset($row['fechaInicio']) ? $row['fechaInicio']->format('H:i:s') : "";
                $fechaFin = isset($row['fechaFin']) ? $row['fechaFin']->format('H:i:s') : "";
                $total = restar_horas($fechaAlta, $fechaFin);
                $totalTodo = suma_horas($totalTodo, $total);
                $html = $html . "<tr>
                    <td>{$fechaAlta}</td>
                    <td>{$fechaFin}</td>
                    <td>{$totalTodo}</td>    
                    </tr>";
            }
			$horatemp = explode(":", $totalTodo);
			$temp_h1 = (int) $horatemp[0];
			$temp_m1 = (int) $horatemp[1];
			$temp_s1 = (int) $horatemp[2];
			echo 'hora'.$temp_h1;
			echo 'minutos'.$temp_m1;
			echo 'segundos'.$temp_s1;
			$segundos = (intval ($temp_h1)*3600)+(intval ($temp_m1) * 60) + intval ($temp_s1);
			echo 'pasado:'.$segundos;
			$segundos = $segundos / $cantidad;
			$hh = intval ($segundos / 3600);
			$mm = intval (($segundos - ($hh*3600)) / 60);
			$ss = intval ($segundos - ($hh*3600) - ($mm*60));	
			echo 'promedio:'.$hh.':'.$mm.':'.$ss;

        } else {
            $html = $html . "";
        }
    } else {
        $html = $html . "";
    }
    return $html;
}

function restar_horas($hora1, $hora2) {

    $temp1 = explode(":", $hora1);
    $temp_h1 = (int) $temp1[0];
    $temp_m1 = (int) $temp1[1];
    $temp_s1 = (int) $temp1[2];
    $temp2 = explode(":", $hora2);
    $temp_h2 = (int) $temp2[0];
    $temp_m2 = (int) $temp2[1];
    $temp_s2 = (int) $temp2[2];

    // si $hora2 es mayor que la $hora1, invierto 
    if ($temp_h1 < $temp_h2) {
        $temp = $hora1;
        $hora1 = $hora2;
        $hora2 = $temp;
    }
    /* si $hora2 es igual $hora1 y los minutos de 
      $hora2 son mayor que los de $hora1, invierto */ elseif ($temp_h1 == $temp_h2 && $temp_m1 < $temp_m2) {
        $temp = $hora1;
        $hora1 = $hora2;
        $hora2 = $temp;
    }
    /* horas y minutos iguales, si los segundos de  
      $hora2 son mayores que los de $hora1,invierto */ elseif ($temp_h1 == $temp_h2 && $temp_m1 == $temp_m2 && $temp_s1 < $temp_s2) {
        $temp = $hora1;
        $hora1 = $hora2;
        $hora2 = $temp;
    }

    $hora1 = explode(":", $hora1);
    $hora2 = explode(":", $hora2);
    $temp_horas = 0;
    $temp_minutos = 0;

    //resto segundos 
    $segundos;
    if ((int) $hora1[2] < (int) $hora2[2]) {
        $temp_minutos = -1;
        $segundos = ( (int) $hora1[2] + 60 ) - (int) $hora2[2];
    } else
        $segundos = (int) $hora1[2] - (int) $hora2[2];

    //resto minutos 
    $minutos;
    if ((int) $hora1[1] < (int) $hora2[1]) {
        $temp_horas = -1;
        $minutos = ( (int) $hora1[1] + 60 ) - (int) $hora2[1] + $temp_minutos;
    } else
        $minutos = (int) $hora1[1] - (int) $hora2[1] + $temp_minutos;

    //resto horas     
    $horas = (int) $hora1[0] - (int) $hora2[0] + $temp_horas;

    if ($horas < 10)
        $horas = '0' . $horas;

    if ($minutos < 10)
        $minutos = '0' . $minutos;

    if ($segundos < 10)
        $segundos = '0' . $segundos;

    $rst_hrs = $horas . ':' . $minutos . ':' . $segundos;

    return ($rst_hrs);
}

function suma_horas($hora1, $hora2) {

    $hora1 = explode(":", $hora1);
    $hora2 = explode(":", $hora2);
    $temp = 0;

    //sumo segundos 
    $segundos = (int) $hora1[2] + (int) $hora2[2];
    while ($segundos >= 60) {
        $segundos = $segundos - 60;
        $temp++;
    }

    //sumo minutos 
    $minutos = (int) $hora1[1] + (int) $hora2[1] + $temp;
    $temp = 0;
    while ($minutos >= 60) {
        $minutos = $minutos - 60;
        $temp++;
    }

    //sumo horas 
    $horas = (int) $hora1[0] + (int) $hora2[0] + $temp;

    if ($horas < 10)
        $horas = '0' . $horas;

    if ($minutos < 10)
        $minutos = '0' . $minutos;

    if ($segundos < 10)
        $segundos = '0' . $segundos;

    $sum_hrs = $horas . ':' . $minutos . ':' . $segundos;

    return ($sum_hrs);
}
?>

<html id="html">
    <head>
        <meta charset="UTF-8">
        <title> SIB </title>
        <link rel="stylesheet" href="../lib/css/bootstrap-toggle.min.css"/>
        <link rel="stylesheet" href="../lib/css/estilos.css"/>
        <link rel="stylesheet" href="../lib/css/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" href="../lib/css/datatables/jquery.dataTables.css">
        <link rel="stylesheet" href="../lib/css/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../lib/css/buttons.dataTables.min.css">
        <script type="text/javascript" src="../lib/JQuery/jquery-3.3.1.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/bootstrap-toggle.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/buttons.flash.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/buttons.html5.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/buttons.print.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/loader.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/JQuery/jquery.tablesorter.min.js"></script>
    </head>
    <body style="background-color:lavender;">
    <navbar id="menu-horizontal" class="navbar navbar-expand-lg navbar-dark" style="background-color: #024d85;">
        <div class="container">
            <span><a href="gsuc/reportesTablas.php"><img src="../lib/img/cabezera.png" class="img-thumbnail" alt="Responsive image" width="70" height="70"></a></span>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        &nbsp;&nbsp;<h3 class="text-white">Gestion de reportes</h3>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    </ul>
                </div>
            </div>
        </div>
    </navbar>
    <div class="container">
        <div class="card-header">
            <div id="centro" class="container">
                <div class="col-lg-12">
                    <div class="row">
                        <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                            <div class="center">
                                <h3 class="text-center"><u>Turnero</u></h3>
                            </div>
                            <br>
                            &nbsp;
                            <br><br>
                            <div class="form-row align-items-center mx-auto">
                                <table id='diariosReversas' class='table table-striped table-bordered' border="3" style="width: 100%">
                                    <colgroup>
                                        <col style='width: 30%'/>
                                        <col style='width: 30%'/>
                                        <col style='width: 30%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha fin</th>
                                            <th>Resto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
echo mensaje();
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
</html>

