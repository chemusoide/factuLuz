<?php

    if (defined("SECURITY_CONSTANT")) {

        $bodyId = "login";
        $pageTitle = "Página de autenticación";

        require_once(SKEL_DIR . "/cabecera.php");
        
        require_once(SKEL_DIR . "/headStart.php");
        require_once(SKEL_DIR . "/headEnd.php");
        
        require_once(SKEL_DIR . "/bodyStart.php");
        
?>
		<h1><?php echo $pageTitle ?></h1>
		
		<div id="formLogin">
        
        	<form class="ficha" method="post" action="index.php?controlador=usuario&amp;opcion=login" onsubmit="return validarForm(this)">
        		<fieldset>
        			<legend>Datos de usuario</legend>
        			<p>
        				<label for="usuario_nombre">Nombre de usuario:</label>
        				<input type="text" name="usuario_nombre" id="usuario_nombre" />
    				</p>
    				<p>
        				<label for="usuario_password">Contraseña:</label>
        				<input type="password" name="usuario_password" id="usuario_password" />
    				</p>
    				<p>
    					<label for="anterior_bd">Seleccione base de datos:</label>
    					<select id="anterior_bd" name="anterior_bd">
    						<option value=""><?php echo str_replace("educalia_", "", DB_DATABASE) ?></option>
    						<?php
    							$oldDatabases = unserialize(DB_OLD_DATABASES);
    							foreach ($oldDatabases as $db) {
							?>
    						<option value="<?php echo $db ?>"><?php echo str_replace("educalia_", "", $db) ?></option>
    						<?php
								}
							?>
    					</select>
    				</p>
    				<p>
    					<input type="submit" value="Entrar" />
					</p>
        		</fieldset>
        	</form>
    	
    	</div>
<?php
        
        require_once(SKEL_DIR . "/bodyEnd.php");
        
        require_once(SKEL_DIR . "/pie.php");

    }

?>