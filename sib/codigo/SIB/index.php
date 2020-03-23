<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>SIB - Inicio</title>
    <link rel="icon" href="../../lib/img/estrella.jpg" type="image/gif" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="lib/css/estilos.css" />
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap/bootstrap.css" />
    <script type="text/javascript" charset="utf8" src="lib/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="lib/js/bootstrap/bootstrap.min.js"></script>
</head>

<body id="body">
    <div class="form-row align-items-center mx-auto">
        <div class="col-lg-12 text-center p-2">
        </div>
    </div>
    <div id="login" class="container">
        <div>
            <form action="app/procesarLogin.php" method="POST">
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-12 text-center p-2">
                        <img class="mb-4 img-login" src="lib/img/086-negro80_logo.fw.png" alt="">
                        <h1 class="h3 mb-3 font-weight-normal text-blue">Sistema Integral Bancario
						<!--</h1>
						<br>
						<h1>DC=santacruz, DC=net   DOMINIO</h1>
						<!--<br>
						<h1>(|(objectCategory=*))   USERS</h1>
						<!--<br>
						<h1>(!(objectCategory=computer))   GROUPS</h1>-->
                    </div>
                </div>

                <div id="contenido2">
                    <?php
                    session_start();
                    if (isset($_SESSION['ingresa']) && $_SESSION['ingresa']) {
                        if (isset($_SESSION['mensajeLogin'])) {
                            echo $_SESSION['mensajeLogin'];
                            unset($_SESSION['mensajeLogin']);
                        }
                    }
                    ?>
                </div>
                <br>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Usuario:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" name="user" id="user" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Contraseña:</label>
                    <div class="col">
                        <input type="password" class="form-control mb-2" name="password" id="password" required="true">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-success p-2" value="Ingresar">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="text-right">
                            <p class="p-2">v2.0.0</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>