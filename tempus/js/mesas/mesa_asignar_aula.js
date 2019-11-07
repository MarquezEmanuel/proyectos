/**
 * 
 */

$(document).ready(function() {
	
	
	$('input#radTipoAsignacion').change(function() {
		var tipo = $('input#radTipoAsignacion:checked').val();
		if(tipo == 0) {
			// tipo de asignacion libre
			$('div#divDisponible').css("display", "block");
			$('div#divOcupada').css("display", "none");
		} else {
			// tipo de asignacion ocupada
			$('div#divOcupada').css("display", "block");
			$('div#divDisponible').css("display", "none");
		}
	});
	
});