<?php
include_once '../conf/Constants.php';
include_once '../conf/BDConexion.php';
include_once '../conf/Log.php';

/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <?php

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
        /* Se obtiene el id para obtener los datos de la BD */
        $idSucursal = $_POST['seleccionado'];
        $query = "SELECT a.*, b.total
        FROM [VM000DB00].[STE].[dbo].[vw_H_INS_TaskInterval] a,
        (SELECT count(*) total
        FROM [VM000DB00].[STE].[dbo].[vw_H_INS_TaskInterval] WHERE PartitionId = {$fecha}
        AND OrganizationCode = {$idSucursal} AND DTECode LIKE '%Totem%' AND 
        StateId = 2 AND AdminStopped = 0) b WHERE a.PartitionId = {$fecha} AND a.OrganizationCode = {$idSucursal}
        AND a.DTECode LIKE '%Totem%' AND a.StateId = 2 AND a.AdminStopped = 0";
        $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
        switch ($idSucursal) {
            case 01:
                $sucursal = "Rio Gallegos";
                break;
            case 02:
                $sucursal = "Comodoro Rivadavia";
                break;
            case 03:
                $sucursal = "Caleta Olivia";
                break;
            case 04:
                $sucursal = "Perito Moreno";
                break;
            case 05:
                $sucursal = "Buenos Aires";
                break;
            case 15:
                $sucursal = "Rio Turbio";
                break;
            case 20:
                $sucursal = "Piedra Buena";
                break;
            case 25:
                $sucursal = "El Calafate";
                break;
            case 30:
                $sucursal = "Gobernador Gregores";
                break;
            case 41:
                $sucursal = "Los Antiguos";
                break;
            case 45:
                $sucursal = "Las Heras";
                break;
            case 50:
                $sucursal = "Pico Truncado";
                break;
            case 55:
                $sucursal = "Puerto Deseado";
                break;
            case 60:
                $sucursal = "San Julian";
                break;
            case 70:
                $sucursal = "Puerto Santa Cruz";
                break;
            case 75:
                $sucursal = "Agencia";
                break;
            case 85:
                $sucursal = "28 de Noviembre";
                break;
        }
        if (!$idSucursal || !$result) {
            echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información solicitada </div>';
            Log::escribirError("[Error al final del turnero][QUERY: $query]");
            Log::escribirError("[sucursal][QUERY: $idSucursal]");
        } else {
            $totalTodo = 0;
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $cantidad = $row['total'];
                $fechaAlta = isset($row['StartDate']) ? $row['StartDate']->format('H:i:s') : "";
                $fechaFin = isset($row['EndDate']) ? $row['EndDate']->format('H:i:s') : "";
                $total = restar_horas($fechaAlta, $fechaFin);
                $totalTodo = suma_horas($totalTodo, $total);
            }
            $horatemp = explode(":", $totalTodo);
            $temp_h1 = (int) $horatemp[0];
            $temp_m1 = (int) $horatemp[1];
            $temp_s1 = (int) $horatemp[2];
            $segundos = (intval($temp_h1) * 3600) + (intval($temp_m1) * 60) + intval($temp_s1);
            $segundos = $segundos / $cantidad;
            $hh = intval($segundos / 3600);
            $mm = intval(($segundos - ($hh * 3600)) / 60);
            $ss = intval($segundos - ($hh * 3600) - ($mm * 60));


            $sql = "SELECT TOP 1 * FROM [VM000DB00].[STE].[dbo].[vw_H_INS_TaskInterval] WHERE 
            PartitionId = {$fecha} AND OrganizationCode = {$idSucursal} AND DTECode LIKE '%Totem%' AND StateId = 2 
            AND AdminStopped = 0 ORDER BY Duration DESC";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
            $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $fechaAlta = isset($row['StartDate']) ? $row['StartDate']->format('H:i:s') : "";
            $fechaFin = isset($row['EndDate']) ? $row['EndDate']->format('H:i:s') : "";
            $maximoEspera = restar_horas($fechaAlta, $fechaFin);

            Log::escribirError("[Error al final del turnero][QUERY: $query]");
            Log::escribirError("[Error al final del turnero segunda consulta ][QUERY: $sql]");
            ?>
            <h3 class="text-center"><u>Turnero <?= $sucursal ?></u></h3>
            <div id="centro" class="container">
                <div class="container">
                    <br><br>
                    <div class="form-group row">
                        <label for="numeroCliente" class="col-sm-2 col-form-label">Fecha:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $actual; ?>" readonly>
                        </div>
                        <label for="nombreCliente" class="col-sm-2 col-form-label">Horas Totales de Espera:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $totalTodo; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="altaUsuario" class="col-sm-2 col-form-label">Cantidad de Clientes:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2" value="<?= $cantidad; ?>" readonly>
                        </div>
                        <label for="nombreUsuario" class="col-sm-2 col-form-label">Tiempo Medio de Espera:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $hh . ":" . $mm . ":" . $ss; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="fechaAlta" class="col-sm-2 col-form-label">Maximo Tiempo de Espera:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $maximoEspera;
        } ?>" readonly>
                    </div>
                    <div class="w-100"></div>
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col" > 
                    </div>
                </div>                    
                <br>
                &nbsp;
                <a href="<?= $_SERVER["HTTP_REFERER"] ?>"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>