<?php

    if (defined("SECURITY_CONSTANT")) {

        $bodyId = "tipoIrpfFicha";
        $pageTitle = "Ficha de tipoIrpf";
        $action = "index.php?controlador=tipoIrpf&amp;";
        
        if ( isset($tipoIrpf) ) {
        	
        	$pageTitle = $pageTitle . " :: " . $tipoIrpf->getTipoIrpfNombre();
        	$action = $action . "opcion=modificacion";
        	
        } else {
        	
        	$pageTitle = $pageTitle . " :: NUEVO";
        	$action = $action . "opcion=creacion";
        	
        }

        require_once(SKEL_DIR . "/cabecera.php");
        
        require_once(SKEL_DIR . "/headStart.php");
        
?>

		<!-- Validaciones JQuery -->
		<script type="text/javascript">
		/* <![CDATA[ */

		function validarForm(f) {

    		if ( $('#tipoIrpf_nombre').val() == "" ) {
        		alert("El campo 'Nombre' no puede estar vacío");
        		$('#tipoIrpf_nombre').focus();
        		return false;
    		}

    		if ( $('#tipoIrpf_porcentaje').val() == "" ) {
        		alert("El campo 'porcentaje' no puede estar vacío");
        		$('#tipoIrpf_porcentaje').focus();
        		return false;
    		}

    		if ( $('#tipoIrpf_porcentaje').val() < 0 || $('#tipoIrpf_porcentaje').val() > 100 || isNaN($('#tipoIrpf_porcentaje').val()) ) {
        		alert("El campo 'porcentaje' ha de ser un número entre 0 y 100");
        		$('#tipoIrpf_porcentaje').focus();
        		return false;
    		}

    		return confirm("¿Está seguro?");

        }

        <?php if ( isset($tipoIrpf) ) { ?>
        function confirmarEliminacion() {

			return confirm("¿Está seguro de que desea borrar al tipo de IRPF '<?php echo $tipoIrpf->getTipoIrpfNombre() ?>'?");
			
        }
        <?php } ?>
                 
        /* ]]> */
		</script>

<?php
        
        require_once(SKEL_DIR . "/headEnd.php");
        
        require_once(SKEL_DIR . "/bodyStart.php");
        
        require_once(SKEL_DIR . "/menu.php");

?>
        <h1><?php echo $pageTitle ?></h1>
        
        <div id="fichaTipoIrpf">
        
        	<p><a href="index.php?controlador=tipoIrpf&amp;opcion=listado">Volver al listado de tipos de IRPF</a></p>
        
        	<form class="ficha" method="post" action="<?php echo $action ?>" onsubmit="return validarForm(this)">
        		<fieldset>
        			<legend>Formulario de creación/edición de tipos de IRPF</legend>
        			<p>
        				<label for="tipoIrpf_nombre">Nombre del tipo de IRPF:</label>
        				<input type="text" name="tipoIrpf_nombre" id="tipoIrpf_nombre" value="<?php if ( isset($tipoIrpf) ) { echo $tipoIrpf->getTipoIrpfNombre(); } ?>" />
    				</p>
    				<p>
        				<label for="tipoIrpf_porcentaje">Porcentaje del tipo de IRPF:</label>
        				<input type="text" name="tipoIrpf_porcentaje" id="tipoIrpf_porcentaje" value="<?php if ( isset($tipoIrpf) ) { echo $tipoIrpf->getTipoIrpfPorcentaje(); } ?>" />
    				</p>
    				<?php if ( isset($tipoIrpf) ) { ?>
    				<input type="hidden" name="tipoIrpf_id" value="<?php echo $tipoIrpf->getTipoIrpfId() ?>" />
    				<?php } ?>
    				<p>
    					<?php if ( isset($tipoIrpf) ) { ?>
    					<input type="submit" value="Modificar tipo de IRPF" />
    					<?php } else { ?>
    					<input type="submit" value="Crear tipo de IRPF" />
    					<?php } ?>
					</p>
        		</fieldset>
        	</form>
        	
			<?php if ( isset($tipoIrpf) ) { ?>
        	<form class="ficha" method="post" action="index.php?controlador=tipoIrpf&amp;opcion=eliminacion" onsubmit="return confirmarEliminacion()">
        		<fieldset>
        			<legend>Eliminación del tipo IRPF</legend>
        			<input type="hidden" name="tipoIrpf_id" value="<?php echo $tipoIrpf->getTipoIrpfId() ?>" />
        			<p>
        				<input type="submit" value="Eliminar tipo de IRPF" />
    				</p>
        		</fieldset>
        	</form>
        	<?php } ?>
        	
        	<p><a href="index.php?controlador=tipoIrpf&amp;opcion=listado">Volver al listado de tipos de IRPF</a></p>
        
        </div>
<?php
        
        require_once(SKEL_DIR . "/bodyEnd.php");
        
        require_once(SKEL_DIR . "/pie.php");

    }

?>
