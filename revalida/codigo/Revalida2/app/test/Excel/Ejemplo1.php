<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../Conexion/Modelo/Constantes.php';

require_once '../../../lib/SimpleExcel/src/SimpleExcel/SimpleExcel.php';


$excel = new SimpleExcel();

$nombre = AVA . "\\reporte.xlsx";

$excel->loadFile($nombre, 'XLSX');
