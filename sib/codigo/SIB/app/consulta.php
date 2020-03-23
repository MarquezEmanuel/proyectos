<?php

include_once 'conf/BDConexion.php';
include_once 'conf/Constants.php';
include_once 'conf/Log.php';

session_start();

$legajo = $_SESSION['legajo'];
$sql = "SELECT * FROM [chatsParticipante] WHERE legajo = '$legajo' AND estado = 'Sin leer'";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
$html = '';
if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $html = $html . '<table class="table table-striped table-bordered" id="msjModal" border="3" style="width: 100%">
                        <thead style="background-color:#024d85;color:white;">
                            <tr>
                                <th>Creador</th>
                                <th>Titulo</th>
                                <th>ir</th>
                            </tr>
                        </thead>
                        <tbody>';
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $id = $row['idChat'];
            $chats = "SELECT * FROM [chats] WHERE id = $id";
            $resultChats = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $chats);
            if ($resultChats) {
                $filas = sqlsrv_has_rows($resultChats);
                if ($filas) {
                    while ($row = sqlsrv_fetch_array($resultChats, SQLSRV_FETCH_ASSOC)) {
                        $html = $html . "<tr>
                        <td>{$row['nombre']}</td>
                        <td>{$row['tema']}</td>
                        <input type='hidden' id='chat' name='chat' value='$id'>
                        <td><input type =submit class ='btn btn-sm btn-danger' value = tratar></td>
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
