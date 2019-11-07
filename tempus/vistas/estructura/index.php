<?php 

    header('Content-Type: text/html; charset=ISO-8859-1');

    if (isset($_POST['email'])) {
        
        include_once '../../lib/conf/ControlAcceso.php';
        
    } else {
        ?>
        	<html>
        		<head>
            		<meta name="google-signin-client_id" content="356408280239-7airslbg59lt2nped9l4dtqm2rf25aii.apps.googleusercontent.com" />
            		<link href="../../css/EstiloPrincipal.css" type="text/css" rel="stylesheet"/>
            		<script type="text/javascript" src="https://apis.google.com/js/platform.js" async defer></script>
                	<script type="text/javascript" src="../../js/jquery-3.2.1.min.js"></script>
                	<script type="text/javascript" src="../../js/login.js"></script>
        		</head>
            	<header id="main-header">
        			<a id="logo-header" href="">
                        <span class="site-name">TEMPUS</span>
                        <span class="site-desc">SIT UNPA-UARG</span>
                    </a>
        		</header>
            	<section id="main-content">
            		<article>
            			<div class="content">
            				<h2>SISTEMA TEMPUS</h2>
            				<fieldset>
            					<legend>Estimado usuario</legend>
            					
            					 <p>Bienvenido a la aplicación Tempus, a través de la cual podrá importar y consultar horarios de cursada y mesas de examen.</p>
                                 
                                 <h6>Ingreso al Sistema</h6>
                                 <p>Usted puede consultar el sistema si está conectado a su e-mail Institucional. Por favor haga click en el botón a continuación y elija su cuenta institucional.</p>
                                 
                                 
                                <div id="okgoogle" class="g-signin2" data-onsuccess="onSignIn" title="Acceder al Sistema Tempus"></div>
                                 
            				</fieldset>
            			</div>
            		</article>
            	</section>
            	
            	<?php include_once 'pie.php'; ?>
            	
        	</html>
        	
        <?php 
    }
    
?>