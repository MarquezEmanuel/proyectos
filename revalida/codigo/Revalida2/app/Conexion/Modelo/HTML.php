<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HTML {

    /**
     * Retorna una cadena con un div de tipo alerta. Se indica un icono y un color
     * segun el resultado que se indique. Ademas se carga el mensaje recibido 
     * dentro del div.
     * @param integer $resultado 0 alerta roja, 1 amarilla, 2 verde.
     * @param string $mensaje Mensaje que se carga dentro de la alerta.
     * @return string Div con la alerta.
     */
    public static function getAlerta($resultado, $mensaje) {
        switch ($resultado) {
            case 2:
                $icono = "<i class='far fa-check-circle'></i>";
                $clase = 'class="alert alert-success text-center"';
                break;
            case 1:
                $icono = "<i class='fas fa-exclamation-circle'></i>";
                $clase = 'class="alert alert-warning text-center"';
                break;
            case 0:
                $icono = "<i class='fas fa-exclamation-triangle'></i>";
                $clase = 'class="alert alert-danger text-center"';
                break;
        }
        return "<div {$clase} role='alert'>{$icono} <strong>{$mensaje}</strong></div>";
    }

    public static function generarCardParaImagen($header, $ruta, $width) {
        return '
        <div class="card">
            <div class="card-header text-center">' . $header . '</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col text-center">
                        <img src="' . $ruta . '" alt="Responsive image"
                             class="img-fluid rounded" style="width: ' . $width . ';">
                    </div>
                </div>
            </div>
        </div>';
    }

}
