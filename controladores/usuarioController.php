<?php
    
    if (defined("SECURITY_CONSTANT")) {
        
        include_once(DAO_DIR . "/usuario/UsuarioDAO.php");

    	$usuarioDAO = new UsuarioDAO();
    	    	    	
        // Resto de opciones
    	if (isset($_GET["opcion"])) {
    	
	        switch ($_GET["opcion"]) {
	
	            case "listado":
	            
	                $usuarios = $usuarioDAO->obtenerTodosLosRegistros();
	                require_once(VIEWS_DIR . "/usuario/usuarioListado.php");
	                break;
	                
	            case "consulta":
	            	
	            	$usuario = $usuarioDAO->obtenerRegistro($_GET["id"]);
	                require_once(VIEWS_DIR . "/usuario/usuarioFicha.php");
	                break;
	                
	            case "precreacion":
	                
	            	require_once(VIEWS_DIR . "/usuario/usuarioFicha.php");
	                break;
	                
                case "creacion":
                	
	                $registro = new DatosUsuario();
	                
	                if ( isset($_POST["usuario_nombre"]) && strlen($_POST["usuario_nombre"]) > 1 ) {
	                    	                    
	                    $registro->setUsuarioNombre($_POST["usuario_nombre"]);
	                    
	                } else {
	                    	                    
	                    $_SESSION["mensaje"] = "Error: no se especificó nombre de usuario.";
	                    break;
	                    
	                }
	                	                
	                if ( ($_POST["usuario_password"] == $_POST["usuario_password_confirm"]) && (strlen($_POST["usuario_password"]) >= 6) ) {
	                    
                        $registro->setUsuarioPassword($_POST["usuario_password"]);
                    
                    } else {
                        
                        $_SESSION["mensaje"] = "Error: no se especificó contraseña, no coincide con la de confirmación o contraseña demasiado corta.";
                        break;
                        
                    }
	                
	                $usuarioDAO->crearRegistro($registro);
	                $_SESSION["mensaje"] = "Info: usuario '" . $registro->getUsuarioNombre() . "' creado exitosamente.";
	                header("Location: index.php?controlador=usuario&opcion=listado");
	            	break;
	                
	            case "modificacion":
	            	
	                $registro = new DatosUsuario();
	                $registro->setUsuarioId($_POST["usuario_id"]);
	                $registro->setUsuarioNombre($_POST["usuario_nombre"]);
	                
	                $usuarioDAO->modificarRegistro($registro);
	                $_SESSION["mensaje"] = "Info: usuario '" . $registro->getUsuarioNombre() . "' modificado exitosamente.";
	                header("Location: index.php?controlador=usuario&opcion=listado");
	            	break;
	                
	            case "eliminacion":
	                
	                $registro = new DatosUsuario();
	                $registro = $usuarioDAO->obtenerRegistro($_POST["usuario_id"]);
	            	$usuarioDAO->borrarRegistro($_POST["usuario_id"]);
	            	$_SESSION["mensaje"] = "Info: usuario '" . $registro->getUsuarioNombre() . "' borrado exitosamente.";
	            	header("Location: index.php?controlador=usuario&opcion=listado");
	            	break;
	            	
	            case "cambiarPassword":
	                
	                $registro = new DatosUsuario();
	                $registro = $usuarioDAO->obtenerRegistro($_POST["usuario_id"]);
	                	                    
                    if ( ($_POST["usuario_password"] == $_POST["usuario_password_confirm"]) && (strlen($_POST["usuario_password"]) >= 6) ) {
                        
                        $registro->setUsuarioPassword($_POST["usuario_password"]);
                    
                    } else {
                        
                        $_SESSION["mensaje"] = "Error: no se especificó contraseña, no coincide con la de confirmación o contraseña demasiado corta.";
                        break;
                        
                    }
	                    	                
	                $usuarioDAO->modificarRegistro($registro);
	                $_SESSION["mensaje"] = "Info: contraseña del usuario '" . $registro->getUsuarioNombre() . "' cambiada exitosamente.";
	                header("Location: index.php?controlador=usuario&opcion=listado");
	                break;
	            	
	            case "login":
	                	                
        	        // Autenticación...
                    if ( isset($_POST["usuario_nombre"]) && isset($_POST["usuario_password"]) ) {
                                                    	    
                	    $datosUsuario = new DatosUsuario();
                	    $datosUsuario = $usuarioDAO->obtenerRegistroPorNombre( $_POST["usuario_nombre"], $_POST["usuario_password"] );
                	                    	    
                	    if ( $datosUsuario->getUsuarioNombre() != NULL ) {
                	                        	                        	            	        
                	        $_SESSION["usuario_id"] = $datosUsuario->getUsuarioId();
                	        $_SESSION["usuario_nombre"] = $datosUsuario->getUsuarioNombre();
                	        $_SESSION["anterior_bd"] = $_POST["anterior_bd"];
                	            	        
                	        header("Location: index.php");
                	        
                	    } else {
                	                        	        
                	        $_SESSION["mensaje"] = "Error: nombre de usuario o contraseña incorrectos.";
                	        require_once(VIEWS_DIR . "/login.php");
                	        
                	    }
                	    
                    } else {
                                        	        
            	        $_SESSION["mensaje"] = "Error: nombre de usuario o contraseña no especificado.";
            	        require_once(VIEWS_DIR . "/login.php");
            	                    	        
            	    }
                    
                    break;
                    
	            case "logout":
	                
	                session_destroy();
	                header("Location: index.php");
	                break;
	            	
                default:
	            	
	                $usuarios = $usuarioDAO->obtenerTodosLosRegistros();
	                require_once(VIEWS_DIR . "/usuario/usuarioListado.php");
	
	        }
	        
    	} else {
    		
    		$usuarios = $usuarioDAO->obtenerTodosLosRegistros();
            require_once(VIEWS_DIR . "/usuario/usuarioListado.php");
    		
    	}

    }

?>