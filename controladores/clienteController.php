<?php

    if (defined("SECURITY_CONSTANT")) {
        
        include_once(DAO_DIR . "/cliente/ClienteDAO.php");

    	$clienteDAO = new ClienteDAO();
    	
    	if (isset($_GET["opcion"])) {
    	
	        switch ($_GET["opcion"]) {
	
	            case "listado":
	            
	                $clientes = $clienteDAO->obtenerTodosLosRegistros();
	                require_once(VIEWS_DIR . "/cliente/clienteListado.php");
	                break;
	                
	            case "consulta":
	            	
	            	$cliente = $clienteDAO->obtenerRegistro($_GET["id"]);
	                require_once(VIEWS_DIR . "/cliente/clienteFicha.php");
	                break;
	                
	            case "precreacion":
	                
	            	require_once(VIEWS_DIR . "/cliente/clienteFicha.php");
	                break;
	                
                case "creacion":
                	
	                $registro = new DatosCliente();
	                $registro->setClienteNombre($_POST["cliente_nombre"]);
	                $registro->setClienteNif($_POST["cliente_nif"]);
	                $registro->setClienteDireccion($_POST["cliente_direccion"]);
	                $registro->setClienteDireccionfacturas($_POST["cliente_direccionfacturas"]);
	                $registro->setClientePersonacontacto($_POST["cliente_personacontacto"]);
	                $registro->setClienteEmails($_POST["cliente_emails"]);
	                $registro->setClienteTelefonos($_POST["cliente_telefonos"]);
	                $registro->setClienteFax($_POST["cliente_fax"]);
	                $registro->setClienteObservaciones($_POST["cliente_observaciones"]);
	                $registro->setClienteInfobancaria($_POST["cliente_infobancaria"]);
	                
	                if (!isset($_POST["cliente_activo"]) || $_POST["cliente_activo"] == "")
	                    $registro->setClienteActivo(0);
	                else
	                    $registro->setClienteActivo(1);
	                
                    // Comprobamos que no exista un cliente con el mismo CIF/NIF...
                    $registroTmp = new DatosCliente();
                    $registroTmp = $clienteDAO->obtenerRegistroPorCif($registro->getClienteNif());
                    
                    if ( $registroTmp->getClienteId() != "" ) {

	                    $_SESSION["mensaje"] = "Info: ya existe un cliente con el CIF " . $registroTmp->getClienteNif() . " (" . $registroTmp->getClienteNombre() . ").";
	                    header("Location: index.php?controlador=cliente&opcion=listado");
                        
                    } else {
                        
                        $clienteDAO->crearRegistro($registro);
	                    $_SESSION["mensaje"] = "Info: cliente '" . $registro->getClienteNombre() . "' creado exitosamente.";
	                    header("Location: index.php?controlador=cliente&opcion=listado");
                        
                    }
	                
	            	break;
	                
	            case "modificacion":
	            	
	                $registro = new DatosCliente();
	                $registro->setClienteId($_POST["cliente_id"]);
	                $registro->setClienteNombre($_POST["cliente_nombre"]);
	                $registro->setClienteNif($_POST["cliente_nif"]);
	                $registro->setClienteDireccion($_POST["cliente_direccion"]);
	                $registro->setClienteDireccionfacturas($_POST["cliente_direccionfacturas"]);
	                $registro->setClientePersonacontacto($_POST["cliente_personacontacto"]);
	                $registro->setClienteEmails($_POST["cliente_emails"]);
	                $registro->setClienteTelefonos($_POST["cliente_telefonos"]);
	                $registro->setClienteFax($_POST["cliente_fax"]);
	                $registro->setClienteObservaciones($_POST["cliente_observaciones"]);
	                $registro->setClienteInfobancaria($_POST["cliente_infobancaria"]);
	                
	                if (!isset($_POST["cliente_activo"]) || $_POST["cliente_activo"] == "")
	                    $registro->setClienteActivo(0);
	                else
	                    $registro->setClienteActivo(1);
	                
	                $clienteDAO->modificarRegistro($registro);
	                $_SESSION["mensaje"] = "Info: cliente '" . $registro->getClienteNombre() . "' modificado exitosamente.";
	                header("Location: index.php?controlador=cliente&opcion=listado");
	            	break;
	                
//	            case "eliminacion":
//	                
//	                $registro = new DatosCliente();
//	                $registro = $clienteDAO->obtenerRegistro($_POST["cliente_id"]);
//	                
//	            	$clienteDAO->borrarRegistro($_POST["cliente_id"]);
//	            	$_SESSION["mensaje"] = "Info: cliente '" . $registro->getClienteNombre() . "' borrado exitosamente.";
//	            	header("Location: index.php?controlador=cliente&opcion=listado");
//	            	break;
//	            	
	            case "consultaAjax":
	                
	                $registro = new DatosCliente();
	                $registro = $clienteDAO->obtenerRegistro($_GET["cliente_id"]);
	                
	                $jsondata = array();
                    $jsondata["cliente_id"] = $registro->getClienteId();
                    $jsondata["cliente_nombre"] = $registro->getClienteNombre();
                    $jsondata["cliente_nif"] = $registro->getClienteNif();
                    $jsondata["cliente_direccion"] = $registro->getClienteDireccion();
                    echo json_encode($jsondata);
                    
	                break;
	            	
                default:
	            	
	                $clientes = $clienteDAO->obtenerTodosLosRegistros();
	                require_once(VIEWS_DIR . "/cliente/clienteListado.php");
	
	        }
	        
    	} else {
    		
    		$clientes = $clienteDAO->obtenerTodosLosRegistros();
            require_once(VIEWS_DIR . "/cliente/clienteListado.php");
    		
    	}

    }

?>