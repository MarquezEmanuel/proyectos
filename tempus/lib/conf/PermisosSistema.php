<?php
/**
 * Clase de constantes del sistema de Roles y Permisos. Esta clase contiene
 * los roles que estan cargados en la base de datos del sistema y los permisos
 * a los que se pueden acceder.
 *
 * @author Eder dos Santos <esantos@uarg.unpa.edu.ar>
 */
class PermisosSistema 
{
    /* ROLES DEL SISTEMA */   
    
    const ROL_ADMIN = "Administrador";
    const ROL_SECRETARIA = "Secretaria";
    
    const PERMISO_AUTH = "Auth";
    
    const PERMISO_SALIR = "Salir";
    const PERMISO_LOGIN = "Ingresar";
    const PERMISO_CONSULTAR = "Consultar";
    
    /* PERMISOS RELACIONADOS AL SUBSISTEMA DE AULAS */
   
    const AULAS = "Aulas";
    
    /* PERMISOS RELACIONADOS AL SUBSISTEMA DE CURSADAS */
    
    const CURSADAS = "Cursadas";
    const IMPORTAR_CURSADA = "Importar cursada";
    const CREAR_CURSADA = "Crear cursada";
    const BORRAR_CURSADA = "Borrar cursada";
    const BUSCAR_CURSADA = "Buscar cursada";
    const INFORME_CURSADA = "Informe cursada";
    
    /* PERMISOS RELACIONADOS AL SUBSISTEMA DE MESAS */
    
    const MESAS = "Mesas";
    const IMPORTAR_MESA = "Importar mesa";
    const CREAR_MESA = "Crear mesa";
    const BORRAR_MESA = "Borrar mesa";
    const BUSCAR_MESA = "Buscar mesa";
    const INFORME_MESA = "Informe mesa";
    
    /* PERMISOS RELACIONADOS AL SUBSISTEMA DE USUARIOS */
    
    const PERMISO_USUARIOS = "Usuarios";
    
    
    
    
}