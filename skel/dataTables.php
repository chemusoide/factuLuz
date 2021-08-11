		
		<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
		<script type="text/javascript">
		/* <![CDATA[ */
		        
            $(document).ready(function() {
            	$('.listado').dataTable({
            		"aaSorting": [],
            		"aLengthMenu": [[50, -1], [50, "Todo"]],
            		"iDisplayLength": 50,
           			"oLanguage": {
           			    "sProcessing":   "Procesando...",
           			    "sLengthMenu":   "Mostrar _MENU_ registros",
           			    "sZeroRecords":  "No se encontraron resultados",
           			    "sInfo":         "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
           			    "sInfoEmpty":    "Mostrando desde 0 hasta 0 de 0 registros",
           			    "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
           			    "sInfoPostFix":  "",
           			    "sSearch":       "Buscar:",
           			    "sUrl":          "",
           			    "oPaginate": {
           			        "sFirst":    "Primero",
           			        "sPrevious": "Anterior",
           			        "sNext":     "Siguiente",
           			        "sLast":     "Último"
           			    }
           			}
            	});
            });
            
		/* ]]> */
		</script>
		