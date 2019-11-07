/**
 * Este archivo contiene el codigo necesario para realizar los controles del formulario
 * para crear un nuevo horariod de cursada, antes que sea enviado al servidor.
 * Para ello se hace uso de la biblioteca JQuery.
 * 
 * Dias de la semana:
 * 		1 = Lunes.
 *  	2 = Martes.
 *  	3 = Miercoles.
 *  	4 = Jueves.
 *  	5 = Viernes.
 *  	6 = Sabado.
 * 
 * @see jQuery
 * 
 * @author Marquez Emanuel.
 */

$(document).ready(function() {
	
	
	/** Al modificar el nombre de la carrera se recorre la lista
	 * de seleccion para asignar el codigo correspondiente.
	 * */
	$('input#txtCarrera').change(function() {
		var carrera = $(this).val();
		$("#carreras option").each(function() {
			var codigo = $(this).text();
			var nombre = $(this).attr('value');
			if(nombre == carrera) {
				$('input#codigoCarrera').val(codigo);
			}
		});
	});
	
	$('input#codigoCarrera').change(function() {
		var carrera = $(this).val();
		$("#carreras option").each(function() {
			var codigo = $(this).text();
			var nombre = $(this).attr('value');
			if(codigo == carrera) {
				$('input#txtCarrera').val(nombre);
			}
		});
	});
	
	/** 
	 * Se habilitan o deshabilitan los campos del dia lunes 
	 * cuando se hace click sobre el checkbox correspondiente.
	 */
	$('#cbDiasClase1').click(function() {
		if ($(this).prop('checked')) {
			/** Se habilitan todos los campos del dia lunes */
			$('#selectHoraInicio1').prop('disabled', false);
			$('#selectHoraFin1').prop('disabled', false);
			$('#txtSector1').prop('disabled', false);
			$('#txtAula1').prop('disabled', false);
			
		} else {
			/** Se deshabilitan todos los campos del dia lunes */
			$('#selectHoraInicio1').prop('disabled', true);
			$('#selectHoraFin1').prop('disabled', true);
			$('#txtSector1').prop('disabled', true);
			$('#txtAula1').prop('disabled', true);
		}
	});
	
	/** 
	 * Se habilitan o deshabilitan los campos del dia martes cuando
	 * se hace click sobre el checkbox correspondiente.
	 */
	$('#cbDiasClase2').click(function() {
		if ($(this).prop('checked')) {
			/** Se habilitan todos los campos del dia martes */
			$('#selectHoraInicio2').prop('disabled', false);
			$('#selectHoraFin2').prop('disabled', false);
			$('#txtSector2').prop('disabled', false);
			$('#txtAula2').prop('disabled', false);
			
		} else {
			/** Se deshabilitan todos los campos del dia martes */
			$('#selectHoraInicio2').prop('disabled', true);
			$('#selectHoraFin2').prop('disabled', true);
			$('#txtSector2').prop('disabled', true);
			$('#txtAula2').prop('disabled', true);
		}
	});
	
	/** 
	 * Se habilitan o deshabilitan los campos del dia miercoles 
	 * cuando se hace click sobre el checkbox correspondiente.
	 */
	$('#cbDiasClase3').click(function() {
		if ($(this).prop('checked')) {
			/** Se habilitan todos los campos del dia miercoles */
			$('#selectHoraInicio3').prop('disabled', false);
			$('#selectHoraFin3').prop('disabled', false);
			$('#txtSector3').prop('disabled', false);
			$('#txtAula3').prop('disabled', false);
			
		} else {
			/** Se deshabilitan todos los campos del dia miercoles */
			$('#selectHoraInicio3').prop('disabled', true);
			$('#selectHoraFin3').prop('disabled', true);
			$('#txtSector3').prop('disabled', true);
			$('#txtAula3').prop('disabled', true);
		}
	});
	
	/** 
	 * Se habilitan o deshabilitan los campos del dia jueves cuando
	 *  se hace click sobre el checkbox correspondiente.
	 */
	$('#cbDiasClase4').click(function() {
		if ($(this).prop('checked')) {
			/** Se habilitan todos los campos del dia jueves */
			$('#selectHoraInicio4').prop('disabled', false);
			$('#selectHoraFin4').prop('disabled', false);
			$('#txtSector4').prop('disabled', false);
			$('#txtAula4').prop('disabled', false);
			
		} else {
			/** Se deshabilitan todos los campos del dia jueves */
			$('#selectHoraInicio4').prop('disabled', true);
			$('#selectHoraFin4').prop('disabled', true);
			$('#txtSector4').prop('disabled', true);
			$('#txtAula4').prop('disabled', true);
		}
	});
	
	/** 
	 * Se habilitan o deshabilitan los campos del dia viernes cuando
	 *  se hace click sobre el checkbox correspondiente.
	 */
	$('#cbDiasClase5').click(function() {
		if ($(this).prop('checked')) {
			/** Se habilitan todos los campos del dia viernes */
			$('#selectHoraInicio5').prop('disabled', false);
			$('#selectHoraFin5').prop('disabled', false);
			$('#txtSector5').prop('disabled', false);
			$('#txtAula5').prop('disabled', false);
			
		} else {
			/** Se deshabilitan todos los campos del dia viernes */
			$('#selectHoraInicio5').prop('disabled', true);
			$('#selectHoraFin5').prop('disabled', true);
			$('#txtSector5').prop('disabled', true);
			$('#txtAula5').prop('disabled', true);
		}
	});
	
	/** 
	 * Se habilitan o deshabilitan los campos del dia sabado 
	 * cuando se hace click sobre el checkbox correspondiente.
	 */
	$('#cbDiasClase6').click(function() {
		if ($(this).prop('checked')) {
			/** Se habilitan todos los campos del dia sabado */
			$('#selectHoraInicio6').prop('disabled', false);
			$('#selectHoraFin6').prop('disabled', false);
			$('#txtSector6').prop('disabled', false);
			$('#txtAula6').prop('disabled', false);
			
		} else {
			/** Se deshabilitan todos los campos del dia sabado */
			$('#selectHoraInicio6').prop('disabled', true);
			$('#selectHoraFin6').prop('disabled', true);
			$('#txtSector6').prop('disabled', true);
			$('#txtAula6').prop('disabled', true);
		}
	});
	
});