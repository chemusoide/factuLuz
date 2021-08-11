    <body id="<?php echo $bodyId ?>">
        <div id="contenedorLogo">
            <img src="img/logo.png" alt="Logo" />
        </div>
        <?php 
        /**************************************
         ** Para que muestre la fecha en local *
        **************************************/
        date_default_timezone_set('Europe/Madrid');
        ?>
        <?php if ( isset($_SESSION["usuario_id"]) ) { ?>
        <p class="derecha">
        	<strong>
        		<?php echo $_SESSION["usuario_nombre"]; ?>
        		<?php if (!empty($_SESSION["anterior_bd"])) echo " <span style='color: red; font-size: 25px; boder: 2px solid red; padding: 5px;'>(" . str_replace("educalia_", "", $_SESSION["anterior_bd"]) . ")</span>"; ?>
        	</strong>
        	 | <a href="index.php?controlador=usuario&amp;opcion=logout" onclick="return confirm('¿Seguro que desea salir?')">cerrar sesión</a>
        	 | <?php echo date("d-m-Y"); ?>
    	</p>
    	<?php } ?>
    	
    	<?php
    	
    	    if ( isset($_SESSION["mensaje"]) ) {

    	        $claseMensaje = "";
    	        
    	        if ( strpos($_SESSION["mensaje"], "Error:") !== false )
    	            $claseMensaje = "errorMensaje";
    	            
	            if ( strpos($_SESSION["mensaje"], "Info:") !== false )
    	            $claseMensaje = "infoMensaje";
        
        ?>    		
    	<!-- Mensajes de error o informativos -->
    	<div id="mensaje" class="<?php echo $claseMensaje ?>"><?php echo $_SESSION["mensaje"] ?></div>
    	<?php
    	
    	        unset( $_SESSION["mensaje"] );
    	    
    	    }
    	    
	    ?>