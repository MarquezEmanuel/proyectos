<?php  
    header('Content-Type: text/html; charset=ISO-8859-1'); 
    include_once '../../lib/conf/Utilidades.php';
    include_once '../../lib/conf/Constantes.php';
      
?>
<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<script type="text/javascript" src="../../js/mesas/mesa_importar.js"></script>
	<section id="main-content">
		<article>
			<div class="content">
            	<h2>IMPORTAR MESAS DE EXAMEN</h2>
            	
            	<form action="../../Controladores/ManejadorMesa.php" id="formCargarMesas" name="formCargarMesas" method="post" enctype="multipart/form-data">
                	
                <?php 
                    $tamanio = $_FILES['fileMesas']['size'];
                    $nombre = $_FILES['fileMesas']['name'];
                    $nombre_temporal = $_FILES['fileMesas']['tmp_name'];
                    $mensaje = null;
                    
                    if ($tamanio > 0) {
                        /* El archivo contiene información. Se abre. */
                        $mesas = fopen($nombre_temporal,"r");
                        if ($mesas) {
                            /* Se pudo abrir el archivo. Evalua las columnas */
                            $fila = fgetcsv($mesas, 2000, ";");
                            $columnas = count($fila);
                            if (($columnas<9) || ($columnas > 10)) {
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
                        rewind($mesas);
                        /* El archivo ha pasado las validaciones. Se puede cargar la tabla. */    
                        ?>
                            <fieldset>
                    		  	<legend><?= $nombre ?></legend>
                    		  	<table id="tablaImportarMesas" class="display">
                    		  		<thead>
                                        <tr>
                                        	<th>Codigo</th>
                                            <th>Carrera</th>
                                            <th>Asignatura</th>
                                            <th>Presidente</th>
                                            <th>Vocal1</th>
                                            <th>Vocal2</th>
                                            <th>Suplente</th>
                                            <th>1er llamado</th>
                                       <?php
                                            if ($columnas == 10) {
                                                echo "<th>2do llamado</th>";
                                            }
                                       ?>
                                            <th>Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        /* $sesionmesas = array que se almacena en la sesion */
                                        $sesionmesas = array();
                                        $estilo = " style='background-color: #c50000; color: white;' ";
                                        if ($columnas == 10) {
                                            
                                            while (($fila = fgetcsv($mesas, 2000, ";")) !== FALSE) {
                                                /* Para saber si agregar la fila al array en sesion */
                                                $agregar = TRUE;
                                                
                                                /* Obtiene cada una de las columnas */
                                                $codigo = (int) $fila[0];
                                                $carrera = (string) $fila[1];
                                                $asignatura = (string) $fila[2];
                                                $presidente = (string) $fila[3];
                                                $vocal1 = (string) $fila[4];
                                                $vocal2 = (string) $fila[5];
                                                $suplente = (string) $fila[6];
                                                $primero = (string) $fila[7];
                                                $segundo = (string) $fila[8];
                                                $hora = (string) $fila[9];
                                                
                                                /* Se controla que no se dupliquen filas */
                                                $mensaje = Utilidades::mesasDuplicadas($sesionmesas, $asignatura, $codigo);
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
                                                
                                                $mensaje = "";
                                                if(!$presidente) {
                                                    /* El presidente es obligatorio */
                                                    $mensaje = $estilo." title='No se ha designado un presidente de tribunal'";
                                                    $agregar = FALSE;
                                                } else {
                                                    /* Se controla el formato del docente agregado */
                                                    $mensaje = Utilidades::formatoNombreDocente($presidente);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                }
                                                echo "<td ".$mensaje.">$presidente</td>";
                                                
                                                $mensaje = "";
                                                if(!$vocal1) {
                                                    /* El vocal 1 es obligatorio */
                                                    $mensaje = $estilo." title='No se ha designado un vocal primero de tribunal'";
                                                    $agregar = FALSE;
                                                } else {
                                                    /* Se controla el formato del docente agregado */
                                                    $mensaje = Utilidades::formatoNombreDocente($vocal1);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                }
                                                echo "<td ".$mensaje.">$vocal1</td>";
                                                
                                                $mensaje = "";
                                                if ($vocal2) {
                                                    /* Solo en caso que se agregue alguna cadena se verifica porque el vocal 2 no es obligatorio */
                                                    $mensaje = Utilidades::formatoNombreDocente($vocal2);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                    echo "<td ".$mensaje.">$vocal2</td>";
                                                    $mensaje = "";
                                                    if ($suplente) {
                                                        $mensaje = Utilidades::formatoNombreDocente($suplente);
                                                        if ($mensaje) {
                                                            $mensaje = $estilo." title='{$mensaje}'";
                                                            $agregar = FALSE;
                                                        }
                                                    }
                                                    echo "<td ".$mensaje.">$suplente</td>";
                                                } else {
                                                    /* Como no hay vocal suplente no deberia haber suplente */
                                                    echo "<td ".$mensaje.">$vocal2</td>";
                                                    $mensaje = "";
                                                    if ($suplente) {
                                                        $mensaje = $estilo." title='El suplente debe ocupar el lugar de vocal 2'";
                                                        $agregar = FALSE;
                                                    }
                                                    echo "<td ".$mensaje.">$suplente</td>";
                                                }
                                                
                                                if ($primero || $segundo) {
                                                    $mensaje = Utilidades::formatoFecha($primero);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                    echo "<td ".$mensaje.">$primero</td>";
                                                    
                                                    $mensaje = Utilidades::formatoFecha($segundo);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                    echo "<td ".$mensaje.">$segundo</td>";
                                                } else {
                                                    $mensaje = $estilo." title='Ambos llamados se han omitido'";
                                                    echo "<td ".$mensaje.">$primero</td>";
                                                    echo "<td ".$mensaje.">$segundo</td>";
                                                }
                                                
                                                $mensaje = Utilidades::formatoHora($hora);
                                                if($mensaje) {
                                                    $mensaje = $estilo." title='{$mensaje}'";
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$hora</td>";
                                                echo "</tr>";
                                                
                                                if($agregar) {
                                                    /* agrega la fila al array que se almacena en la sesion. */
                                                    if ($primero) {
                                                        $primero = str_replace('/', '-', $primero);
                                                        $primero = date('Y-m-d', strtotime($primero));
                                                    }
                                                    if ($segundo) {
                                                        $segundo = str_replace('/', '-', $segundo);
                                                        $segundo = date('Y-m-d', strtotime($segundo));
                                                    }
                                                    $carrera = Utilidades::convertirCamelCase($carrera);
                                                    $asignatura = Utilidades::convertirCamelCase($asignatura);
                                                    $presidente = Utilidades::convertirCamelCase($presidente);
                                                    $vocal1 = Utilidades::convertirCamelCase($vocal1);
                                                    $vocal2 = Utilidades::convertirCamelCase($vocal2);
                                                    $suplente = Utilidades::convertirCamelCase($suplente);
                                                    $sesionmesas [] = array($codigo, $carrera, $asignatura, $presidente, $vocal1, $vocal2, $suplente, $primero, $segundo, $hora);
                                                }
                                            }
                                            
                                        } else {
                                            while (($fila = fgetcsv($mesas, 2000, ";")) !== FALSE) {
                                                /* Para saber si agregar la fila al array en sesion */
                                                $agregar = TRUE;
                                                
                                                /* Obtiene cada una de las columnas */
                                                $codigo = (int) $fila[0];
                                                $carrera = (string) $fila[1];
                                                $asignatura = (string) $fila[2];
                                                $presidente = (string) $fila[3];
                                                $vocal1 = (string) $fila[4];
                                                $vocal2 = (string) $fila[5];
                                                $suplente = (string) $fila[6];
                                                $primero = (string) $fila[7];
                                                $hora = (string) $fila[8];
                                                
                                                /* Se controla que no se dupliquen filas */
                                                $mensaje = Utilidades::mesasDuplicadas($sesionmesas, $asignatura, $codigo);
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
                                                
                                                $mensaje = "";
                                                if(!$presidente) {
                                                    /* El presidente es obligatorio */
                                                    $mensaje = $estilo." title='No se ha designado un presidente de tribunal'";
                                                    $agregar = FALSE;
                                                } else {
                                                    /* Se controla el formato del docente agregado */
                                                    $mensaje = Utilidades::formatoNombreDocente($presidente);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                }
                                                echo "<td ".$mensaje.">$presidente</td>";
                                                
                                                $mensaje = "";
                                                if(!$vocal1) {
                                                    /* El vocal 1 es obligatorio */
                                                    $mensaje = $estilo." title='No se ha designado un vocal primero de tribunal'";
                                                    $agregar = FALSE;
                                                } else {
                                                    /* Se controla el formato del docente agregado */
                                                    $mensaje = Utilidades::formatoNombreDocente($vocal1);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                }
                                                echo "<td ".$mensaje.">$vocal1</td>";
                                                
                                                $mensaje = "";
                                                if ($vocal2) {
                                                    /* Solo en caso que se agregue alguna cadena se verifica porque el vocal 2 no es obligatorio */
                                                    $mensaje = Utilidades::formatoNombreDocente($vocal2);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                    echo "<td ".$mensaje.">$vocal2</td>";
                                                    $mensaje = "";
                                                    if ($suplente) {
                                                        $mensaje = Utilidades::formatoNombreDocente($suplente);
                                                        if ($mensaje) {
                                                            $mensaje = $estilo." title='{$mensaje}'";
                                                            $agregar = FALSE;
                                                        }
                                                    }
                                                    echo "<td ".$mensaje.">$suplente</td>";
                                                } else {
                                                    /* Como no hay vocal suplente no deberia haber suplente */
                                                    echo "<td ".$mensaje.">$vocal2</td>";
                                                    $mensaje = "";
                                                    if ($suplente) {
                                                        $mensaje = $estilo." title='El suplente debe ocupar el lugar de vocal 2'";
                                                        $agregar = FALSE;
                                                    }
                                                    echo "<td ".$mensaje.">$suplente</td>";
                                                }
                                                
                                                $mensaje = Utilidades::formatoFecha($primero);
                                                if ($mensaje) {
                                                    $mensaje = $estilo." title='{$mensaje}'";
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$primero</td>";
                                                
                                                $mensaje = Utilidades::formatoHora($hora);
                                                if($mensaje) {
                                                    $mensaje = $estilo." title='{$mensaje}'";
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$hora</td>";
                                                echo "</tr>";
                                                
                                                if($agregar) {
                                                    /* agrega la fila al array que se almacena en la sesion. */
                                                    $primero = str_replace('/', '-', $primero);
                                                    $primero = date('Y-m-d', strtotime($primero));
                                                    $carrera = Utilidades::convertirCamelCase($carrera);
                                                    $asignatura = Utilidades::convertirCamelCase($asignatura);
                                                    $presidente = Utilidades::convertirCamelCase($presidente);
                                                    $vocal1 = Utilidades::convertirCamelCase($vocal1);
                                                    $vocal2 = Utilidades::convertirCamelCase($vocal2);
                                                    $suplente = Utilidades::convertirCamelCase($suplente);
                                                    $sesionmesas [] = array($codigo, $carrera, $asignatura, $presidente, $vocal1, $vocal2, $suplente, $primero, $hora);
                                                }
                                            }
                                        }
                                            
                                        $_SESSION['mesas'] = $sesionmesas;
                                    ?>
                                    </tbody>
                    		  	</table>
                    		</fieldset>
                    		<?php
                    		  if (count($sesionmesas) > 0) {
                    		?>  
                    		      <input type="hidden" id="accion" name="accion" value="importar">
                    		      <input class="botonVerde" type="submit" id="btnCargarMesas" name="btnCargarMesas" value="Cargar">
                    		<?php 
                    		  }
                    }
                ?>            	
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>
