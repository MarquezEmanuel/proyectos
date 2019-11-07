/**
 *  Controla los eventos del archivo cursada_importar.php
 *  
 *  @see jQuery
 *   
 *  @author Marquez Emanuel
 */

$(document).ready(function() {
	
	/** Inicializa la tabla para presentar las cursadas */
	
	$("table#tablaImportarCursadas").DataTable({
		dom: 'Bfrtip',
        buttons: [
        	{
    		extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            download: 'open',
            text: 'Descargar PDF',
            title: ' Mesas de Examen '
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
	
});