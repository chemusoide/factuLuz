<?php

    if (defined("SECURITY_CONSTANT")) {

        $bodyId = "tipoIvaFicha";
        $pageTitle = "Ficha de tipoIva";
        $action = "index.php?controlador=tipoIva&amp;";
        
        if ( isset($tipoIva) ) {
        	
        	$pageTitle = $pageTitle . " :: " . $tipoIva->getTipoIvaNombre();
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

    		if ( $('#tipoIva_nombre').val() == "" ) {
        		alert("El campo 'Nombre' no puede estar vacío");
        		$('#tipoIva_nombre').focus();
        		return false;
    		}

    		if ( $('#tipoIva_porcentaje').val() == "" ) {
        		alert("El campo 'porcentaje' no puede estar vacío");
        		$('#tipoIva_porcentaje').focus();
        		return false;
    		}

    		if ( $('#tipoIva_porcentaje').val() < 0 || $('#tipoIva_porcentaje').val() > 100 || isNaN($('#tipoIva_porcentaje').val()) ) {
        		alert("El campo 'porcentaje' ha de ser un número entre 0 y 100");
        		$('#tipoIva_porcentaje').focus();
        		return false;
    		}

    		return confirm("¿Está seguro?");

        }

        <?php if ( isset($tipoIva) ) { ?>
        function confirmarEliminacion() {

			return confirm("¿Está seguro de que desea borrar al tipo de IVA '<?php echo $tipoIva->getTipoIvaNombre() ?>'?");
			
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
        
        <div id="fichaTipoIva">
        
        	<p><a href="index.php?controlador=tipoIva&amp;opcion=listado">Volver al listado de tipos de IVA</a></p>
        
        	<form class="ficha" method="post" action="<?php echo $action ?>" onsubmit="return validarForm(this)">
        		<fieldset>
        			<legend>Formulario de creación/edición de tipos de IVA</legend>
        			<p>
        				<label for="tipoIva_nombre">Nombre del tipo de IVA:</label>
        				<input type="text" name="tipoIva_nombre" id="tipoIva_nombre" value="<?php if ( isset($tipoIva) ) { echo $tipoIva->getTipoIvaNombre(); } ?>" />
    				</p>
    				<p>
        				<label for="tipoIva_porcentaje">Porcentaje del tipo de IVA:</label>
        				<input type="text" name="tipoIva_porcentaje" id="tipoIva_porcentaje" value="<?php if ( isset($tipoIva) ) { echo $tipoIva->getTipoIvaPorcentaje(); } ?>" />
    				</p>
    				<?php if ( isset($tipoIva) ) { ?>
    				<input type="hidden" name="tipoIva_id" value="<?php echo $tipoIva->getTipoIvaId() ?>" />
    				<?php } ?>
    				<p>
    					<?php if ( isset($tipoIva) ) { ?>
    					<input type="submit" value="Modificar tipo de IVA" />
    					<?php } else { ?>
    					<input type="submit" value="Crear tipo de IVA" />
    					<?php } ?>
					</p>
        		</fieldset>
        	</form>
        	
			<?php if ( isset($tipoIva) ) { ?>
        	<form class="ficha" method="post" action="index.php?controlador=tipoIva&amp;opcion=eliminacion" onsubmit="return confirmarEliminacion()">
        		<fieldset>
        			<legend>Eliminación del tipo IVA</legend>
        			<input type="hidden" name="tipoIva_id" value="<?php echo $tipoIva->getTipoIvaId() ?>" />
        			<p>
        				<input type="submit" value="Eliminar tipo de IVA" />
    				</p>
        		</fieldset>
        	</form>
        	<?php } ?>
        	
        	<p><a href="index.php?controlador=tipoIva&amp;opcion=listado">Volver al listado de tipos de IVA</a></p>
        
        </div>
<?php
        
        require_once(SKEL_DIR . "/bodyEnd.php");
        
        require_once(SKEL_DIR . "/pie.php");

    }

?>
