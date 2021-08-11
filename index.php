<?php

    // Constante de seguridad. Si alguna vista se intenta cargar fuera del index.php,
    // esta constante no existirá y no mostraremos nada
    define("SECURITY_CONSTANT", "arturo");
    
    session_name("factuWeb");
    session_start();

    require_once("config.php");
    //Añadido Chema 02.01.2017 - Solucionar problema Fecha Serie Factura. Archivos: config.php e index.php - Begin
	$nombre_bd = $_SESSION["anterior_bd"];
	
	if ($nombre_bd == ""){
		
		define ("SERIE_NORMAL", ANO_ACTUAL."L");
		
		define ("SERIE_RECTIFICATIVA", "R".ANO_ACTUAL."L");
		
	}else{
		
		$nombre_bd_dividida = explode(NOMBRE_BD_SIN_ANO, $nombre_bd);
		
		$fecha_bd = $nombre_bd_dividida[1];
		
		define ("SERIE_NORMAL", $fecha_bd."L");
		
		define ("SERIE_RECTIFICATIVA", "R".$fecha_bd."L");
		
	}
	
//Añadido Chema 02.01.2017 - Solucionar problema Fecha Serie Factura - End
    
    $allowedControllers = unserialize(ALLOWED_CONTROLLERS);
        
    if ( isset($_SESSION["usuario_id"]) ) {
    
        if ( isset($_GET["controlador"]) && $_GET["controlador"] != "" ) {
        
            if ( in_array($_GET["controlador"], $allowedControllers, true) ) {
    
                require_once(CONTROLLERS_DIR . "/" . $_GET["controlador"] . "Controller.php");
    
            } else {
            
                echo "<p>Controlador no permitido " . urlencode( $_GET["controlador"] ) . "</p>";
    
            }
                
        } else {
    
            header("Location: index.php?controlador=factura&opcion=listado");
    
        }
        
    } else {
        
        // Autenticación...
        if ( isset($_POST["usuario_nombre"]) && isset($_POST["usuario_password"]) ) {
            
            require_once(CONTROLLERS_DIR . "/usuarioController.php");
        
        } else {
                            
            require_once(VIEWS_DIR . "/login.php");
            
        }
                	    
    }
    
?>