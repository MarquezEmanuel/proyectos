<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';
include_once './Clase_consultas.php';
include_once './menu.php';

$filas = "";
$filas .= Clase_consultas::clientesBloqueadosEnIVR();
?>
<div class="container mt-4">
    <div class="container">
        <div class="row">
            <div class="col mt-4">
                <table class="table table-striped table-bordered"> 
                    <thead style='background-color:#024d85; color:white;'>
                        <tr> 
                            <th>Nombre de reporte</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody><?= $filas; ?></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>