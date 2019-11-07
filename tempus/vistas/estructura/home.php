<?php

    include_once '../../lib/conf/ControlAcceso.php';
    include_once '../../lib/conf/PermisosSistema.php';
    include_once '../../modelos/usuarios/Usuario.php';
    include_once '../../modelos/usuarios/UsuarioGoogle.php';
    
    ControlAcceso::requierePermiso(PermisosSistema::PERMISO_AUTH);
?>

<html>
	<?php include_once 'encabezado.php'; ?>
	<section id="main-content">
		<article>
			<div class="content">
				<h2>¡LE DAMOS LA BIENVENIDA!</h2>
				<fieldset>
					
					<fieldset>
						<legend><img class="perfil" src="<?= $_SESSION['usuario']->getImagen(); ?>"><?= $_SESSION['usuario']->getEmail();?> :: <?= $_SESSION['usuario']->getNombre();?></legend>
						<?php
        					foreach ($_SESSION['usuario']->getRoles() as $rol) {
        					    echo "<p>Rol: ".$rol->getNombre()."</p>";
                            }
                        ?>
                        <p>
                        	Ha ingresado al sistema Tempus - Gestión de Horarios de Cursada y Mesas de Examen. Para comenzar 
                        	a trabajar debe posicionarse sobre el menú horizontal y seleccionar la opción deseada en el 
                        	sub-menú correspondiente.
                        </p>
                        <p>
                        	Para obtener información detallada sobre la utilización del sistema puede acudir al Manual de Usuario
                        	que se encuentra disponible a continuación.
                        </p>
					</fieldset>
					
				</fieldset>
			</div>
		</article>
	</section>
	<?php include_once 'pie.php'; ?>
</html>
