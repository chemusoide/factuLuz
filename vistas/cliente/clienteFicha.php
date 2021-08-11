<?php

    if (defined("SECURITY_CONSTANT")) {

        $bodyId = "clienteFicha";
        $pageTitle = "Ficha de cliente";
        $action = "index.php?controlador=cliente&amp;";
        
        if ( isset($cliente) ) {
        	
        	$pageTitle = $pageTitle . " :: " . $cliente->getClienteNombre();
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

    		if ( $('#cliente_nombre').val() == "" ) {
        		alert("El campo 'Nombre' no puede estar vacío");
        		$('#cliente_nombre').focus();
        		return false;
    		}

    		if ( $('#cliente_nif').val() == "" ) {
        		alert("El campo 'NIF/CIF' no puede estar vacío");
        		$('#cliente_nif').focus();
        		return false;
    		}

    		if ( $('#cliente_direccion').val() == "" ) {
        		alert("El campo 'Dirección fiscal' no puede estar vacío");
        		$('#cliente_direccion').focus();
        		return false;
    		}

    		return confirm("¿Está seguro?");

        }

        <?php if ( isset($cliente) ) { ?>
        function confirmarEliminacion() {

			return confirm("¿Está seguro de que desea borrar al cliente '<?php echo $cliente->getClienteNombre() ?>'?");
			
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
        
        <div id="fichaCliente">
        
        	<p><a href="index.php?controlador=cliente&amp;opcion=listado">Volver al listado de clientes</a></p>
        
        	<?php if ( isset($cliente) ) { ?>
        
        	<ul>
        		<li>
            		<a href="index.php?controlador=factura&amp;opcion=facturasPendientesCliente&amp;idcliente=<?php echo $cliente->getClienteId() ?>">
            			Consultar facturas pendientes de pago del cliente
        			</a>
    			</li>
    			<li>
            		<a href="index.php?controlador=factura&amp;opcion=facturasCliente&amp;idcliente=<?php echo $cliente->getClienteId() ?>">
            			Consultar todas las facturas del cliente
        			</a>
    			</li>
    			<li>
            		<a href="index.php?controlador=factura&amp;opcion=precreacion&amp;factura_tipo=servicio&amp;idcliente=<?php echo $cliente->getClienteId() ?>">
            			Nueva factura servicio clínica
        			</a>
    			</li>
    			<li>
            		<a href="index.php?controlador=factura&amp;opcion=precreacion&amp;factura_tipo=quirofano&amp;idcliente=<?php echo $cliente->getClienteId() ?>">
            			Nueva factura servicio quirófano
        			</a>
    			</li>
			</ul>
			
			<?php } ?>
        
        	<form class="ficha" method="post" action="<?php echo $action ?>" onsubmit="return validarForm(this)">
        		<fieldset>
        			<legend>Formulario de creación/edición de clientes</legend>
        			<p>
        				<label for="cliente_nombre">Nombre *:</label>
        				<input type="text" class="input_ancho" name="cliente_nombre" id="cliente_nombre" value="<?php if ( isset($cliente) ) { echo $cliente->getClienteNombre(); } ?>" />
    				</p>
    				<p>
        				<label for="cliente_nif">NIF/CIF *:</label>
        				<input type="text" name="cliente_nif" id="cliente_nif" value="<?php if ( isset($cliente) ) { echo $cliente->getClienteNif(); } ?>" />
    				</p>
    				<?php if ( isset($cliente) ) { ?>
    				<p>
    					<label for="cliente_fechacreacion">Fecha de alta:</label>
    					<input readonly="readonly" type="text" name="cliente_fechacreacion" id="cliente_fechacreacion" value="<?php echo $cliente->getClienteFechacreacion() ?>" />
    				</p>
    				<p>
        				<label for="cliente_activo">Activo ?:</label>
    					<input <?php if ( $cliente->getClienteActivo() == 1 ) { echo "checked=\"checked\""; } ?> type="checkbox" name="cliente_activo" id="cliente_activo" value="1" />
        			</p>
    				<input type="hidden" name="cliente_id" value="<?php echo $cliente->getClienteId() ?>" />
    				<?php } ?>
    				<p>
        				<label for="cliente_direccion">Dirección fiscal *:</label>
        				<input type="text" class="input_ancho" name="cliente_direccion" id="cliente_direccion" value="<?php if ( isset($cliente) ) { echo $cliente->getClienteDireccion(); } ?>" />
    				</p>
    				<p>
        				<label for="cliente_direccionfacturas">Dirección de envío de facturas:</label>
        				<input type="text" class="input_ancho" name="cliente_direccionfacturas" id="cliente_direccionfacturas" value="<?php if ( isset($cliente) ) { echo $cliente->getClienteDireccionfacturas(); } ?>" />
    				</p>
    				<p>
        				<label for="cliente_personacontacto">Persona de contacto:</label>
        				<input type="text" class="input_ancho" name="cliente_personacontacto" id="cliente_personacontacto" value="<?php if ( isset($cliente) ) { echo $cliente->getClientePersonacontacto(); } ?>" />
    				</p>
    				<p>
        				<label for="cliente_emails">Dirección/es de correo electrónico:</label>
        				<textarea rows="" cols="" name="cliente_emails" id="cliente_emails"><?php if ( isset($cliente) ) { echo $cliente->getClienteEmails(); } ?></textarea>
        			</p>
        			<p>
        				<label for="cliente_telefonos">Teléfono/s:</label>
        				<textarea rows="" cols="" name="cliente_telefonos" id="cliente_telefonos"><?php if ( isset($cliente) ) { echo $cliente->getClienteTelefonos(); } ?></textarea>
        			</p>
        			<p>
        				<label for="cliente_fax">Fax:</label>
        				<input type="text" name="cliente_fax" id="cliente_fax" value="<?php if ( isset($cliente) ) { echo $cliente->getClienteFax(); } ?>" />
    				</p>
    				<p>
        				<label for="cliente_infobancaria">Información bancaria:</label>
        				<textarea rows="" cols="" name="cliente_infobancaria" id="cliente_infobancaria"><?php if ( isset($cliente) ) { echo $cliente->getClienteInfobancaria(); } ?></textarea>
        			</p>
    				<p>
        				<label for="cliente_observaciones">Observaciones:</label>
        				<textarea rows="" cols="" name="cliente_observaciones" id="cliente_observaciones"><?php if ( isset($cliente) ) { echo $cliente->getClienteObservaciones(); } ?></textarea>
        			</p>
    				<p>
    					<?php if ( isset($cliente) ) { ?>
    					<input type="submit" value="Modificar cliente" />
    					<?php } else { ?>
    					<input type="submit" value="Crear cliente" />
    					<?php } ?>
					</p>
        		</fieldset>
        	</form>        	
        	
			<?php if ( isset($cliente) ) { ?>
        	
<!--        	<form class="ficha" method="post" action="index.php?controlador=cliente&amp;opcion=eliminacion" onsubmit="return confirmarEliminacion()">-->
<!--        		<fieldset>-->
<!--        			<legend>Eliminación del cliente</legend>-->
<!--        			<input type="hidden" name="cliente_id" value="<?php echo $cliente->getClienteId() ?>" />-->
<!--        			<p>-->
<!--        				<input type="submit" value="Eliminar cliente" />-->
<!--    				</p>-->
<!--        		</fieldset>-->
<!--        	</form>-->
        	
        	<?php } ?>
        	
        	<p><a href="index.php?controlador=cliente&amp;opcion=listado">Volver al listado de clientes</a></p>
        
        </div>
<?php
        
        require_once(SKEL_DIR . "/bodyEnd.php");
        
        require_once(SKEL_DIR . "/pie.php");

    }

?>
