<?php
    header('Content-Type: text/html; charset=ISO-8859-1');
    
    include_once '../../lib/conf/Utilidades.php';
    include_once '../../lib/conf/Constantes.php';
    
    /* Controla que solo se acceda de la pagina donde se importa el archivo */
    $ubicacion = $_SERVER["PHP_SELF"];
    if($ubicacion != '/tempus/vistas/cursadas/cursada_importar.php') {
        header("Location: " . Constantes::HOMEURL);
    }
    
    include_once '../../modelos/carreras/Plan.php';
    include_once '../../modelos/cursadas/Cursada.php';
    include_once '../../modelos/cursadas/Clase.php';
    include_once '../../modelos/aulas/Aula.php';
?>
<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<script type="text/javascript" src="../../js/cursadas/cursada_importar.js"></script>
	<section id="main-content">
		<article>
			<div class="content">
            	<h2>IMPORTAR HORARIOS DE CURSADA</h2>
            	<form action="../../Controladores/ManejadorCursada.php" id="formCargarCursadas" name="formCargarCursadas" method="post" enctype="multipart/form-data">
                
                <?php 
                    $tamanio = $_FILES['fileCursadas']['size'];
                    $nombre = $_FILES['fileCursadas']['name'];
                    $nombre_temporal = $_FILES['fileCursadas']['tmp_name'];
                    $mensaje = null;
                    
                    if ($tamanio > 0) {
                        /* El archivo contiene información. Se abre. */
                        $cursadas = fopen($nombre_temporal,"r");
                        if ($cursadas) {
                            /* Se pudo abrir el archivo. Evalua las columnas */
                            $fila = fgetcsv($cursadas, 2000, ";");
                            $columnas = count($fila);
                            if ($columnas != 28) {
                                $mensaje = "El archivo seleccionado tiene una cantidad de columnas inválidas (".$columnas." columnas).";
                            }
                        } else {
                            $mensaje = "El archivo seleccionado no se pudo abrir.";
                        }
                    } else {
                        $mensaje = "El archivo seleccionado está vacío.";
                    }
                    
                    if ($mensaje) {
                        /* El archivo no ha pasado las validaciones. Se muestra el mensaje. */
                        echo "<fieldset>";
                        echo "<legend>".$nombre."</legend>";
                        echo "<h4>".$mensaje."</h4>";
                        echo "</fieldset>";
                    } else {
                        /* Regresa a la primer fila luego de leer para saber la cantidad de columnas */
                        rewind($cursadas);
                        /* El archivo ha pasado las validaciones. Se puede cargar la tabla. */
                    ?>
                		<fieldset>
                    		<legend><?= $nombre ?></legend>
                        	<table id="tablaImportarCursadas" class="display">
                        		<thead>
                        			<tr>
                        				<th>Código</th>
                        				<th>Carrera</th>
                        				<th>Asignatura</th>
                        				<th>Año</th>
                        				<th>Lunes</th>
                        				<th>Martes</th>
                        				<th>Miercoles</th>
                        				<th>Jueves</th>
                        				<th>Viernes</th>
                        				<th>Sábado</th>
                        			</tr>
                        		</thead>
                        		<tbody>
                        		<?php
                        		    /* $sesioncursadas = array que se almacena en la sesion */
                        		    $sesioncursadas = array();
                        		    $estilo = " style='background-color: #c50000; color: white;' ";
                        		    while (($fila = fgetcsv($cursadas, 2000, ";")) !== FALSE) {
                        		        /* Para saber si agregar la fila al array en sesion */
                        		        $agregar = TRUE;
                        		        
                        		        $codigo = (int) $fila[0];
                        		        $carrera = (string) $fila[1];
                        		        $asignatura = (string) $fila[2];
                        		        $anio = (int) $fila[3];
                        		        
                        		        /* Informacion de 1 = Lunes */
                        		        $desde1 = (string) $fila[4];
                        		        $hasta1 = (string) $fila[5];
                        		        $sector1 = (string) $fila[6];
                        		        $aula1 = (string) $fila[7];
                        		        
                        		        /* Informacion de 2 = Martes */
                        		        $desde2 = (string) $fila[8];
                        		        $hasta2 = (string) $fila[9];
                        		        $sector2 = (string) $fila[10];
                        		        $aula2 = (string) $fila[11];
                        		        
                        		        /* Informacion de 3 = Miercoles */
                        		        $desde3 = (string) $fila[12];
                        		        $hasta3 = (string) $fila[13];
                        		        $sector3 = (string) $fila[14];
                        		        $aula3 = (string) $fila[15];
                        		        
                        		        /* Informacion de 4 = Jueves */
                        		        $desde4 = (string) $fila[16];
                        		        $hasta4 = (string) $fila[17];
                        		        $sector4 = (string) $fila[18];
                        		        $aula4 = (string) $fila[19];
                        		        
                        		        /* Informacion de 5 = Viernes */
                        		        $desde5 = (string) $fila[20];
                        		        $hasta5 = (string) $fila[21];
                        		        $sector5 = (string) $fila[22];
                        		        $aula5 = (string) $fila[23];
                        		        
                        		        /* Informacion de 6 = Sabado */
                        		        $desde6 = (string) $fila[24];
                        		        $hasta6 = (string) $fila[25];
                        		        $sector6 = (string) $fila[26];
                        		        $aula6 = (string) $fila[27];
                        		        
                        		        
                        		        $mensaje = Utilidades::cursadasDuplicadas($sesioncursadas, $asignatura, $codigo);
                        		        if ($mensaje) {
                        		            $mensaje = $estilo." title='{$mensaje}'";
                        		            $agregar = FALSE;
                        		        }
                        		        echo "<tr {$mensaje}>";
                        		        
                        		        $mensaje = Utilidades::formatoCodigoCarrera($codigo);
                        		        if($codigo == 0) {
                        		            $mensaje = $estilo." title='{$mensaje}'";
                        		            $codigo = $fila[0];
                        		            $agregar = FALSE;
                        		        }
                        		        echo "<td ".$mensaje.">$codigo</td>";
                        		        
                        		        $mensaje = Utilidades::formatoNombreCarrera($carrera);
                        		        if ($mensaje) {
                        		            $mensaje = $estilo." title='{$mensaje}'";
                        		            $agregar = FALSE;
                        		        }
                        		        echo "<td ".$mensaje.">$carrera</td>";
                        		        
                        		        $mensaje = Utilidades::formatoNombreAsignatura($asignatura);
                        		        if($mensaje) {
                        		            $mensaje = $estilo." title='{$mensaje}'";
                        		            $agregar = FALSE;
                        		        }
                        		        echo "<td ".$mensaje.">$asignatura</td>";
                        		        
                        		        echo "<td>$anio</td>";
                        		        
                        		        $lunes = "";
                        		        $mensaje = "";
                        		        if ($desde1 && $hasta1 && $sector1 && $aula1) {
                        		            $lunes = $desde1." a ".$hasta1." en ".$sector1." - ".$aula1;
                        		            
                        		            $mensaje = Utilidades::formatoHora($desde1);
                        		            if ($mensaje) {
                        		                $mensaje = $estilo." title='{$mensaje}'";
                        		                $agregar = FALSE;
                        		            } else {
                        		                $mensaje = Utilidades::formatoHora($hasta1);
                        		                if ($mensaje) {
                        		                    $mensaje = $estilo." title='{$mensaje}'";
                        		                    $agregar = FALSE;
                        		                } else {
                        		                    $mensaje = Utilidades::formatoSector($sector1);
                        		                    if ($mensaje) {
                        		                        $mensaje = $estilo." title='{$mensaje}'";
                        		                        $agregar = FALSE;
                        		                    } else {
                        		                        $mensaje = Utilidades::formatoNombreAula($aula1);
                        		                        if ($mensaje) {
                        		                            $mensaje = $estilo." title='{$mensaje}'";
                        		                            $agregar = FALSE;
                        		                        }
                        		                    }
                        		                }
                        		            }
                        		        } 
                        		        echo "<td ".$mensaje.">".$lunes."</td>";
                        		        
                        		        $martes = "";
                        		        $mensaje = "";
                        		        if ($desde2 && $hasta2 && $sector2 && $aula2) {
                        		            $martes = $desde2." a ".$hasta2." en ".$sector2." - ".$aula2;
                        		            
                        		            $mensaje = Utilidades::formatoHora($desde2);
                        		            if ($mensaje) {
                        		                $mensaje = $estilo." title='{$mensaje}'";
                        		                $agregar = FALSE;
                        		            } else {
                        		                $mensaje = Utilidades::formatoHora($hasta2);
                        		                if ($mensaje) {
                        		                    $mensaje = $estilo." title='{$mensaje}'";
                        		                    $agregar = FALSE;
                        		                } else {
                        		                    $mensaje = Utilidades::formatoSector($sector2);
                        		                    if ($mensaje) {
                        		                        $mensaje = $estilo." title='{$mensaje}'";
                        		                        $agregar = FALSE;
                        		                    } else {
                        		                        $mensaje = Utilidades::formatoNombreAula($aula2);
                        		                        if ($mensaje) {
                        		                            $mensaje = $estilo." title='{$mensaje}'";
                        		                            $agregar = FALSE;
                        		                        }
                        		                    }
                        		                }
                        		            }
                        		        }
                        		        echo "<td ".$mensaje.">".$martes."</td>";
                        		        
                        		        $miercoles = "";
                        		        $mensaje = "";
                        		        if ($desde3 && $hasta3 && $sector3 && $aula3) {
                        		            $miercoles = $desde3." a ".$hasta3." en ".$sector3." - ".$aula3;
                        		            
                        		            $mensaje = Utilidades::formatoHora($desde3);
                        		            if ($mensaje) {
                        		                $mensaje = $estilo." title='{$mensaje}'";
                        		                $agregar = FALSE;
                        		            } else {
                        		                $mensaje = Utilidades::formatoHora($hasta3);
                        		                if ($mensaje) {
                        		                    $mensaje = $estilo." title='{$mensaje}'";
                        		                    $agregar = FALSE;
                        		                } else {
                        		                    $mensaje = Utilidades::formatoSector($sector3);
                        		                    if ($mensaje) {
                        		                        $mensaje = $estilo." title='{$mensaje}'";
                        		                        $agregar = FALSE;
                        		                    } else {
                        		                        $mensaje = Utilidades::formatoNombreAula($aula3);
                        		                        if ($mensaje) {
                        		                            $mensaje = $estilo." title='{$mensaje}'";
                        		                            $agregar = FALSE;
                        		                        }
                        		                    }
                        		                }
                        		            }
                        		        } 
                        		        echo "<td ".$mensaje.">".$miercoles."</td>";
                        		        
                        		        $jueves = "";
                        		        $mensaje = "";
                        		        if ($desde4 && $hasta4 && $sector4 && $aula4) {
                        		            $jueves = $desde4." a ".$hasta4." en ".$sector4." - ".$aula4;
                        		            
                        		            $mensaje = Utilidades::formatoHora($desde4);
                        		            if ($mensaje) {
                        		                $mensaje = $estilo." title='{$mensaje}'";
                        		                $agregar = FALSE;
                        		            } else {
                        		                $mensaje = Utilidades::formatoHora($hasta4);
                        		                if ($mensaje) {
                        		                    $mensaje = $estilo." title='{$mensaje}'";
                        		                    $agregar = FALSE;
                        		                } else {
                        		                    $mensaje = Utilidades::formatoSector($sector4);
                        		                    if ($mensaje) {
                        		                        $mensaje = $estilo." title='{$mensaje}'";
                        		                        $agregar = FALSE;
                        		                    } else {
                        		                        $mensaje = Utilidades::formatoNombreAula($aula4);
                        		                        if ($mensaje) {
                        		                            $mensaje = $estilo." title='{$mensaje}'";
                        		                            $agregar = FALSE;
                        		                        }
                        		                    }
                        		                }
                        		            }
                        		        }
                        		        echo "<td ".$mensaje.">".$jueves."</td>";
                        		        
                        		        $viernes = "";
                        		        $mensaje = "";
                        		        if ($desde5 && $hasta5 && $sector5 && $aula5) {
                        		            $viernes = $desde5." a ".$hasta5." en ".$sector5." - ".$aula5;
                        		            
                        		            $mensaje = Utilidades::formatoHora($desde5);
                        		            if ($mensaje) {
                        		                $mensaje = $estilo." title='{$mensaje}'";
                        		                $agregar = FALSE;
                        		            } else {
                        		                $mensaje = Utilidades::formatoHora($hasta5);
                        		                if ($mensaje) {
                        		                    $mensaje = $estilo." title='{$mensaje}'";
                        		                    $agregar = FALSE;
                        		                } else {
                        		                    $mensaje = Utilidades::formatoSector($sector5);
                        		                    if ($mensaje) {
                        		                        $mensaje = $estilo." title='{$mensaje}'";
                        		                        $agregar = FALSE;
                        		                    } else {
                        		                        $mensaje = Utilidades::formatoNombreAula($aula5);
                        		                        if ($mensaje) {
                        		                            $mensaje = $estilo." title='{$mensaje}'";
                        		                            $agregar = FALSE;
                        		                        }
                        		                    }
                        		                }
                        		            }
                        		        }
                        		        echo "<td ".$mensaje.">".$viernes."</td>";
                        		        
                        		        $sabado = "";
                        		        $mensaje = "";
                        		        if ($desde6 && $hasta6 && $sector6 && $aula6) {
                        		            $lunes = $desde6." a ".$hasta6." en ".$sector6." - ".$aula6;
                        		            
                        		            $mensaje = Utilidades::formatoHora($desde6);
                        		            if ($mensaje) {
                        		                $mensaje = $estilo." title='{$mensaje}'";
                        		                $agregar = FALSE;
                        		            } else {
                        		                $mensaje = Utilidades::formatoHora($hasta6);
                        		                if ($mensaje) {
                        		                    $mensaje = $estilo." title='{$mensaje}'";
                        		                    $agregar = FALSE;
                        		                } else {
                        		                    $mensaje = Utilidades::formatoSector($sector6);
                        		                    if ($mensaje) {
                        		                        $mensaje = $estilo." title='{$mensaje}'";
                        		                        $agregar = FALSE;
                        		                    } else {
                        		                        $mensaje = Utilidades::formatoNombreAula($aula6);
                        		                        if ($mensaje) {
                        		                            $mensaje = $estilo." title='{$mensaje}'";
                        		                            $agregar = FALSE;
                        		                        }
                        		                    }
                        		                }
                        		            }
                        		        }
                        		        echo "<td ".$mensaje.">".$sabado."</td>";
                        		        
                        		        echo "</tr>";
                        		        
                        		        if ($agregar) {
                        		            
                        		            $Carrera = new Carrera();
                        		            $Carrera->setCodigo($codigo);
                        		            $carrera = Utilidades::convertirCamelCase($carrera);
                        		            $Carrera->setNombre($carrera);
                        		            
                        		            $Asignatura = new Asignatura();
                        		            $asignatura = Utilidades::convertirCamelCase($asignatura);
                        		            $Asignatura->setNombre($asignatura);
                        		            
                        		            $Plan = new Plan();
                        		            $Plan->setCarrera($Carrera);
                        		            $Plan->setAsignatura($Asignatura);
                        		            $Plan->setAnio($anio);
                        		            
                        		            $Cursada = new Cursada();
                        		            $Cursada->setPlan($Plan);
                        		            
                        		            $clases = array();
                        		            
                        		            if ($lunes) {
                        		                $Clase = new Clase();
                        		                $Clase->setDia(1);
                        		                $Clase->setDesde($desde1);
                        		                $Clase->setHasta($hasta1);
                        		                
                        		                $Aula = new Aula();
                        		                $Aula->setSector($sector1);
                        		                $Aula->setNombre($aula1);
                        		                
                        		                $Clase->setAula($Aula);
                        		                $clases[] = $Clase;
                        		            }
                        		            
                        		            if ($martes) {
                        		                $Clase = new Clase();
                        		                $Clase->setDia(2);
                        		                $Clase->setDesde($desde2);
                        		                $Clase->setHasta($hasta2);
                        		                
                        		                $Aula = new Aula();
                        		                $Aula->setSector($sector2);
                        		                $Aula->setNombre($aula2);
                        		                
                        		                $Clase->setAula($Aula);
                        		                $clases[] = $Clase;
                        		            }
                        		            
                        		            if ($miercoles) {
                        		                $Clase = new Clase();
                        		                $Clase->setDia(3);
                        		                $Clase->setDesde($desde3);
                        		                $Clase->setHasta($hasta3);
                        		                
                        		                $Aula = new Aula();
                        		                $Aula->setSector($sector3);
                        		                $Aula->setNombre($aula3);
                        		                
                        		                $Clase->setAula($Aula);
                        		                $clases[] = $Clase;
                        		            }
                        		            
                        		            if ($jueves) {
                        		                $Clase = new Clase();
                        		                $Clase->setDia(4);
                        		                $Clase->setDesde($desde4);
                        		                $Clase->setHasta($hasta4);
                        		                
                        		                $Aula = new Aula();
                        		                $Aula->setSector($sector4);
                        		                $Aula->setNombre($aula4);
                        		                
                        		                $Clase->setAula($Aula);
                        		                $clases[] = $Clase;
                        		            }
                        		            
                        		            if ($viernes) {
                        		                $Clase = new Clase();
                        		                $Clase->setDia(5);
                        		                $Clase->setDesde($desde5);
                        		                $Clase->setHasta($hasta5);
                        		                
                        		                $Aula = new Aula();
                        		                $Aula->setSector($sector5);
                        		                $Aula->setNombre($aula5);
                        		                
                        		                $Clase->setAula($Aula);
                        		                $clases[] = $Clase;
                        		            }
                        		            
                        		            if ($sabado) {
                        		                $Clase = new Clase();
                        		                $Clase->setDia(6);
                        		                $Clase->setDesde($desde6);
                        		                $Clase->setHasta($hasta6);
                        		                
                        		                $Aula = new Aula();
                        		                $Aula->setSector($sector6);
                        		                $Aula->setNombre($aula6);
                        		                
                        		                $Clase->setAula($Aula);
                        		                $clases[] = $Clase;
                        		            }
                        		            if ($clases) {
                        		              $Cursada->setClases($clases);
                        		              $sesioncursadas [] = $Cursada;
                        		            }
                        		        } /* Fin del if (agregar) */
                        		    }
                        		    $_SESSION['cursadas'] = $sesioncursadas;
                        		?>
                        		</tbody>
                        	</table>  
                        </fieldset>    
                        
                        <?php if (count($sesioncursadas) > 0) { ?>  
                		    <input type="hidden" id="accion" name="accion" value="importar">
                			<input class="botonVerde" type="submit" id="btnCargarCursadas" name="btnCargarCursadas" value="Cargar">
                		<?php }
                    }
                ?>
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>
