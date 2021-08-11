<?php
    
    if (defined("SECURITY_CONSTANT")) {
        
        include_once(DAO_DIR . "/config/ConfigDAO.php");

    	$configDAO = new ConfigDAO();
    	
    	if (isset($_GET["opcion"])) {
    	
	        switch ($_GET["opcion"]) {
		                
	            case "consulta":
	            	
	            	$config = $configDAO->obtenerRegistro();
	                require_once(VIEWS_DIR . "/config/configFicha.php");
	                break;
	                	                
	            case "modificacion":
	            	
	                $registro = new DatosConfig();
	                $registro->setConfigId($_POST["config_id"]);
	                $registro->setConfigInfobancaria($_POST["config_infobancaria"]);
	                $registro->setConfigInfobancaria2($_POST["config_infobancaria2"]);
	                
	                $configDAO->modificarRegistro($registro);
	                $_SESSION["mensaje"] = "Info: Configuración modificada exitosamente.";
	                header("Location: index.php?controlador=config&opcion=consulta");
	            	break;
	                	            	
                default:
	            	
	                $config = $configDAO->obtenerRegistro();
	                require_once(VIEWS_DIR . "/config/configFicha.php");
	
	        }
	        
    	} else {
    		
    		$configs = $configDAO->obtenerTodosLosRegistros();
            require_once(VIEWS_DIR . "/config/configListado.php");
    		
    	}

    }

?>