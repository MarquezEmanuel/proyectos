/**
 * Este archivo contiene el codigo necesario para realizar los controles del 
 * formulario para modificar una mesa de examen, antes que sea enviado al servidor.
 * Para ello se hace uso de la biblioteca JQuery.
 * 
 * @see jQuery
 * 
 * @author Marquez Emanuel.
 */

$(document).ready(function() {
	
	/** Cuando se carga el formulario almacena la informacion original
	 * 	para luego realizar la verificación que se ha modificado alguno
	 *  de los campos.
	 *  orig = original.
	 */
	var orig_presidente = $('input#txtNombrePresidente').val();
	var orig_vocal1 = $('input#txtNombreVocal1').val();
	var orig_vocal2 = $('input#txtNombreVocal2').val();
	var orig_suplente = $('input#txtNombreSuplente').val();
	var orig_primero = $('input#datePrimerLlamado').val();
	var orig_segundo = $('input#dateSegundoLlamado').val();
	var orig_sector = $('input#txtSector').val();
	var orig_aula = $('input#txtNombreAula').val();
	var orig_horario = $('select#selectHora').val();
	
	/** Captura el submit para hacer las validaciones al formulario  */
	
	$('form#formModificarMesa').submit(function() {
		var accion = $('input#accion').val();
		if (accion == 'modificarTribunal') {
			var presidente = $('input#txtNombrePresidente').val();
			var vocal1 = $('input#txtNombreVocal1').val();
			var vocal2 = $('input#txtNombreVocal2').val();
			var suplente = $('input#txtNombreSuplente').val();
			
			if((orig_presidente != presidente) || (orig_vocal1 != vocal1) || (orig_vocal2 != vocal2) || (orig_suplente != suplente)) {
				if ((presidente == vocal1) || (presidente == vocal2) || (presidente == suplente)) {
					$("h3#mensaje" ).remove();
					var mensaje = "El docente asignado como presidente de tribunal se encuentra repetido";
					$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
					$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
					return false;
				}
				if ((vocal1 == vocal2) || (vocal1 == suplente)) {
					$("h3#mensaje" ).remove();
					var mensaje = "El docente asignado como vocal primero de tribunal se encuentra repetido";
					$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
					$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
					return false;
				}
				if (vocal2 == suplente) {
					$("h3#mensaje" ).remove();
					var mensaje = "El docente asignado como vocal segundo de tribunal se encuentra repetido";
					$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
					$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
					return false;
				}
					
			} else {
				$("h3#mensaje" ).remove();
				var mensaje = "No se realiz\u00F3 una modificaci\u00F3n para el tribunal de la mesa de examen";
				$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
				$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
				return false;
			}
		}
	});
	
	$('input#imgPrimerLlamado').click(function(e) {
		e.preventDefault();
		var fecha = $('input#datePrimerLlamado').val();
		if(fecha != orig_primero) {
			var titulo = "\u00BFEst\u00E1 seguro que desea modificar la fecha del primer llamado ";
			var contenido = "Confirme la modificaci\u00F3n del llamado a "+fecha;
			$.confirm({
			    title: titulo,
			    content: contenido,
			    buttons: {
			        confirmar: function () {
			        	$('input#accion').val('modificarLlamado');
			        	$('input#llamado').val('1');
			        	$('form#formModificarMesa').submit();
			        },
			        cancelar: function () {
			            return true;
			        }
			    }
			});
		} else {
			$("h3#mensaje" ).remove();
			var mensaje = "No se realiz\u00F3 una modificaci\u00F3n de la fecha para el primer llamado";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
	});
	
	$('input#imgSegundoLlamado').click(function(e) {
		e.preventDefault();
		var fecha = $('input#dateSegundoLlamado').val();
		if(fecha != orig_segundo) {
			var titulo = "\u00BFEst\u00E1 seguro que desea modificar la fecha del segundo llamado ";
			var contenido = "Confirme la modificaci\u00F3n del llamado";
			$.confirm({
			    title: titulo,
			    content: contenido,
			    buttons: {
			        confirmar: function () {
			        	$('input#accion').val('modificarLlamado');
			        	$('input#llamado').val('2');
			        	$('form#formModificarMesa').submit();
			        },
			        cancelar: function () {
			            return true;
			        }
			    }
			});
		} else {
			$("h3#mensaje" ).remove();
			var mensaje = "No se realiz\u00F3 una modificaci\u00F3n de la fecha para el segundo llamado";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
	});
	
	$('input#imgModificarHora').click(function(e) {
		e.preventDefault();
		var titulo = "\u00BFEst\u00E1 seguro que desea modificar la hora para la mesa de examen";
		var contenido = "Confirme la modificaci\u00F3n de la hora";
		$.confirm({
		    title: titulo,
		    content: contenido,
		    buttons: {
		        confirmar: function () {
		        	$('input#accion').val('modificarHora');
		        	$('form#formModificarMesa').submit();
		        },
		        cancelar: function () {
		            return true;
		        }
		    }
		});
	});
	
		
});