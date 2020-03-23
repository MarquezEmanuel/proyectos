

<html>
    <script type="text/javascript" charset="utf8" src="../../../lib/js/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function () {

            alert("dsds");

            inicio();

            function inicio() {
                var estado = "ESPERANDO APROBACION";
                $.ajax({
                    type: "POST",
                    url: "./datos.php",
                    data: "estado=" + estado,
                    success: function (data) {
                        $('#resultado').html(data);
                    },
                    error: function (data) {
                        console.log(data);
                        var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                        var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                        $("#resultado").html(div);
                    }
                });
            }

            $(".panel").click(function () {

                event.preventDefault();
                alert($(this).attr("name"));

                var estado = $(this).attr("name");

                $.ajax({
                    type: "POST",
                    url: "./datos.php",
                    data: "estado=" + estado,
                    success: function (data) {
                        $('#resultado').html(data);
                    },
                    error: function (data) {
                        console.log(data);
                        var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                        var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                        $("#resultado").html(div);
                    }
                });

            });

        });
    </script>
</html>
<?php
require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();

$consulta = "SELECT * FROM vw_panel";
$resultado = SQLServer::instancia()->seleccionar($consulta, array());


if (gettype($resultado)) {
    while ($panel = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
        echo "<input class=' text panel' name='{$panel['estado']}' value='{$panel['cantidad']}'>" . utf8_encode($panel['estado']) . "</div><br>";
    }
}

echo "<div id='panel'></div>";
echo "<div id='resultado'></div>";
echo "<div id='panel'></div>";
