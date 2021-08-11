<?php

    if (defined("SECURITY_CONSTANT")) {

        $bodyId = "configFicha";
        $pageTitle = "Ficha de configuración";
        $action = "index.php?controlador=config&amp;";
        
        if ( isset($config) ) {
        	
        	$action = $action . "opcion=modificacion";
        	
        } else {
        	
        	$action = $action . "opcion=creacion";
        	
        }

        require_once(SKEL_DIR . "/cabecera.php");
        
        require_once(SKEL_DIR . "/headStart.php");
        
?>

		<!-- Validaciones JQuery -->
		<script type="text/javascript">
		/* <![CDATA[ */

		function validarForm(f) {

    		return confirm("¿Está seguro?");

        }
                 
        /* ]]> */
		</script>

<?php
        
        require_once(SKEL_DIR . "/headEnd.php");
        
        require_once(SKEL_DIR . "/bodyStart.php");
        
        require_once(SKEL_DIR . "/menu.php");

?>
        <h1><?php echo $pageTitle ?></h1>
        
        <div id="fichaConfig">
                
        	<form class="ficha" method="post" action="<?php echo $action ?>" onsubmit="return validarForm(this)">
        		<fieldset>
        			<legend>Formulario de edición de la configuración</legend>
        			<p>
        				<label for="config_infobancaria">Información bancaria 1:</label>
        				<textarea rows="" cols="" name="config_infobancaria" id="config_infobancaria"><?php if ( isset($config) ) { echo $config->getConfigInfobancaria(); } ?></textarea>
        			</p>
        			<p>
        				<label for="config_infobancaria2">Información bancaria 2:</label>
        				<textarea rows="" cols="" name="config_infobancaria2" id="config_infobancaria2"><?php if ( isset($config) ) { echo $config->getConfigInfobancaria2(); } ?></textarea>
        			</p>
    				<?php if ( isset($config) ) { ?>
    				<input type="hidden" name="config_id" value="<?php echo $config->getConfigId() ?>" />
    				<?php } ?>
    				<p>
    					<?php if ( isset($config) ) { ?>
    					<input type="submit" value="Modificar configuración" />
    					<?php } else { ?>
    					<input type="submit" value="Crear configuración" />
    					<?php } ?>
					</p>
        		</fieldset>
        	</form>
        	        
        </div>
<?php
        
        require_once(SKEL_DIR . "/bodyEnd.php");
        
        require_once(SKEL_DIR . "/pie.php");

    }

?>
