<?php

/* CONSTANTES PARA LAS RUTAS - LOG PARA REGISTRAR Y CONEXION A BASE DE DATOS */
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$sucursal = $_POST['numSucursal'];
$sav = $_POST['numSav'];
$estado = $_POST['selectEstado'];
$nroCliente = $_POST['numNroCliente'];
$nomCliente = $_POST['txtNomCliente'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT * FROM garantia g
            LEFT JOIN cartera c ON g.id_cartera = c.id_cartera
            LEFT JOIN fianza f ON g.id_fianza = f.id_fianza 
            LEFT JOIN hipoteca h ON g.id_hipoteca = h.id_hipoteca 
            LEFT JOIN leasing l ON g.id_leasing = l.id_leasing 
            LEFT JOIN prenda p ON g.id_prenda = p.id_prenda ";

if (isset($sucursal) && $sucursal != null) {
    $query = $query . " WHERE g.sucursal=" . $sucursal;
    if (isset($sav) && $sav != null) {
        $query = $query . " AND g.sav = " . $sav;
        if (isset($estado)) {
            $query = $query . " AND g.estado = '" . $estado . "'";
        }
        if (isset($nroCliente) && $nroCliente != null) {
            $query = $query . " AND g.nroCli = '" . $nroCliente . "'";
        }
        if (isset($nomCliente) && $nomCliente != null) {
            $query = $query . " AND g.nomCli LIKE '%" . $nomCliente . "%'";
        }
    } else {
        if (isset($estado)) {
            $query = $query . " AND g.estado = '" . $estado . "'";
            if (isset($nroCliente) && $nroCliente != null) {
                $query = $query . " AND g.nroCli = '" . $nroCliente . "'";
            }
            if (isset($nomCliente) && $nomCliente != null) {
                $query = $query . " AND g.nomCli LIKE '%" . $nomCliente . "%'";
            }
        } else {
            if (isset($nroCliente) && $nroCliente != null) {
                $query = $query . " AND g.nroCli = '" . $nroCliente . "'";
                if (isset($nomCliente) && $nomCliente != null) {
                    $query = $query . " AND g.nomCli LIKE '%" . $nomCliente . "%'";
                }
            } else {
                if (isset($nomCliente) && $nomCliente != null) {
                    $query = $query . " AND g.nomCli LIKE '%" . $nomCliente . "%'";
                }
            }
        }
    }
} else {
    if (isset($sav) && $sav != null) {
        $query = $query . "WHERE g.sav = " . $sav;
        if (isset($estado)) {
            $query = $query . " AND g.estado = '" . $estado . "'";
        }
        if (isset($nroCliente) && $nroCliente != null) {
            $query = $query . " AND g.nroCli = '" . $nroCliente . "'";
        }
        if (isset($nomCliente) && $nomCliente != null) {
            $query = $query . " AND g.nomCli LIKE '%" . $nomCliente . "%'";
        }
    } else {
        if (isset($estado)) {
            $query = $query . " WHERE g.estado = '" . $estado . "'";
            if (isset($nroCliente) && $nroCliente != null) {
                $query = $query . " AND g.nroCli = '" . $nroCliente . "'";
            }
            if (isset($nomCliente) && $nomCliente != null) {
                $query = $query . " AND g.nomCli LIKE '%" . $nomCliente . "%'";
            }
        } else {
            if (isset($nroCliente) && $nroCliente != null) {
                $query = $query . " WHERE g.nroCli = '" . $nroCliente . "'";
                if (isset($nomCliente) && $nomCliente != null) {
                    $query = $query . " AND g.nomCli LIKE '%" . $nomCliente . "%'";
                }
            } else {
                if (isset($nomCliente) && $nomCliente != null) {
                    $query = $query . " WHERE g.nomCli LIKE '%" . $nomCliente . "%'";
                }
            }
        }
    }
}

// SE EJECUTA LA CONSULTA 
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_gtia' class='table table-bordered '>
        <thead style='background-color:#024d85; color:white;'>
            <tr>
                <th title='Sucursal' class='text-center'>Sucursal</th>
                <th title='Fecha de alta de la operación' class='text-center'>Alta operación</th>
                <th title='Fecha de vencimiento de la operación' class='text-center'>Vto operación</th>
                <th style='display:none;'>Número cliente</th>
                <th title='Nombre del cliente' class='text-center'>Nombre cliente</th>
                <th title='Valor nominal' class='text-center'>Valor nominal</th>
                <th style='display:none;'>Moneda</th>
                <th title='Descripción del producto' class='text-center'>Descripción producto</th>
                <th title='Operacion/Relación' class='text-center'>Operación/Relación</th>
                <th style='display:none;'>Producto cred</th>
                <th style='display:none;'>Entrega Garantia</th>
                <th style='display:none;'>Original</th>
                <th title='Número de SAV' class='text-center'>SAV</th>
                <th style='display:none;'>Estado</th>
                <th style='display:none;'>Gestión Cancelación</th>
                <th style='display:none;'>Observación</th>
                
                <th style='display:none;'>H: Producto gtia</th>
                <th style='display:none;'>H: Nro gtia</th>
                <th style='display:none;'>H: Fecha vto</th>
                <th style='display:none;'>H: Esc dominio</th>
                <th style='display:none;'>H: Fecha inscripcion</th>
                <th style='display:none;'>H: Cotización</th>
                <th style='display:none;'>H: Numero inscripción</th>
                <th style='display:none;'>H: Hipotecante</th>
                <th style='display:none;'>H: Seguro</th>
                <th style='display:none;'>H: Vencimiento</th>
                <th style='display:none;'>H: Datos</th>
                
                <th style='display:none;'>P: Producto gtia</th>
                <th style='display:none;'>P: Nro gtia</th>
                <th style='display:none;'>P: Fecha vto</th>
                <th style='display:none;'>P: Numero inscripción</th>
                <th style='display:none;'>P: Seguro</th>
                <th style='display:none;'>P: Vencimiento</th>
                <th style='display:none;'>P: Cotización</th>
                <th style='display:none;'>P: Fecha inscripción</th>
                <th style='display:none;'>P: Deudor</th>
                <th style='display:none;'>P: Datos</th>
                
                <th style='display:none;'>F: Producto gtia</th>
                <th style='display:none;'>F: Nro gtia</th>
                <th style='display:none;'>F: Fecha vto</th>
                <th style='display:none;'>F: Monto</th>
                <th style='display:none;'>F: Datos acuerdo</th>
                <th style='display:none;'>F: Datos fiador</th>
                <th style='display:none;'>F: Fecha Instrumentacion</th>
                <th style='display:none;'>F: Fecha escribania</th>
                
                <th style='display:none;'>L: Producto gtia</th>
                <th style='display:none;'>L: Nro gtia</th>
                <th style='display:none;'>L: Fecha vto</th>
                <th style='display:none;'>L: Numero inscripción</th>
                <th style='display:none;'>L: Seguro</th>
                <th style='display:none;'>L: Vencimiento</th>
                <th style='display:none;'>L: Cotizacion</th>
                <th style='display:none;'>L: Fecha escrituración</th>
                <th style='display:none;'>L: Datos</th>
                
                <th style='display:none;'>C: Producto gtia</th>
                <th style='display:none;'>C: Nro gtia</th>
                <th style='display:none;'>C: Fecha vto</th>
                <th style='display:none;'>C: Fecha escrituracion</th>
                <th style='display:none;'>C: Fecha inscripcion</th>
                <th style='display:none;'>C: Datos cartera</th>
                
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            
            $fecVtoGtiaHip = isset($row['fecVtoGtiaHip']) ? $row['fecVtoGtiaHip']->format('d/m/Y') : "";
            $fecVtoGtiaPre = isset($row['fecVtoGtiaPre']) ? $row['fecVtoGtiaPre']->format('d/m/Y') : "";
            $fecVtoGtiaFia = isset($row['fecVtoGtiaFia']) ? $row['fecVtoGtiaFia']->format('d/m/Y') : "";
            $fecVtoGtiaLea = isset($row['fecVtoGtiaLea']) ? $row['fecVtoGtiaLea']->format('d/m/Y') : "";
            $fecVtoGtiaCart = isset($row['fecVtoGtiaCart']) ? $row['fecVtoGtiaCart']->format('d/m/Y') : "";
            $altaOperacion = isset($row['fecAltaOpe']) ? $row['fecAltaOpe']->format('d/m/Y') : "";
            $vtoOperacion = isset($row['fecVtoOpe']) ? $row['fecVtoOpe']->format('d/m/Y') : "";
            $fechaInsHip = isset($row['fecInscHip']) ? $row['fecInscHip']->format('d/m/Y') : "";
            $fechaEscPre = isset($row['fecEscPre']) ? $row['fecEscPre']->format('d/m/Y') : "";
            $fechaInsFia = isset($row['fecInscFia']) ? $row['fecInscFia']->format('d/m/Y') : "";
            $fechaEscFia = isset($row['fecEscFia']) ? $row['fecEscFia']->format('d/m/Y') : "";
            $fechaEscLea = isset($row['fecEscLea']) ? $row['fecEscLea']->format('d/m/Y') : "";
            $fechaEscCart = isset($row['fecEscCart']) ? $row['fecEscCart']->format('d/m/Y') : "";
            $fechaInscCart = isset($row['fecInscCart']) ? $row['fecInscCart']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['sucursal']}</td>
                <td>{$altaOperacion}</td>
                <td>{$vtoOperacion}</td>
                <td style='display:none;'>{$row['nroCli']}</td>
                <td>{$row['nomCli']}</td>
                <td>{$row['valNomi']}</td>
                <td style='display:none;'>{$row['moneda']}</td>
                <td>{$row['descProd']}</td>
                <td>{$row['opeRela']}</td>
                <td style='display:none;'>{$row['prodCred']}</td>
                <td style='display:none;'>{$row['entGtia']}</td>
                <td style='display:none;'>{$row['oriGtia']}</td>
                <td>{$row['sav']}</td>
                <td style='display:none;'>{$row['estado']}</td>
                <td style='display:none;'>{$row['gesCan']}</td>
                <td style='display:none;'>{$row['observacion']}</td>
                
                <td style='display:none;'>{$row['prodGtiaHip']}</td>
                <td style='display:none;'>{$row['nroGtiaHip']}</td>
                <td style='display:none;'>{$fecVtoGtiaHip}</td>
                <td style='display:none;'>{$row['nroInscPre']}</td>
                <td style='display:none;'>{$fechaInsHip}</td>
                <td style='display:none;'>{$row['cotizaHip']}</td>
                <td style='display:none;'>{$row['nroInscHip']}</td>
                <td style='display:none;'>{$row['deudorHip']}</td>
                <td style='display:none;'>{$row['nomSegHip']}</td>
                <td style='display:none;'>{$row['vtoSegHip']}</td>
                <td style='display:none;'>{$row['datGtiaHip']}</td>
                
                 <td style='display:none;'>{$row['prodGtiaPre']}</td>
                <td style='display:none;'>{$row['nroGtiaPre']}</td>
                <td style='display:none;'>{$fecVtoGtiaPre}</td>
                <td style='display:none;'>{$row['escDomHip']}</td>
                <td style='display:none;'>{$row['nomSegPre']}</td>
                <td style='display:none;'>{$row['vtoSegPre']}</td>
                <td style='display:none;'>{$row['cotizaPre']}</td>
                <td style='display:none;'>{$fechaEscPre}</td>
                <td style='display:none;'>{$row['deudorPre']}</td>
                <td style='display:none;'>{$row['datGtiaPre']}</td>
                
                <td style='display:none;'>{$row['prodGtiaFia']}</td>
                <td style='display:none;'>{$row['nroGtiaFia']}</td>
                <td style='display:none;'>{$fecVtoGtiaFia}</td>
                <td style='display:none;'>{$row['montoFia']}</td>
                <td style='display:none;'>{$row['datAcue']}</td>
                <td style='display:none;'>{$row['datFiad']}</td>
                <td style='display:none;'>{$fechaInsFia}</td>
                <td style='display:none;'>{$fechaEscFia}</td>
                    
                <td style='display:none;'>{$row['prodGtiaLea']}</td>
                <td style='display:none;'>{$row['nroGtiaLea']}</td>
                <td style='display:none;'>{$fecVtoGtiaLea}</td>
                <td style='display:none;'>{$row['nroInscLea']}</td>
                <td style='display:none;'>{$row['nomSegLea']}</td>
                <td style='display:none;'>{$row['vtoSegLea']}</td>
                <td style='display:none;'>{$row['cotizaLea']}</td>
                <td style='display:none;'>{$fechaEscLea}</td>
                <td style='display:none;'>{$row['datGtiaLea']}</td>
                
                <td style='display:none;'>{$row['prodGtiaCart']}</td>
                <td style='display:none;'>{$row['nroGtiaCart']}</td>
                <td style='display:none;'>{$fecVtoGtiaCart}</td>
                <td style='display:none;'>{$fechaEscCart}</td>
                <td style='display:none;'>{$fechaInscCart}</td>
                <td style='display:none;'>{$row['datCart']}</td>

                <td class='text-center' title='Ir a la modificación de garantia'>
                    <button class='btn btn-sm btn-outline-warning'> 
                        <img src='../../lib/img/EDIT.png' class='modificarGtia' name='{$row['id_garantia']}' width='18' height='18' > 
                    </button>
                </td>
                <td class='text-center' title='Ir a ver detalles de la garantia'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/SHOW.png' class='detallesGtia' name='{$row['id_garantia']}' width='18' height='18' > 
                    </button>
                </td>
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
    $log = new Log();
    $log->writeLine("[No se pudo ejecutar la consulta en la BD][Query: $query]");
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
}

echo $print;
