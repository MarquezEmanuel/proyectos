<?php

/**
 * Esta clase contiene metodos de utilidad para diferentes clases. Se puede
 * utilizar para validar cadenas de texto entre otras operaciones.
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Márquez Emanuel.
 * */
class Utilidades 
{
  
    /**
     * Verifica que una cadena cumpla con el formato de hora HH:MM. Para ello
     * controla la longitud de la cadena y el formato. Las cadenas vacías y 
     * nulas no cumplen con el formato.
     * @param string $hora Cadena con la hora.
     * @return string Devuelve un mensaje indicando un error o null si es correcto.
     * @author Márquez Emanuel.
     * @see ereg().
     * */
    static function formatoHora($hora)
    {
        if ($hora) {
            $longitud = strlen($hora);
            if ($longitud == 5 ) {
                $expresion = "^(1[0-9]|2[0-3]):[0-5][0-9]$";
                if(ereg($expresion, $hora)) {
                    return null;
                }
                return "La hora no cumple con el formato o rango";
            }
            return "La longitud de la hora debe ser de cinco caracteres (HH:MM)";
        }
        return "Se debe indicar un horario";
    }
    
    /**
     * Verifica que una cadena cumpla con el formato de fecha DD/MM/AAAA. Para 
     * ello controla la longitud de la cadena y el formato. Las cadenas vacías 
     * y nulas no cumplen con el formato.
     * @param string $fecha Cadena con la fecha.
     * @return string Null si es correcta, mensaje en caso contrario.
     * @author Márquez Emanuel.
     * @see DateTime.
     * */
    static function formatoFecha($fecha)
    {
        if ($fecha) {
            $longitud = strlen($fecha);
            if ($longitud == 10) {
                $date = DateTime::createFromFormat('d/m/Y',$fecha);
                if (($date !== false) && ($date) && ($date->format('d/m/Y')==$fecha)) {
                    return null;
                }
                return "La fecha no cumple con el formato";
            }
            return "La longitud de la fecha debe ser de 10 caracteres (DD/MM/AAAA)";
        }
        return null;
    }
    
    /**
     * Controla el formato del nombre de una asignatura. El nombre de asignatura
     * tiene un rango de 5 a 255 carácteres. Ademas, puede contener espacio en
     * blanco, letras con y sin acento, y números.
     * @param string $nombre Nombre de la asignatura.
     * @return string Null si es correcto, mensaje en caso contrario.
     * @author Márquez Emanuel.
     * */
    static function formatoNombreAsignatura($nombre)
    {
        if ($nombre) 
        {
            $longitud = strlen($nombre);
            if (($longitud > 4) && ($longitud < 256)) {
                
                if (!ctype_digit($nombre)) {
                    $expresion = "/^[A-Za-záéíóúÁÉÍÓÚñÑ0123456789,. ]{5,255}$/";
                    if(preg_match($expresion, $nombre))
                        return null;
                    return "El nombre de asignatura no cumple con el formato (Se aceptan letras, acentos, espacios, puntos y/o comas)";
                }
                return "El nombre de asignatura está completamente compuesto de números";
            }
            return "La longitud del nombre debe ser entre 5 y 255 caracteres";
        }
        return "Se debe indicar un nombre de asignatura";
    }
    
    /**
     * Controla el formato del código de una carrera. El código de carrera
     * tiene una longitud de 1 a 3 digitos. El mismo no puede ser nulo ni
     * vacío.
     * @var string $codigo Codigo de la carrera.
     * @return string Null si es correcto, mensaje en caso contrario.
     * @author Márquez Emanuel.
     * */
    static function formatoCodigoCarrera($codigo)
    {
        if ($codigo) {
            if ($codigo != 0) {
                $longitud = strlen($codigo);
                if (($longitud > 0) && ($longitud < 4)) {
                    $expresion = "/^[0-9]{1,3}$/";
                    if(preg_match($expresion, $codigo)) {
                        return null;
                    }
                    return "El código no cumple con el formato númerico";
                }
                return "La longitud del código debe ser de 1 a 3 digitos";
            }
            return "No se ha indicado un código de carrera o no es númerico";
        }
        return "Se debe indicar un código de carrera";
    }
    
    /**
     * Controla el formato del nombre de una carrera. El nombre de carrera
     * tiene un rango de 10 a 255 carácteres. Ademas, puede contener espacio en
     * blanco y letras con y sin acento.
     * @param string $nombre Nombre de la carrera.
     * @return string Null si es correcto, mensaje en caso contrario.
     * @author Márquez Emanuel.
     * */
    static function formatoNombreCarrera($nombre) 
    {
        if ($nombre)
        {
            $longitud = strlen($nombre);
            if (($longitud > 9) && ($longitud < 256)) {
                $expresion = "/^[A-Za-záéíóúÁÉÍÓÚñÑ. ]{10,255}$/";
                if (preg_match($expresion, $nombre)) {
                    return null;
                }
                return "El nombre de carrera no cumple con el formato (Se aceptan letras y espacios)";
            }
            return "La longitud del nombre debe ser de 10 a 255 caracteres";
        }
        return "Se debe indicar un nombre de carrera";
    }
    
    /**
     * Controla el formato del nombre de un docente. El nombre de docente puede
     * contener letras, espacios, acentos, puntos y comas. La longitud minima de
     * cadena es de 3 caracteres y la maxima de 255.
     * @param string $nombre Nombre del docente.
     * @return string Null si es correcto, mensaje en caso contrario.
     * @author Márquez Emanuel.
     * */
    static function formatoNombreDocente($nombre)
    {
        $longitud = strlen($nombre);
        if (($longitud > 3) && ($longitud < 256)) {
            $expresion = "/^[A-Za-záéíóúñüÁÉÍÓÚÜÑ,. ]{4,255}$/";
            if (preg_match($expresion, $nombre)) {
                return null;
            }
            return "El nombre de docente no cumple con el formato (Se aceptan letras, acentos, espacios, puntos y comas)";
        }
        return "La longitud del nombre de docente debe ser de 3 a 255 caracteres";
    }
    
    /**
     * Controla que no se repita el mismo docente en el tribunal. Para ello
     * compara cada nombre en cada posición.
     * @param string $presidente Nombre del presidente.
     * @param string $vocal1 Nombre del vocal 1.
     * @param string $vocal2 Nombre del vocal 2.
     * @param string $suplente Nombre del suplente.
     * @return string Null si es correcto, mensaje en caso contrario.
     * @author Márquez Emanuel.
     * */
    static function verificarTribunal($presidente, $vocal1, $vocal2, $suplente)
    {
        if ($presidente == $vocal1) {
            return "El docente que es presidente tambien es vocal primero";
        }
        if ($vocal2) {
            if ($presidente == $vocal2) {
                return "El docente que es presidente tambien es vocal segundo";
            }
            if ($vocal1 == $vocal2) {
                return "El docente que es vocal primero tambien es vocal segundo";
            }
            if ($suplente) {
                if ($presidente == $suplente) {
                    return "El docente que es presidente tambien es suplente";
                }
                if ($vocal1 == $suplente) {
                    return "El docente que es vocal primero tambien es suplente";
                }
            }
        }
        return null;
    }
    
    /**
     * Controla el formato del nombre de sector. Este debe ser de un solo
     * caracter y de una letra.
     * @param string $sector Sector donde se ubica el aula.
     * @return string Null si es correcto, mensaje en caso contrario.
     * @author Márquez Emanuel.
     * */
    static function formatoSector($sector) 
    {
        if (strlen($sector) == 1) {
            $expresion = "/^[A-Za-z]$/";
            if (preg_match($expresion, $sector)) {
                return null;
            }
            return "El sector no cumple con el formato (Se acepta solo una letra)";
        }
        return "La longitud del sector debe ser de 1";
    }
    
    /**
     * Controla el formato del nombre del aula. Este puede contener letras
     * espacios y números.
     * @param string $aula Aula donde se dicta la clase.
     * @return string Null si es correcto, mensaje en caso contrario.
     * @author Márquez Emanuel.
     * */
    static function formatoNombreAula($aula)
    {
        $expresion = "/^[A-Za-záéíóúñüÁÉÍÓÚÜÑ0123456789 ]{1,255}$/";
        if (preg_match($expresion, $aula)) {
            return null;
        }
        return "El nombre de aula no cumple con el formato (Se aceptan letras, acentos, espacios)";
    }
    
    /**
     * Controla que en un arreglo no haya mesas de examen duplicadas. Se controla
     * que no exista una mesa de examen para la misma asignatura en la misma
     * carrera. Para ello, se busca primero el nombre de asignatura, si existe se
     * busca la carrera para ver coincidencias.
     * @param array $mesas Recibe el arreglo de mesas.
     * @param string $asignatura Recibe el nombre de la asignatura.
     * @param integer $codigo Recibe el codigo de la carrera.
     * @return string Null si no hay duplicadas, mensaje en caso contrario.
     * @author Márquez Emanuel.
     * */
    static function mesasDuplicadas($mesas, $asignatura, $carrera)
    {
        $mensaje = null;
        $posicion = 0;
        $encontrado = false;
        $tamanio = count($mesas);
        while (($posicion < $tamanio) && !$encontrado) {
            $mesa = $mesas[$posicion];
            if (in_array($asignatura, $mesa)) {
                if (in_array($carrera, $mesa)) {
                    $mensaje = "La mesa de examen ya se encuentra cargada";
                    $encontrado = true;
                }
            }
            ++$posicion;
        }
        return $mensaje;
    }
    
    /**
     * Controla que en un arreglo no haya cursadas duplicadas. Se controla que
     * no exista una cursada para la misma asignatura en la misma carrera. Para
     * ello, se busca primero el nombre de la asignatura, si existe se busca la
     * carrera para ver coincidencias.
     * @param Cursada[] $cursadas Recibe el arreglo de cursadas.
     * @param string $asignatura Recibe el nombre de la asignatura.
     * @param integer $codigo Recibe el codigo de la carrera.
     * @return string Null si no hay duplicadas, mensaje en caso contrario.
     * @author Márquez Emanuel.
     * */
    static function cursadasDuplicadas($cursadas, $asignatura, $codigo)
    {
        $mensaje = null;
        $posicion = 0;
        $encontrado = false;
        $tamanio = count($cursadas);
        while (($posicion < $tamanio) && !$encontrado) {
            $cursada = $cursadas[$posicion];
            if ($cursada->getPlan()->getAsignatura()->getNombre() == $asignatura) {
                if ($cursada->getPlan()->getCarrera()->getCodigo() == $codigo) {
                    $mensaje = "La cursada ya se encuentra cargada";
                    $encontrado = true;
                }
            }
            ++$posicion;
        }
        return $mensaje;
    }
    
    /**
     * Realiza la conversión de una cadena de texto a formato Camel Case.
     * Cada una de las palabras de la cadena de texto recibida será convertida
     * a un formato donde se inicia la primer letra con mayuscula y luego las 
     * demas letras con minuscula.
     * @param string $texto Cadena de texto en cualquier formato.
     * @return string Devuelve la cadena en formato Camel Case. 
     * */
    static function convertirCamelCase($texto)
    {
        if ($texto) {
            /* Convierta la cadena completa a minuscula */
            $texto = strtolower($texto);
            /* Coloca cada letra inicial de palabra en mayuscula */
            $texto = ucwords($texto);
        }
        return $texto;
    }
    
    /**
     * Devuelve el nombre de un dia a partir del numero de la semana donde
     * 0 es lunes y 6 es sabado.
     * @param integer $dia Recibe el dia 0, 1, 2, 3, 4, 5 o 6.
     * @return string Nombre del dia.
     * */
    static function nombreDeDia($dia)
    {
        switch ($dia) {
            case 1:
                return "Lunes";
            case 2:
                return "Martes";
            case 3:
                return "Miercoles";
            case 4:
                return "Jueves";
            case 5:
                return "Viernes";
            case 6:
                return "Sabado";
        }
        return null;
    }
}