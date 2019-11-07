<?php  

header('Content-Type: text/html; charset=ISO-8859-1'); 
include_once '../../lib/conf/ControlAcceso.php'; 
include_once '../../lib/conf/PermisosSistema.php';   
echo "<head>";
echo "<title>TEMPUS</title>";
echo "<meta http-equiv='Content-type' content='text/html; charset=iso-8859-1'/>";
echo "<link href='../../css/EstiloPrincipal.css' type='text/css' rel='stylesheet'/>";
echo "<link rel='stylesheet' type='text/css' href='../../css/datatables.min.css'/>";
echo "<link rel='stylesheet' type='text/css' href='../../css/responsivo.css'/>";
echo "<link rel='stylesheet' type='text/css' href='../../js/Buttons-1.4.2/css/buttons.dataTables.min.css'/>";
echo "<link rel='stylesheet' type='text/css' href='../../js/jquery-confirm-master/css/jquery-confirm.css'/>";
echo "<script type='text/javascript' src='../../js/jquery-3.2.1.min.js'></script>";
echo "<script type='text/javascript' src='../../js/datatables.min.js'></script>";
echo "<script type='text/javascript' src='../../js/Buttons-1.4.2/js/buttons.html5.min.js'></script>";
echo "<script type='text/javascript' src='../../js/Buttons-1.4.2/js/dataTables.buttons.min.js'></script>";
echo "<script type='text/javascript' src='../../js/pdfmake-0.1.32/pdfmake.min.js'></script>";
echo "<script type='text/javascript' src='../../js/pdfmake-0.1.32/vfs_fonts.js'></script>";
echo "</head>";
echo "<body>";
    echo "<header id='main-header'>";
    echo "<a id='logo-header' href=''>";
    echo "<span class='site-name'>TEMPUS</span>";
    echo "<span class='site-desc'>SIT UNPA-UARG</span>";
    echo "</a>";   
    echo "</header>";
    echo "<nav>";
    echo "<ul class='ul'>";
    echo "<li><a href='../estructura/home.php'>Home</a></li>";
    
    if (ControlAcceso::verificaPermiso(PermisosSistema::CURSADAS)) {
      echo "<li class='dropdown'>";
      echo "<a class='dropbtn'>Cursada</a>";
        echo "<div class='dropdown-content'>";
        echo "<a href='../cursadas/cursada_buscar.php'>Buscar</a>";
        echo "<a href='../cursadas/cursada_crear.php'>Crear</a>";
        echo "<a href='../cursadas/cursada_seleccionar.php'>Importar</a>";
        echo "<a href='../cursadas/cursada_informe.php'>Informe</a>";
        echo "</div>";
      echo "</li>";
    } 
              
    if (ControlAcceso::verificaPermiso(PermisosSistema::MESAS)) {
      echo "<li class='dropdown'>";
      echo "<a class='dropbtn'>Mesas de examen</a>";
      echo "<div class='dropdown-content'>";
      echo "<a href='../mesas/mesa_asignar.php'>Asignar aulas</a>";
      echo "<a href='../mesas/mesa_buscar.php'>Buscar</a>";
      echo "<a href='../mesas/mesa_crear.php'>Crear</a>";
      echo "<a href='../mesas/mesa_seleccionar.php'>Importar</a>";
      echo "<a href='../mesas/mesa_informe.php'>Informe</a>";
      echo "</div>";
      echo "</li>";
    }
              
    if (ControlAcceso::verificaPermiso(PermisosSistema::AULAS)) {
      echo "<li class='dropdown'>";
      echo "<a class='dropbtn'>Aulas</a>";
      echo "<div class='dropdown-content'>";
      echo "<a href='../aulas/aula_buscar.php'>Buscar</a>";
      echo "</div>";
      echo "</li>";
    }
    
    if (ControlAcceso::verificaPermiso(PermisosSistema::PERMISO_USUARIOS)) {
        echo "<li class='dropdown'>";
        echo "<a class='dropbtn'>Usuarios</a>";
        echo "<div class='dropdown-content'>";
        echo "<a href=''>Borrar / Modificar</a>";
        echo "</div>";
        echo "</li>";
    }
    echo "<li class='dropdown'>";
    echo "<a class='dropbtn'>Ayuda</a>";
    echo "<div class='dropdown-content'>";
    echo "<a href=''>Manual de usuario</a>";
    echo "<a href=''>Archivo para mesas de examen</a>";
    echo "<a href=''>Archivo para horarios de cursada</a>";
    echo "</div>";
    echo "</li>";
    echo "</ul>";
    echo "</nav>";
?>