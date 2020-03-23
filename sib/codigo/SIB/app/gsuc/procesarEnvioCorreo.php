<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';
include_once '../conf/ConstantsMailer.php';
include_once '../conf/class.phpmailer.php';

$resultado = $form = "";
if (isset($_POST['cbCorreos'])) {
    $origen = $_POST['origen'];
    $reporte = $_POST['reporte'];
    $correos = $_POST['cbCorreos'];
    $queryCorreo = "SELECT * FROM [3correoMensaje] WHERE reporte='{$reporte}' ";
    $resultCorreo = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCorreo);
    if ($resultCorreo) {
        if (sqlsrv_has_rows($resultCorreo)) {
            $row = sqlsrv_fetch_array($resultCorreo, SQLSRV_FETCH_ASSOC);
            $nombre = utf8_encode($row['nombre']);
            $asunto = utf8_encode($row['asunto']);
            $mensaje = utf8_encode($row['mensaje']);
            $cuerpo = "
                <!DOCTYPE html>
                <html>
                <body>
                    <table width='50%' border='0' style='font-family:Myriad Pro; font-size:14px'>
                        <thead>
                            <tr>
                                <th><img src='cid:mail_info'/></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr align='justify'>
                                <td style='text-align:justify; padding:13px;'> {$mensaje} </td>
                            </tr>
                            <tr> 
                                <td style='color:#666; font-size:9px; padding: 13px;'>Este mensaje fue originado automáticamente. Por favor, no responder al mismo </td>
                            </tr>
                            <tr> 
                                <td style='color:#666; padding: 13px;'>Banco de Santa Cruz S.A.</td> 
                            </tr>
                            <tr>
                                <td style ='text-align:center'> <img src='cid:mail_pie'/> </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style='padding: 13px; text-align:justify; font-size:10px;'>
                                    Por favor no responda este e-mail. NOTA DE RESPONSABILIDAD: El contenido del presente mensaje es privado, estrictamente confidencial y exclusivo para su destinatario. 
                                    Este mensaje puede contener información protegida por normas legales y/o de secreto profesional y es solo para su destinatario. El emisor no asume responsabilidad ni 
                                    obligación legal alguna por cualquier información incorrecta o alterada contenida en este mensaje. Si usted no es el destinatario de este mensaje, por favor elimínelo, 
                                    no lo copie ni lo haga conocer a terceros e informe al emisor. Usted tiene el derecho de acceso a sus datos personales gratuitamente a intervalos no inferiores a seis 
                                    meses, salvo lo establecido en Ley 25.326, art. 14 inc. 3. La DIRECCION NACIONAL DE PROTECCION DE DATOS PERSONALES, tiene la atribución de atender las denuncias y reclamos. 
                                    El titular del dato podrá en cualquier momento solicitar el retiro o bloqueo de su nombre de los bancos de datos a los que se refiere el presente artículo (Art.27, inc.3 Ley N° 25.326). 
                                    A pedido del interesado, se deberá informar el nombre del responsable o usuario del banco de datos que proveyó la información (Párrafo tercero del art. 27 del Anexo I 
                                    del Decreto N° 1558/01 de Protección de Datos Personales).
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </body>
            </html>";
            $total = count($correos);
            $enviados = 0;
            foreach ($correos as $correo) {
                $mail = new phpmailer ();
                $mail->Mailer = "smtp";
                $mail->SMTPAuth = false;
                $mail->IsHTML(true);
                $mail->Host = HOST_MAIL;
                $mail->Username = USER_MAIL;
                $mail->Password = PASS_MAIL;
                $mail->Port = PORT_MAIL;
                $mail->From = USER_MAIL;
                $mail->FromName = $nombre;
                $mail->AddAddress($correo);
                $mail->AddEmbeddedImage(IMAG_MAIL . 'mail_info.png', 'mail_info');
                $mail->AddEmbeddedImage(IMAG_MAIL . 'mail_pie.png', 'mail_pie');
                $mail->Subject = $asunto;
                $mail->Body = $cuerpo;
                $mail->AltBody = $cuerpo;
                if ($mail->Send()) {
                    $enviados++;
                }
                unset($mail);
            }
            $resultado = '<div class="alert alert-success text-center" role="alert">Total de correos electronicos enviados correctamente: ' . $enviados . ' de ' . $total . '</div>';
            $form = '<div class="col">
                    <div class="text-center">
                        <a href="' . $origen . '"><button class="btn btn-dark">Volver</button></a>
                    </div>
                </div>';
        } else {
            $resultado = '<div class="alert alert-danger text-center" role="alert">No se obtuvo un mensaje predeterminado para el reporte (' . $reporte . ')</div>';
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de mensaje para correos electronicos del reporte][QUERY: $queryCorreo]");
        $resultado = '<div class="alert alert-danger text-center" role="alert">Error al realizar la consulta de mensaje para el reporte</div>';
    }
} else {
    $resultado = '<div class="alert alert-danger text-center" role="alert">No se recibieron los correos electronicos seleccionados</div>';
}
/* AGREGA LA CABECERA CON EL MENU */

require_once './header.php';
?>
<div class="container">
    <div class="card-header">
        <div class="center">
            <h3 class="text-center"><u>Envío de correos electrónicos</u></h3>
        </div>
        <div class="mb-4 mt-4" id="resultado"><?= $resultado; ?></div>
        <div class="mb-4 mt-4">
            <?= $form ?>
        </div>
    </div>
</div>

