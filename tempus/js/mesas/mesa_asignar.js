/**
 * 
 */

$(document).ready(function() {
	
	$("table#tablaAsignarAulas").DataTable({
		dom: 'Bfrtip',
		buttons: [
        	{
	    		extend: 'pdfHtml5',
	            orientation: 'portrait',
	            pageSize: 'LEGAL',
	            download: 'open',
	            text: 'Descargar PDF',
	            title: ' Listado de mesas de examen sin asignar aula ',
	            exportOptions: {
                    columns: [1, 2]
                },
                customize: function (doc) {
                    doc.pageMargins = [20,20,20,20];
                    doc.defaultStyle.fontSize = 11;
                    doc.styles.tableHeader.fontSize = 11;
                    doc.styles.title.fontSize = 14;
                    doc.content[0].text = doc.content[0].text.trim(); // Remove spaces around page title
                    doc['footer']=(function(page, pages) {
                        return {
                        	columns: [
                        		'UNPA-UARG: Documento generado con TEMPUS',
                                {
                        			alignment: 'right',  // This is the right column
                                    text: [{ text: page.toString() },  ' de ', { text: pages.toString() }]
                                }
                            ],
                            margin: [10, 0]
                        }
                    });
                }
        	}
        ],
        language: {
			processing: "Procesando...",
	        search: "Buscar:",
            lengthMenu: "Viendo _MENU_ regristros por página",
            zeroRecords: "Sin resultados",
            info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(Filtrado de _MAX_ registros totales)",
            loadingRecords: "Cargando registros...",
            emptyTable: "Sin resultados",
            paginate: {
                previous: "Anterior",
                next: "Siguiente"
            }
       }
	});
	
	$('input#radMesa').change(function() {
		var seleccionada = $('input#radMesa:checked').val();
		$("input#radMesa").each(function (indice) { 
			$('input#imgAsignar'+indice).css("display", "none");
		});
		$('input#imgAsignar'+seleccionada).css("display", "block");
	});
	
	
});