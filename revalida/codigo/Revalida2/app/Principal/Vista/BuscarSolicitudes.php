<?php

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$estado = "";
$count= 1;
$controlador = new ControladorPrincipal();

$estado = $controlador->buscarEspApro($_POST['x']);



if (gettype($estado) == "resource") {
  $cuerpo  = "";
    $total = sqlsrv_num_rows($estado);

    $cuerpo = '
<link href="../css/fieldSet.css" rel="stylesheet" id="bootstrap-css">
<link href="../css/tabs.css" rel="stylesheet" id="bootstrap-css">

<form id="msform">
  <div class="container">
    <div class="form-row">';

  while ($esta = sqlsrv_fetch_array($estado, SQLSRV_FETCH_ASSOC)) {
 
     $cuerpo.=' <div class="col-sm-4">
        <fieldset>
          <div class="input">
            <p>FECHA</p>
            <p>' . utf8_encode(date_format($esta['fechaPedido'],'Y-m-d')) . '</p>
          </div>
          <div>

          </div>
          <div class="input" style="border:1px">
            <span align="left"><img style="max-width: 50px; max-height: 50px" src="../../../lib/img/hombres.png" alt=""></span>
          </div>
        </fieldset>  
      </div>';
}

$cuerpo.='</div>
</div>
</form>
';

echo $cuerpo;
} else {
  echo " 
  <div class='container'  align='center'>
    <div id='loader-icon' style='max-width: 300px; max-height: 300px'>
      <img  style='max-width: 300px; max-height: 300px' src='../../../lib/img/mac.png' alt=''>
    </div>
    <div>
      <font id='fuentes'>Lo siento.</font>
      <font id='fuenta'>Aun no ha recibido ninguna noticia.</font>
    </div>
  </div>
";
}
