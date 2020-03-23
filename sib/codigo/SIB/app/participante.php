<?php

include_once 'conf/BDConexion.php';
include_once 'conf/Constants.php';
include_once 'conf/Log.php';

session_start();

$id = $_POST['id'];
$legajo = $_SESSION['legajo'];
$sql = "SELECT * FROM [chatsParticipante] WHERE legajo = '$legajo' AND idChat = $id";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
$html = '';
if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $html = $html . '<table id="participantes" class="table table-striped table-bordered" border="3" style="width: 100%">
                                <colgroup>
                                    <col style="width: 12%"/>
                                    <col style="width: 18%"/>
                                    <col style="width: 16%"/>
                                    <col style="width: 18%"/>
                                    <col style="width: 18%"/>
                                    <col style="width: 18%"/>
                                </colgroup>
                                <thead style="background-color:#024d85;color:white;">
                                    <tr>
                                        <th>Legajo</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        <th>Nuevo estado</th>
                                        <th>Nuevo estado</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>';
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $chats = "SELECT * FROM [chatsParticipante] WHERE idChat =$id AND estado != 'Creador'";
            $resultChats = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $chats);
            if ($resultChats) {
                $filas = sqlsrv_has_rows($resultChats);
                if ($filas) {
                    while ($row = sqlsrv_fetch_array($resultChats, SQLSRV_FETCH_ASSOC)) {
                        $html = $html . "<tr>
                    <td>{$row['legajo']}</td>
                    <td>{$row['nombre']}</td>    
                    <td>{$row['estado']}</td>
                    <td>
                    <form name='cualquiera' method='post' action='procesarCambiarEstado.php'>
                        <input type='hidden' id='chat' name='chat' value='" . $id . "'>
                        <input type='hidden' id='legajo' name='legajo' value='" . $row['legajo'] . "'>
                        <input type='hidden' id='espera' name='espera' value='Espera'>
                        <input type='submit' class='btn btn-primary' value='En espera'>
                        </form>
                    </td>
                    <td>
                    <form name='cualquiera' method='post' action='procesarCambiarEstado.php'>
                        <input type='hidden' id='chat' name='chat' value='" . $id . "'>
                        <input type='hidden' id='legajo' name='legajo' value='" . $row['legajo'] . "'>
                        <input type='hidden' id='sinLeer' name='sinLeer' value='Sin leer'>
                        <input type='submit' class='btn btn-danger' value='Informar'>
                        </form>
                    </td>
                    <td>
                    <form name='cualquiera' method='post' action='procesarBorrarParticipante.php'>
                        <input type='hidden' id='chat' name='chat' value='" . $id . "'>
                        <input type='hidden' id='legajo' name='legajo' value='" . $row['legajo'] . "'>
                        <button class='btn btn-sm btn-outline-info' type='submit'><img src='../lib/img/DELETE.png' width='18' height='18'></button> 
                        </form>
                    </td>
                    </tr>";
                    }
                }
            }
        }
        $html = $html . '</tbody>
                    </table>';
    }
    echo $html;
}
