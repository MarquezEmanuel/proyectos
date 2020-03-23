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
        $html = $html . '<table class="table table-striped table-bordered" id="mensaje" border="3" style="width: 100%" style="margin-top: 0px; margin-bottom: 0px; height: 340px;">
                        <colgroup>
                            <col style="width: 20%"/>
                            <col style="width: 80%"/>
                        </colgroup>
                        <thead style="background-color:#024d85;color:white;">
                            <tr>
                                <th>Usuario</th>
                                <th>Mensaje</th>
                            </tr>
                        </thead>
                        <tbody>';
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $chats = "SELECT * FROM [chatsMensaje] WHERE idChat = $id ORDER BY id ASC";
            $resultChats = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $chats);
            $html = $html . "<input type='hidden' id='chat' name='chat' value='$id'>
                        <input type='hidden' id='envia' name='envia' value='$legajo'>";
            if ($resultChats) {
                $filas = sqlsrv_has_rows($resultChats);
                if ($filas) {
                    while ($row = sqlsrv_fetch_array($resultChats, SQLSRV_FETCH_ASSOC)) {
                        $html = $html . "
                        <tr>
                        <td>{$row['nombre']}</td>
                        <td>{$row['mensaje']}</td>  
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
