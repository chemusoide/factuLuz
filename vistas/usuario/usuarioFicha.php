<?php

    if (defined("SECURITY_CONSTANT")) {

        $bodyId = "usuarioFicha";
        $pageTitle = "Ficha de usuario";
        $action = "index.php?controlador=usuario&amp;";
        
        if ( isset($usuario) ) {
        	
        	$pageTitle = $pageTitle . " :: " . $usuario->getUsuarioNombre();
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

    		if ( $('#usuario_nombre').val() == "" ) {
        		alert("El campo 'Nombre' no puede estar vacío");
        		$('#usuario_nombre').focus();
        		return false;
    		}

    		if ( !validarPassword() )
        		return false;

    		return confirm("¿Está seguro?");

        }

        function validarPassword() {

        	if ( $('#usuario_password').val() == "" ) {
        		alert("El campo 'Contraseña' no puede estar vacío");
        		$('#usuario_password').focus();
        		return false;
    		}

        	if ( $('#usuario_password').val().length < 6 ) {
        		alert("El campo 'Contraseña' ha de ser de, mínimo, 6 caracteres");
        		$('#usuario_password').focus();
        		return false;
    		}

        	if ( $('#usuario_password').val() != $('#usuario_password_confirm').val() ) {
        		alert("El campo 'Contraseña' no coincide con el campo 'Confirmar contraseña'");
        		$('#usuario_password').focus();
        		return false;
    		}

    		return true;

        }

        <?php if ( isset($usuario) ) { ?>
        function confirmarEliminacion() {

			return confirm("¿Está seguro de que desea borrar al usuario '<?php echo $usuario->getUsuarioNombre() ?>'?");
			
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
        
        <div id="fichaUsuario">
        
        	<p><a href="index.php?controlador=usuario&amp;opcion=listado"><img alt="Volver al listado de usuarios" src="img/usuarios_32x32.png"/> Volver al listado de usuarios</a></p>
        
        	<form class="ficha" method="post" action="<?php echo $action ?>" onsubmit="return validarForm(this)">
        		<fieldset>
        			<legend>Formulario de creación/edición de usuarios</legend>
        			<p>
        				<label for="usuario_nombre">Nombre del usuario:</label>
        				<input type="text" name="usuario_nombre" id="usuario_nombre" value="<?php if ( isset($usuario) ) { echo $usuario->getUsuarioNombre(); } ?>" />
    				</p>
    				<?php if ( isset($usuario) ) { ?>
    				<input type="hidden" name="usuario_id" value="<?php echo $usuario->getUsuarioId() ?>" />
    				<?php } else { ?>
    				<p>
        				<label for="usuario_password">Contraseña:</label>
        				<input type="password" name="usuario_password" id="usuario_password" />
    				</p>
    				<p>
        				<label for="usuario_password_confirm">Confirmar contraseña:</label>
        				<input type="password" name="usuario_password_confirm" id="usuario_password_confirm" />
    				</p>
    				<?php } ?>
    				<p>
    					<?php if ( isset($usuario) ) { ?>
    					<input type="submit" value="Modificar usuario" />
    					<?php } else { ?>
    					<input type="submit" value="Crear usuario" />
    					<?php } ?>
					</p>
        		</fieldset>
        	</form>
        	
        	<?php if ( isset($usuario) ) { ?>
        	<form class="ficha" method="post" action="index.php?controlador=usuario&amp;opcion=cambiarPassword" onsubmit="return validarPassword() && confirm('¿Está seguro?')">
        		<fieldset>
        			<legend>Cambiar contraseña</legend>
        			<input type="hidden" name="usuario_id" value="<?php echo $usuario->getUsuarioId() ?>" />
        			<p>
        				<label for="usuario_password">Contraseña:</label>
        				<input type="password" name="usuario_password" id="usuario_password" />
    				</p>
    				<p>
        				<label for="usuario_password_confirm">Confirmar contraseña:</label>
        				<input type="password" name="usuario_password_confirm" id="usuario_password_confirm" />
    				</p>
    				<p>
        				<input type="submit" value="Cambiar contraseña" />
    				</p>
        		</fieldset>
        	</form>
        	
        	<form class="ficha" method="post" action="index.php?controlador=usuario&amp;opcion=eliminacion" onsubmit="return confirmarEliminacion()">
        		<fieldset>
        			<legend>Eliminación del usuario</legend>
        			<input type="hidden" name="usuario_id" value="<?php echo $usuario->getUsuarioId() ?>" />
        			<p>
        				<input type="submit" value="Eliminar usuario" />
    				</p>
        		</fieldset>
        	</form>
        	<?php } ?>
        	
        	<p><a href="index.php?controlador=usuario&amp;opcion=listado"><img alt="Volver al listado de usuarios" src="img/usuarios_32x32.png"/> Volver al listado de usuarios</a></p>
        
        </div>
<?php
        
        require_once(SKEL_DIR . "/bodyEnd.php");
        
        require_once(SKEL_DIR . "/pie.php");

    }

?>
