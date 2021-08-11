<?php
    
    if (defined("SECURITY_CONSTANT")) {
        
        include_once(DAO_DIR . "/tipoIrpf/TipoIrpfDAO.php");

    	$tipoIrpfDAO = new TipoIrpfDAO();
    	
    	if (isset($_GET["opcion"])) {
    	
	        switch ($_GET["opcion"]) {
	
	            case "listado":
	            
	                $tipoIrpfs = $tipoIrpfDAO->obtenerTodosLosRegistros();
	                require_once(VIEWS_DIR . "/tipoIrpf/tipoIrpfListado.php");
	                break;
	                
	            case "consulta":
	            	
	            	$tipoIrpf = $tipoIrpfDAO->obtenerRegistro($_GET["id"]);
	                require_once(VIEWS_DIR . "/tipoIrpf/tipoIrpfFicha.php");
	                break;
	                
	            case "precreacion":
	                
	            	require_once(VIEWS_DIR . "/tipoIrpf/tipoIrpfFicha.php");
	                break;
	                
                case "creacion":
                	
	                $registro = new DatosTipoIrpf();
	                $registro->setTipoIrpfNombre($_POST["tipoIrpf_nombre"]);
	                $registro->setTipoIrpfPorcentaje($_POST["tipoIrpf_porcentaje"]);
	                
	                $tipoIrpfDAO->crearRegistro($registro);
	                $_SESSION["mensaje"] = "Info: tipo de IRPF '" . $registro->getTipoIrpfNombre() . "' creado exitosamente.";
	                header("Location: index.php?controlador=tipoIrpf&opcion=listado");
	            	break;
	                
	            case "modificacion":
	            	
	                $registro = new DatosTipoIrpf();
	                $registro->setTipoIrpfId($_POST["tipoIrpf_id"]);
	                $registro->setTipoIrpfNombre($_POST["tipoIrpf_nombre"]);
	                $registro->setTipoIrpfPorcentaje($_POST["tipoIrpf_porcentaje"]);
	                
	                $tipoIrpfDAO->modificarRegistro($registro);
	                $_SESSION["mensaje"] = "Info: tipo de IRPF '" . $registro->getTipoIrpfNombre() . "' modificado exitosamente.";
	                header("Location: index.php?controlador=tipoIrpf&opcion=listado");
	            	break;
	                
	            case "eliminacion":
	                
	                $registro = new DatosTipoIrpf();
	                $registro = $tipoIrpfDAO->obtenerRegistro($_POST["tipoIrpf_id"]);
	            	$tipoIrpfDAO->borrarRegistro($_POST["tipoIrpf_id"]);
	            	$_SESSION["mensaje"] = "Info: tipo de IRPF '" . $registro->getTipoIrpfNombre() . "' borrado exitosamente.";
	            	header("Location: index.php?controlador=tipoIrpf&opcion=listado");
	            	break;
	            	
                default:
	            	
	                $tipoIrpfs = $tipoIrpfDAO->obtenerTodosLosRegistros();
	                require_once(VIEWS_DIR . "/tipoIrpf/tipoIrpfListado.php");
	
	        }
	        
    	} else {
    		
    		$tipoIrpfs = $tipoIrpfDAO->obtenerTodosLosRegistros();
            require_once(VIEWS_DIR . "/tipoIrpf/tipoIrpfListado.php");
    		
    	}

    }

?>