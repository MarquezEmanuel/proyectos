<?php
    require_once '../modelos/cursadas/Cursada.php';
    require_once '../modelos/cursadas/Clase.php';
    require_once '../modelos/carreras/Plan.php';
    require_once '../modelos/aulas/Aula.php';
    require_once '../lib/conf/ObjetoDatos.php';

    echo "<H1>TEST_COMMIT</H1>";
    
    
    ObjetoDatos::getInstancia()->autocommit(false);
    
    
    /*
        ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM mesa_examen WHERE 1");
        $mesas = ObjetoDatos::getInstancia()->affected_rows;
        ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM llamado WHERE 1");
        $llamado = ObjetoDatos::getInstancia()->affected_rows;
        ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM tribunal WHERE 1");
        $tribunal = ObjetoDatos::getInstancia()->affected_rows;
        ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM docente WHERE 1");
        $docente = ObjetoDatos::getInstancia()->affected_rows;
        
        if (($mesas > 0) && ($llamado > 0) && ($tribunal > 0) && ($docente > 0)) {
            echo "Se han ejecutado. Se puede hacer commit.";
            ObjetoDatos::getInstancia()->commit(true);
        } else {
            echo "No se han ejecutado. No se puede hacer commit.";
        }
        
        
        ObjetoDatos::getInstancia()->autocommit(true);
    
   */
    
    
    
    
   
    