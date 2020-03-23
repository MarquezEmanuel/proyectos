<?php

include_once '../conf/BDConexion.php';

$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];

if (isset($desde) && $desde != null) {
    $desde = date("d/m/Y", strtotime($desde));
    $desde = $desde . " 00:00:00";
}
if (isset($hasta) && $hasta != null) {
    $hasta = date("d/m/Y", strtotime($hasta));
    $hasta = $hasta . " 23:59:00";
}

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT * FROM [correosElectronicosInvalidos] WHERE
CAST ([FECHAALTA] AS DATE) between 
 '".$desde."' and '".$hasta."'
";

if (isset($codigo) && $codigo != null) {
    //si tiene cuenta empieza el where
    $query = $query . " AND NROCLIENTE = " . $codigo;
    if (isset($nombre) && $nombre != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND NOMCLIENTE LIKE '%" . $nombre ."%'";
        if (isset($usuario) && $usuario != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND CORREO LIKE '%" . $usuario . "%'";
        }
    } else {
        //no tiene sucursal
        if (isset($usuario) && $usuario != null) {
            //si tiene tipo debito agrega en and
            $query = $query . " AND CORREO LIKE '%" . $usuario . "%'";
        }
    }
} else {				
    //no tiene cuenta
    if (isset($nombre) && $nombre != null) {
        //si tiene sucursal empieza el where
        $query = $query . " AND NOMCLIENTE LIKE '%" . $nombre ."%'";
        if (isset($usuario) && $usuario != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND CORREO LIKE '%" . $usuario . "%'";
        } 
    } else {
        //no tiene sucursal
        if (isset($usuario) && $usuario != null) {
             //si tiene tipo debito empieza el where
            $query = $query . " AND CORREO LIKE '%" . $usuario . "%'";
        }
    }
}

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cheques' class='table table-hover table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 15%'/>
                                        <col style='width: 20%'/>
                                        <col style='width: 25%'/>
                                        <col style='width: 10%'/>
                                        <col style='width: 10%'/>
										<col style='width: 10%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#363663;color:white;'>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            <th>Correo Electronico</th>
                                            <th>Usuario Creacion</th>
											<th>Usuario Edicion</th>
											<th>Sucursal</th>
											<th>Fecha</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['NOMCLIENTE']);
            $print = $print . "
            <tr>
                <td>{$row['NROCLIENTE']}</td>
                <td>{$row['NOMCLIENTE']}</td>
                <td>{$row['CORREO']}</td>
                <td>{$row['CODUSUCRE']}</td>
                <td>{$row['CODUSUMOD']}</td>
				<td>{$row['SUCURSAL']}</td>
				<td>{$row['FECHAALTA']}</td>
            </tr>";
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


