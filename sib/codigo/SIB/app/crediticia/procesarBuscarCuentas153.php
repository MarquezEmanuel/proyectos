<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cliente = $_POST['cliente'];
$producto = $_POST['producto'];
$dias = $_POST['dias'];
$signoDias = $_POST['signoDias'];
$protegido = $_POST['protegido'];
$signoProtegido = $_POST['signoProtegido'];
$disponible = $_POST['disponible'];
$signoDisponible = $_POST['signoDisponible'];


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select *,convert(varchar,cast(SALDOTOTACUERDOS as money),1) AS SALDOTOTACUERDOS2,convert(varchar,cast(SALDOCONTABLE as money),1) AS SALDOCONTABLE2,
convert(varchar,cast(SALDOPROTEGIDO as money),1) AS SALDOPROTEGIDO2, convert(varchar,cast(SALDODISPONIBLE as money),1) AS SALDODISPONIBLE2
from openquery(M4000SF,'
select DISTINCT
A.SCO_IDENT CLIENTE,
CONCAT(CONCAT(A.CCU_OFICI,''-''), CONCAT(CONCAT(A.CCUNUMCUE ,''/''), A.CCUDIGVER)) CUENTA,
A.CCU_PRODU PRODUCTO,
A.CCU_MONED MONEDA,
CASE A.CCOESTCUE
WHEN 1 THEN   ''ACTIVA''
WHEN 2 THEN   ''INMOVILIZADA''
WHEN 3 THEN   ''EN CIERRE''
WHEN 4 THEN   ''CERRADA HOY''
WHEN 5 THEN   ''POR CERRAR''
WHEN 7 THEN   ''POR ABRIR''
WHEN 8 THEN   ''INACTIVA''
END ESTADO,
A.CNO_CUENT NOMBRE,
A.CSAACUERD SALDOTOTACUERDOS,
A.CSATOTHOY SALDOCONTABLE,
A.CSA_PROTE SALDOPROTEGIDO,
A.CSAEFEHOY SALDODISPONIBLE,
A.CDIDEUMES DIASSALDODEUDOR,
(SELECT C.ANO_BLOQU FROM SFB_AAMTB C WHERE B.ACO_BLOQU =C.ACO_BLOQU) MOTIVOBLOQUEO,
D.ACO_USUAR USUARIO
from sfb_acmol A
LEFT JOIN SFB_ACABL B ON A.CCU_OFICI=B.CCU_OFICI AND A.CCUNUMCUE = B.CCUNUMCUE
LEFT JOIN SFB_ACABH D ON d.tnudoctra= b.tnudoctra and substr(lpad(b.glb_dtime,16),1,14)=substr(lpad(d.glb_dtime,16),1,14)
where A.ccu_produ=153 AND A.CCOESTCUE IN (1,2,3,4,5,7,8)
order by a.sco_ident 
')
 ";

if (isset($cliente) && $cliente != null) {
    //si tiene documento empieza el where
    $query = $query . " WHERE cliente = " . $cliente;
    if (isset($protegido) && $protegido != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND SALDOPROTEGIDO $signoProtegido" . $protegido;
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND PRODUCTO = " . $producto ;
            if (isset($disponible) && $disponible != null) {
                //si tiene sucursal y cartera y atraso agrega en and
                $query = $query . " AND SALDODISPONIBLE $signoDisponible" . $disponible;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            }else{
                //no tiene atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            }
        } else{
            //no tiene cartera
            if (isset($disponible) && $disponible != null) {
                //si tiene sucursal y atraso agrega en and
                $query = $query . " AND SALDODISPONIBLE $signoDisponible" . $disponible;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            } else{
                //no tiene cartera ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            }
        }
    } else {
        //no tiene sucursal
        if (isset($producto) && $producto != null) {
            //si tiene cartera agrega en and
            $query = $query . " AND PRODUCTO = " . $producto;
            if (isset($disponible) && $disponible != null) {
                //si tiene cartera y atraso agrega en and
                $query = $query . " AND SALDODISPONIBLE $signoDisponible" . $disponible;
                if (isset($dias) && $dias != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            }
        } else{
            //no tiene sucursal ni cartera
            if (isset($disponible) && $disponible != null) {
                //si tiene atraso agrega en and
                $query = $query . " AND SALDODISPONIBLE $signoDisponible" . $disponible;
                if (isset($dias) && $dias != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            } else{
                //no tiene sucursal ni prestamo ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            }
        }
    }
} else {
    //no tiene documento
    if (isset($protegido) && $protegido != null) {
        //si tiene sucursal empieza el where
        $query = $query . " WHERE SALDOPROTEGIDO $signoProtegido" . $protegido;
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND PRODUCTO = " . $producto;
            if (isset($disponible) && $disponible != null) {
                //si tiene sucursal y cartera y atraso agrega en and
                $query = $query . " AND SALDODISPONIBLE $signoDisponible" . $disponible;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            } else{
                //no tiene producto ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            }
        } else{
            //no tiene producto ni prestamo
            if (isset($disponible) && $disponible != null) {
                //si tiene sucursal y atraso agrega en and
                $query = $query . " AND SALDODISPONIBLE $signoDisponible" . $disponible;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            } else{
                //no tiene tipo debito ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            }
        }
    } else {
        //no tiene sucursal
        if (isset($producto) && $producto != null) {
             //si tiene cartera empieza el where
            $query = $query . " WHERE PRODUCTO = " . $producto;
            if (isset($disponible) && $disponible != null) {
                //si tiene cartera y atraso agrega en and
                $query = $query . " AND SALDODISPONIBLE $signoDisponible" . $disponible;
                if (isset($dias) && $dias != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            } else{
                //no tiene atraso
                if (isset($dias) && $dias != null) {
                    //si tiene cartera y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            }
        } else{
            //no tiene cartera
            if (isset($disponible) && $disponible != null) {
                //si tiene atraso agrega en and
                $query = $query . " WHERE SALDODISPONIBLE $signoDisponible" . $disponible;
                if (isset($dias) && $dias != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND DIASSALDODEUDOR $signoDias " . $dias;
                }
            } else{
                //no tiene atraso
                if (isset($dias) && $dias != null) {
                    //si tiene monto agrega en and
                    $query = $query . " WHERE DIASSALDODEUDOR $signoDias " . $dias;
                }
            }
        }
    }
}

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);


$_SESSION['buscar'] = $query;


if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th>Cliente</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th>Producto</th>
                                            <th style='display:none;'>Moneda</th>
                                            <th>Estado</th>
                                            <th style='display:none;'>Nombre</th>
                                            <th>Saldo Total Acuerdos</th>
                                            <th>Saldo Contable</th>
                                            <th style='display:none;'>Saldo Protegido</th>
                                            <th style='display:none;'>Saldo Disponible</th>
                                            <th>Dias Saldo Deudor</th>
											<th style='display:none;'>Motivo de Bloqueo</th>
											<th style='display:none;'>Usuario</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
		$fila = 0;
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['NOMBRE']);
			$motivoBloqueo = utf8_encode($row['MOTIVOBLOQUEO']);
            $print = $print . "
            <tr id='{$fila}'>
                <td>{$row['CLIENTE']}</td>
                <td style='display:none;'>{$row['CUENTA']}</td>
                <td>{$row['PRODUCTO']}</td>
                <td style='display:none;'>{$row['MONEDA']}</td>
                <td>{$row['ESTADO']}</td>
                <td style='display:none;'>{$nombre}</td>
                <td>{$row['SALDOTOTACUERDOS2']}</td>
                <td>{$row['SALDOCONTABLE2']}</td>
                <td style='display:none;'>{$row['SALDOPROTEGIDO2']}</td>
                <td style='display:none;'>{$row['SALDODISPONIBLE2']}</td>
                <td>{$row['DIASSALDODEUDOR']}</td>
                <td style='display:none;'>{$motivoBloqueo}</td>
				<td style='display:none;'>{$row['USUARIO']}</td>
                <td class='text-center' title='Ver detalles de la cobranza'>
                    <button class='btn btn-sm btn-outline-info detalleChequePagado' name='{$fila}'> 
                        <img src='/lib/img/SHOW.png' class='detallesCobranzasTC' name='' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
			$fila++;
        }
        $print = $print . "</tbody></table>
        ";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
} else {
    // OCURRIO UN ERROR 
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
    echo $query;
}

echo $print;


