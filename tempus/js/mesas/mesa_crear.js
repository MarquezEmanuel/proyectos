/**
 * Este archivo contiene el codigo necesario para realizar los controles del formulario
 * para crear una nueva mesa de examen, antes que sea enviado al servidor.
 * Para ello se hace uso de la biblioteca JQuery.
 * 
 * @see jQuery
 * 
 * @author Marquez Emanuel.
 */

$(document).ready(function() {
	
	/** Captura el submit para controlar el archivo que se ha seleccionado */
	$('form#formCrearMesa').submit(function() {	
		
		$("h3#mensaje" ).remove();
		
		var primero = $('input#datePrimerLlamado').val();
		var segundo = $('input#dateSegundoLlamado').val();
		var presidente = $('input#txtNombrePresidente').val().toLowerCase();
		var vocal1 = $('input#txtNombreVocal1').val().toLowerCase();
		var vocal2 = $('input#txtNombreVocal2').val().toLowerCase();
		var suplente = $('input#txtNombreSuplente').val().toLowerCase();
		
		if (presidente == vocal1) {
			$("<h3 id='mensaje' class='letraNaranja'>El nombre del Presidente coincide con el nombre del Vocal 1</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		if (presidente == vocal2) {
			$("<h3 id='mensaje' class='letraNaranja'>El nombre del Presidente coincide con el nombre del Vocal 2</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		if (presidente == suplente) {
			$("<h3 id='mensaje' class='letraNaranja'>El nombre del Presidente coincide con el nombre del Suplente</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		if (vocal1 == vocal2) {
			$("<h3 id='mensaje' class='letraNaranja'>El nombre del Vocal 1 coincide con el nombre del Vocal 2</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		if (vocal1 == suplente) {
			$("<h3 id='mensaje' class='letraNaranja'>El nombre del Vocal 1 coincide con el nombre del Suplente</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		if(vocal2 && suplente) {
			if(vocal2 == suplente) {
				$("<h3 id='mensaje' class='letraNaranja'>El nombre del Vocal 2 coincide con el nombre del Suplente</h3>").insertAfter( "#content h2" );
				$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
				return false;
			}
		}
		
		/* Si no hay primer llamado ni segundo llamado, muestra mensaje */
		if (!primero && !segundo) {
			$("<h3 id='mensaje' class='letraNaranja'>Debe indicar una fecha de llamado</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
});