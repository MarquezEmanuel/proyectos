<?php
/**
 * ROOT:        D:/Aplica/SIB
 * DOCUMENTS:   D:/Aplica/SIB/documents
 * LOGS:        D:/Aplica/SIB/logs
 * CONF:        D:/Aplica/SIB/app/conf
 * GAR:         D:/Aplica/SIB/app/gar
 * REP:         D:/Aplica/SIB/app/rep
 * SUC:         D:/Aplica/SIB/app/suc
 * USU:         D:/Aplica/SIB/app/usu
 * 
 * URL_RTEPF:   D:/Aplica/SIB/app/documents/rtepf
 * URL_RTEOC:   D:/Aplica/SIB/app/documents/rteoc
 * URL_CAR:     D:/Aplica/SIB/app/documents/cartera
 * URL_FIA:     D:/Aplica/SIB/app/documents/fianza
 * URL_HIP:     D:/Aplica/SIB/app/documents/hipoteca
 * URL_LEA:     D:/Aplica/SIB/app/documents/leasing
 * URL_PRE:     D:/Aplica/SIB/app/documents/prenda
 */

/* ESTRUCTURA DE DIRECTORIOS DEL SISTEMA */

const ROOT = "D:\\Aplica\\SIB";
const DOCUMENTS = ROOT . "\\documents";
const LOGS = ROOT . "\\logs";
const CONF = ROOT . "\\app\\conf";
const GAR = ROOT . "\\gar";
const REP = ROOT . "\\app\\rep";
const SUC = ROOT . "\\app\\suc";
const USU = ROOT . "\\app\\usu";
const CREDI = ROOT . "\\app\\crediticia";

/* ESTRUCTURA PARA REPORTES DE SUCURSALES */

const URL_ConstanciaSaldo = DOCUMENTS . "\\constanciaSaldo";
const URL_Conta = DOCUMENTS."\\conta";

/* ESTRUCTURA PARA RTE (PLAZO FIJO / OPERACIONES DE CAMBIO) */

const URL_CuentaComitente = DOCUMENTS . "\\cuentaComitente";
const URL_RTE = DOCUMENTS . "\\rte";
const URL_RTEPF = DOCUMENTS . "\\rtepf";
const URL_RTEOC = DOCUMENTS . " \\rteoc";
const URL_PMDEB = DOCUMENTS . " \\pmdeb";

/* ESTRUCTURA PARA GARANTIAS */

const URL_CAR = DOCUMENTS . "\\cartera";
const URL_FIA = DOCUMENTS . "\\fianza";
const URL_HIP = DOCUMENTS . "\\hipoteca";
const URL_LEA = DOCUMENTS . "\\leasing";
const URL_PRE = DOCUMENTS . "\\prenda";


/* DOMINIO DE ACTIVE DIRECTORY */

const HOST_LDAP = "ldap://192.168.250.150";
const PORT_LDAP = 389;
const DOMINIO_LDAP = "desarrollo\\";
