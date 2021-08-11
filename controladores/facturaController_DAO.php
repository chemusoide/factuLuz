<?php

if (defined("SECURITY_CONSTANT")) {

    include_once (DAO_DIR . "/factura/FacturaDAO.php");
    include_once (DAO_DIR . "/lfactura/LfacturaDAO.php");
    include_once (DAO_DIR . "/cliente/ClienteDAO.php");
    include_once (DAO_DIR . "/tipoIva/TipoIvaDAO.php");
    include_once (DAO_DIR . "/tipoIrpf/TipoIrpfDAO.php");

    $facturaDAO = new FacturaDAO();
    $lfacturaDAO = new LfacturaDAO();
    $clienteDAO = new ClienteDAO();
    $tipoIvaDAO = new TipoIvaDAO();
    $tipoIrpfDAO = new TipoIrpfDAO();

    if (isset($_GET["opcion"])) {

        switch ($_GET["opcion"]) {

            case "listado" :
                $facturas = $facturaDAO -> obtenerTodosLosRegistros();
                require_once (VIEWS_DIR . "/factura/facturaListado.php");
                break;

            case "consulta" :
                $factura 	= $facturaDAO  -> obtenerRegistro($_GET["id"]);
                $cliente 	= $clienteDAO  -> obtenerRegistro($factura -> getFacturaIdCliente());
                $tiposIva 	= $tipoIvaDAO  -> obtenerTodosLosRegistros();
                $tiposIrpf 	= $tipoIrpfDAO -> obtenerTodosLosRegistros();
                $lfacturas 	= $lfacturaDAO -> obtenerTodosLosRegistrosPorFactura($_GET["id"]);

                // Si no es un cliente activo, necesitamos consultar todos los registros
                // para que aparezca en el desplegable de clientes de la ficha de factura
                if ($cliente -> getClienteActivo())
                    $clientes = $clienteDAO -> obtenerTodosLosRegistrosActivos();
                else
                    $clientes = $clienteDAO -> obtenerTodosLosRegistros();

                switch ($factura->getFacturaTipo()) {

                    case "quirofano" :
                        require_once (VIEWS_DIR . "/factura/facturaQuirofanoFicha.php");
                        break;

                    case "servicio" :
                        require_once (VIEWS_DIR . "/factura/facturaServicioFicha.php");
                        break;

                    default :
                        require_once (VIEWS_DIR . "/factura/facturaServicioFicha.php");
                }

                break;

            case "precreacion" :
                $clientes = $clienteDAO -> obtenerTodosLosRegistrosActivos();
                $tiposIva = $tipoIvaDAO -> obtenerTodosLosRegistros();
                $tiposIrpf = $tipoIrpfDAO -> obtenerTodosLosRegistros();

                if (isset($_GET["idcliente"]) && $_GET["idcliente"] != "")
                    $cliente = $clienteDAO -> obtenerRegistro($_GET["idcliente"]);

                if (isset($_GET['factura_tipo'])) {

                    switch ($_GET['factura_tipo']) {

                        case "quirofano" :
                            require_once (VIEWS_DIR . "/factura/facturaQuirofanoFicha.php");
                            break;

                        case "servicio" :
                            require_once (VIEWS_DIR . "/factura/facturaServicioFicha.php");
                            break;

                        default :
                            require_once (VIEWS_DIR . "/factura/facturaServicioFicha.php");
                    }

                } else {

                    require_once (VIEWS_DIR . "/factura/facturaServicioFicha.php");

                }

                break;

            case "creacion" :
            	
            	
                $registro =  new DatosFactura ();
                
                $registro -> setFacturaIdCliente($_POST["factura_idcliente"]);
                $registro -> setFacturaTipo($_POST["factura_tipo"]);
                $registro -> setFacturaTotal($_POST["factura_total"], TRUE);
                $registro -> setFacturaParcial($_POST["factura_parcial"], TRUE);
                $registro -> setFacturaNombrepaciente($_POST["factura_nombrepaciente"]);
                $registro -> setFacturaApellidospaciente($_POST["factura_apellidospaciente"]);
                $registro -> setFacturaFechaoperacion($_POST["factura_fechaoperacion"], TRUE);
                $registro -> setFacturaOperacion($_POST["factura_operacion"]);
                $registro -> setFacturaFechacobro($_POST["factura_fechacobro"], TRUE);

                if ($_POST["factura_tipo"] == "quirofano")
                    $registro -> setFacturaIdpaciente($_POST["factura_tipoidpaciente"] . ":" . $_POST["factura_idpaciente"]);

                if (!isset($_POST["factura_pagada"]) || $_POST["factura_pagada"] == "")
                    $registro -> setFacturaPagada(0);
                else
                    $registro -> setFacturaPagada(1);
			
                $id = $facturaDAO -> crearRegistro($registro);
                
				//echo "ID : $id";
                if ($_POST["factura_tipo"] == "servicio")
                    $lfacturas = $lfacturaDAO -> parsearLineasDeFacturaServicio(
                    															$_POST["lfactura_fechaservicio"], 
                    															$_POST["lfactura_pacienteservicio"], 
                    															$_POST["lfactura_intervencionservicio"], 
                    															$_POST["lfactura_bimp"], 
                    															$_POST["lfactura_iva"], 
                    															$_POST["lfactura_irpf"] 
																				);
                else
                    $lfacturas = $lfacturaDAO -> parsearLineasDeFactura(
                    													$_POST["lfactura_intervencionservicio"], 
                    													$_POST["lfactura_bimp"], 
                    													$_POST["lfactura_iva"], 
                    													$_POST["lfactura_irpf"]
																		);

                if (isset($lfacturas))
                	
                    $lfacturaDAO -> actualizarLineasFactura($id, $lfacturas);

                $_SESSION["mensaje"] = "Info: factura creada exitosamente.";
                
                if ($_GET["volver"] == "true")
                    header("Location: index.php?controlador=factura&opcion=consulta&id=" . $id);
                else
                    header("Location: index.php?controlador=factura&opcion=listado");
                
                break;

            case "modificacion" :
                $registro = new DatosFactura();
                
                $registro -> setFacturaId				($_POST["factura_id"					]);
                $registro -> setFacturaNumero			($_POST["factura_numero"				]);
                $registro -> setFacturaIdCliente		($_POST["factura_idcliente"				]);
                $registro -> setFacturaTipo				($_POST["factura_tipo"					]);
                $registro -> setFacturaTotal			($_POST["factura_total"		  	  ], TRUE);
                $registro -> setFacturaParcial			($_POST["factura_parcial"	  	  ], TRUE);
                $registro -> setFacturaNombrepaciente	($_POST["factura_nombrepaciente"		]);
                $registro -> setFacturaApellidospaciente($_POST["factura_apellidospaciente" 	]);
                $registro -> setFacturaFechaoperacion	($_POST["factura_fechaoperacion"  ], TRUE);
                $registro -> setFacturaOperacion		($_POST["factura_operacion"				]);
                $registro -> setFacturaFechacobro		($_POST["factura_fechacobro"	  ], TRUE);

                if ($_POST["factura_tipo"] == "quirofano")
                    $registro -> setFacturaIdpaciente($_POST["factura_tipoidpaciente"] . ":" . $_POST["factura_idpaciente"]);

                if (!isset($_POST["factura_pagada"]) || $_POST["factura_pagada"] == "")
                    $registro -> setFacturaPagada(0);
                else
                    $registro -> setFacturaPagada(1);

                $facturaDAO -> modificarRegistro($registro);

                if ($_POST["factura_tipo"] == "servicio")
                    $lfacturas = $lfacturaDAO -> parsearLineasDeFacturaServicio($_POST["lfactura_fechaservicio"], $_POST["lfactura_pacienteservicio"], $_POST["lfactura_intervencionservicio"], $_POST["lfactura_bimp"], $_POST["lfactura_iva"], $_POST["lfactura_irpf"]);
                else
                    $lfacturas = $lfacturaDAO -> parsearLineasDeFactura($_POST["lfactura_intervencionservicio"], $_POST["lfactura_bimp"], $_POST["lfactura_iva"], $_POST["lfactura_irpf"]);

                if (isset($lfacturas))
                    $lfacturaDAO -> actualizarLineasFactura($registro -> getFacturaId(), $lfacturas);

                $_SESSION["mensaje"] = "Info: factura modificada exitosamente.";
                
                if ($_GET["volver"] == "true")
                    header("Location: index.php?controlador=factura&opcion=consulta&id=" . $registro->getFacturaId());
                else
                    header("Location: index.php?controlador=factura&opcion=listado");
                
                  break;

            case "facturasPendientesCliente" :
                $facturas = $facturaDAO -> obtenerFacturasPendientesPorCliente($_GET["idcliente"]);
                $cliente = $clienteDAO -> obtenerRegistro($_GET["idcliente"]);
                require_once (VIEWS_DIR . "/factura/facturaListadoPendientesCliente.php");
                break;

            case "facturasCliente" :
                $facturas = $facturaDAO -> obtenerFacturasPorCliente($_GET["idcliente"]);
                $cliente = $clienteDAO -> obtenerRegistro($_GET["idcliente"]);
                require_once (VIEWS_DIR . "/factura/facturaListadoCliente.php");
                break;

            case "facturaRectificativa" :
                // Obtener factura
                $facturaOriginal = $facturaDAO -> obtenerRegistro($_POST["factura_id"]);
                $facturaRec = $facturaDAO -> obtenerRegistro($_POST["factura_id"]);

                // Cambiar de signo el total
                $facturaRec -> setFacturaTotal(-1 * $facturaRec -> getFacturaTotal(FALSE), FALSE);
                $facturaRec -> setFacturaId(NULL);

                // Crear factura rectificativa y obtener ID
                $idFacturaRectificativa = $facturaDAO -> crearRegistro($facturaRec);
        		
                // Modificar la serie de factura a Rectificativa: 1
                $facturaRec -> setFacturaSerie (SERIE_BBDD_RECTIFICATIVA);
                
                // Asociar id de rectificativa a factura original
                $facturaOriginal -> setFacturaIdrectificativa($idFacturaRectificativa);
                $facturaDAO -> modificarRegistro($facturaOriginal);

                // Obtener líneas de factura
                $lfacturas = $lfacturaDAO -> obtenerTodosLosRegistrosPorFactura($_POST["factura_id"]);

                $numLfacturas = count($lfacturas);
                for ($i = 0; $i < $numLfacturas; $i++) {

                    $lfactura = (object)$lfacturas[$i];
                    // Cambiar de signo bases imponibles
                    $lfactura -> setLfacturaBimp(-1 * $lfactura -> getLfacturaBimp(FALSE));
                    // Modificar idfactura
                    $lfactura -> setLfacturaId(NULL);
                    $lfactura -> setLfacturaIdfactura($idFacturaRectificativa);
                    // Crear
                    $lfacturaDAO -> crearRegistro($lfactura);

                }

                $_SESSION["mensaje"] = "Info: abono creado exitosamente.";
                header("Location: index.php?controlador=factura&opcion=listado");
                break;

            case "cerrarFactura" :
                $facturaDAO -> cerrarFactura($_POST["factura_id"]);
                $factura = $facturaDAO -> obtenerRegistro($_POST["factura_id"]);
                $_SESSION["mensaje"] = "Info: la factura '" . $factura -> getFacturaNumero() . "' ha sido cerrada exitosamente.";
                
                if ($_GET["volver"] == "true")
                    header("Location: index.php?controlador=factura&opcion=consulta&id=" . $factura->getFacturaId());
                else
                    header("Location: index.php?controlador=factura&opcion=listado");
                  
                break;
                
            case "formularioServiciosQuirofanoPaciente":
                require_once (VIEWS_DIR . "/factura/formularioServiciosQuirofanoPaciente.php");
                break;
                
            case "listadoServiciosQuirofanoPaciente":
                $facturas = $facturaDAO -> obtenerFacturasServiciosQuirofanoPaciente($_POST["nombre_paciente"]);
                require_once (VIEWS_DIR . "/factura/listadoServiciosQuirofanoPaciente.php");
                break;
                
            case "informeFacturacionAnyoMes":
            	$anyo = (empty($_POST['anyo'])) ? '' : $_POST['anyo'];
            	$mes = (empty($_POST['mes'])) ? '' : $_POST['mes'];
            	$limite = (empty($_POST['limite'])) ? '' : $_POST['limite'];
            	$datosInforme = $facturaDAO->facturacionAnyoMes($anyo, $mes, $limite);
            	require_once (VIEWS_DIR . "/factura/informeFacturacionAnyoMes.php");
            	break;

            case "imprimir" :
                $facturaDAO -> imprimirRegistro($_GET["id"]);
                break;

            default :
                $facturas = $facturaDAO -> obtenerTodosLosRegistros();
                require_once (VIEWS_DIR . "/factura/facturaListado.php");
        }

    } else {

        $facturas = $facturaDAO -> obtenerTodosLosRegistros();
        require_once (VIEWS_DIR . "/factura/facturaListado.php");

    }

}
?>