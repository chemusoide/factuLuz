<?php
    
    if (defined("SECURITY_CONSTANT")) {
        
        include_once(DAO_DIR . "/tipoIva/TipoIvaDAO.php");

    	$tipoIvaDAO = new TipoIvaDAO();
    	
    	if (isset($_GET["opcion"])) {
    	
	        switch ($_GET["opcion"]) {
	
	            case "listado":
	            
	                $tipoIvas = $tipoIvaDAO->obtenerTodosLosRegistros();
	                require_once(VIEWS_DIR . "/tipoIva/tipoIvaListado.php");
	                break;
	                
	            case "consulta":
	            	
	            	$tipoIva = $tipoIvaDAO->obtenerRegistro($_GET["id"]);
	                require_once(VIEWS_DIR . "/tipoIva/tipoIvaFicha.php");
	                break;
	                
	            case "precreacion":
	                
	            	require_once(VIEWS_DIR . "/tipoIva/tipoIvaFicha.php");
	                break;
	                
                case "creacion":
                	
	                $registro = new DatosTipoIva();
	                $registro->setTipoIvaNombre($_POST["tipoIva_nombre"]);
	                $registro->setTipoIvaPorcentaje($_POST["tipoIva_porcentaje"]);
	                
	                $tipoIvaDAO->crearRegistro($registro);
	                $_SESSION["mensaje"] = "Info: tipo de IVA '" . $registro->getTipoIvaNombre() . "' creado exitosamente.";
	                header("Location: index.php?controlador=tipoIva&opcion=listado");
	            	break;
	                
	            case "modificacion":
	            	
	                $registro = new DatosTipoIva();
	                $registro->setTipoIvaId($_POST["tipoIva_id"]);
	                $registro->setTipoIvaNombre($_POST["tipoIva_nombre"]);
	                $registro->setTipoIvaPorcentaje($_POST["tipoIva_porcentaje"]);
	                
	                $tipoIvaDAO->modificarRegistro($registro);
	                $_SESSION["mensaje"] = "Info: tipo de IVA '" . $registro->getTipoIvaNombre() . "' modificado exitosamente.";
	                header("Location: index.php?controlador=tipoIva&opcion=listado");
	            	break;
	                
	            case "eliminacion":
	                
	                $registro = new DatosTipoIva();
	                $registro = $tipoIvaDAO->obtenerRegistro($_POST["tipoIva_id"]);
	            	$tipoIvaDAO->borrarRegistro($_POST["tipoIva_id"]);
	            	$_SESSION["mensaje"] = "Info: tipo de IVA '" . $registro->getTipoIvaNombre() . "' borrado exitosamente.";
	            	header("Location: index.php?controlador=tipoIva&opcion=listado");
	            	break;
	            	
                default:
	            	
	                $tipoIvas = $tipoIvaDAO->obtenerTodosLosRegistros();
	                require_once(VIEWS_DIR . "/tipoIva/tipoIvaListado.php");
	
	        }
	        
    	} else {
    		
    		$tipoIvas = $tipoIvaDAO->obtenerTodosLosRegistros();
            require_once(VIEWS_DIR . "/tipoIva/tipoIvaListado.php");
    		
    	}

    }

?>