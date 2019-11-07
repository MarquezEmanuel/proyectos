/**
 * 
 * 
 * Significado de los prefigos:
 *   orig = Original. Valor del campo antes de modificar.
 *   txt = Text. Input de tipo texto.
 *   num = Number. Input de tipo numerico.
 *   sel = Select. Campo de seleccion de opciones.
 */

$(document).ready(function() {
	
	/** VALORES ORIGINALES DE LOS CAMPOS DE INFORMACION BASICA */
	var orig_codigoCarrera = $('input#numCarrera').val();
	var orig_nombreCarrera = $('input#txtCarrera').val();
	var orig_nombreAsignatura = $('input#txtAsignatura').val();
	var orig_anio = $('input#selAnio').val();
	
	/** VALORES ORIGINALES DE LOS CAMPOS DEL DIA LUNES */
	var idclase1 = $("input#idclase1").val();
	var orig_horaInicio1 = $("select#selectHoraInicio1").val();
	var orig_horaFin1 = $("select#selectHoraFin1").val();
	var orig_sector1 = $("input#txtSector1").val();
	var orig_aula1 = $("input#txtAula1").val();
	
	/** VALORES ORIGINALES DE LOS CAMPOS DEL DIA MARTES */
	var idclase2 = $("input#idclase2").val();
	var orig_horaInicio2 = $("select#selectHoraInicio2").val();
	var orig_horaFin2 = $("select#selectHoraFin2").val();
	var orig_sector2 = $("input#txtSector2").val();
	var orig_aula2 = $("input#txtAula2").val();
	
	/** VALORES ORIGINALES DE LOS CAMPOS DEL DIA MIERCOLES */
	var idclase3 = $("input#idclase3").val();
	var orig_horaInicio3 = $("select#selectHoraInicio3").val();
	var orig_horaFin3 = $("select#selectHoraFin3").val();
	var orig_sector3 = $("input#txtSector3").val();
	var orig_aula3 = $("input#txtAula3").val();
	
	/** VALORES ORIGINALES DE LOS CAMPOS DEL DIA JUEVES */
	var idclase4 = $("input#idclase4").val();
	var orig_horaInicio4 = $("select#selectHoraInicio4").val();
	var orig_horaFin4 = $("select#selectHoraFin4").val();
	var orig_sector4 = $("input#txtSector4").val();
	var orig_aula4 = $("input#txtAula4").val();
	
	/** VALORES ORIGINALES DE LOS CAMPOS DEL DIA VIERNES */
	var idclase5 = $("input#idclase5").val();
	var orig_horaInicio5 = $("select#selectHoraInicio5").val();
	var orig_horaFin5 = $("select#selectHoraFin5").val();
	var orig_sector5 = $("input#txtSector5").val();
	var orig_aula5 = $("input#txtAula5").val();
	
	/** VALORES ORIGINALES DE LOS CAMPOS DEL DIA SABADO */
	var idclase6 = $("input#idclase6").val();
	var orig_horaInicio6 = $("select#selectHoraInicio6").val();
	var orig_horaFin6 = $("select#selectHoraFin6").val();
	var orig_sector6 = $("input#txtSector6").val();
	var orig_aula6 = $("input#txtAula6").val();

	/* CUANDO SE SELECCIONA UN NUEVO DIA (CAMBIO EN EL RADIO) SE HABILITAN
	 * LOS CAMPOS CORRESPONDIENTES PARA SU EDICION. ADEMAS SE DEBEN MOSTRAR
	 * LOS ICONOS PARA MODIFICAR, BORRAR O CREAR. */
	$('input#radDias').change(function() {
		var dia = $('input#radDias:checked').val();
		for (indice = 1; indice < 7; indice++) {
			if(indice != dia) {
				/* SE DESHABILITAN LOS CAMPOS DE TODOS LOS DIAS (SALVO EL SELECCIONADO) */
				$("select#selectHoraInicio"+indice).prop('disabled', true);
				$("select#selectHoraFin"+indice).prop('disabled', true);
				$("input#txtSector"+indice).prop('disabled', true);
				$("input#txtAula"+indice).prop('disabled', true);
				$('img#imgModificar'+indice).css("display", "none");
				$('img#imgBorrar'+indice).css("display", "none");
				$('img#imgCrear'+indice).css("display", "none");
				
			} else {
				/* SE HABILITAN LOS CAMPOS DEL DIA SELECCIONADO */
				$("select#selectHoraInicio"+dia).prop('disabled', false);
				$("select#selectHoraFin"+dia).prop('disabled', false);
				$("input#txtSector"+dia).prop('disabled', false);
				$("input#txtAula"+dia).prop('disabled', false);
				$('img#imgModificar'+dia).css("display", "block");
				$('img#imgBorrar'+dia).css("display", "block");
				$('img#imgCrear'+indice).css("display", "block");
			}
		}
	});
	
	$('form#formModificarCursada').submit(function() {
		
		alert($('input#accion').val());
		
	});

/************** CAMPOS CORRESPONDIENTES AL DIA 1: LUNES  **************/
	
	$('select#selectHoraInicio1').change(function() {
		var horaInicio = $("select#selectHoraInicio1").val();
		var tope = horaInicio.substring(0,2);
		for (indice = 11; indice < 24; indice++) {
			if(indice <= tope) {
				$("select#selectHoraFin1 option[value='"+indice+":00']").prop('disabled',true);
			} else {
				$("select#selectHoraFin1 option[value='"+indice+":00']").prop('disabled',false);
			}
		}
		var fin = parseInt(tope) + 1;
		$("select#selectHoraFin1 option[value='"+fin+":00']").prop('selected',true);
	});
	
	$('img#imgModificar1').click(function() {
		var horaInicio = $("select#selectHoraInicio1").val();
		var horaFin = $("select#selectHoraFin1").val();
		var sector = $("input#txtSector1").val();
		var aula = $("input#txtAula1").val();
		
		if((orig_horaInicio1 != horaInicio) || (orig_horaFin1 != horaFin) || (orig_sector1 != sector) || (orig_aula1 != aula)) {
			/* SE ENCONTRARON MODIFICACIONES EN LOS CAMPOS DEL DIA */
			var titulo = "\u00BFEst\u00E1 seguro que desea modificar el horario de clase correspondiente al Lunes?";
			var contenido = "Confirme la modificaci\u00F3n del horario de clase: Desde "+horaInicio+" hs hasta "+horaFin+" hs en "+sector+"-"+aula;
			$.confirm({
			    title: titulo,
			    content: contenido,
			    buttons: {
			        confirmar: function () {
			        	$('input#accion').val('modificarclase');
			        	$('form#formModificarCursada').submit();
			        },
			        cancelar: function () {
			            return true;
			        }
			    }
			});
		} else {
			/* NO SE ENCONTRARON MODIFICACIONES EN LOS CAMPOS DEL DIA */
			$("h3#mensaje" ).remove();
			var mensaje = "No se realizaron modificaciones al horario de clases del dia lunes";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
	});
	
	$('img#imgBorrar1').click(function() {
		var titulo = "\u00BFEst\u00E1 seguro que desea borrar el horario de clase correspondiente al Lunes?";
		var contenido = "Confirme la eliminaci\u00F3n del horario de clase";
		$.confirm({
		    title: titulo,
		    content: '' +
		    	'<form action="" class="formName">' +
			    	'<div class="form-group">' +
			    	'<label>Indique si desea borrar el horario de clases para todas las carreras</label><br>' +
			    	'<input type="checkbox" id="checkbox" name="checkbox" required />' +
			    	'<label>Tildar para aplicar a todas las carreras</label>' +
			    	'</div>' +
		    	'</form>',
		    buttons: {
		    	formSubmit: {
	                text: 'Confirmar',
	                btnClass: 'btn-blue',
	                action: function () {
	                    var check = this.$content.find('#checkbox').is(":checked");
	                    if(check) {
	                    	$('input#aplicarTodas').val('true');
	                    } else {
	                    	$('input#aplicarTodas').val('false');
	                    }
	                    $('input#accion').val('borrarclase');
			        	$('form#formModificarCursada').submit();
                        return true;
	                }
	            },
		        cancelar: function () {
		            return true;
		        }
		    },
		    onContentReady: function () {
		        var jc = this;
		        this.$content.find('form').on('submit', function (e) {
		            e.preventDefault();
		            jc.$$formSubmit.trigger('click');
		        });
		    }
		});
	});
	
	$('img#imgCrear1').click(function() {
		var sector = $("input#txtSector1").val();
		var aula = $("input#txtAula1").val();
		if(sector != null && aula != null) {
			var titulo = "\u00BFEst\u00E1 seguro que desea crear el horario de clase correspondiente al Lunes?";
			var contenido = "Confirme la creaci\u00F3n del horario de clase";
			$.confirm({
			    title: titulo,
			    content: contenido,
			    buttons: {
			        confirmar: function () {
			        	$('input#accion').val('crearclase');
			        	$('form#formModificarCursada').submit();
			        },
			        cancelar: function () {
			            return true;
			        }
			    }
			});
		} else {
			
		}
	});

/************** CAMPOS CORRESPONDIENTES AL DIA 2: MARTES  **************/
	
	$('select#selectHoraInicio2').change(function() {
		var horaInicio = $("select#selectHoraInicio2").val();
		var tope = horaInicio.substring(0,2);
		for (indice = 11; indice < 24; indice++) {
			if(indice <= tope) {
				$("select#selectHoraFin2 option[value='"+indice+":00']").prop('disabled',true);
			} else {
				$("select#selectHoraFin2 option[value='"+indice+":00']").prop('disabled',false);
			}
		}
		var fin = parseInt(tope) + 1;
		$("select#selectHoraFin2 option[value='"+fin+":00']").prop('selected',true);
	});
	
	$('img#imgModificar2').click(function() {
		var horaInicio = $("select#selectHoraInicio2").val();
		var horaFin = $("select#selectHoraFin2").val();
		var sector = $("input#txtSector2").val();
		var aula = $("input#txtAula2").val();
		
		if((orig_horaInicio2 != horaInicio) || (orig_horaFin2 != horaFin) || (orig_sector2 != sector) || (orig_aula2 != aula)) {
			/* SE ENCONTRARON MODIFICACIONES EN LOS CAMPOS DEL DIA */
			var titulo = "\u00BFEst\u00E1 seguro que desea modificar el horario de clase correspondiente al Martes?";
			var contenido = "Confirme la modificaci\u00F3n del horario de clase: Desde "+horaInicio+" hs hasta "+horaFin+" hs en "+sector+"-"+aula;
			$.confirm({
			    title: titulo,
			    content: contenido,
			    buttons: {
			        confirmar: function () {
			        	$('input#accion').val('modificarclase');
			        	$('form#formModificarCursada').submit();
			        },
			        cancelar: function () {
			            return true;
			        }
			    }
			});
		} else {
			/* NO SE ENCONTRARON MODIFICACIONES EN LOS CAMPOS DEL DIA */
			$("h3#mensaje" ).remove();
			var mensaje = "No se realizaron modificaciones al horario de clases del dia martes";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
	});
	
	$('img#imgBorrar2').click(function() {
		var titulo = "\u00BFEst\u00E1 seguro que desea borrar el horario de clase correspondiente al Martes?";
		var contenido = "Confirme la eliminaci\u00F3n del horario de clase";
		$.confirm({
		    title: titulo,
		    content: '' +
		    	'<form action="" class="formName">' +
			    	'<div class="form-group">' +
			    	'<label>Indique si desea borrar el horario de clases para todas las carreras</label><br>' +
			    	'<input type="checkbox" id="checkbox" name="checkbox" required />' +
			    	'<label>Tildar para aplicar a todas las carreras</label>' +
			    	'</div>' +
		    	'</form>',
		    buttons: {
		    	formSubmit: {
	                text: 'Confirmar',
	                btnClass: 'btn-blue',
	                action: function () {
	                    var check = this.$content.find('#checkbox').is(":checked");
	                    if(check) {
	                    	$('input#aplicarTodas').val('true');
	                    } else {
	                    	$('input#aplicarTodas').val('false');
	                    }
	                    $('input#accion').val('borrarclase');
			        	$('form#formModificarCursada').submit();
                        return true;
	                }
	            },
		        cancelar: function () {
		            return true;
		        }
		    },
		    onContentReady: function () {
		        var jc = this;
		        this.$content.find('form').on('submit', function (e) {
		            e.preventDefault();
		            jc.$$formSubmit.trigger('click');
		        });
		    }
		});
	});
	

/************** CAMPOS CORRESPONDIENTES AL DIA 3: MIERCOLES  ***********/
	
	$('select#selectHoraInicio3').change(function() {
		var horaInicio = $("select#selectHoraInicio3").val();
		var tope = horaInicio.substring(0,2);
		for (indice = 11; indice < 24; indice++) {
			if(indice <= tope) {
				$("select#selectHoraFin3 option[value='"+indice+":00']").prop('disabled',true);
			} else {
				$("select#selectHoraFin3 option[value='"+indice+":00']").prop('disabled',false);
			}
		}
		var fin = parseInt(tope) + 1;
		$("select#selectHoraFin3 option[value='"+fin+":00']").prop('selected',true);
	});
	
	$('img#imgModificar3').click(function() {
		var horaInicio = $("select#selectHoraInicio3").val();
		var horaFin = $("select#selectHoraFin3").val();
		var sector = $("input#txtSector3").val();
		var aula = $("input#txtAula3").val();
		
		if((orig_horaInicio3 != horaInicio) || (orig_horaFin3 != horaFin) || (orig_sector3 != sector) || (orig_aula3 != aula)) {
			/* SE ENCONTRARON MODIFICACIONES EN LOS CAMPOS DEL DIA */
			var titulo = "\u00BFEst\u00E1 seguro que desea modificar el horario de clase correspondiente al Miercoles?";
			var contenido = "Confirme la modificaci\u00F3n del horario de clase: Desde "+horaInicio+" hs hasta "+horaFin+" hs en "+sector+"-"+aula;
			$.confirm({
			    title: titulo,
			    content: contenido,
			    buttons: {
			        confirmar: function () {
			        	$('input#accion').val('modificarclase');
			        	$('form#formModificarCursada').submit();
			        },
			        cancelar: function () {
			            return true;
			        }
			    }
			});
		} else {
			/* NO SE ENCONTRARON MODIFICACIONES EN LOS CAMPOS DEL DIA */
			$("h3#mensaje" ).remove();
			var mensaje = "No se realizaron modificaciones al horario de clases del dia Miercoles";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
	});
	
	$('img#imgBorrar3').click(function() {
		var titulo = "\u00BFEst\u00E1 seguro que desea borrar el horario de clase correspondiente al Miercoles?";
		$.confirm({
		    title: titulo,
		    content: '' +
		    	'<form action="" class="formName">' +
			    	'<div class="form-group">' +
			    	'<label>Indique si desea borrar el horario de clases para todas las carreras</label><br>' +
			    	'<input type="checkbox" id="checkbox" name="checkbox" required />' +
			    	'<label>Tildar para aplicar a todas las carreras</label>' +
			    	'</div>' +
		    	'</form>',
		    buttons: {
		    	formSubmit: {
	                text: 'Confirmar',
	                btnClass: 'btn-blue',
	                action: function () {
	                    var check = this.$content.find('#checkbox').is(":checked");
	                    if(check) {
	                    	$('input#aplicarTodas').val('true');
	                    } else {
	                    	$('input#aplicarTodas').val('false');
	                    }
	                    $('input#accion').val('borrarclase');
			        	$('form#formModificarCursada').submit();
                        return true;
	                }
	            },
		        cancelar: function () {
		            return true;
		        }
		    },
		    onContentReady: function () {
		        var jc = this;
		        this.$content.find('form').on('submit', function (e) {
		            e.preventDefault();
		            jc.$$formSubmit.trigger('click');
		        });
		    }
		});
	});

/************** CAMPOS CORRESPONDIENTES AL DIA 4: JUEVES  **************/
	
	$('select#selectHoraInicio4').change(function() {
		var horaInicio = $("select#selectHoraInicio4").val();
		var tope = horaInicio.substring(0,2);
		for (indice = 11; indice < 24; indice++) {
			if(indice <= tope) {
				$("select#selectHoraFin4 option[value='"+indice+":00']").prop('disabled',true);
			} else {
				$("select#selectHoraFin4 option[value='"+indice+":00']").prop('disabled',false);
			}
		}
		var fin = parseInt(tope) + 1;
		$("select#selectHoraFin4 option[value='"+fin+":00']").prop('selected',true);
	});
	
	$('img#imgModificar4').click(function() {
		var horaInicio = $("select#selectHoraInicio4").val();
		var horaFin = $("select#selectHoraFin4").val();
		var sector = $("input#txtSector4").val();
		var aula = $("input#txtAula4").val();
		
		if((orig_horaInicio4 != horaInicio) || (orig_horaFin4 != horaFin) || (orig_sector4 != sector) || (orig_aula4 != aula)) {
			/* SE ENCONTRARON MODIFICACIONES EN LOS CAMPOS DEL DIA */
			var titulo = "\u00BFEst\u00E1 seguro que desea modificar el horario de clase correspondiente al Jueves?";
			var contenido = "Confirme la modificaci\u00F3n del horario de clase: Desde "+horaInicio+" hs hasta "+horaFin+" hs en "+sector+"-"+aula;
			$.confirm({
			    title: titulo,
			    content: contenido,
			    buttons: {
			        confirmar: function () {
			        	$('input#accion').val('modificarclase');
			        	$('form#formModificarCursada').submit();
			        },
			        cancelar: function () {
			            return true;
			        }
			    }
			});
		} else {
			/* NO SE ENCONTRARON MODIFICACIONES EN LOS CAMPOS DEL DIA */
			$("h3#mensaje" ).remove();
			var mensaje = "No se realizaron modificaciones al horario de clases del dia Jueves";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
	});
	
	$('img#imgBorrar4').click(function() {
		var titulo = "\u00BFEst\u00E1 seguro que desea borrar el horario de clase correspondiente al Jueves?";
		$.confirm({
		    title: titulo,
		    content: '' +
		    	'<form action="" class="formName">' +
			    	'<div class="form-group">' +
			    	'<label>Indique si desea borrar el horario de clases para todas las carreras</label><br>' +
			    	'<input type="checkbox" id="checkbox" name="checkbox" required />' +
			    	'<label>Tildar para aplicar a todas las carreras</label>' +
			    	'</div>' +
		    	'</form>',
		    buttons: {
		    	formSubmit: {
	                text: 'Confirmar',
	                btnClass: 'btn-blue',
	                action: function () {
	                    var check = this.$content.find('#checkbox').is(":checked");
	                    if(check) {
	                    	$('input#aplicarTodas').val('true');
	                    } else {
	                    	$('input#aplicarTodas').val('false');
	                    }
	                    $('input#accion').val('borrarclase');
			        	$('form#formModificarCursada').submit();
                        return true;
	                }
	            },
		        cancelar: function () {
		            return true;
		        }
		    },
		    onContentReady: function () {
		        var jc = this;
		        this.$content.find('form').on('submit', function (e) {
		            e.preventDefault();
		            jc.$$formSubmit.trigger('click');
		        });
		    }
		});
	});

/************** CAMPOS CORRESPONDIENTES AL DIA 5: VIERNES  *************/

	$('select#selectHoraInicio5').change(function() {
		var horaInicio = $("select#selectHoraInicio5").val();
		var tope = horaInicio.substring(0,2);
		for (indice = 11; indice < 24; indice++) {
			if(indice <= tope) {
				$("select#selectHoraFin5 option[value='"+indice+":00']").prop('disabled',true);
			} else {
				$("select#selectHoraFin5 option[value='"+indice+":00']").prop('disabled',false);
			}
		}
		var fin = parseInt(tope) + 1;
		$("select#selectHoraFin5 option[value='"+fin+":00']").prop('selected',true);
	});
	
	$('img#imgModificar5').click(function() {
		var horaInicio = $("select#selectHoraInicio5").val();
		var horaFin = $("select#selectHoraFin5").val();
		var sector = $("input#txtSector5").val();
		var aula = $("input#txtAula5").val();
		
		if((orig_horaInicio5 != horaInicio) || (orig_horaFin5 != horaFin) || (orig_sector5 != sector) || (orig_aula5 != aula)) {
			/* SE ENCONTRARON MODIFICACIONES EN LOS CAMPOS DEL DIA */
			var titulo = "\u00BFEst\u00E1 seguro que desea modificar el horario de clase correspondiente al Viernes?";
			var contenido = "Confirme la modificaci\u00F3n del horario de clase: Desde "+horaInicio+" hs hasta "+horaFin+" hs en "+sector+"-"+aula;
			$.confirm({
			    title: titulo,
			    content: contenido,
			    buttons: {
			        confirmar: function () {
			        	$('input#accion').val('modificarclase');
			        	$('form#formModificarCursada').submit();
			        },
			        cancelar: function () {
			            return true;
			        }
			    }
			});
		} else {
			/* NO SE ENCONTRARON MODIFICACIONES EN LOS CAMPOS DEL DIA */
			$("h3#mensaje" ).remove();
			var mensaje = "No se realizaron modificaciones al horario de clases del dia Viernes";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
	});
	
	$('img#imgBorrar5').click(function() {
		var titulo = "\u00BFEst\u00E1 seguro que desea borrar el horario de clase correspondiente al Viernes?";
		$.confirm({
		    title: titulo,
		    content: '' +
		    	'<form action="" class="formName">' +
			    	'<div class="form-group">' +
			    	'<label>Indique si desea borrar el horario de clases para todas las carreras</label><br>' +
			    	'<input type="checkbox" id="checkbox" name="checkbox" required />' +
			    	'<label>Tildar para aplicar a todas las carreras</label>' +
			    	'</div>' +
		    	'</form>',
		    buttons: {
		    	formSubmit: {
	                text: 'Confirmar',
	                btnClass: 'btn-blue',
	                action: function () {
	                    var check = this.$content.find('#checkbox').is(":checked");
	                    if(check) {
	                    	$('input#aplicarTodas').val('true');
	                    } else {
	                    	$('input#aplicarTodas').val('false');
	                    }
	                    $('input#accion').val('borrarclase');
			        	$('form#formModificarCursada').submit();
                        return true;
	                }
	            },
		        cancelar: function () {
		            return true;
		        }
		    },
		    onContentReady: function () {
		        var jc = this;
		        this.$content.find('form').on('submit', function (e) {
		            e.preventDefault();
		            jc.$$formSubmit.trigger('click');
		        });
		    }
		
		});
	});
	
/************** CAMPOS CORRESPONDIENTES AL DIA 6: SABADO  **************/
	
	$('select#selectHoraInicio6').change(function() {
		var horaInicio = $("select#selectHoraInicio6").val();
		var tope = horaInicio.substring(0,2);
		for (indice = 11; indice < 24; indice++) {
			if(indice <= tope) {
				$("select#selectHoraFin6 option[value='"+indice+":00']").prop('disabled',true);
			} else {
				$("select#selectHoraFin6 option[value='"+indice+":00']").prop('disabled',false);
			}
		}
		var fin = parseInt(tope) + 1;
		$("select#selectHoraFin6 option[value='"+fin+":00']").prop('selected',true);
	});
	
	$('img#imgModificar6').click(function() {
		var horaInicio = $("select#selectHoraInicio6").val();
		var horaFin = $("select#selectHoraFin6").val();
		var sector = $("input#txtSector6").val();
		var aula = $("input#txtAula6").val();
		
		if((orig_horaInicio6 != horaInicio) || (orig_horaFin6 != horaFin) || (orig_sector6 != sector) || (orig_aula6 != aula)) {
			/* SE ENCONTRARON MODIFICACIONES EN LOS CAMPOS DEL DIA */
			var titulo = "\u00BFEst\u00E1 seguro que desea modificar el horario de clase correspondiente al S\u00E1bado?";
			var contenido = "Confirme la modificaci\u00F3n del horario de clase: Desde "+horaInicio+" hs hasta "+horaFin+" hs en "+sector+"-"+aula;
			$.confirm({
			    title: titulo,
			    content: contenido,
			    buttons: {
			        confirmar: function () {
			        	$('input#accion').val('modificarclase');
			        	$('form#formModificarCursada').submit();
			        },
			        cancelar: function () {
			            return true;
			        }
			    }
			});
		} else {
			/* NO SE ENCONTRARON MODIFICACIONES EN LOS CAMPOS DEL DIA */
			$("h3#mensaje" ).remove();
			var mensaje = "No se realizaron modificaciones al horario de clases del dia S\u00E1bado";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
	});
	
	$('img#imgBorrar6').click(function() {
		var titulo = "\u00BFEst\u00E1 seguro que desea borrar el horario de clase correspondiente al Sabado?";
		$.confirm({
		    title: titulo,
		    content: '' +
		    	'<form action="" class="formName">' +
			    	'<div class="form-group">' +
			    	'<label>Indique si desea borrar el horario de clases para todas las carreras</label><br>' +
			    	'<input type="checkbox" id="checkbox" name="checkbox" required />' +
			    	'<label>Tildar para aplicar a todas las carreras</label>' +
			    	'</div>' +
		    	'</form>',
		    buttons: {
		    	formSubmit: {
	                text: 'Confirmar',
	                btnClass: 'btn-blue',
	                action: function () {
	                    var check = this.$content.find('#checkbox').is(":checked");
	                    if(check) {
	                    	$('input#aplicarTodas').val('true');
	                    } else {
	                    	$('input#aplicarTodas').val('false');
	                    }
	                    $('input#accion').val('borrarclase');
			        	$('form#formModificarCursada').submit();
                        return true;
	                }
	            },
		        cancelar: function () {
		            return true;
		        }
		    },
		    onContentReady: function () {
		        var jc = this;
		        this.$content.find('form').on('submit', function (e) {
		            e.preventDefault();
		            jc.$$formSubmit.trigger('click');
		        });
		    }
		});
	});
	
	$('img#imgCrear6').click(function() {
		var sector = $("input#txtSector6").val();
		var aula = $("input#txtAula6").val();
		if(sector != null && aula != null) {
			var titulo = "\u00BFEst\u00E1 seguro que desea crear el horario de clase correspondiente al Viernes?";
			var contenido = "Confirme la creaci\u00F3n del horario de clase";
			$.confirm({});
		} else {
			
		}
	});
		
});