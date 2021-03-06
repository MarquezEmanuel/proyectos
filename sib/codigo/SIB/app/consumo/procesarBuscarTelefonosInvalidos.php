<?php

include_once '../conf/BDConexion.php';

$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT TOP 6000* FROM [telefonosParticularesInvalidos] ";

if (isset($codigo) && $codigo != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE NROCLIENTE = " . $codigo;
    if (isset($nombre) && $nombre != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND NOMCLIENTE LIKE '%" . $nombre ."%'";
        if (isset($usuario) && $usuario != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND CODUSUCRE LIKE '%" . $usuario . "%'";
        }
    } else {
        //no tiene sucursal
        if (isset($usuario) && $usuario != null) {
            //si tiene tipo debito agrega en and
            $query = $query . " AND CODUSUCRE LIKE '%" . $usuario . "%'";
        }
    }
} else {				
    //no tiene cuenta
    if (isset($nombre) && $nombre != null) {
        //si tiene sucursal empieza el where
        $query = $query . " WHERE NOMCLIENTE LIKE '%" . $nombre ."%'";
        if (isset($usuario) && $usuario != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND CODUSUCRE LIKE '%" . $usuario . "%'";
        } 
    } else {
        //no tiene sucursal
        if (isset($usuario) && $usuario != null) {
             //si tiene tipo debito empieza el where
            $query = $query . " WHERE CODUSUCRE LIKE '%" . $usuario . "%'";
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
                                        <col style='width: 25%'/>
                                        <col style='width: 25%'/>
                                        <col style='width: 25%'/>
                                        <col style='width: 25%'/>
                                    </colgroup>
                                    <thead style='background-color:#363663;color:white;'>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nombre y Apellido</th>
                                            <th>Telefono</th>
                                            <th>Usuario Creacion</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['NOMCLIENTE']);
            $print = $print . "
            <tr>
                <td>{$row['NROCLIENTE']}</td>
                <td>{$nombre}</td>
                <td>{$row['TELEFONO']}</td>
                <td>{$row['CODUSUCRE']}</td>
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


